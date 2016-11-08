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

/**
 * Twenga Lang class
 */
class Twenga_Services_Helper
{
    /**
     * Domain for Twenga-Solution website
     * @var string
     */
    private static $twsDomain;

    /**
     * Domain for tws api
     * @var string
     */
    private static $apiDomain;

    /**
     * Lang code, used on some urls
     * @var string
     */
    private static $langCode;

    /**
     * Set TWS domain
     * @param string $domain
     */
    public static function setTwsDomain($domain)
    {
        static::$twsDomain = $domain;
    }

    /**
     * Set API domain
     * @param string $domain
     */
    public static function setApiDomain($domain)
    {
        static::$apiDomain = $domain;
    }

    /**
     * Set lang code
     * @param string $langCode
     */
    public static function setLangCode($langCode)
    {
        static::$langCode = $langCode;
    }

    /**
     * @param string $sPath
     * @param array $params
     * @param bool $bAddLang
     * @return string
     */
    public static function buildTwsUrl($sPath, array $params = array(), $bAddLang = false)
    {
        return static::buildUrl(static::$twsDomain, $sPath, $params, $bAddLang);
    }

    /**
     * @param string $sPath
     * @param array $params
     * @return string
     */
    public static function buildApiUrl($sPath, array $params = array())
    {
        return static::buildUrl(static::$apiDomain, $sPath, $params, false);
    }

    /**
     * Build an url
     *
     * For now, it does not manage user:password
     *
     * @param string $sDomain
     * @param string $sPath
     * @param array $params
     * @param bool $bAddLang Add language as first path element
     * @return string
     */
    private static function buildUrl($sDomain, $sPath, array $params = array(), $bAddLang = false)
    {
        $parsedUrl = parse_url($sDomain . $sPath);

        $urlParams = array();
        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $urlParams);
        }

        if (!empty($params)) {
            $urlParams = array_merge($urlParams, $params);
        }

        $parsedUrl['query'] = http_build_query($urlParams);

        return
            (isset($parsedUrl['scheme']) ? $parsedUrl['scheme'] . '://' : (isset($parsedUrl['host']) ? '//' : ''))
            . (isset($parsedUrl['host']) ? $parsedUrl['host'] : '')
            . (isset($parsedUrl['port']) ? ':' . $parsedUrl['port'] : '')
            . ($bAddLang ? '/' . static::$langCode : '')
            . (isset($parsedUrl['path']) ? $parsedUrl['path'] : '')
            . (isset($parsedUrl['query']) ? '?' . $parsedUrl['query'] : '')
            . (isset($parsedUrl['fragment']) ? '#' . $parsedUrl['fragment'] : '');
    }
}
