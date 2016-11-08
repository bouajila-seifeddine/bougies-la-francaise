<?php
/**
  * Copyright (c) 2016 Twenga
  * 
  * Permission is hereby granted, free of charge, to any person obtaining a copy
  * of this software and associated documentation files (the "Software"), to deal
  * in the Software without restriction, including without limitation the rights
  * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
  * copies of the Software, and to permit persons to whom the Software is
  * furnished to do so, subject to the following conditions:
  * 
  * The above copyright notice and this permission notice shall be included in all
  * copies or substantial portions of the Software.
  * 
  * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
  * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
  * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
  * IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
  * DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
  * OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE
  * OR OTHER DEALINGS IN THE SOFTWARE.
  * 
  * @author    Twenga
  * @copyright 2016 Twenga
  * @license   http://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
  */

if (!defined('_PS_VERSION_')) {
    exit;
}

class TwengaAbstract extends Module
{
    /**
     * @var array
     */
    protected $geozoneInfo = array();

    public $limited_countries = array('fr', 'de', 'gb', 'it', 'es', 'nl', 'pl');

    /**
     * Module constructor
     */
    public function __construct()
    {
        parent::__construct();

        spl_autoload_register(array($this, 'autoload'));

        Twenga_Config::setConfigPath(_PS_MODULE_DIR_.$this->name . '/config');

        $this->loadGeozone();

        Twenga_Services_Lang::setTranslationDir(_PS_MODULE_DIR_.$this->name . '/config/translations');
        Twenga_Services_Lang::init();
        Twenga_Services_Lang::setDebugMode(Twenga_Config::get('tws.debug'));
        Twenga_Services_Lang::setLanguageId($this->geozoneInfo['language_id']);
    }

    /**
     * Install module
     * @return bool
     * @throws PrestaShopException
     */
    public function install()
    {
        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }

        return parent::install()
        && $this->registerHook('header')
        && $this->initConfig()
        && $this->installModuleTab();
    }

    /**
     * Uninstall module
     * @return bool
     */
    public function uninstall()
    {
        return
            parent::uninstall()
            && $this->unregisterHook('header')
            && $this->uninstallModuleTab()
            && $this->resetConfig();
    }

    /**
     * Header hook
     * Allow us to add tracking script
     * @return string
     */
    public function hookHeader()
    {
        $scripts = '';
        // Only display tracking script if no other twenga module did it
        if (!isset($this->context->commonHeaderInstalled) || !$this->context->commonHeaderInstalled) {
            $scripts .= $this->displayTrackingScript();
            $this->context->commonHeaderInstalled = true;
        }

        return $scripts;
    }

    private function displayTrackingScript()
    {
        if (false != ($script = \Configuration::get('TW_TRACKING_SCRIPT'))) {
            return $script;
        }
        return '';
    }

    /**
     * Get configuration page content
     * @return mixed
     */
    public function getContent()
    {
        $this->context->controller->addJquery('1.11.3');

        $this->context->controller->addCSS($this->getPathUri() . 'views/css/bundle.css');
        $this->context->controller->addCSS(
            '//fonts.googleapis.com/css?' .
            'family=Roboto:100italic,100,300italic,300,400italic,400,500italic,500,700italic,700,900italic,900'
        );
        $this->context->controller->addJS($this->getPathUri() . 'views/js/configure.js');
        $this->context->controller->addJS(Twenga_Config::get('product.tag_manager_url'));

        require_once _PS_MODULE_DIR_ . $this->name . '/controllers/admin/twengasignup.php';
        $oConfigureController = new \TwengaSignUpController();
        return $oConfigureController->getConfigurePage();
    }

    /**
     * Initialize module configuration
     * @return bool
     */
    private function initConfig()
    {
        $config = array();
        if (false !== ($configJson = \Configuration::get('TWENGA_CONFIG'))) {
            $config = \Tools::jsonDecode($configJson, true);
        }

        $productId = Twenga_Config::get('product.id');
        $config[$productId] = true;

        return \Configuration::updateValue('TWENGA_CONFIG', \Tools::jsonEncode($config), true)
        && \Configuration::updateValue('TWENGA_GEOZONE', $this->geozoneInfo['tw_code'])
        && \Configuration::updateValue('TW_SMARTLEADS_CONFIGURE_STEP', 1);
    }

    /**
     * Remove configuration
     * @return bool
     */
    private function resetConfig()
    {
        $config = array();
        if (false !== ($configJson = \Configuration::get('TWENGA_CONFIG'))) {
            $config = \Tools::jsonDecode($configJson, true);
            $productId = Twenga_Config::get('product.id');
            unset($config[$productId]);
        }

        $commonConfReturn =
            \Configuration::deleteByName('TW_SMARTLEADS_CONFIGURE_ACCOUNT_TYPE') &&
            \Configuration::deleteByName('TW_SMARTLEADS_CONFIGURE_STEP');

        if (empty($config)) {
            unset($this->context->cookie->tw_token);
            // No more twenga solutions modules installed => remove all configurations
            return \Configuration::deleteByName('TWENGA_CONFIG')
            && \Configuration::deleteByName('TWENGA_GEOZONE')
            && \Configuration::deleteByName('TW_TRACKING_SCRIPT')
            && \Configuration::deleteByName('TW_MERCHANT_EMAIL')
            && \Configuration::deleteByName('TW_SMARTLEADS_IS_FEED_SENT')
            && $commonConfReturn;
        } else {
            return
                \Configuration::updateValue('TWENGA_CONFIG', \Tools::jsonEncode($config), true) &&
                $commonConfReturn;
        }
    }

    /**
     * Install module tab to allow the use of admin controllers
     * @return bool
     */
    private function installModuleTab()
    {
        $tab = new Tab();
        $tab->name = array(Configuration::get('PS_LANG_DEFAULT') => 'Twenga SmartLeads');
        $tab->class_name = 'TwengaSignUp';
        $tab->module = 'twenga';
        $tab->id_parent = -1;
        $tab->active = 0;
        return $tab->save();
    }

    /**
     * Uninstall module tab
     * @return bool
     */
    private function uninstallModuleTab()
    {
        if (false !== ($tab = new Tab((int)Tab::getIdFromClassName('TwengaSignUp')))) {
            return $tab->delete();
        }
        return true;
    }

    /**
     * Autoload for module classes
     * @param string $className
     */
    public function autoload($className)
    {
        if (0 === strpos($className, 'Twenga_')) {
            $filePath = _PS_MODULE_DIR_ . $this->name . '/classes' . DIRECTORY_SEPARATOR .
                \Tools::strtolower(str_replace('_', '/', \Tools::substr($className, 7))) . '.php';
            require_once($filePath);
        }
    }

    /**
     * Load twenga geozones based on iso_code
     * @return $this
     */
    private function loadGeozone()
    {
        $geozoneConfigs = Twenga_Config::get('geozone');
        if (isset($geozoneConfigs[$this->context->country->iso_code])) {
            $this->geozoneInfo = $geozoneConfigs[$this->context->country->iso_code];
        }
        return $this;
    }
}
