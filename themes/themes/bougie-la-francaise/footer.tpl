{*
* 2007-2016 PrestaShop
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
*  @copyright  2007-2016 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
{if !isset($content_only) || !$content_only}
							</div><!-- #center_column -->
							{if isset($right_column_size) && !empty($right_column_size)}
								<div id="right_column" class="col-xs-12 col-sm-{$right_column_size|intval} column">{$HOOK_RIGHT_COLUMN}</div>
							{/if}
						
					{if $page_name != 'index'}
						</div><!-- .row -->
					</div><!-- .container -->
					{/if}
					
				</div><!-- #columns -->
			</div><!-- .columns-container -->
			{if $page_name == 'cms'}
				<div class="footer-collections">
					{hook h='customSliderCollections'}
				</div>
			{/if}
			{if isset($HOOK_FOOTER)}
				<!-- Footer -->
				<div class="footer-container">
					<footer id="footer">
						<div id="footer-find-store" class="footer-static-content">
							<div class="container">
								<div class="row">
									<p class="blf-title"><i class="ycon-boutiques"></i> <span>{l s='Find a store'}</span></p>
									<p>{l s='The stores nearest to you'}</p>
									<a class="link-btn" href="{$link->getPageLink('stores')|escape:'html':'UTF-8'}" title="{l s='Our stores'}">
										{l s='Search stores'}
									</a>
								</div>
							</div>
							
						</div>
						
						<!-- Content module footer -->
						{*<!--
						<div id="footer-engagements" class="footer-static-content">
							<div class="container">
								<div class="row">
									<div class="col-md-3 col-sm-6">
										<div class="engagement-block">
											<a href="/content/21-livraison-2448h" rel="nofollow">
												<i class="ycon-livraison-48-72"></i>
												<p>Livraison <br />48/72h</p>
											</a>
										</div>
									</div>
									<div class="col-md-3 col-sm-6">
										<div class="engagement-block">
											<a href="/content/22-livraison-offerte-des-45" rel="nofollow">
												<i class="ycon-livraison-offerte"></i>
												<p>Livraison offerte <br />dès 45€</p>
											</a>
										</div>
									</div>
									<div class="col-md-3 col-sm-6">
										<div class="engagement-block">
											<a href="/content/11-satisfait-ou-rembourse" rel="nofollow">
												<i class="ycon-satisfait-rembourse"></i>
												<p>Satisfait <br />ou remboursé</p>
											</a>
										</div>
									</div>
									<div class="col-md-3 col-sm-6">
										<div class="engagement-block">
											<a href="/content/24-votre-fidelite-recompensee" rel="nofollow">
												<i class="ycon-fidelite"></i>
												<p>Votre fidélité <br />récompensé</p>
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						-->*}
						<div class="footer-stages">
							<div class="footer-stage-1">
								{hook h='customFooterStage1'}
							</div>
							<div class="footer-stage-2">
								<div class="container">
									<div class="row">
										{hook h='customFooterStage2'}
										<div class="col-sm-3 col-xs-6">
											<div class="footer-block private-label-block">
												<a href="http://www.blf-privatelabel.com/">
													<h4>Private label</h4>
													{l s='Create a'} <strong>{l s='candle'}</strong>
													<br />{l s='to your'} <strong>{l s='brand'}</strong>
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="footer-stage-3">
								<div class="container">
									<div class="row">
										{$HOOK_FOOTER}
									</div>
									<div class="row">
										<div class="footer-credits clearfix">
											<div class="footer-payments-methods col-sm-6 col-xs-12">
												{l s='Payment methods'} <img src="/themes/bougie-la-francaise/image/design/footer-payments.jpg" alt="VISA, Mastercard, CB, Paypal" />
											</div>
											<div class="blf-credits col-sm-6 col-xs-12">
												© Bougies la Française - 2016 | <a href="{$link->getCMSLink(2)|escape:'html':'UTF-8'}" rel="nofollow">{l s='Legal Notice'}</a> | {l s='Website created by'} <a href="http://www.yateo.com" target="_blank">yateo.com</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</footer>
				</div><!-- #footer -->
			{/if}
		</div><!-- #page -->
		{*}<!--
		<div id="responsive-tester"><div id="mediaquery-width"></div></div>
		-->{*}
{/if}
{include file="$tpl_dir./global.tpl"}
	</body>
</html>