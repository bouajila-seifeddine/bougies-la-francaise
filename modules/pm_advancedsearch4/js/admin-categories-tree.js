/*
* 2007-2011 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
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
*  @copyright  2007-2011 PrestaShop SA
*  @version  Release: $Revision: 8130 $
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

var readyToExpand = true;
var needCheckAll = false;
var needUncheckAll = false;
var interval = null;
var id = 0;
var arrayCatToExpand = new Array();
var categoryBoxName = 'categoryBox[]';

$jqPm(document).ready(function(){
	$jqPm("#categories-treeview").treeview({
		url : _base_config_url+'&getPanel=getChildrenCategories',
		toggle: function () { callbackToggle($jqPm(this)); },
		ajax : {
			type: 'POST',
			async: true,
			data: {
				selectedCat: selectedCat
			}
		}
	});

	$jqPm('#categories-treeview li#'+category_root_id+' span').trigger('click');
	$jqPm('#categories-treeview li#'+category_root_id+'').children('div').remove();
	$jqPm('#categories-treeview li#'+category_root_id+'').
		removeClass('collapsable lastCollapsable').
		addClass('last static');

	$jqPm('#expand_all').click( function () {
		if ($jqPm(this).attr('rel') != '') categoryBoxName = $jqPm(this).attr('rel');
		expandAllCategories();
		return false;
	});

	$jqPm('#collapse_all').click( function () {
		if ($jqPm(this).attr('rel') != '') categoryBoxName = $jqPm(this).attr('rel');
		collapseAllCategories();
		return false;
	});

	$jqPm('#check_all').click( function () {
		if ($jqPm(this).attr('rel') != '') categoryBoxName = $jqPm(this).attr('rel');
		needCheckAll = true;
		checkAllCategories();
		return false;
	});

	$jqPm('#uncheck_all').click( function () {
		if ($jqPm(this).attr('rel') != '') categoryBoxName = $jqPm(this).attr('rel');
		needUncheckAll = true;
		uncheckAllCategories();
		return false;
	});
});

function callbackToggle(element)
{
	if (!element.is('.expandable'))
		return false;

	if (element.children('ul').children('li.collapsable').length != 0)
		closeChildrenCategories(element);
}

function closeChildrenCategories(element)
{
	var arrayLevel = new Array();

	if (element.children('ul').find('li.collapsable').length == 0)
		return false;

	element.children('ul').find('li.collapsable').each(function() {
		var level = $jqPm(this).children('span.category_level').html();
		if (arrayLevel[level] == undefined)
			arrayLevel[level] = new Array();

		arrayLevel[level].push($jqPm(this).attr('id'));
	});

	for(i=arrayLevel.length-1;i!=0;i--)
		if (arrayLevel[i] != undefined)
			for(j=0;j<arrayLevel[i].length;j++)
			{
				$jqPm('li#'+arrayLevel[i][j]+'.collapsable').children('span.category_label').trigger('click');
				$jqPm('li#'+arrayLevel[i][j]+'.expandable').children('ul').hide();
			}
}

function setCategoryToExpand()
{
	var ret = false;

	id = 0;
	arrayCatToExpand = new Array();
	$jqPm('li.expandable:visible').each(function() {
		arrayCatToExpand.push($jqPm(this).attr('id'));
		ret = true;
	});

	return ret;
}

function needExpandAllCategories()
{
	return $jqPm('li').is('.expandable');
}

function expandAllCategories()
{
	// if no category to expand, no action
	if (!needExpandAllCategories())
		return;
	// force to open main category
	if ($jqPm('li#'+category_root_id+'').is('.expandable'))
		$jqPm('li#'+category_root_id+'').children('span.folder').trigger('click');
	readyToExpand = true;
	if (setCategoryToExpand())
		interval = setInterval(openCategory, 10);
}

function openCategory()
{
	// Check readyToExpand in order to don't clearInterval if AJAX request is in progress
	// readyToExpand = category has been expanded, go to next ;)
	if (id >= arrayCatToExpand.length && readyToExpand)
	{
		if (!setCategoryToExpand())
		{
			clearInterval(interval);
			// delete interval value
			interval = null;
			readyToExpand = false;
			if (needCheckAll)
			{
				checkAllCategories();
				needCheckAll = false;
			}
			else if (needUncheckAll)
			{
				uncheckAllCategories();
				needUncheckAll = false;
			}
		}
		else
			readyToExpand = true;
	}

	if (readyToExpand)
	{
		if ($jqPm('li#'+arrayCatToExpand[id]+'.hasChildren').length > 0)
			readyToExpand = false;
		$jqPm('li#'+arrayCatToExpand[id]+'.expandable:visible span.category_label').trigger('click');
		id++;
	}
}

function collapseAllCategories()
{
	closeChildrenCategories($jqPm('li#'+category_root_id+''));
}

function checkAllCategories()
{
	if (needExpandAllCategories())
		expandAllCategories();
	else
	{
		$jqPm('input[name="'+categoryBoxName+'"]').not(':checked').each(function () {
			$jqPm(this).attr('checked', 'checked');
			clickOnCategoryBox($jqPm(this));
		});
	}
}

function uncheckAllCategories()
{
	if (needExpandAllCategories())
		expandAllCategories();
	else
	{
		$jqPm('input[name="'+categoryBoxName+'"]:checked').each(function () {
			$jqPm(this).removeAttr('checked');
			clickOnCategoryBox($jqPm(this));
		});
	}
}

function clickOnCategoryBox(category)
{
	if (category.is(':checked'))
	{

		$jqPm('select#id_category_default').append('<option value="'+category.val()+'">'+(category.val() !=category_root_id ? category.parent().find('span').html() : home)+'</option>');
		updateNbSubCategorySelected(category, true);
		if ($jqPm('select#id_category_default option').length > 0)
		{
			$jqPm('select#id_category_default').show();
			$jqPm('#no_default_category').hide();
		}
	}
	else
	{
		$jqPm('select#id_category_default option[value='+category.val()+']').remove();
		updateNbSubCategorySelected(category, false);
		if ($jqPm('select#id_category_default option').length == 0)
		{
			$jqPm('select#id_category_default').hide();
			$jqPm('#no_default_category').show();
		}
	}
}

function updateNbSubCategorySelected(category, add)
{
	var currentSpan = category.parent().parent().parent().children('.nb_sub_cat_selected');
	var parentNbSubCategorySelected = currentSpan.children('.nb_sub_cat_selected_value').html();

	if (use_radio)
	{
		$jqPm('.nb_sub_cat_selected').hide();
		return false;
	}

	if (add)
		var newValue = parseInt(parentNbSubCategorySelected)+1;
	else
		var newValue = parseInt(parentNbSubCategorySelected)-1;

	currentSpan.children('.nb_sub_cat_selected_value').html(newValue);
	currentSpan.children('.nb_sub_cat_selected_word').html(selectedLabel);

	if (newValue == 0)
		currentSpan.hide();
	else
		currentSpan.show();

	if (currentSpan.parent().children('.nb_sub_cat_selected').length != 0)
		updateNbSubCategorySelected(currentSpan.parent().children('input'), add);
}
function checkChildrenCategory(e,id_category)
{
	if($jqPm(e).attr('checked')) {
		$jqPm('li#'+id_category+'.expandable:visible span.category_label').trigger('click');
		var interval = setInterval(function() {
			if($jqPm(e).parent('li').children('ul').children('li').children('input:not([value="undefined"]):not(.check_all_children)').length) {
				$jqPm(e).parent('li').children('ul').children('li').children('input:not(.check_all_children)').attr('checked','checked');
				clearInterval(interval);
			}
		}, 200);
	}else {
		$jqPm(e).parent('li').children('ul').children('li').children('input:not(.check_all_children)').attr('checked','');
	}
}
