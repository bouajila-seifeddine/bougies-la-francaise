<?php
include_once('../../config/config.inc.php');
$dir = str_replace('\\', '/', dirname(__FILE__));

if (is_dir($dir.'/../../themes/'._THEME_NAME_.'/modules/cartabandonmentpro'))
{
    // rmdir($dir.'/../../themes/'._THEME_NAME_.'/modules/cartabandonmentpro');
	deleteDirectory($dir.'/../../themes/'._THEME_NAME_.'/modules/cartabandonmentpro');
}
$token = Tools::getValue('token');
$token_bdd = Configuration::get('CARTABAND_TOKEN');

if(strlen($token_bdd) > 0 && isset($token_bdd) && isset($token) && $token_bdd == $token)
{
	require_once dirname(__FILE__).'/controllers/ReminderController.class.php';
	require_once dirname(__FILE__).'/controllers/TemplateController.class.php';
	require_once dirname(__FILE__).'/classes/Template.class.php';

	include_once('classes/Template.class.php');
	include_once('controllers/TemplateController.class.php');
	include_once('controllers/DiscountsController.class.php');
	include_once('classes/Model.class.php');

	$id_lang = Tools::getValue('id_lang');
	$iso = Language::getIsoById($id_lang);
	$id_shop = Tools::getValue('id_shop');
	$mail = Tools::getValue('mail');

	$templates = TemplateController::getAllTemplates($id_shop, $id_lang);

	$x = 0;
	if(!isset(Context::getContext()->link))
		Context::getContext()->link = new Link();
	foreach($templates as $template){
		$content = Tools::file_get_contents(realpath('./') . '/mails/' . $iso . '/' . $template['id_template'] . '.html');
		$templateObj = new Template($template['id_template'], new Model(TemplateController::getModelByTemplate($template['id_template'])));
		$content = $templateObj->editTemplate($content);

		if(!$content) continue;
		
		$discounts = DiscountsController::getDiscounts();
		
		$cart = new Cart(1);
		$total_cart = $cart->getOrderTotal();
		$i = 0;
		$disc = false;
		$disc_valid = false;
		$type = false;
		$min = false;
		$max = false;
		$value = false;

		foreach($discounts as $discount)
		{
			if($total_cart >= $discount['min_amount'])
			{
				$disc = $i;
				$disc_valid = $discount['valid_value'];
				$type = $discount['type'];
				$min = $discount['min_amount'];
				$max = $discount['max_amount'];
				$value = $discount['value'];
			}
			$i++;
		}
		if($disc >= 0)
		{
			$voucher = DiscountsController::createDiscount(1, $value, 1, $disc_valid, $type, $min, $max);
			$content = Template::editDiscount($voucher, $content, $id_lang);
		}
		else
			$content = str_replace('%DISCOUNT_TXT%', "", $content);
		
		$fp = fopen('mails/' . $iso . '/send.html', 'w+');
		fwrite($fp, $content);
		fclose($fp);
		$fp = fopen('mails/' . $iso . '/send.txt', 'w+');
		fwrite($fp, $content);
		fclose($fp);

		$title = Template::editTitleBeforeSending($template['template_name'], NULL, $id_lang);

		$mail = Mail::Send($id_lang, 'send', $title, array(), trim($mail), null, null, null, null, null, dirname(__FILE__) . '/mails/');

		if($mail)
			$x++;
	}
	echo $x . ' mails have been sent.';
}
else{
	echo 'hack ...';die;
}

function deleteDirectory($dir) {
    if (!file_exists($dir)) {
        return true;
    }

    if (!is_dir($dir)) {
        return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }

    }

    return rmdir($dir);
}