<?php

/**
 * Class AdminSpreadController
 */
class AdminSpreadController extends ModuleAdminController
{

    public function renderView() {


        global $cookie;

        if(!$this->getApiKeys())
        {
            //Nécéssaire pour le if dans le tpl
            $case = 1;

        }

        elseif($this->getApiKeys())
        {
            //Nécéssaire pour le if dans le tpl
            $case = 3;

            // Les données doivent être encodé en UTF8

            $this->post_array['public'] = $this->publicKey;//Clé public

            $this->post_array['apiKeys'] = true;

            ksort($this->post_array); // trie des clés

            // certification de l'API (utilisé pour la signature
            $cert = $this->privateKey;

            // Création de la signature
            $post_data = '';

            foreach ($this->post_array as $k => $v)
            {
                $post_data = $post_data . $k .'='. $v .'&';
            }

            // Création de la signature
            $sign = sha1($post_data . $cert);

            // finalisation des valeurs postés
            $post_data .= 'sign' . '='. $sign;

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, "http://social-sb.com/api/GetToken"); // a remplacer l'url de votre plateforme
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $curl_return = curl_exec($curl);
            curl_close($curl);

            // Met le retour json dans un tableau
            if ($this->post_array['returnformat'] == 'json')
            {
                $return =  (array)json_decode($curl_return);

                // Si le format JSON n'est pas bien interprété le tableau est vide
                if (sizeof($return)==0)
                {
                    $error =  print_r($curl_return, true);
                    $apiError =  $this->l('An error occurred')." : " . $error;

                }
            }

            if (is_array($return)
                && !empty($return['sign']))
            {
                // Vérification de la signature
                ksort($return);
                $tosign = '';

                foreach ($return as $key => $value)
                {
                    if  ($key!='sign'
                        && $key!='tosign')
                    {
                        $tosign .= $key.'='.$value.'&';
                    }
                }

                // Si tout s'est bien passé, on affiche le BO SPREAD
                if (isset($return['sign'])
                    && $return['sign'] == sha1($tosign . $cert))
                {

                    $showIframe = true;
                }
                elseif (isset($return['sign']))
                {
                    $apiError = $this->l('Sign error. Please update your API keys or contact support@spreadfamily.com');
                }

            }
            elseif (isset($return['sign'])
                && $return['sign']=='')
            {
                $apiError = $this->l('No sign. Please update your API keys or contact support@spreadfamily.com');
            }
            elseif (isset($return['return'])
                && $return['return']=='ERR-9003')
            {

                Configuration::deleteByName('SB_PRIVATEKEY');
                Configuration::deleteByName('SB_PUBLICKEY');
                $tabDenomination=$this->getVersionTabName();
                header('Location: '.$_SERVER['PHP_SELF'].'?'.$tabDenomination.'='.$_GET[$tabDenomination].'&token='.$_GET['token'].'&error=9003');

            }
            else
            {
                $apiError = $this->l('Sign error. Please update your API keys or contact support@spreadfamily.com');
            }



        }
        elseif(isset($_GET['error']))
        {
            //Nécéssaire pour le if dans le tpl
            $case=4;
        }

        $this->tpl_view_vars = array(
            'case' => $case,
            'apiError' => (isset($apiError) ? $apiError : ''),
            'tokenSbt' => (isset($return) ? $return['sbt'] : ''),
            'showIframe' => (isset($showIframe) ? $showIframe : '')

        );

        return parent::renderView();
    }
}