var pathCSS = '';
var iso = '';
var ad = '';

jQuery(function($){
	$('.tabs').tabs();
	$('.tabs').show();

	// reward payment
	$('input[name="rewards_payment"]').click(function(){
		if ($(this).val() == 1)
			$('.rewards_payment_optional').show();
		else
			$('.rewards_payment_optional').hide();
	});

	// reward transformation
	$('input[name="rewards_voucher"]').click(function(){
		if ($(this).val() == 1)
			$('.rewards_voucher_optional').show();
		else
			$('.rewards_voucher_optional').hide();
	});

	// reminder
	$('input[name="rewards_use_cron"]').click(function(){
		if ($(this).val() == 1)
			$('.rewards_use_cron_optional').show();
		else
			$('.rewards_use_cron_optional').hide();
	});

	// reminder
	$('input[name="rewards_reminder"]').click(function(){
		if ($(this).val() == 1)
			$('.rewards_reminder_optional').show();
		else
			$('.rewards_reminder_optional').hide();
	});

	// sponsor
	$('input[name="reward_s"]').click(function(){
		if ($(this).val() == 1)
			$('.sponsor_optional').show();
		else
			$('.sponsor_optional').hide();
	});

	// sponsored
	$('input[name="discount_gc"]').click(function(){
		if ($(this).val() == 1)
			$('.sponsored_optional').show();
		else
			$('.sponsored_optional').hide();
	});

	// popup
	$('input[name="popup"]').click(function(){
		if ($(this).val() == 1)
			$('.popup_optional').show();
		else
			$('.popup_optional').hide();
	});

	// open inviter
	$('input[name="open_inviter"]').click(function(){
		if ($(this).val() == 1)
			$('.open_inviter_optional').show();
		else
			$('.open_inviter_optional').hide();
	});

	$('#add_level').click(function(){
		addSponsorshipLevel();
	});

	// Facebook reward for guest
	$('input[name="facebook_reward_guest"]').click(function(){
		if ($(this).val() == 1)
			$('.facebook_voucher_optional').show();
		else
			$('.facebook_voucher_optional').hide();
	});

	initForm();
});

function initForm(){
	$('input[name="rewards_payment"]:checked').trigger('click');
	$('input[name="rewards_voucher"]:checked').trigger('click');
	$('input[name="rewards_use_cron"]:checked').trigger('click');
	$('input[name="rewards_reminder"]:checked').trigger('click');
	$('input[name="reward_s"]:checked').trigger('click');
	$('input[name="discount_gc"]:checked').trigger('click');
	$('input[name="popup"]:checked').trigger('click');
	$('input[name="open_inviter"]:checked').trigger('click');
	$('input[name^="discount_type_gc"]:checked').trigger('click');
	$('input[name^="reward_type_s"]').each(function(i){
		checkType($(this));
	});
	$('input[name="facebook_reward_guest"]:checked').trigger('click');
	$('input[name^="facebook_voucher_type"]:checked').trigger('click');
}

function checkType(obj){
	if ($(obj).attr('checked')) {
		if ($(obj).val() == 1) {
			$(obj).parents('div.level_information').find('.reward_percentage').hide();
			$(obj).parents('div.level_information').find('.reward_amount').show();
		} else {
			$(obj).parents('div.level_information').find('.reward_amount').hide();
			$(obj).parents('div.level_information').find('.reward_percentage').show();
		}
	}
}

function addSponsorshipLevel() {
	var levels = $('div.level_information');
	var nb = levels.size();
	var newLevel = $(levels[nb-1]).clone(true);
	newLevel.find('span.numlevel').html(nb + 1);
	var reg=new RegExp('\\\['+(nb-1)+'\\\]"', "g");
	newLevel.html(newLevel.html().replace(reg,'['+nb+']"'));
	$(levels[nb-1]).after(newLevel);
	$('#unlimited_level').html(nb + 1);
	// hack pour cocher le type sur la nouvelle ligne à l'identique, sinon sur FF ca bug
	var selectedValue = $(levels[nb-1]).find('input[name^="reward_type_s"]:checked').val();
	newLevel.find('input[name^="reward_type_s"][value="'+selectedValue+'"]').trigger('click');
	return false;
}

function delSponsorshipLevel(obj) {
	var nb = $("div.level_information").size();
	if (nb > 1) {
		$(obj).parents('div.level_information').remove();
		var cpt = 1;
		// on réaffecte des ID séquentiels aux levels
		$("div.level_information").each(function(i){
			$(this).find("span.numlevel").html(cpt);
			cpt++;
		});
		$('#unlimited_level').html(nb - 1);
	}
	return false;
}

function showDetails(id_sponsor, url) {
	$('.statistics .details').remove();
	$.ajax({
		type	: "POST",
		cache	: false,
		url		: url + '&id_sponsor=' + id_sponsor,
		dataType: "html",
		success : function(data) {
			$('#line_' + id_sponsor).after(data);
		}
	});
}

function convertCurrencyValue(obj, fromField, rate) {
	fromField = $('input[name^='+fromField+'].currency_default');
	if (fromField.size() > 1) {
		fromField = $(obj).parents('.level_information').find('input[name^='+fromField+'].currency_default');
	}
	value = fromField.val();
	fieldTo = $(obj).parent().find('input');
	fieldTo.val((value * rate).toFixed(4));
	return false;
}