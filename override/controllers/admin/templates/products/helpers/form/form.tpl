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

{extends file="controllers/products/helpers/form/form.tpl"}

{block name="autoload_tinyMCE"}
	{$smarty.block.parent}
    
    $('#description_short_1').attr('class', 'specificmce');
    
	tabs_manager.onLoad('Informations', function(){

		tinySetup({
            editor_selector :"specificmce",
			setup : function(ed) {
				ed.onInit.add(function(ed)
				{
					if (typeof ProductMultishop.load_tinymce[ed.id] != 'undefined')
					{
						if (typeof ProductMultishop.load_tinymce[ed.id])
							ed.hide();
						else
							ed.show();
					}
				});

				ed.onKeyUp.add(function(ed, e) {
					tinyMCE.triggerSave();
					textarea = $('#'+ed.id);
					max = textarea.parent('div').find('span.counter').attr('max');
					if (max != 'none')
					{
						textarea_value = textarea.val();
						count = stripHTML(textarea_value).length;
						rest = max - count;
						if (rest < 0)
							textarea.parent('div').find('span.counter').html('<span style="color:red;">{l s='Maximum'} '+max+' {l s='characters'} : '+rest+'</span>');
						else
							textarea.parent('div').find('span.counter').html(' ');
					}
				});
			},
            theme_advanced_buttons1 : "image,|,code",
            theme_advanced_buttons2 : "",
            theme_advanced_buttons3 : "",
            theme_advanced_buttons4 : "",
		});
	});
{/block}