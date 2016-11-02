<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Curl
 *
 * @author Aurélien
 */
class SpreadCurl {

    private $response;
    
    static function getInstance($url, $params = array()){
        return new SpreadCurl($url, $params);
    }
    
    public function __construct($url, $params = array()) {

        $this->response = false;

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($curl, CURLOPT_USERPWD, Configuration::get('SB_PUBLICKEY').':'.Configuration::get('SB_PRIVATEKEY'));
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $this->response = curl_exec($curl);
    }

    public function getResponse()
    {
        $response = json_decode($this->response);

        if (!$response)
        {
            $response = false;
        }

        return $response;
    }
}
