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

require_once 'twengaabstract.php';

class Twenga extends TwengaAbstract
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
        $this->name = 'twenga';
        $this->tab = 'market_place';
        $this->version = '3.0.3';
        $this->author = 'Twenga';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
        $this->bootstrap = true;
        $this->module_key = '09ce4706342693f1f4a97cd1bcf701b9';

        parent::__construct();

        $this->displayName = Twenga_Services_Lang::trans(
            array('_id' => '86117'),
            'Acquisition et ciblage d\'audience avec le Module Twenga'
        );
        $this->description = Twenga_Services_Lang::trans(
            array('_id' => '86127'),
            'Vous disposez d\'un petit budget, Twenga vous propose une offre de référencement adaptée qui boostera '
            . 'immédiatement votre chiffre d\'affaire.'
        );
        $this->confirmUninstall = Twenga_Services_Lang::trans(
            array('_id' => '0'),
            'Are you sure you want to uninstall?'
        );
    }
}
