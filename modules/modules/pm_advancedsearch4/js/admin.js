function deleteCriterionImg(id_criterion, id_search, id_lang) {
	$jqPm.ajax({
		type : "GET",
		url : _base_config_url + "&pm_load_function=processDeleteCriterionImg&id_criterion=" + id_criterion + "&id_search=" + id_search + "&id_lang=" + id_lang,
		dataType : "script",
		error : function (XMLHttpRequest, textStatus, errorThrown) {
			alert(msgAjaxError);
		}
	});
}

function displayHideBar(e) {
	var itemType = $jqPm(e).val();
	var itemName = $jqPm(e).attr("name");
	if ($jqPm(e).is(":checked")) {
		$jqPm("#hide_after_" + itemType).show("fast");
	} else {
		$jqPm("#hide_after_" + itemType).hide("fast");
	}
	var order = $jqPm(".connectedSortableIndex").sortable("toArray");
	saveOrder(order.join(","), "orderCriterionGroup", $jqPm(".connectedSortableIndex").find("input[name=id_search]").val(), $jqPm("input[name=auto_hide]").is(":checked"));

}

function showRelatedOptions(e, groupType) {
	var itemType = $jqPm(e).val();
	var itemName = $jqPm(e).attr("name");
	var isColorGroup = false;
	if ($jqPm('#display_type option.display_type-7').size() > 0) isColorGroup = true;
	
	// Init items display status
	$jqPm('#display_type-menu li').show();
	$jqPm('.blc_range, .blc_range_nb, .blc_range_interval, .blc_range_sign, .multicrit, .max_display_container').hide();
	if (groupType != 'attribute' && groupType != 'feature' && groupType != 'price' && groupType != 'depth' && groupType != 'height' && groupType != 'width' & groupType != 'weight') {
		$jqPm('#display_type option.display_type-5').removeAttr('selected').attr('disabled', 'disabled');
		$jqPm('#display_type').selectmenu();
	}
	if (groupType == 'category' || groupType == 'manufacturer' || groupType == 'supplier') {
		if ($jqPm("#range_on:checked").length) $jqPm("#range_off").attr('checked', 'checked');
		$jqPm(".multicrit").show();
	}
	if (groupType == 'price') {
		$jqPm('#display_type option.display_type-2').removeAttr('selected').attr('disabled', 'disabled');
		$jqPm('#display_type').selectmenu();
		if (itemType != "5" && $jqPm("#range_off:checked").length) $jqPm("#range_on").attr('checked', 'checked');
	}
	if (itemName == "step_search") {
		if (itemType == 0) $jqPm(".collapse").show("fast");
		else $jqPm(".collapse").hide("fast");
	}

	switch (itemType) {
		// Select
		case '1':
			if (groupType == 'price')
				$jqPm('.blc_range_interval, .max_display_container').show();
			else if (groupType == 'category' || groupType == 'manufacturer' || groupType == 'supplier' || groupType == 'on_sale' || groupType == 'condition' || groupType == 'online_only' || groupType == 'available_for_order' || groupType == 'stock')
				$jqPm('.max_display_container').show();
			else
				$jqPm('.blc_range, .blc_range_interval, .blc_range_sign, .max_display_container').show();
			break;
		// Image
		case '2':
			if ($jqPm("#range_on:checked").length) $jqPm("#range_off").attr('checked', 'checked');
			$jqPm(".multicrit, .max_display_container").show();
			break;
		// Link
		case '3':
			$jqPm(".max_display_container").show();
		// Checkbox
		case '4':
			$jqPm(".multicrit").show();
			if (groupType == 'price')
				$jqPm('.blc_range_interval, .max_display_container').show();
			else if (groupType == 'category' || groupType == 'manufacturer' || groupType == 'supplier' || groupType == 'on_sale' || groupType == 'condition' || groupType == 'online_only' || groupType == 'available_for_order' || groupType == 'stock')
				$jqPm('.max_display_container').show();
			else
				$jqPm('.blc_range, .blc_range_interval, .blc_range_sign, .max_display_container').show();
			break;
		// Cursor, Slider
		case '5':
			$jqPm(".blc_range_nb").show();
			if (groupType != 'price') $jqPm(".blc_range_sign").show();
			if ($jqPm("#range_on:checked").length) $jqPm("#range_off").attr('checked', 'checked');
			break;
		// Reserved
		case '6':
			break;
		// Color square
		case '7':
			$jqPm(".multicrit, .max_display_container").show();
			break;
	}
	
	// Reset change items
	if ($jqPm("#range_on:checked").length) {
		if (groupType != 'price') {
			$jqPm(".blc_range_interval, .blc_range_sign").show();
		} else {
			$jqPm(".blc_range_interval").show();
			$jqPm(".blc_range_sign").hide();
		}
	} else {
		if (itemType != 5)
			$jqPm(".blc_range_interval, .blc_range_sign").hide();
	}
	
	if (isColorGroup) {
		if ($jqPm("#range_on:checked").length) $jqPm("#range_off").attr('checked', 'checked');
		$jqPm('.blc_range, .blc_range_nb, .blc_range_interval, .blc_range_sign').hide();
		$jqPm('#display_type option.display_type-5').removeAttr('selected').attr('disabled', 'disabled');
		$jqPm('#display_type').selectmenu();
	}
}
function displayRangeOptions(e, groupType) {
	var valRange = parseInt($jqPm(e).val());
	if (valRange) {
		$jqPm(".blc_range_interval, .blc_range_sign").slideDown("fast");
		$jqPm('#display_type-menu li').show();
		$jqPm('#display_type-menu li.display_type-5').hide();
		if ($jqPm('#display_type').val() == 5)
			$jqPm('#display_type').val(1);
		$jqPm('#display_type').trigger('click');
	} else {
		$jqPm(".blc_range_interval, .blc_range_sign").slideUp("fast");

		$jqPm('#display_type-menu li.display_type-5').show();
	}
}
function hideNextIfTrue(e) {

	var val = parseInt($jqPm(e).val());
	if (val) {
		$jqPm(e).parent('.margin-form').next('div').slideUp('fast');
	} else {
		$jqPm(e).parent('.margin-form').next('div').slideDown('fast');
	}
}

