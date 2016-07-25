<?php

if (_PS_VERSION_ < '1.5')
{
    include_once(dirname(__FILE__).'/controllers/admin/AdminSpread.php');
}
else
{
    include_once(dirname(__FILE__).'/controllers/admin/AdminSpreadController.php');
}

/**
 * Class AdminSpread
 *
 * Permet de gérer l'affichage du BO SPREAD dans l'interface de presta
 *
 */
class AdminSpread extends AdminSpreadController
{
    /**
     * @var string Clé d'API publique SPREAD
     */
    protected $publicKey;

    /**
     * @var string Clé d'API privée SPREAD
     */
    protected $privateKey;

    /**
     * @var array Tableau de data à envoyer chez SPREAD pour obtenir un token
     */
    protected $post_array;


    public function __construct()
	{
        if (_PS_VERSION_ >= '1.5')
        {
            $this->display = 'view';
            $this->meta_title = $this->l('BO SPREAD');
            $this->context = Context::getContext();
        }

        $this->post_array['returnformat'] = 'json';
        $this->post_array['plateforme'] = 'prestashop';

        parent::__construct();
	}

    public function getVersionTabName()
	{
		$version = explode('.', _PS_VERSION_);  //résolution des problèmes de compatibilité

    	if ($version[0] <= 1
            && $version[1] < 5)
        {
            return 'tab';
        }
		else
        {
            return 'controller';
        }
	}

    /**
     * @return bool True si les clés d'API sont enregistrées dans le presta, sinon false
     */
    public function getApiKeys()
    {
        $this->publicKey = Tools::getValue('publicKey', (Configuration::get('SB_PUBLICKEY')?Configuration::get('SB_PUBLICKEY'):''));
        $this->privateKey = Tools::getValue('privateKey', (Configuration::get('SB_PRIVATEKEY')?Configuration::get('SB_PRIVATEKEY'):''));

        if (!empty($this->publicKey)
            && !empty($this->privateKey))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
?>