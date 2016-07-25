/**
 * Systempay payment module 1.2f (revision 61545)
 *
 * Compatible with V2 payment platform. Developped for Prestashop 1.5.0.x.
 * Support contact: supportvad@lyra-network.com.
 * 
 * Copyright (C) 2014 Lyra Network (http://www.lyra-network.com/) and contributors
 * 
 * 
 * NOTICE OF LICENSE
 *
 * This source file is licensed under the Open Software License version 3.0
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
*/

/**
 * Misc JavaScript functions.
 */

function systempayAddOption(first, deleteText) {
	if(first) {
		$('#systempay_multi_options_btn').css('display', 'none');
		$('#systempay_multi_options_table').css('display', '');
	}
	
	var timestamp = new Date().getTime();
	
	var optionLine = '<tr id="systempay_multi_option_' + timestamp + '">' +
					 '	<td><input name="SYSTEMPAY_MULTI_OPTIONS[' + timestamp + '][label]" style="width: 150px;" type="text"/></td>' + 
					 '	<td><input name="SYSTEMPAY_MULTI_OPTIONS[' + timestamp + '][amount_min]" style="width: 80px;" type="text"/></td>' +
					 '	<td><input name="SYSTEMPAY_MULTI_OPTIONS[' + timestamp + '][amount_max]" style="width: 80px;" type="text"/></td>' +
					 '	<td><input name="SYSTEMPAY_MULTI_OPTIONS[' + timestamp + '][contract]" style="width: 70px;" type="text"/></td>' +
					 '	<td><input name="SYSTEMPAY_MULTI_OPTIONS[' + timestamp + '][count]" style="width: 70px;" type="text"/></td>' +
					 '	<td><input name="SYSTEMPAY_MULTI_OPTIONS[' + timestamp + '][period]" style="width: 70px;" type="text"/></td>' +
					 '	<td><input name="SYSTEMPAY_MULTI_OPTIONS[' + timestamp + '][first]" style="width: 70px;" type="text"/></td>' +
					 '	<td><input type="button" value="' + deleteText + '" onclick="javascript: systempayDeleteOption(' + timestamp + ');"/></td>' +
					 '</tr>';
							
	$(optionLine).insertBefore('#systempay_multi_option_add');
}

function systempayDeleteOption(key) {
	$('#systempay_multi_option_' + key).remove();
	
	if($('#systempay_multi_options_table tbody tr').length == 1) {
		$('#systempay_multi_options_btn').css('display', '');
		$('#systempay_multi_options_table').css('display', 'none');
	}	
}

function systempayTypeChanged(key) {
	var type = $('#systempay_oney_type_' + key).val();
	
	if(type == 'RECLAIM_IN_SHOP') {
		$('#systempay_oney_address_' + key).css('display', '');
	} else {
		$('#systempay_oney_address_' + key).val('');
		$('#systempay_oney_address_' + key).css('display', 'none');
	}
}

function disableTable(e) {
    $('#systempay_oney_categories_table select').attr('disabled', e.checked);
    document.getElementById('systempay_oney_com_cat').disabled = !e.checked; 
    if (e.checked) {
	    e.value = '1';
	} else {
		e.value = '0';
	}
 }

// init selected tab in backoffice gui
var pos_select = 0;

function loadTab(id) {
	// static tabs, do nothing
}