function showNextIfTrue(e) {
	var val = parseInt($jqPm(e).val());
	if (val) {
		showNext(e);
	} else {
		hideNext(e);
	}
}
function showNext(e) {
	$jqPm(e).parent('.margin-form').next('div').slideDown('fast');
}
function hideNext(e) {
	$jqPm(e).parent('.margin-form').next('div').slideUp('fast');
}
function showSpanIfChecked(e, idToShow) {
	var val = $jqPm(e).attr('checked');
	if (val) {
		$jqPm(idToShow).css('display', 'inline');
	} else {
		$jqPm(idToShow).hide();
	}
}

var original_search_results_selector = false;
function updateHookOptions(e) {
	if (!original_search_results_selector && $jqPm('#search_results_selector').val() != '#as_home_content_results' && $jqPm('#search_results_selector').val() != '#as_custom_content_results')
		original_search_results_selector = $jqPm('#search_results_selector').val();
	else if (!original_search_results_selector && ($jqPm('#search_results_selector').val() == '#as_home_content_results' || $jqPm('#search_results_selector').val() == '#as_custom_content_results'))
		original_search_results_selector = '#center_column';
	var current_search_results_selector = $jqPm('#search_results_selector').val();
	var selectedHook = $jqPm(e).val();
	var selectedHookLabel = $jqPm('option:selected', e).text();
	$jqPm('.hookOptions').slideUp('fast');
	//Hide content selector if hook home
	if (selectedHookLabel == 'home' || selectedHookLabel == 'displayHome') {
		$jqPm('#blc_search_results_selector').hide();
		$jqPm('#search_results_selector').val('#as_home_content_results');
		$jqPm('.hookOption-' + selectedHookLabel).slideDown('fast');
	} else if (selectedHook == -1) {
		$jqPm("#custom_content_area_results").show();
		$jqPm('.hookOption' + selectedHook).slideDown('fast');
	} else {
		if (selectedHook >= 0 || !parseInt($jqPm("input[name=insert_in_center_column]").val()))
			$jqPm('#blc_search_results_selector').show();
		if (original_search_results_selector == '#center_column' || current_search_results_selector == '#as_home_content_results' || current_search_results_selector == '#as_custom_content_results') {
			$jqPm('#search_results_selector').val(original_search_results_selector);
		}
		$jqPm('.hookOption-' + selectedHookLabel).slideDown('fast');

		/*Ligne ci dessus A remplacer par*/
		/*
		if(original_search_results_selector == '#center_column' || current_search_results_selector == '#as_home_content_results' || current_search_results_selector == '#as_custom_content_results') {
		$jqPmSearch('#search_results_selector').val('#center_column');
		}else $jqPmSearch('#search_results_selector').val(original_search_results_selector);

		 */
	}
}
function updateDisplayHook() {
	/*var hasAction = false
	if ($jqPm('#inputProducts').val() == '') {
	$jqPm('#categoryDisplay').slideDown();
	$jqPm('select[name=id_hook] option.hookLine').attr('disabled', '').show();
	} else {
	$jqPm('#categoryDisplay').slideUp();
	$jqPm('#inputCategories').val('');
	$jqPm('select[name=id_hook] option.hookLine').attr('disabled', 'disabled')
	.hide();
	$jqPm('select[name=id_hook] option[class~="hookProduct"]').attr('disabled',
	'').show();
	$jqPm('select[name=id_hook]').val('0');
	hasAction = true;
	}
	if (!hasAction && $jqPm('#inputCategories').val() == '') {
	$jqPm('#productDisplay').slideDown();
	$jqPm('select[name=id_hook] option.hookLine').attr('disabled', '').show();

	} else if ($jqPm('#inputCategories').val() != '') {
	$jqPm('#productDisplay').slideUp();
	$jqPm('#inputProducts').val('');
	$jqPm('select[name=id_hook] option.hookLine').attr('disabled', 'disabled')
	.hide();
	$jqPm('select[name=id_hook] option[class~="hookCategory"]').attr(
	'disabled', '').show();
	$jqPm('select[name=id_hook]').val('0');
	}*/
}
function addCms(event, data, formatted) {
	if (data == null)
		return false;
	var cmsId = data[1];
	var cmsName = data[0];

	var $divCms = $jqPm('#divCms');
	var $inputCms = $jqPm('#inputCms');
	var $nameCms = $jqPm('#nameCms');
	/*
	 * delete cms from select + add cms line to the div, input_name,
	 * input_ids elements
	 */
	$divCms
	.html($divCms.html()
		 + cmsName
		 + ' <span onclick="delCms('
		 + cmsId
		 + ');" style="cursor: pointer;"><img src="../img/admin/delete.gif" /></span><br />');
	$nameCms.val($nameCms.val() + cmsName + '¤');
	$inputCms.val($inputCms.val() + cmsId + '-');
	$jqPm('#cms_autocomplete_input').val('');
	$jqPm('#cms_autocomplete_input').setOptions({
		extraParams : {
			excludeIds : $jqPm('#inputCms').val().replace(/\-/g, ',').replace(/\,$/, '')
		}
	});
	updateDisplayHook();
}
function delCms(id) {
	var div = getE('divCms');
	var input = getE('inputCms');
	var name = getE('nameCms');

	// Cut hidden fields in array
	var inputCut = input.value.split('-');
	var nameCut = name.value.split('¤');

	if (inputCut.lenght != nameCut.lenght)
		return alert('Bad size');

	// Reset all hidden fields
	input.value = '';
	name.value = '';
	div.innerHTML = '';
	for (i in inputCut) {
		// If empty, error, next
		if (!inputCut[i] || !nameCut[i])
			continue;

		// Add to hidden fields no selected cms OR add to select field
		// selected cms
		if (inputCut[i] != id) {
			input.value += inputCut[i] + '-';
			name.value += nameCut[i] + '¤';
			div.innerHTML += nameCut[i]
			 + ' <span onclick="delCms('
			 + inputCut[i]
			 + ');" style="cursor: pointer;"><img src="../img/admin/delete.gif" /></span><br />';
		} else
			$jqPm('#selectCms').append(
				'<option selected="selected" value="' + inputCut[i] + '-'
				 + nameCut[i] + '">' + inputCut[i] + ' - '
				 + nameCut[i] + '</option>');
	}
	updateDisplayHook();
}

