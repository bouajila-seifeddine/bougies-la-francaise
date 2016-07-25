<?php

/**
 * Class AdminSpreadController
 */
class AdminSpreadController extends AdminTab
{
    public function display()
    {

        // Si on a pas les clés d'API
        if (!$this->getApiKeys())
        {

            echo '
                <div style="width:60%; margin:20px 20%" class="admin-box1">
                <h5>' . $this->l('You have to set your API key in the configuration of the plugin.') . '</h5>
            ';

        }
        // Si on a les clés d'API
        elseif ($this->getApiKeys())
        {

            $this->post_array['public'] = $this->publicKey; //Clé public

            $this->post_array['apiKeys'] = true;

            ksort($this->post_array); // trie des clés

            // certification de l'API (utilisé pour la signature
            $cert = $this->privateKey;

            // Création de la signature
            $post_data = '';

            foreach ($this->post_array as $k => $v)
            {
                $post_data = $post_data . $k . '=' . $v . '&';
            }

            // Création de la signature
            $sign = sha1($post_data . $cert);

            // finalisation des valeurs postés
            $post_data .= 'sign' . '=' . $sign;

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, "http://social-sb.com/api/GetToken");
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $curl_return = curl_exec($curl);
            curl_close($curl);


            // Met le retour json dans un tableau
            if ($this->post_array['returnformat'] == 'json')
            {
                $return = (array)json_decode($curl_return);

                // Si le format JSON n'est pas bien interprété le tableau est vide
                if (sizeof($return) == 0)
                {
                    $error =  print_r($curl_return, true);
                    echo "<h3>".$this->l('An error occurred')." : </h3>" . $error;

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
                    if ($key != 'sign' && $key != 'tosign')
                    {
                        $tosign .= $key . '=' . $value . '&';
                    }
                }

                // Si tout s'est bien passé, on affiche le BO SPREAD
                if (isset($return['sign'])
                    && $return['sign'] == sha1($tosign . $cert))
                {

                    echo "
                        <div style='margin:5px 0'>
                            <iframe style='min-height:1500px;border:none;' frameborder='0' width='100%'src='http://social-sb.com/boi?token=".$return['sbt']."'></iframe>
                        </div>
                    ";

                }
                elseif (isset($return['sign']))
                {
                    echo "<h3>".$this->l('Sign error. Please update your API keys or contact support@spreadfamily.com')."</h3>";
                }

            }
            elseif (isset($return['sign'])
                && $return['sign'] == '')
            {
                echo "<h3>".$this->l('No sign. Please update your API keys or contact support@spreadfamily.com')."</h3>";
            }
            elseif (isset($return['return'])
                && $return['return'] == 'ERR-9003')
            {

                Configuration::deleteByName('SB_PRIVATEKEY');
                Configuration::deleteByName('SB_PUBLICKEY');
                $tabDenomination = $this->getVersionTabName();
                header('Location: ' . $_SERVER['PHP_SELF'] . '?' . $tabDenomination . '=' . $_GET[$tabDenomination] . '&token=' . $_GET['token'] . '&error=9003');

            }
            else
            {
                echo "<h3>".$this->l('Sign error. Please update your API keys or contact support@spreadfamily.com')."</h3>";
            }

        }
        elseif (isset($_GET['error']))
        {
            if ($_GET['error'] = 'unknow_user')
            {
                echo "<h3>".$this->l('User unknown. Please update your API keys or contact support@spreadfamily.com')."</h3>";
            }
        }

    }
}