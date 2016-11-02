<?php

			/* For prerequisites checks */
			require_once(_PS_MODULE_DIR_.$this->name.'/lib/GTSChecks.php');
			$checks = new BT_GTSChecks();

			/* Check context */
			if (!BT_GTSChecks::checkShopGroup()) {
				$this->_html = '<div class="alert alert-danger">'.$this->l('For performance reasons, this module cannot be configured within a shop group context. You must configure it one shop at a time.').'</div>';
				return $this->_html;
			}

			/* Languages */
			$languages = $this->getAvailableLanguages($this->id_shop);
			$isoCurrent = Language::getIsoById((int)($this->context->cookie->id_lang));
			$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));

			/* Order states for order confirmation script, shipments feed etc... */
			$orderStatuses = OrderState::getOrderStates((int)($this->context->cookie->id_lang));

			if (!empty($this->configuration['GTRUSTEDSTORES_OK_ORDER_STATES'])) {
				$checkedStatuses = explode(',', $this->configuration['GTRUSTEDSTORES_OK_ORDER_STATES']);
			}
			else {
				$checkedStatuses = array();
			}

			if (!empty($this->configuration['GTRUSTEDSTORES_SHIPPED_STATUS'])) {
				$checkedShipStatuses = explode(',', $this->configuration['GTRUSTEDSTORES_SHIPPED_STATUS']);
			}
			else {
				$checkedShipStatuses = array();
			}
	
			/* detect version - case of jquery UI depreciated for 1.4.4 core */
			$bConflict = version_compare(_PS_VERSION_, '1.4.9.0') != -1? true : false;

			/* For missing fields highlight */
			$fieldErrorStyles = array();

			/* For shipping settings */
			$cutoffMinutes = array('00', '15', '30', '45');

			$weekdays = array(
				1 => $this->l('Monday', 'form_config'),
				2 => $this->l('Tuesday', 'form_config'),
				3 => $this->l('Wednesday', 'form_config'),
				4 => $this->l('Thursday', 'form_config'),
				5 => $this->l('Friday', 'form_config'),
				6 => $this->l('Saturday', 'form_config'),
				0 => $this->l('Sunday', 'form_config'),
			);

			$months = array(
				1 => array('name' => $this->l('January', 'form_config'), 'days' => 31),
				2 => array('name' => $this->l('February', 'form_config'), 'days' => 29),
				3 => array('name' => $this->l('March', 'form_config'), 'days' => 31),
				4 => array('name' => $this->l('April', 'form_config'), 'days' => 30),
				5 => array('name' => $this->l('May', 'form_config'), 'days' => 31),
				6 => array('name' => $this->l('June', 'form_config'), 'days' => 30),
				7 => array('name' => $this->l('July', 'form_config'), 'days' => 31),
				8 => array('name' => $this->l('August', 'form_config'), 'days' => 31),
				9 => array('name' => $this->l('September', 'form_config'), 'days' => 30),
				10 => array('name' => $this->l('October', 'form_config'), 'days' => 31),
				11 => array('name' => $this->l('November', 'form_config'), 'days' => 30),
				12 => array('name' => $this->l('December', 'form_config'), 'days' => 31),
			);

			if (!empty($_POST['closed_days'])) {
				$closedDays =  Tools::getValue('closed_days');
			}
			elseif(!empty($this->configuration['GTRUSTEDSTORES_CLOSED_DAYS'])) {
				$closedDays = (explode(',', $this->configuration['GTRUSTEDSTORES_CLOSED_DAYS']));
			}
			else {
				$closedDays = array();
			}

			if (!empty($_POST['holidays'])) {
				$holidays =  Tools::getValue('holidays');
			}
			elseif(!empty($this->configuration['GTRUSTEDSTORES_HOLIDAYS'])) {
				$holidays = (explode(',', $this->configuration['GTRUSTEDSTORES_HOLIDAYS']));
			}
			else {
				$holidays = array();
			}

			/* Prerequisites stuff */
			$prerequisites = array(
				'shop_domain' 		=> (int)((Configuration::get('PS_SHOP_DOMAIN')) ? true : false),
				'shop_domain_ssl' 	=> (int)((Configuration::get('PS_SHOP_DOMAIN_SSL')) ? true : false),
				'ssl_enabled' 		=> (int)((Configuration::get('PS_SSL_ENABLED')) ? true : false),
				'ssl_override' 		=> (int)$checks->checkSSLOverride(),
				'doc_type_ok' 		=> (int)$checks->checkThemeDocType(),
				'prefix_check'		=> (int)$checks->shopPrefixCheck(),
				'output_file'		=> (int)$checks->checkOutputFile(),
			);

			$req_ok_img = '<img src="'._MODULE_DIR_.$this->name.'views/img/admin/icon-valid.png" align="absmiddle" width="32" height="32" border="0" /> ';
			$req_ko_img = '<img src="'._MODULE_DIR_.$this->name.'views/img/admin/icon-invalid.png" align="absmiddle" width="32" height="32" border="0" /> ';

			// For order confirmation: estimated shipping time
			if (!empty($this->configuration['GTRUSTEDSTORES_SHIP_TIME'])) {
				$shipTimes = unserialize($this->configuration['GTRUSTEDSTORES_SHIP_TIME']);
			}
			else {
				$shipTimes = array();
			}

			// For feeds: carriers
			$carriers = $this->getAvailableCarriers();
			if (!empty($this->configuration['GTRUSTEDSTORES_CARRIERS'])) {
				$matchedCarriers = unserialize($this->configuration['GTRUSTEDSTORES_CARRIERS']);
			}
			else {
				$matchedCarriers = array();
			}

			// For order cancellation status codes matching to Google predefined reasons for cancellations
			if (!empty($this->configuration['GTRUSTEDSTORES_CANCEL_MATCHING'])) {
				$matchedCancelStatuses = unserialize($this->configuration['GTRUSTEDSTORES_CANCEL_MATCHING']);
			}
			else {
				$matchedCancelStatuses = array();
			}

			/* Start form code */
			$this->_html .= '
			<link rel="stylesheet" type="text/css" href="'._MODULE_DIR_.$this->name.'/views/css/admin.css" />
			<script type="text/javascript">
			ThickboxI18nImage = \''.$this->l('Image', 'form_config').'\';
			ThickboxI18nOf = \''.$this->l('on', 'form_config').'\';
			ThickboxI18nClose = \''.$this->l('Close', 'form_config').'\';
			ThickboxI18nOrEscKey = \' \';
			ThickboxI18nNext = \''.$this->l('Next', 'form_config').' >\';
			ThickboxI18nPrev = \'< '.$this->l('Previous', 'form_config').'\';
			tb_pathToImage = \''.__PS_BASE_URI__.'views/img/loadingAnimation.gif\';
			</script>';

			// jQuery version for 1.4 or 1.5
			if ($bConflict)
			{
				$this->_html .= '
			<script type="text/javascript" src="'._MODULE_DIR_.$this->name.'/views/js/jquery-1.4.4.min.js"></script>
			<script type="text/javascript">var JQuery144 = $.noConflict(true);</script>
			<script type="text/javascript" src="'._MODULE_DIR_.$this->name.'/views/js/thickbox-modified.js"></script>';
			}
			else
			{
				$this->_html .= '
			<script type="text/javascript" src="'.__PS_BASE_URI__.'js/jquery/thickbox-modified.js"></script>
			<script type="text/javascript" src="'._MODULE_DIR_.$this->name.'/views/js/jquery19-for-147lower.js"></script>';
			}

			if(version_compare(_PS_VERSION_, '1.6', '<'))
			{
				$this->_html .='
				<script type="text/javascript" src="'._MODULE_DIR_.$this->name.'/views/js/bootstrap.min.js"></script>
				<link rel="stylesheet" type="text/css" href="'._MODULE_DIR_.$this->name.'/views/css/bootstrap.min.css" />
				<link rel="stylesheet" type="text/css" href="'._MODULE_DIR_.$this->name.'/views/css/admin-theme.css" />
				<link rel="stylesheet" type="text/css" href="'._MODULE_DIR_.$this->name.'/views/css/admin-15-14.css" />
			';
			}

		$this->_html .= '
			<script>
				  $(function() {
				    $(".icon-question-sign").tooltip();
				  });
				  $(function() {
				    $(".label-tooltip").tooltip();
				  });
			</script>';


			$this->_html .= '
			<script type="text/javascript" src="'._MODULE_DIR_.$this->name.'/views/js/jquery-mutuallyExclusive.min.js"></script>
			<script type="text/javascript" src="'._MODULE_DIR_.$this->name.'/views/js/jquery-ui-1.5.3.min.js"></script>
			<script type="text/javascript">id_language = Number('.$defaultLanguage.');</script>
			
			<style type="text/css">
			.GTSTable th, .GTSTable td, .GTSTable th a, .GTSTable td a { font-size: 12px !important; }
			</style>
			
			<style type="text/css">
			@import url(\''.self::BT_API_MAIN_URL.'css/styles.css?ts='.time().'\');
			';
	
			ob_start();
			include _PS_MODULE_DIR_.$this->name.'/views/css/thickbox.css';
			$this->_html .= ob_get_contents();
			ob_end_clean();
	
			$this->_html .= '
			</style>';
			
			$this->_html .= '
			<p><img src="'._MODULE_DIR_.$this->name.'/views/img/admin/gts.png" width="350" height="62" border="0" /></p>
			<br/>
			<br/>
			<form action="'.$_SERVER['REQUEST_URI'].'" method="post">
			<div class="bootstrap">

				<div class="bootstrap alert alert-info">
				<h3><i class="icon icon-tags"></i>&nbsp;'.$this->l('Documentation','form_config').'</h3>
				&nbsp;'.$this->l('Please read carefully the documentation of the module', 'form_config').'</strong> <a target="_blank" href="'._PS_BASE_URL_._MODULE_DIR_.$this->name.'/readme_'.$isoCurrent.'.pdf">readme_'.$isoCurrent.'.pdf</a></p>
			</div>

				<ul class="nav nav-tabs" id="workTabs">
					<li class="active"><a data-toggle="tab" href="#tab-0"><span class="icon-home"></span>&nbsp;'.$this->l('Welcome', 'form_config').'</a></li>
					<li><a data-toggle="tab" href="#tab-1"><span class="icon-check"></span>&nbsp;'.$this->l('Prerequisite check', 'form_config').'</a></li>
					<li><a data-toggle="tab" href="#tab-2"><span class="icon-cog"></span>&nbsp;'.$this->l('Basic settings', 'form_config').'</a></li>
					<li><a data-toggle="tab" href="#tab-3"><span class="icon-star"></span>&nbsp;'.$this->l('Order settings', 'form_config').'</a></li>
					<li><a data-toggle="tab" href="#tab-4"><span class="icon-time"></span>&nbsp;'.$this->l('Shipping settings', 'form_config').'</a></li>
					<!--<li><a data-toggle="tab" href="#tab-5"><span class="icon-tag"></span>&nbsp;'.$this->l('Feed settings', 'form_config').'</a></li>
					<li><a data-toggle="tab" href="#tab-6"><span class="icon-play"></span>&nbsp;'.$this->l('Your feeds', 'form_config').'</a></li>-->
					<li><a data-toggle="tab" href="#tab-7"><span class="icon-file"></span>&nbsp;'.$this->l('Help resources', 'form_config').'</a></li>
				</ul>
				<div class="tab-content">
					<div id="tab-0" class="tab-pane fade in active information">
						<h2 style="font-size: 16px;">'.$this->l('IMPORTANT INFORMATION: PLEASE READ...', 'form_config').'</h2>
						<div class="clr_hr"></div>
						<div class="clr_20"></div>
						<div class="fbpscClearAdmin"></div>
						<div class="alert alert-success" style="display: block !important;">
							<p style="font-weight: bold; color: #FF0000;">'.$this->l('You MUST first register for an account on https://www.google.com/trustedstores', 'form_config', 'form_config').'</p>
							<p style="font-weight: bold; color: #FF0000;">'.$this->l('You MUST ALSO register for an account on http://www.google.com/merchants/', 'form_config', 'form_config').'</p>
							<p style="font-weight: bold; color: #FF0000;">'.$this->l('Please be sure to consult the Help resources section (last tab on the left menu)', 'form_config').'</p>
							<p>'.$this->l('Please be sure to read the documentation carefully and use the help resources available (last tab on the left menu). Please also be aware that Google requires your checkout and order confirmation pages to be hosted on https / SSL. Therefore, you will need to have an SSL certificate installed on your website to participate in the Google Trusted Stores program. Please also check the "Prerequisites" tab of this module before anything else to see if you satisfy all of them.', 'form_config').'</p>
						</div>
						<p>&nbsp;</p>
						<iframe class="btxsellingiframe" src="'.self::BT_API_MAIN_URL.'?ts='.time().'&sName='.$this->name.'&sLang='.$isoCurrent.'"></iframe>
					</div> <!-- end tab 0 -->

					<div id="tab-1" class="tab-pane fade">
						<div class="form-horizontal">
							<h2 style="font-size: 16px;">'.$this->l('Prerequisites check', 'form_config').'</h2>
							<div class="clr_hr"></div>
							<div class="clr_20"></div>
							<div class="fbpscClearAdmin"></div>
							<div class="alert alert-info">
								<p>'.$this->l('This section lets you verify that your store is properly configured and meets all necessary technical requirements to qualify for Google\'s Trusted Stores program and for the module to function properly. You should see a green check next to each item. If not, then there will be an explanation next to the icon to help you fix the issue.', 'form_config').'</p>
								<p>'.$this->l('Please also be aware that Google requires your checkout and order confirmation pages to be hosted on https / SSL. Therefore, you will need to have an SSL certificate installed on your website to participate in the Google Trusted Stores program.', 'form_config').'</p><br />
							</div>
							<div class="form-group">
								<div class="col-lg-4">'.
									(!empty($prerequisites['shop_domain']) ? '<div class="alert alert-success">'.$this->l('Shop domain is configured', 'form-config').'</div>' : '<div class="alert alert-danger">'.$this->l('Shop domain is not configured : you need to set this in the back office: Preferences: SEO & URLs', 'form_config').'</div>').'
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-4">'.
									(!empty($prerequisites['shop_domain_ssl']) ? '<div class="alert alert-success">'.$this->l('Shop SSL Domain is configured', 'form-config').'</div>' : '<div class="alert alert-danger">'.$this->l('Shop SSL Domain is not configured : you need to set this in the back office: Preferences: SEO & URLs', 'form_config').'</div>').'
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-4">'.
									(!empty($prerequisites['ssl_enabled']) ? '<div class="alert alert-success">'.$this->l('SSL is enabled', 'form-config').'</div>' :'<div class="alert alert-danger">'.$this->l('SSL is disabled : You need to set this in the back office: Preferences: General', 'form_config').'</div>').'
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-4">';
									if ($prerequisites['ssl_override'] == -2)
									{
										$this->_html .= '<div class="alert alert-danger">'.$this->l('You need to install our override file. ', 'form_config').'
										<a target="_blank" href="'.self::BT_FAQ_MAIN_URL.'70&lg='.$isoCurrent.'" target="_blank">&nbsp;<span class="icon-info-sign"></span>&nbsp'.$this->l('Click for more information ', 'form_config').'</a></div>
										';
									}
									elseif ($prerequisites['ssl_override'] == -1)
									{
										$this->_html .= '<div class="alert alert-danger">'.$this->l('An override file is installed but does not have the necessary code in it. Click this icon for help: ', 'form_config').'
										<a target="_blank" href="'.self::BT_FAQ_MAIN_URL.'70&lg='.$isoCurrent.'" target="_blank">&nbsp;<span class="icon-info-sign"></span>&nbsp'.$this->l('Click for more information ', 'form_config').'</a></div>';
									}
									elseif ($prerequisites['ssl_override'] == 0)
									{
										$this->_html .= '<div class="alert alert-danger">'.$this->l('An override file is installed and has the necessary code in it, but the class_index.php file has not been updated. ', 'form_config').'
										<a target="_blank" href="'.self::BT_FAQ_MAIN_URL.'70&lg='.$isoCurrent.'" target="_blank">&nbsp;<span class="icon-info-sign"></span>&nbsp'.$this->l('Click for more information ', 'form_config').'</a></div>';
									}
									elseif ($prerequisites['ssl_override'] ==1)
									{
										$this->_html .= '<div class="alert alert-success">'.$this->l('Override file is installed for order confirmation on SSL', 'form-config').'</div>';
									}
									$this->_html .= '
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-4">';
									if ($prerequisites['doc_type_ok'] == 0)
									{
										$this->_html .= '<div class="alert alert-danger">'.$this->l('You need to have the proper DOCTYPE tag in your theme\'s header.tpl file: <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">', 'form_config').'</div>';
									}
									elseif ($prerequisites['doc_type_ok'] == -1)
									{
										$this->_html .= '<div class="alert alert-danger">'.$this->l('We could not read your theme\'s header.tpl file due to insufficient file permissions. It could be OK, but please simply double-check that the HTML code in header.tpl starts with: <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">', 'form_config').'</div>';
									}
									elseif ($prerequisites['doc_type_ok'] == 1)
									{
										$this->_html .= '<div class="alert alert-success">'.$this->l('DOCTYPE tag is on your header tpl', 'form-config').'</div>';
									}
									$this->_html .= '
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-4">';
									if ($prerequisites['prefix_check'] == -1)
									{
										$this->_html .= '<div class="alert alert-danger">'.$this->l('You need to set the shop prefix in the module\'s bascic settings', 'form_config').'</div>';
									}
									elseif ($prerequisites['prefix_check'] == 0)
									{
										$this->_html .= '<div class="alert alert-danger">'.$this->l('You have set the prefix, but it is different from what you have set in our Google Merchant Center module. Please double-check your shop prefix setting in our Google Merchant Center module and make sure you use the same value in this module.', 'form_config').'</div>';
									}
									elseif ($prerequisites['prefix_check'] == 1)
									{
										$this->_html .= '<div class="alert alert-warning">'.$this->l('You have set your prefix, but we noticed you do not have our Google Merchant Center module installed and correctly configured to upload your products to Google Shopping. These 2 modules are meant to work together. You can buy Google Merchant Center on', 'form_config').' <a href="'.$this->l('http://addons.prestashop.com/en/seo-prestashop-modules/1768-google-merchant-center-the-best-google-shopping-module.html', 'form_config').'" target="_blank">'.$this->l('http://addons.prestashop.com/en/seo-prestashop-modules/1768-google-merchant-center-the-best-google-shopping-module.html', 'form_config').'</a></div>';
									}
									elseif ($prerequisites['prefix_check'] == 2)
									{
										$this->_html .= '<div class="alert alert-success">'.$this->l('Shop prefix is setted', 'form-config').'</div>';
									}
									$this->_html .= '
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-4">'.
									(!empty($prerequisites['output_file']) ? '<div class="alert alert-success">'.$this->l('Feed output file is correctly copied at website root', 'form-config').'</div>' : '<div class="alert alert-danger">'.$this->l('Please copy the gtrustedstores.feed.php file from the gtrustedstores module\'s directory to your shop\'s root directory', 'form_config').'</div>').'
								</div>
							</div>
						</div>

						<div class="clr_600 "></div>


					</div><!-- end tab 1 -->

					<div id="tab-2" class="tab-pane fade">
						<div class="form-horizontal">
							<h2 style="font-size: 16px;">'.$this->l('Basic settings', 'form_config').'</h2>
							<div class="clr_hr"></div>
							<div class="clr_20"></div>
							<div class="fbpscClearAdmin"></div>
							<p class="alert alert-info">'.$this->l('This section lets you set the basic settings necessary for the module to work.', 'form_config').'</p>

							<!--<div class="form-group ">
								<label class="control-label col-lg-3">
									<span class="label-tooltip" title="'.$this->l('Check this feature if your shop is located in USA', 'form_config').'"><b>'.$this->l('My shop is located in the USA ', 'form_config').'</b></span>
								</label>
								<div class="col-xs-2">
								<select name="shop_usa" id="shop_usa">
									<option value="0" '.(((int)$this->configuration['GTRUSTEDSTORES_SHOP_USA'] === 0) ? 'selected=selected' : '').'>'.$this->l('No', 'form_config').'</option>
									<option value="1" '.(((int)$this->configuration['GTRUSTEDSTORES_SHOP_USA'] === 1) ? 'selected=selected' : '').'>'.$this->l('Yes', 'form_config').'</option>
								</select>
								</div>
								<span class="icon-question-sign" title="'.$this->l('Check this feature if your shop is located in USA', 'form_config').'"></span>
								<a href="'.self::BT_FAQ_MAIN_URL.'8&lg='.$isoCurrent.'" target="_blank"></span></a>
							</div>-->

							<div class="form-group ">
								<label class="control-label col-lg-3">
									<span class="label-tooltip" title="'.$this->l('You will find this on your Google Trusted Stores account (https://www.google.com/trustedstores/sell), on the "Overview" tab', 'form_config').'"><b>'.$this->l('Your Google Trusted Stores ID', 'form_config').'</b></span>
								</label>
								<div class="col-xs-2">
									<input type="text"'.$this->_fieldErrorStyles['gts_id'].' size="10" name="gts_id" value="'.Tools::getValue('gts_id', $this->configuration['GTRUSTEDSTORES_GTS_ID']).'" />
								</div>
								<span class="icon-question-sign" title="'.$this->l('You will find on your Google Trusted Stores account (https://www.google.com/trustedstores/sell), on the "Overview" tab', 'form_config').'"></span>
								<a href="'.self::BT_FAQ_MAIN_URL.'8&lg='.$isoCurrent.'" target="_blank"></span></a>
							</div>

							<div class="form-group ">
								<label class="control-label col-lg-3">
									<span class="label-tooltip" title="'.$this->l('You will find this on the top LEFT of your Google Merchant Center account (http://www.google.com/merchants/)', 'form_config').'"><b>'.$this->l('Your Google Shopping / Merchant Center ID', 'form_config').'</b></span>
								</label>
								<div class="col-xs-2">
									<input type="text"'.$this->_fieldErrorStyles['gmc_id'].' size="10" name="gmc_id" value="'.Tools::getValue('gmc_id', $this->configuration['GTRUSTEDSTORES_GMC_ID']).'" />
								</div>
								<span class="icon-question-sign" title="'.$this->l('You will find this on the top LEFT of your Google Merchant Center account (http://www.google.com/merchants/)', 'form_config').'"></span>
							</div>

							<div class="form-group ">
								<label class="control-label col-lg-3">
									<span class="label-tooltip" title="'.$this->l('Enter a short prefix for your shop. If you are using our Google Merchant Center module to export your products, this should be the same value that you have already entered for this field in the Google Merchant Center module. If not, then, for example, if your shop is called "Janes\'s Flowers", enter jf, Please enter lowercase letters only', 'form_config').'"><b>'.$this->l('Product ID prefix for your shop', 'form_config').'</b></span>
								</label>
								<div class="col-xs-2">
									<input type="text" size="5" name="id_prefix" value="'.Tools::getValue('id_prefix', $this->configuration['GTRUSTEDSTORES_ID_PREFIX']).'" />
								</div>
								<span class="icon-question-sign" title="'.$this->l('Enter a short prefix for your shop. If you are using our Google Merchant Center module to export your products, this should be the same value that you have already entered for this field in the Google Merchant Center module. If not, then, for example, if your shop is called "Janes\'s Flowers", enter jf, Please enter lowercase letters only', 'form_config').'"></span>
							</div>

							<div class="form-group ">
								<label class="control-label col-lg-3">
									<span class="label-tooltip" title="'.$this->l('If set to yes, this will display the Google Trusted Stores certification badge on your store. You should leave this set to yes, but you can disable it here if you need to.', 'form_config').'"><b>'.$this->l('Display Trusted Stores badge ?', 'form_config').'</b></span>
								</label>
								<div class="col-xs-2">
								<select name="show_badge" id="badge_value">
									<option value="0"'
										.(((int)(0) === (int)(Tools::getValue('show_badge', $this->configuration['GTRUSTEDSTORES_SHOW_BADGE']))) ? ' selected="selected"' : '')
										.'>'.$this->l('No', 'form_config').'</option>'."\n".
										'<option value="1"'
										.(((int)(1) === (int)(Tools::getValue('show_badge', $this->configuration['GTRUSTEDSTORES_SHOW_BADGE']))) ? ' selected="selected"' : '')
										.'>'.$this->l('Bottom right (recommended by Google)', 'form_config').'</option>'
										.'<option value="2"'
										.(((int)(2) === (int)(Tools::getValue('show_badge', $this->configuration['GTRUSTEDSTORES_SHOW_BADGE']))) ? ' selected="selected"' : '')
										.'>'.$this->l('Customize', 'form_config').'</option>'
										;
										$this->_html .= '
								</select>
								</div>
								<span class="icon-question-sign" title="'.$this->l('If set to yes, this will display the Google Trusted Stores certification badge on your store. You should leave this set to yes, but you can disable it here if you need to.', 'form_config').'"></span>
							</div>

							<div class="form-group" id="customize_css">
								<label class="control-label col-lg-3">
									<span class="label-tooltip" title="'.$this->l('You can create your css style to maange the badge position', 'form_config').'"><b>'.$this->l('Create my CSS code', 'form_config').'</b></span>
								</label>
								<div class="col-lg-4">
									<textarea name="set_css" rows="25" cols="15">'.$this->configuration['GTRUSTEDSTORES_SHOW_BADGE_CSS'].'</textarea>
									<br/>
									<div class="alert alert-warning">
										<p>'.$this->l('You have to add : <div id="GTS_CONTAINER"></div> in your tpl file').'</p>
										<p>'.$this->l('This is the container that defines the location of the Trusted Stores badge. For any page with a USER_DEFINED position, you must place this div in the location where you would like the Google Trusted Stores badge to appear on that page').'</p>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-lg-3"></label>
								<div class="col-xs-2">
									<input type="submit" name="updateGTS" value="'.$this->l('Update settings', 'form_config').'" class="btn btn-success" />
								</div>
							</div>
						</div>



						<script>
						$( document ).ready(function() {
							$("#customize_css").hide();
							if ($("#badge_value").val() == "2")
							{
								$("#customize_css").show();
							}
							$("#badge_value").change(function(){
								if ($("#badge_value").val() == "2")
								{
									$("#customize_css").fadeIn();
								}
								else
								{
									$("#customize_css").fadeOut();
								}
							});

							$( "#shop_usa" ).change(function() {
								if ($( "#shop_usa" ).val() ==  "0")
								{

								}
								else
								{

								}
							});

						});
						</script>

						<div class="clr_600 "></div>

					</div> <!-- end of tab 2 -->

					<div id="tab-3" class="tab-pane fade">
						<div class="form-horizontal">
							<h2 style="font-size: 16px;">'.$this->l('Order settings', 'form_config').'</h2>
							<div class="clr_hr"></div>
							<div class="clr_20"></div>
							<div class="fbpscClearAdmin"></div>
							<p class="alert alert-info">'.$this->l('This section contains the settings that will determine when and how the order confirmation script will be executed on the order confirmation page, after a customer has placed an order, paid, and returned to your PrestaShop website.', 'form_config').'</p><br />

							<div class="form-group ">
								<label class="control-label col-lg-3">
									<span class="label-tooltip" title="'.$this->l('Here, you should select only order statuses that represent a valid order, paid in full. Usually, this will be limited to the "Payment accepted" order status, but according to your business rules, additional statuses may apply. In any case, you should check at least one status.', 'form_config').'"><b>'.$this->l('Valid order statuses', 'form_config').'</b></span>
								</label>
								<div class="'.(version_compare(_PS_VERSION_, '1.6', '<') ? "col-xs-4" :  "col-xs-2").'">';
										foreach ($orderStatuses as $os)
										{
											$checked = ((in_array($os['id_order_state'], $checkedStatuses)) ? ' checked="checked"' : '');
											$this->_html .= '
											<input'.$this->_fieldErrorStyles['ok_order_states'].' type="checkbox" name="ok_order_states[]" value="'.(int)($os['id_order_state']).'"'.$checked.' /> '.Tools::stripslashes($os['name'])."<br />\n";
										}
										$this->_html .='
								</div>
								<span class="icon-question-sign" title="'.$this->l('Here, you should select only order statuses that represent a valid order, paid in full. Usually, this will be limited to the "Payment accepted" order status, but according to your business rules, additional statuses may apply. In any case, you should check at least one status.', 'form_config').'"></span>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-3"></label>
								<div class="col-xs-2">
									<input type="submit" name="updateGTS" value="'.$this->l('Update settings', 'form_config').'" class="btn btn-success" />
								</div>
							</div>
						</div>
						<div class="clr_800 "></div>
					</div><!-- end of tab 3 -->

						<div id="tab-4" class="tab-pane fade">
							<div class="form-horizontal">
								<h2 style="font-size: 16px;">'.$this->l('Shipping settings', 'form_config').'</h2>
								<div class="clr_hr"></div>
								<div class="clr_20"></div>
								<div class="fbpscClearAdmin"></div>
								<p class="alert alert-info">'.$this->l('Google has strict requirements if you want to be accepted in their program. From fast order processing during business days to working with shipping carriers that provide online tracking, this section allows you to configure everything related to shipping and order processing.', 'form_config').'</p><br />
								<div class="form-group ">
									<label class="control-label col-lg-3">
										<span class="label-tooltip" title="'.$this->l('Check this box if you are almost always able to ship orders on the same day when an order is received before a certain time of day. If it past the time you set, the module will assume that the estimated shipping date will always be the next open business day following the order, unless items in the order are on back-order, in which case the latest estimated product availability date + 1 day will be used. If you do not check this box, then please fill out your order processing time in days below.', 'form_config').'"><b>'.$this->l('Same-day order processing', 'form_config').'</b></span>
									</label>
									<div class="col-xs-2">
										<input type="checkbox" onclick="return toggleDayPrefs(this);" name="same_day" value="1"'.((!empty($this->configuration['GTRUSTEDSTORES_SAME_DAY']) || Tools::getValue('same_day')) ? ' checked="checked"' : '').' /> '.'
										</select>
									</div>
									<span class="icon-question-sign" title="'.$this->l('Check this box if you are almost always able to ship orders on the same day when an order is received before a certain time of day. If it past the time you set, the module will assume that the estimated shipping date will always be the next open business day following the order, unless items in the order are on back-order, in which case the latest estimated product availability date + 1 day will be used. If you do not check this box, then please fill out your order processing time in days below.', 'form_config').'"></span>
								</div>

								<div class="form-group ">
									<label class="control-label col-lg-3">
										<span class="label-tooltip" title="'.$this->l('If you usually ship orders on the same day when orders are received before a certain time, you should set that cutoff time here. This setting uses 24-hour time format', 'form_config').'"><b>'.$this->l('Cut off time', 'form_config').'</b></span>
									</label>
									<div class="col-xs-2">
										<div class="col-xs-2">
											<select name="cutoff_hours">';
												for ($i = 0; $i <= 23; $i++)
												{
													$val = ( Tools::strlen($i) == 1 ? '0'.$i : $i);
													$selected = ($val == $this->configuration['GTRUSTEDSTORES_CUTOFF_HOURS'] || $val == Tools::getValue('cutoff_hours') ? ' selected="selected"' : '');
													$this->_html .= '<option value="'.$val.'"'.$selected.'>'.$val.'</option>';
												}
												$this->_html .='
												</select>
											</div>
											<div class="col-xs-2">
												<select name="cutoff_minutes">';
													foreach ($cutoffMinutes as $val)
													{
														$selected = ($val == $this->configuration['GTRUSTEDSTORES_CUTOFF_MINUTES'] || $val == Tools::getValue('cutoff_minutes') ? ' selected="selected"' : '');
														$this->_html .= '<option value="'.$val.'"'.$selected.'>'.$val.'</option>';
													}
													$this->_html .= '
												</select>
											</div>
									</div>
									<span class="icon-question-sign" title="'.$this->l('If you usually ship orders on the same day when orders are received before a certain time, you should set that cutoff time here. This setting uses 24-hour time format', 'form_config').'"></span>
								</div>

								<div class="form-group" id="orderTimePrefs">
									<label class="control-label col-lg-3">
										<span class="label-tooltip" title="'.$this->l('If you have not checked the same-day shipping checkbox above (which assumes that you either ship on the same day, or the next business day at the latest, depending on the time of the order), then indicate here how many days it takes you to ship after an order is placed. For example, if you usually ship on Wednesday for an order placed on Monday, then indicate 2. This value should probably be 3 at most to qualify for Google\'s performance standards. If items in the order are on back-order, here as well, the latest estimated product availability date + 1 day will be used.', 'form_config').'"><b>'.$this->l('Estimated order processing time', 'form_config').'</b></span>
									</label>
									<div class="col-xs-2">
										<input type="text"'.$this->_fieldErrorStyles['process_time'].' size="10" name="process_time" value="'.Tools::getValue('process_time', $this->configuration['GTRUSTEDSTORES_PROCESS_TIME']).'" />
									</div>
									<span class="icon-question-sign" title="'.$this->l('If you have not checked the same-day shipping checkbox above (which assumes that you either ship on the same day, or the next business day at the latest, depending on the time of the order), then indicate here how many days it takes you to ship after an order is placed. For example, if you usually ship on Wednesday for an order placed on Monday, then indicate 2. This value should probably be 3 at most to qualify for Google\'s performance standards. If items in the order are on back-order, here as well, the latest estimated product availability date + 1 day will be used.', 'form_config').'"></span>
								</div>

								<div class="form-group ">
									<label class="control-label col-lg-3">
										<span class="label-tooltip" title="'.$this->l('Check here the days where your business is closed and you do not ship orders. This is usually Saturday and Sunday, but can be different in some cases based on your location.', 'form_config').'"><b>'.$this->l('Week-end / closed days', 'form_config').'</b></span>
									</label>
									<div class="col-xs-2">';
										foreach ($weekdays as $num => $label) {
											$checked = (in_array($num, $closedDays) ? ' checked="checked"' : '');
											$this->_html .= '<input type="checkbox" name="closed_days[]" value="'.$num.'"'.$checked.'> <span style="color: #000;">'.$label.'</span><br />';
										}
										$this->_html .= '
									</div>
									<span class="icon-question-sign" title="'.$this->l('Check here the days where your business is closed and you do not ship orders. This is usually Saturday and Sunday, but can be different in some cases based on your location.', 'form_config').'"></span>
									<a href="'.self::BT_FAQ_MAIN_URL.'8&lg='.$isoCurrent.'" target="_blank"></span></a>
								</div>

								<div class="form-group ">
									<label class="control-label col-lg-3">
										<span class="label-tooltip" title="'.$this->l('Select here the additional days during the year where your business is closed and you do not ship orders. This usually includes Christmas, January 1st etc... But additional Holidays will vary based on your country. DO NOT check week-end days here. This is already managed by the setting above.', 'form_config').'"><b>'.$this->l('National holidays / additional closed days', 'form_config').'</b></span>
									</label>
									<div class=""'.(version_compare(_PS_VERSION_, '1.6', '<') ? "col-xs-4" :  "col-xs-2").'">
										<table border="0" cellpadding="0" cellspacing="12" class="table table-bordered">
										<tr>
										';
											foreach ($months as $num => $data) {
												$this->_html .= '<th valign="top"><b>'.mb_substr($data['name'], 0, 3).'</b></th>';
											}
											$this->_html .= '
																		</tr>
																		';
											$cnt = 1;
											foreach ($months as $num => $data) {
												$style_extra = (($cnt % 2 == 0) ? ' background-color: #ACD7F2 !important' : '');
												$this->_html .= '<td valign="top" style="font-size: 11px !important;'.$style_extra.'">';
												for ($i = 1; $i <= $data['days']; $i++) {
													$day = $num.'_'.$i;
													$checked = (in_array($day, $holidays) ? ' checked="checked"' : '');
													$this->_html .= '<input type="checkbox" name="holidays[]" value="'.$day.'"'.$checked.'> <span style="color: #000;">'.$i.'</span><br />';
												}
												$this->_html .= '</td>';
												$cnt++;
											}
											$this->_html .= '
										</tr>
										</table>
									</div>
									&nbsp;<span class="icon-question-sign" title="'.$this->l('Select here the additional days during the year where your business is closed and you do not ship orders. This usually includes Christmas, January 1st etc... But additional Holidays will vary based on your country. DO NOT check week-end days here. This is already managed by the setting above.', 'form_config').'"></span>
								</div>

								<div class="form-group ">
										<label class="control-label col-lg-3">
											<span class="label-tooltip" title="' . $this->l('This is needed to tell Google the estimated delivery date. You should indicate here, in days (usually 1 to 4 days), how long your carrier usually takes to deliver a parcel.', 'form_config') . '"><b>' . $this->l('Average transport time (in days) for each carrier', 'form_config') . '</b></span>
										</label>
										<div class="col-lg-4">
											<table style="width:100%" border="0" cellpadding="2" cellspacing="2" class="table table-striped">
												<tr>
													<th>' . $this->l('Your carrier', 'form_config') . '</th>
													<th>' . $this->l('Average transport time (in days)', 'form_config') . '</th>
												</tr>
												';
									foreach ($carriers as $c) {
										$shipval = (!empty($_POST['ship_time'][$c['id_carrier']]) ? $_POST['ship_time'][$c['id_carrier']] : (!empty($shipTimes[(int)($c['id_carrier'])]) ? $shipTimes[(int)($c['id_carrier'])] : 0));
										$this->_html .= '<tr><td valign="top">' . Tools::stripslashes($c['name']) . '</td><td valign="top"><input type="text" size="3" name="ship_time[' . (int)($c['id_carrier']) . ']" value="'.(int)$shipval.'"></td></tr>';
									}
									$this->_html .= '</table>
											</div>
										<span class="icon-question-sign" title="' . $this->l('This is needed to tell Google the estimated delivery date. You should indicate here, in days (usually 1 to 4 days), how long your carrier usually takes to deliver a parcel.', 'form_config') . '"></span>
								</div>

								<div class="form-group">
									<label class="control-label col-lg-3"></label>
									<div class="col-xs-2">
										<input type="submit" name="updateGTS" value="'.$this->l('Update settings', 'form_config').'" class="btn btn-success" />
									</div>
								</div>
							</div>
							<div class="clr_600 "></div>
					</div><!-- end of tab 4 -->

					<div id="tab-5" class="tab-pane fade">
						<div class="form-horizontal">
							<h2 style="font-size: 16px;">'.$this->l('Feed settings', 'form_config').'</h2>
							<div class="clr_hr"></div>
							<div class="clr_20"></div>
							<div class="fbpscClearAdmin"></div>';
								if ($this->configuration['GTRUSTEDSTORES_SHOP_USA'] == 0) {
									$this->_html .= '<p class="alert alert-danger">'.$this->l('These options below are ONLY available if your shop is located in the USA. You can set this feature in the "Basics settings" tab','form_config').'</p>';
								}
								$this->_html .= '
								<div id="feed_settings_show">
									<p class="alert alert-info">'.$this->l('Here, you will be able to set the last few preferences necessary to generate your shipment and cancellation feeds.', 'form_config').'</p>
									<div class="form-group ">
										<label class="control-label col-lg-3">
											<span class="label-tooltip" title="' . $this->l('This is a security measure so people from the outside cannot call the feed URL and be able to view your shipments information. It can be any alphanumeric set of characters (letters and numbers only, no spaces or any other characters), 32 characters max (eg: 8ee7a6e2970c859f3071478972ab9565). We have automatically generated one on install for your convenience.', 'form_config') . '"><b>' . $this->l('Security token for your feeds', 'form_config') . '</b></span>
										</label>
										<div class="col-xs-2">
												<input type="text"' . $this->_fieldErrorStyles['feed_token'] . ' size="40" maxlength="32" name="feed_token" value="' . Tools::getValue('feed_token', $this->configuration['GTRUSTEDSTORES_FEED_TOKEN']) . '" />
										</div>
										<span class="icon-question-sign" title="' . $this->l('This is a security measure so people from the outside cannot call the feed URL and be able to view your shipments information. It can be any alphanumeric set of characters (letters and numbers only, no spaces or any other characters), 32 characters max (eg: 8ee7a6e2970c859f3071478972ab9565). We have automatically generated one on install for your convenience.', 'form_config') . '"></span>
									</div>

									<div class="form-group ">
										<label class="control-label col-lg-3">
											<span class="label-tooltip" title="' . $this->l('When sending your shipments feed, Google requires that the feed indicates the code of the carrier used. This corresponds to a list that is predefined by Google (see https://support.google.com/trustedstoresmerchant/answer/3272612?hl=en&ref_topic=3272286). Therefore, for each carrier, please select from the list an appropriate matching value (there is an "All other carriers" option at the end of the list).', 'form_config') . '"><b>' . $this->l('Carriers matching for shipments feed', 'form_config') . '</b></span>
										</label>
										<div class="col-lg-4">
											<table style="width:100%" border="0" cellpadding="2" cellspacing="2" class="table table-striped">
												<tr>
													<th>' . $this->l('Your carrier', 'form_config') . '</th>
													<th>' . $this->l('Google matching carrier', 'form_config') . '</th>
												</tr>
												';
									foreach ($carriers as $c) {
										$this->_html .= '<tr><td valign="top">' . Tools::stripslashes($c['name']) . '</td><td valign="top"><select name="carriers[' . (int)($c['id_carrier']) . ']">';

										foreach ($this->gCarriers as $k => $v) {
											$selected = ((!empty($matchedCarriers) && $k == $matchedCarriers[(int)($c['id_carrier'])]) ? ' selected="selected"' : '');
											$this->_html .= '<option' . $selected . ' value="' . $k . '">' . $v . '</option>';
										}
										$this->_html .= '</select></td></tr>';
									}
									$this->_html .= '</table>
											</div>
										<span class="icon-question-sign" title="' . $this->l('When sending your shipments feed, Google requires that the feed indicates the code of the carrier used. This corresponds to a list that is predefined by Google (see https://support.google.com/trustedstoresmerchant/answer/3272612?hl=en&ref_topic=3272286). Therefore, for each carrier, please select from the list an appropriate matching value (there is an "All other carriers" option at the end of the list).', 'form_config') . '"></span>
									</div>

									<div class="form-group ">
										<label class="control-label col-lg-3">
											<span class="label-tooltip" title="' . $this->l('Indicate here all order statuses that indicate that an order has been shipped. This is usually only the "Shipped" status, but according to your business rules, you may have additional ones.', 'form_config') . '"><b>' . $this->l('Statuses for shipments feed', 'form_config') . '</b></span>
										</label>
										<div class="' . (version_compare(_PS_VERSION_, '1.6', '<') ? "col-xs-4" : "col-xs-2") . '">';
									foreach ($orderStatuses as $os) {
										$checked = ((in_array($os['id_order_state'], $checkedShipStatuses)) ? ' checked="checked"' : '');
										$this->_html .= '
																		<input' . $this->_fieldErrorStyles['shipped_status'] . ' type="checkbox" name="shipped_status[]" value="' . (int)($os['id_order_state']) . '"' . $checked . ' /> ' . Tools::stripslashes($os['name']) . "<br />\n";
									}

									$this->_html .= '
										</div>
										<span class="icon-question-sign" title="' . $this->l('Indicate here all order statuses that indicate that an order has been shipped. This is usually only the "Shipped" status, but according to your business rules, you may have additional ones.', 'form_config') . '"></span>
									</div>

									<div class="form-group ">
										<label class="control-label col-lg-3">
											<span class="label-tooltip" title="' . $this->l('When sending your cancellation feed, Google requires that the feed indicates the reason for the cancellation, and there are 4 possible values (see https://support.google.com/trustedstoresmerchant/answer/3272615?hl=en&ref_topic=3272286). Therefore, you MUST have 4 different cancellation statuses in your back-office, and match each one to the reasons above. See the PDF documentation link on the "Help resources" tab for detailed instructions on this.', 'form_config') . '"><b>' . $this->l('Statuses for cancellations feed', 'form_config') . '</b></span>
										</label>
										<div class="col-xs-2">
										<span style="color: red; font-weight: bold;">' . $this->l('Note: the select menus below are mutually exclusive to ensure that a given status cannot be selected more than once. So, you need to deselect a status from a select before it becomes available for another select. You can select one of the statuses you will never use as an intermediate step if you want to exchange 2 statuses.', 'form_config') . '</span><br /><br />';
									foreach ($this->gCancelReasons as $code => $label) {
										$value = (!empty($matchedCancelStatuses) && array_key_exists($code, $matchedCancelStatuses) ? $matchedCancelStatuses[$code] : 0);
										$this->_html .= $label . ':<br />
																	<select class="cancel_status" id="cancel_' . $code . '" name="cancel_statuses[' . $code . ']">';
										foreach ($orderStatuses as $os) {
											$selected = ((int)($os['id_order_state']) == (int)($value) ? ' selected="selected"' : '');
											$this->_html .= '<option' . $selected . ' value="' . (int)($os['id_order_state']) . '">' . Tools::stripslashes($os['name']) . '</option>';
										}
										$this->_html .= '
											</select><br />
											';
									}
									$this->_html .= '
										</div>
										<span class="icon-question-sign" title="' . $this->l('When sending your cancellation feed, Google requires that the feed indicates the reason for the cancellation, and there are 4 possible values (see https://support.google.com/trustedstoresmerchant/answer/3272615?hl=en&ref_topic=3272286). Therefore, you MUST have 4 different cancellation statuses in your back-office, and match each one to the reasons above. See the PDF documentation link on the "Help resources" tab for detailed instructions on this.', 'form_config') . '"></span>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-3"></label>
										<div class="col-xs-2">
											<input type="submit" name="updateGTS" value="' . $this->l('Update settings', 'form_config') . '" class="btn btn-success" />
										</div>
									</div>
								</div>';

							$this->_html .= '
						</div>
					</div><!-- end of tab 5 -->

					<div id="tab-6" class="tab-pane fade">
						<div class="form-horizontal">
							<h2 style="font-size: 16px;">'.$this->l('Your feeds', 'form_config').'</h2>
							<div class="clr_hr"></div>
							<div class="clr_20"></div>
							<div class="fbpscClearAdmin"></div>';
							if ($this->configuration['GTRUSTEDSTORES_SHOP_USA'] == 0) {
								$this->_html .= '<p class="alert alert-danger">'.$this->l('These options below are ONLY available if your shop is located in the USA. You can set this feature in the "Basics settings" tab','form_config').'</p>';
							}
								$this->_html .= '
							<p class="alert alert-info">'.$this->l('Here, you will find the links you will need to copy / paste in the Google Merchant Center website to tell Google how to get your shipment and cancellation feeds. There is one feed link per country for each type of feed, as each feed must contain ONLY orders for the destination country matching the feed country on the Google Merchant Center website.', 'form_config').'</p>
							<div class="alert alert-info" style="color: red; display: block !important; font-weight: bold;">
							'.$this->l('WARNING: Only orders placed and shipped AFTER the module has been installed will show up in the feeds. Therefore, when you first install the module, the feeds will be empty. This is entirely normal and is actually required for everything to check out correctly on Google\'s end. It will populate after your receive and ship your first order following the module\'s installation.', 'form_config').'
							</div><br />


							<div class="form-group ">
								<label class="control-label col-lg-3">
									'.$this->l('Your data feed', 'form_config').'
								</label>
								<div class="col-lg-5">
									<table border="0" cellpadding="2" cellspacing="2" class="table table-striped">
										<tr>
										<th nowrap="nowrap">'.$this->l('Country').'</th>
										<th nowrap="nowrap">'.$this->l('Link to copy / paste on the Google Merchant Center website', 'form_config').'</th>
										</tr>
										';
										foreach ($this->getValidCountries() as $id => $name)
										{
											$link = 'http://'.trim(Configuration::get('PS_SHOP_DOMAIN')).'/gtrustedstores.feed.php?action=shipments&token='.$this->configuration['GTRUSTEDSTORES_FEED_TOKEN'].'&id_country='.(int)($id);
											$this->_html .= '
											<tr>
											<td>'.$name.'</td>
											<td><a target="_blank" href="'.$link.'">'.$link.'</a></td>
											</tr>';
										}
									$this->_html .='
									</table><br /><br />
								</div>
							</div>
							<div class="form-group ">
								<label class="control-label col-lg-3">
									'.$this->l('Cancellation feeds', 'form_config').'
								</label>
								<div class="col-lg-5">
									<table border="0" cellpadding="2" cellspacing="2" class="table table-striped">
										<tr>
										<th nowrap="nowrap">'.$this->l('Country').'</th>
										<th nowrap="nowrap">'.$this->l('Link to copy / paste on the Google Merchant Center website', 'form_config').'</th>
										</tr>
										';
										foreach ($this->getValidCountries() as $id => $name)
										{
											$link = 'http://'.trim(Configuration::get('PS_SHOP_DOMAIN')).'/gtrustedstores.feed.php?action=cancellations&token='.$this->configuration['GTRUSTEDSTORES_FEED_TOKEN'].'&id_country='.(int)($id);
											$this->_html .= '
																	<tr>
																	<td>'.$name.'</td>
																	<td><a target="_blank" href="'.$link.'">'.$link.'</a></td>
																	</tr>
																	';
										}
										$this->_html .=
											'
									</table>
								</div>
							</div>
							';
						$this->_html .= '
						</div>
					</div><!-- end of tab 6 -->

					<div id="tab-7" class="tab-pane fade">
						<h2 style="font-size: 16px;">'.$this->l('Help resources', 'form_config').'</h2>
						<div class="clr_hr"></div>
						<div class="clr_20"></div>
						<div class="fbpscClearAdmin"></div>

						<p><strong style="font-weight: bold;"> '.$this->l('MODULE PDF DOCUMENTATION', 'form_config').' :</strong> <a target="_blank" href="'._MODULE_DIR_.$this->name.$this->l('/readme_en.pdf', 'form_config').'">'.$this->l('readme_en.pdf', 'form_config').'</a></p>
						<p><strong style="font-weight: bold;"> '.$this->l('ONLINE FAQ', 'form_config').' :</strong> <a target="_blank" href="'.$this->l('http://faq.businesstech.fr/?lg=en', 'form_config').'">'.$this->l('http://faq.businesstech.fr/?lg=en', 'form_config').'</a></p>
						<p><strong style="font-weight: bold;"> '.$this->l('GOOGLE TRUSTED STORES HELP', 'form_config').' :</strong> <a target="_blank" href="'.$this->l('https://support.google.com/trustedstoresmerchant/?hl=en', 'form_config').'">'.$this->l('https://support.google.com/trustedstoresmerchant/?hl=en', 'form_config').'</a></p>
						<p><strong style="font-weight: bold;"> '.$this->l('CONTACT US', 'form_config').' :</strong> <a target="_blank" href="'.$this->l('http://www.businesstech.fr/en/contact-us', 'form_config').'">'.$this->l('http://www.businesstech.fr/en/contact-us', 'form_config').'</a></p>
					</div><!-- end of tab 6 -->


				</div><!-- end of tab content-->
			</div><!-- end boostrap -->


			</form>
			
			<div id="loadingDiv" style="display: none;"><img src="'._MODULE_DIR_.$this->name.'views/img/admin/loading.gif" alt="Loading" /><br /><br />'.$this->l('Update in progress...', 'form_config').'</div>

			<script type="text/javascript">
			$(document).ready(function(){
				$("ul.ui-tabs-nav").tabs({selected : ' . ((isset($iActiveTab)) ? $iActiveTab : 0) . '});
				$("select.cancel_status").mutuallyExclusive();
			});
			
			function toggleDayPrefs(object) {
				if ($(object).attr("checked")) {
					$("#orderTimePrefs").hide("fast");
				}
				else {
					$("#orderTimePrefs").show("fast");
				}
			}
			</script>
			';

?>