function addCategory(event, data, formatted) {
	if (data == null)
		return false;
	var categoryId = data[1];
	var categoryName = data[0];

	var $divCategories = $jqPm('#divCategories');
	var $inputCategories = $jqPm('#inputCategories');
	var $nameCategories = $jqPm('#nameCategories');

	/*
	 * delete category from select + add category line to the div, input_name,
	 * input_ids elements
	 */
	$divCategories
	.html($divCategories.html()
		 + categoryName
		 + ' <span onclick="delCategory('
		 + categoryId
		 + ');" style="cursor: pointer;"><img src="../img/admin/delete.gif" /></span><br />');
	$nameCategories.val($nameCategories.val() + categoryName + '¤');
	$inputCategories.val($inputCategories.val() + categoryId + '-');
	$jqPm('#category_autocomplete_input').val('');
	$jqPm('#category_autocomplete_input').setOptions({
		extraParams : {
			excludeIds : $jqPm('#inputCategories').val().replace(/\-/g, ',').replace(/\,$/, '')
		}
	});
	updateDisplayHook();
}
function delCategory(id) {
	var div = getE('divCategories');
	var input = getE('inputCategories');
	var name = getE('nameCategories');

	// Cut hidden fields in array
	var inputCut = input.value.split('-');
	var nameCut = name.value.split('¤');

	if (inputCut.lenght != nameCut.lenght)
		return alert('Bad size');

	// Reset all hidden fields
	input.value = '';
	name.value = '';
	div.innerHTML = '';
	for (i in inputCut) {
		// If empty, error, next
		if (!inputCut[i] || !nameCut[i])
			continue;

		// Add to hidden fields no selected category OR add to select field
		// selected category
		if (inputCut[i] != id) {
			input.value += inputCut[i] + '-';
			name.value += nameCut[i] + '¤';
			div.innerHTML += nameCut[i]
			 + ' <span onclick="delCategory('
			 + inputCut[i]
			 + ');" style="cursor: pointer;"><img src="../img/admin/delete.gif" /></span><br />';
		} else
			$jqPm('#selectCategories').append(
				'<option selected="selected" value="' + inputCut[i] + '-'
				 + nameCut[i] + '">' + inputCut[i] + ' - '
				 + nameCut[i] + '</option>');
	}
	updateDisplayHook();
}

