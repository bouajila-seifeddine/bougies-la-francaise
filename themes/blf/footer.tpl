{*
* 2007-2013 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2013 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

        {if !$content_only}
                    </section><!-- // Section -->
                    
                    <aside id="right-column">
                        {$HOOK_RIGHT_COLUMN}
                    </aside>
                    
                </div><!-- // Container -->
                
                <div id="push"></div>
            </div><!-- // Wrapper -->


			<footer id="footer">
                <div id="footer-inner">
                    
                    <ul class="footer-link">
                        <li class="header"><h5>{l s='Our company'}</h5></li>
                        <li><a href="{$link->getCMSLink(6)|escape:'html'}">{l s='Company'}</a></li>
                        <li><a href="{$link->getCMSLink(7)|escape:'html'}">{l s='Expertise'}</a></li>
                        <li><a href="{$link->getCMSLink(8)|escape:'html'}">{l s='Learn all about the candles'}</a></li>
                        <li><a href="{$link->getPageLink('module-pressreviews-default')|escape:'html'}">{l s='We talk about'}</a></li>
                        <li><a href="{$link->getCMSLink(25)|escape:'html'}">{l s='Videos'}</a></li>
                        <li><a href="{$link->getCMSLink(18)|escape:'html'}">{l s='Recruitment'}</a></li>
                    </ul>
                    
                    <ul class="footer-link">
                        <li class="header"><h5>{l s='Customers service'}</h5></li>
                        <li><a href="{$link->getPageLink('contact', true)|escape:'html'}" rel="nofollow">{l s='Contact us'}</a></li>
                        <li><a href="{$link->getCMSLink(1)|escape:'html'}" rel="nofollow">{l s='Deliveries'}</a></li>
                        <li><a href="{$link->getCMSLink(11)|escape:'html'}" rel="nofollow">{l s='Money back '}</a></li>
                        <li><a href="{$link->getCMSLink(5)|escape:'html'}" rel="nofollow">{l s='Secure payment'}</a></li>
                        <li><a href="{$link->getCMSLink(12)|escape:'html'}">{l s='FAQs'}</a></li>
                        <li><a href="{$link->getPageLink('sitemap')|escape:'html'}">{l s='Sitemap'}</a></li>
                    </ul>

                    <ul class="footer-link">
                        <li class="header"><h5>{l s='Informations'}</h5></li>
                        {if !$PS_CATALOG_MODE}<li><a href="{$link->getCategoryLink(77)|escape:'html'}">{l s='Specials'}</a></li>{/if}
                        <li><a href="{$link->getPageLink('new-products')|escape:'html'}">{l s='New products'}</a></li>
                        {if !$PS_CATALOG_MODE}<li><a href="{$link->getPageLink('best-sales')|escape:'html'}">{l s='Top sellers'}</a></li>{/if}
                        <li><a href="{$link->getPageLink('stores')|escape:'html'}">{l s='Our stores'}</a></li>
                        <li><a href="{$link->getCMSLink(3)|escape:'html'}" rel="nofollow">{l s='CGV'}</a></li>
                        <li><a href="{$link->getCMSLink(2)|escape:'html'}" rel="nofollow">{l s='Legal notice'}</a></li>
                    </ul>
                    
                    {$HOOK_FOOTER}
                    
                    {*<div id="newsletter">
                        <h5>{l s='Newsletter subscription'}</h5>
                        <p>{l s='Subscribe to our newsletter to receive news from Bougie la française'}</p>
                        <a href="{$link->getCMSLink(19)|escape:'html'}">{l s='Subscribe newsletter'}<span></span></a>
                    </div>*}
                    
                    <div id="line"></div>
                    
                    <div id="payment-block">
                        <h5>{l s='Payment'}</h5>
                        <img id="paiement-logo" src="{$img_dir}paiement-logo.png" alt="{l s='Paiement by mastercard, visa'}" />
                    </div>
                    <p id="made">{l s='Family Business centennial'}</p>
                    <p id="copyright">© Bougies la Française - 2014</p>
                </div>
			</footer>

        {/if}

        <script type="text/javascript" src="//cdn.tradelab.fr/tag/24a6364da5.js"></script>
        <script type="text/javascript" src="//use.typekit.net/kgt6zsh.js"></script>
        <script type="text/javascript">{literal}try{Typekit.load();}catch(e){}{/literal}</script>
		
		<script src="//connect.facebook.net/fr_FR/all.js#xfbml=1" type="text/javascript">/* <![CDATA[ *//* ]]> */</script>
		<script src="/modules/allinone_rewards/js/facebook.js" type="text/javascript">/* <![CDATA[ *//* ]]> */</script>	
		<script src="/modules/homeslider/js/jquery.bxSlider.min.js" type="text/javascript"></script>
		<script src="/modules/homeslider/js/homeslider.js" type="text/javascript"></script>
		<script src="/js/jquery/plugins/fancybox/jquery.fancybox.js" type="text/javascript">/* <![CDATA[ *//* ]]> */</script>
		
		<script src="/themes/blf/js/vendor/modernizr-2.6.2.min.js" type="text/javascript"></script>
		<script src="/themes/blf/js/vendor/plugins.js" type="text/javascript"></script>
		<script src="/themes/blf/js/script.js" type="text/javascript"></script>
	</body>
</html>