function setCriterionGroupActions(key_criterions_group, show) {
	$jqPm('#' + key_criterions_group).append('<a href="javascript:void(0);" ' + (typeof(show) == 'undefined' ? 'style="display:none;"' : '') + ' class="getCriterionGroupActions" id="action-' + key_criterions_group + '">' + editTranlate + '</a><div class="blocCriterionGroupActions"></div>');
	if (typeof(show) == 'undefined') {
		$jqPm("#action-" + key_criterions_group).fadeIn("fast").click(function () {
			getCriterionGroupActions(key_criterions_group);
		});
	} else {
		$jqPm("#action-" + key_criterions_group).click(function () {
			getCriterionGroupActions(key_criterions_group);
		});
	}
}
function getCriterionGroupActions(key_criterions_group, refresh) {
	if ((typeof(refresh) == 'undefined') && $jqPm('#' + key_criterions_group + ' .blocCriterionGroupActions div').length) {
		if ($jqPm('#' + key_criterions_group + ' .blocCriterionGroupActions:visible').length) {
			$jqPm('#' + key_criterions_group + ' .blocCriterionGroupActions').slideUp('slow');
		} else {
			$jqPm('#' + key_criterions_group + ' .blocCriterionGroupActions').slideDown('slow');
		}
	} else {
		var id_criterion_group = $jqPm('#' + key_criterions_group).attr('rel');
		var id_search = $jqPm('#' + key_criterions_group).children('input[name=id_search]').val();
		openDialogIframe(_base_config_url + "&id_search=" + id_search + "&pm_load_function=displayCriterionGroupForm&class=AdvancedSearchCriterionGroupClass&id_criterion_group=" + id_criterion_group, 830, 530, 1);
	}
	return;
}
function saveOrder(order, actionType, curId_search, auto_hide) {
	$jqPm.post(_base_config_url, {
		action : actionType,
		order : order,
		id_search : curId_search,
		auto_hide : auto_hide
	}, function (data) {
		parent.show_info(data);
	});
}
function receiveCriteria(item) {
	var curAction = $jqPm(item).parent("ul").parent("div").attr("id");
	if (curAction == "DesindexCriterionsGroup") {
		$jqPm("#action-" + $jqPm(item).attr("id")).unbind("click").remove();
		$jqPm(item).children(".blocCriterionGroupActions").remove();
	}
	$jqPm(item).append("<div class='loadingOnConnectList'><img src='" + _modulePath + "img/snake_transparent.gif' /></div>");
	$jqPm.ajax({
		type : "GET",
		url : _base_config_url + "&pm_load_function=process" + curAction + "&id_employee=" + _id_employee + "&key_criterions_group=" + $jqPm(item).attr("id"),
		dataType : "script",
		error : function (XMLHttpRequest, textStatus, errorThrown) {
			//alert(msgAjaxError);
		}
	});
}
function addCriterion(item) {
	$jqPm(item).hide().appendTo($jqPm('#IndexCriterionsGroup ul')).end().fadeIn('slow');
	receiveCriteria($jqPm(item));
}
function deleteCriterion(item) {
	$jqPm(item).hide().appendTo($jqPm('#IndexCriterionsGroup ul')).end().fadeIn('slow');
	receiveCriteria($jqPm(item));
}
function loadTabPanel(tabPanelId, li, ul, id_search) {
	var indexTab = $jqPm(li).index(ul);

	$jqPm(tabPanelId).tabs("load", indexTab, function (response, status, xhr) {
		if (status == "error") {
			//alert(msgAjaxError);
			return;
		}
	});
}
function addTabPanel(tabPanelId, label, id_search, load_after) {
	$jqPm("#msgNoResults").hide();
	if (typeof(load_after) != 'undefined' && load_after == true) {
		$jqPm(tabPanelId).unbind("tabsadd").bind("tabsadd", function (event, ui) {
			$jqPm(tabPanelId).tabs('select', '#' + ui.panel.id);
		});
	}
	$jqPm(tabPanelId).tabs("add", _base_config_url + '&pm_load_function=displaySearchAdminPanel&id_search=' + id_search, label);
	$jqPm(tabPanelId).children('li:last-child').attr('id', 'TabSearchAdminPanel' + id_search);
}
function removeTabPanel(tabPanelId, li, ul) {
	var indexTab = $jqPm(li).index();
	$jqPm(tabPanelId).tabs("remove", indexTab);
}

var defaultValueSubmit = false;
function showRequest(formData, jqForm, options) {
	var btn_submit = $jqPm(jqForm).find('input[type=submit]');
	defaultValueSubmit = $jqPm(btn_submit).attr('value');
	$jqPm(btn_submit).attr('disabled', 'disabled');
	$jqPm(btn_submit).attr('value', msgWait);
	return true;
}
// post-submit callback
function showResponse(responseText, statusText, xhr, $form) {
	var btn_submit = $form.find('input[type=submit]');
	if (defaultValueSubmit) {
		$jqPm(btn_submit).removeAttr('disabled');
		$jqPm(btn_submit).attr('value', defaultValueSubmit);
		defaultValueSubmit = false;
	}
}
function removeSelectedSeoCriterion(e) {
	var curId = $jqPm(e).parent('li').attr('rel');
	$jqPm('#' + curId).fadeIn('fast');
	$jqPm('#bis' + curId).remove();
	seoSearchCriteriaUpdate();
}
function seoSearchCriteriaUpdate() {
	var order = $jqPm("#seoSearchPanelCriteriaSelected ul").sortable("toArray");
	$jqPm("#posted_id_currency").val($jqPm("#id_currency").val());
	$jqPm("#seoSearchCriteriaInput").val(order);
	checkSeoCriteriaCombination();
}
function massSeoSearchCriteriaGroupUpdate() {
	var order = $jqPm("#seoMassSearchPanelCriteriaGroupsTabs ul").sortable("toArray");
	$jqPm("#posted_id_currency").val($jqPm("#id_currency").val());
	$jqPm("#massSeoSearchCriterionGroupsInput").val(order);
}
function fillSeoFields() {
	var criteria = $jqPm("#seoSearchPanelCriteriaSelected ul").sortable("toArray");
	if (criteria == '') {
		show_info(msgNoSeoCriterion);
		return;
	}
	$jqPm.ajax({
		type : "GET",
		url : _base_config_url + "&pm_load_function=processFillSeoFields&criteria=" + $jqPm("#seoSearchCriteriaInput").val() + "&id_search=" + $jqPm("#id_search").val() + "&id_currency=" + $jqPm("#posted_id_currency").val(),
		dataType : "script",
		error : function (XMLHttpRequest, textStatus, errorThrown) {
			//alert(msgAjaxError);
		}
	});
}

function checkChildrenCheckbox(e) {
	if ($jqPm(e).children('input[type=checkbox]:checked').length)
		$jqPm(e).children('input[type=checkbox]').removeAttr('checked');
	else
		$jqPm(e).children('input[type=checkbox]').attr('checked', 'checked');
}
function unCheckAllChildrenCheckbox(e) {
	$jqPm(e).find('input[type=checkbox]').removeAttr('checked');
}
function enableAllCriterion4MassSeo(e) {
	var parentDiv = $jqPm(e).parent('div');
	var id_criterion_group = $jqPm(parentDiv).children('input[name=id_criterion_group]').val();
	if (!$jqPm('#criterion_group_' + id_criterion_group + ':visible').length && $jqPm('.seoSearchCriterionGroupSortable:visible').length >= 3) {
		unCheckAllChildrenCheckbox(parentDiv);
		alert(msgMaxCriteriaForMass);
		return false;
	}
	$jqPm(parentDiv).find('li.massSeoSearchCriterion').trigger('click');
}

function enableCriterion4MassSeo(e) {
	checkChildrenCheckbox(e);
	var parentDiv = $jqPm(e).parent('ul').parent('div');
	var id_criterion_group = $jqPm(parentDiv).children('input[name=id_criterion_group]').val();

	if ($jqPm(parentDiv).find('input[type=checkbox]:checked').length) {
		if ($jqPm(e).children('input[type=checkbox]:checked').length) {
			if (!$jqPm('#criterion_group_' + id_criterion_group + ':visible').length) {
				if ($jqPm('.seoSearchCriterionGroupSortable:visible').length >= 3) {
					unCheckAllChildrenCheckbox(parentDiv);
					alert(msgMaxCriteriaForMass);
					return false;
				}
				$jqPm('#criterion_group_' + id_criterion_group).removeClass('ui-state-disabled').fadeIn('fast');
				$jqPm('#seoMassSearchPanelCriteriaGroupsTabs ul').sortable('refresh');
				massSeoSearchCriteriaGroupUpdate();
			}

		}
	} else {
		$jqPm('#criterion_group_' + id_criterion_group).addClass('ui-state-disabled').fadeOut('fast');
		$jqPm('#seoMassSearchPanelCriteriaGroupsTabs ul').sortable('refresh');
		massSeoSearchCriteriaGroupUpdate();
	}
}
function checkSeoCriteriaCombination() {
	$jqPm.ajax({
		type : "GET",
		url : _base_config_url + "&pm_load_function=checkSeoCriteriaCombination&criteria=" + $jqPm("#seoSearchCriteriaInput").val() + "&id_search=" + $jqPm("#id_search").val() + "&id_currency=" + $jqPm("#posted_id_currency").val(),
		dataType : "script",
		error : function (XMLHttpRequest, textStatus, errorThrown) {
			//alert(msgAjaxError);
		}
	});
}
function ASStr2url(e) {
	str = $jqPm(e).val();
	str = str.toUpperCase();
	str = str.toLowerCase();

	str = str.replace(/[\u0105\u0104\u00E0\u00E1\u00E2\u00E3\u00E4\u00E5]/g, 'a');
	str = str.replace(/[\u00E7\u010D\u0107\u0106]/g, 'c');
	str = str.replace(/[\u010F]/g, 'd');
	str = str.replace(/[\u00E8\u00E9\u00EA\u00EB\u011B\u0119\u0118]/g, 'e');
	str = str.replace(/[\u00EC\u00ED\u00EE\u00EF]/g, 'i');
	str = str.replace(/[\u0142\u0141]/g, 'l');
	str = str.replace(/[\u00F1\u0148]/g, 'n');
	str = str.replace(/[\u00F2\u00F3\u00F4\u00F5\u00F6\u00F8\u00D3]/g, 'o');
	str = str.replace(/[\u0159]/g, 'r');
	str = str.replace(/[\u015B\u015A\u0161]/g, 's');
	str = str.replace(/[\u00DF]/g, 'ss');
	str = str.replace(/[\u0165]/g, 't');
	str = str.replace(/[\u00F9\u00FA\u00FB\u00FC\u016F]/g, 'u');
	str = str.replace(/[\u00FD\u00FF]/g, 'y');
	str = str.replace(/[\u017C\u017A\u017B\u0179\u017E]/g, 'z');
	str = str.replace(/[\u00E6]/g, 'ae');
	str = str.replace(/[\u0153]/g, 'oe');
	str = str.replace(/[\u013E\u013A]/g, 'l');
	str = str.replace(/[\u0155]/g, 'r');

	str = str.replace(/[^a-z0-9\s\'\:\/\[\]-]/g, '');
	str = str.replace(/[\s\'\:\/\[\]-]+/g, ' ');
	str = str.replace(/[ ]/g, '-');
	str = str.replace(/[-]/g, '-');

	$jqPm(e).val(str)

	return true;
}
function updateSmartyVarNamPicker() {
	var val = $jqPm("#smarty_var_name").val();
	$jqPm("#smarty_var_name_picker").html('{if isset($' + val + ')}{$' + val + '}{/if}');
}

function selectText(element) {
	var doc = document;
	var text = doc.getElementById(element);
	if (doc.body.createTextRange) {
		var range = document.body.createTextRange();
		range.moveToElementText(text);
		range.select();
	} else if (window.getSelection) {
		var selection = window.getSelection();
		if (selection.setBaseAndExtent) {
			selection.setBaseAndExtent(text, 0, text, 1);
		} else {
			var range = document.createRange();
			range.selectNodeContents(text);
			selection.removeAllRanges();
			selection.addRange(range);
		}
	}
}
function checkAllSeoItems(id_search) {
	$jqPm('#dataTable' + id_search + ' input[name="seo_group_action[]"]:checked').removeAttr('checked').attr('isAltered', '1');
	$jqPm('#dataTable' + id_search + ' input[name="seo_group_action[]"][isAltered!=1]:not(:checked)').attr('checked', 'checked');
	$jqPm('#dataTable' + id_search + ' input[name="seo_group_action[]"]').removeAttr('isAltered');
}
function deleteSeoItems(id_search) {
	$jqPm.ajax({
		type : "GET",
		url : _base_config_url + "&pm_load_function=processDeleteMassSeo&id_search=" + id_search + '&' + $jqPm('#dataTable' + id_search + ' input[name="seo_group_action[]"]:checked').serialize(),
		dataType : "script",
		error : function (XMLHttpRequest, textStatus, errorThrown) {}
	});
}

function reorderCriteria(sort_by, sort_way, id_criterion_group, id_search) {
	$jqPm('#sortCriteriaPanel').load(_base_config_url + "&pm_load_function=displaySortCriteriaPanel&id_criterion_group=" + id_criterion_group + '&sort_by=' + sort_by + '&sort_way=' + sort_way + '&id_search=' + id_search);
}

function display_cat_picker() {
	var val = parseInt($jqPm('input[name="bool_cat"]:checked').val());
	if (val)
		$jqPm('#category_picker').show('medium');
	else
		$jqPm('#category_picker').hide('medium');
}

function display_prod_picker() {
	var val = parseInt($jqPm('input[name="bool_prod"]:checked').val());
	if (val)
		$jqPm('#product_picker').show('medium');
	else
		$jqPm('#product_picker').hide('medium');
}

function display_manu_picker() {
	var val = parseInt($jqPm('input[name="bool_manu"]:checked').val());
	if (val)
		$jqPm('#manu_picker').show('medium');
	else
		$jqPm('#manu_picker').hide('medium');
}

function display_supp_picker() {
	var val = parseInt($jqPm('input[name="bool_supp"]:checked').val());
	if (val)
		$jqPm('#supp_picker').show('medium');
	else
		$jqPm('#supp_picker').hide('medium');
}

function display_cms_picker() {
	var val = parseInt($jqPm('input[name="bool_cms"]:checked').val());
	if (val)
		$jqPm('#cms_picker').show('medium');
	else
		$jqPm('#cms_picker').hide('medium');
}

function display_spe_picker() {
	var val = parseInt($jqPm('input[name="bool_spe"]:checked').val());
	if (val)
		$jqPm('#special_pages').show('medium');
	else
		$jqPm('#special_pages').hide('medium');
}

var toogleDisplayCriteriaOptionsOff = false;
function toogleDisplayCriteriaOptions() {
	if (toogleDisplayCriteriaOptionsOff) {
		toogleDisplayCriteriaOptionsOff = false;
		return;
	}
	var step_search = parseInt($jqPm('input[name="step_search"]:checked').val());
	var save_selection = parseInt($jqPm('input[name="save_selection"]:checked').val());
	var display_empty_criteria = parseInt($jqPm('input[name="display_empty_criteria"]:checked').val());
	
	$jqPm('select[name="search_method"] option').removeAttr('disabled');
	$jqPm('select[name="search_method"]').trigger('change');
	if (step_search && display_empty_criteria) {
		$jqPm('div.displaySaveSelection').show('medium');
	} else if (step_search && !display_empty_criteria) {
		$jqPm('div.displaySaveSelection').hide('medium');
		toogleDisplayCriteriaOptionsOff = true;
		$jqPm('input[id="save_selection_off"]').trigger('click');
	} else if (!step_search) {
		$jqPm('div.displaySaveSelection').show('medium');
		if (save_selection) {
			$jqPm('select[name="search_method"] option[value=1]').removeAttr('selected').attr('disabled', 'disabled');
			$jqPm('select[name="search_method"] option[value=2]').removeAttr('disabled').attr('selected', 'selected');
			$jqPm('select[name="search_method"]').val(2).trigger('change');
		}
	}
	$jqPm('select[name="search_method"]').selectmenu();
	
	if (display_empty_criteria)
		$jqPm('#criteriaOptions').hide('medium');
	else
		$jqPm('#criteriaOptions').show('medium');
}

function display_search_method_options() {
	var val = parseInt($jqPm('select[name="search_method"]').val());
	if (val == 2) {
		$jqPm('.search_method_options').show('medium');
	} else
		$jqPm('.search_method_options').hide('medium');
}

var currentCriteriaGroupIndex = 0;
var prevCriteriaGroupIndex = -1;
var reindexation_in_progress = false;
function reindexSearchCritriaGroups(e, critriasGroups, wrapperProgress) {
	if (reindexation_in_progress) {
		alert(reindexationInprogressMsg);
		return;
	}
	reindexation_in_progress = true;
	var nbCriteriaGroupsTotal = critriasGroups.length;
	var nbCriteriaGroupsReindexed = 0;

	$jqPm(e).hide();

	var reindexationInterval = setInterval(function () {
			//Reindexation In progress
			if (typeof(critriasGroups[currentCriteriaGroupIndex]) != 'undefined' && currentCriteriaGroupIndex != prevCriteriaGroupIndex) {
				prevCriteriaGroupIndex++;
				$jqPm(wrapperProgress).progressbar({
					value : Math.round((currentCriteriaGroupIndex * 100) / nbCriteriaGroupsTotal)
				});
				$jqPm(wrapperProgress).next('.progressbarpercent').html(reindexingCriteriaMsg + ' ' + currentCriteriaGroupIndex + ' ' + reindexingCriteriaOfMsg + ' ' + nbCriteriaGroupsTotal + ' (' + Math.round((currentCriteriaGroupIndex * 100) / nbCriteriaGroupsTotal) + '%)');
				reindexSearchCritriaGroup(critriasGroups[currentCriteriaGroupIndex].id_criterion_group, critriasGroups[currentCriteriaGroupIndex].id_search);
			}
			//Reindexation done
			else if (typeof(critriasGroups[currentCriteriaGroupIndex]) == 'undefined') {
				$jqPm(wrapperProgress).progressbar({
					value : 100
				});
				clearInterval(reindexationInterval);
				$jqPm(e).show();
				$jqPm(wrapperProgress).next('.progressbarpercent').text("");
				$jqPm(wrapperProgress).progressbar("destroy");
				currentCriteriaGroupIndex = 0;
				prevCriteriaGroupIndex = -1;
				reindexation_in_progress = false;
			}
		}, 500);
}
function reindexSearchCritriaGroup(id_criterion_group, id_search) {
	$jqPm.ajax({
		type : "GET",
		url : _base_config_url + "&pm_load_function=reindexCriteriaGroup&id_criterion_group=" + id_criterion_group + "&id_search=" + id_search,
		dataType : "script",
		success : function (data) {
			currentCriteriaGroupIndex++;
		},
		error : function (XMLHttpRequest, textStatus, errorThrown) {
			alert(msgAjaxError);
		}
	});
}
