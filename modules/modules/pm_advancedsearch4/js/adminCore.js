/**
 *
 * PM_JsCoreFunctions
 *
 * @author    Presta-Module.com <support@presta-module.com>
 * @copyright Presta-Module 2011
 * @version   0.0.1
 *
 *************************************
 ** JS Core Functions For PM Addons  *
 **   http://www.presta-module.com   *
 **             V 0.0.1              *
 *************************************
 * + Description: Js Core Functions For PM Addons
 * + Languages: EN, FR
 **/
(function(){
	var old = $jqPm.ui.dialog.prototype._create;
	$jqPm.ui.dialog.prototype._create = function(d){
		old.call(this, d);

		var self = this;
		var options = self.options,
		oldHeight = options.height,
		oldWidth = options.width;
		fixDialogSize(self,options,oldHeight,oldWidth);
		$jqPm(window).unbind('resize.uidialog').bind('resize.uidialog', function() {
			fixDialogSize(self,options,oldHeight,oldWidth);
		});
	};
})();

function fixDialogSize(self,options,oldHeight,oldWidth) {

	var fitHeight = options.fitHeight,
	screenHeight 	= $jqPm(window).height(),
	screenWidth 	= $jqPm(window).width(),
	dialogHeight	= options.height,
	dialogWidth		= options.width;

	if(!fitHeight && (screenHeight < oldHeight)) {
		fitHeight = true;
	}else if(!fitHeight && (dialogHeight < oldHeight) && (screenHeight < oldHeight)) {
		$jqPm(self).dialog( "option", "height",  screenHeight);
	}

	uiDialogTitlebarFull = $jqPm('<a href="#"><span class="ui-icon ui-icon-newwin"></span></a>')
		.addClass(
			'ui-dialog-titlebar-full ' +
			'ui-corner-all'
		)
		.attr('role', 'button')
		.hover(
			function() {
				uiDialogTitlebarFull.addClass('ui-state-hover');
			},
			function() {
				uiDialogTitlebarFull.removeClass('ui-state-hover');
			}
		)
		.toggle(
			function() {
				self._setOptions({
					height : window.innerHeight - 10,
					width : oldWidth
				});
				self._position('center');
				return false;
			},
			function() {
				self._setOptions({
					height : oldHeight,
					width : oldWidth
				});
				self._position('center');
				return false;
			}
		)
		.focus(function() {
			uiDialogTitlebarFull.addClass('ui-state-focus');
		})
		.blur(function() {
			uiDialogTitlebarFull.removeClass('ui-state-focus');
		})
		.appendTo(self.uiDialogTitlebar),

		uiDialogTitlebarFullText = $jqPm('<span></span>')
			.addClass(
				'ui-icon ' +
				'ui-icon-newwin'
			)
			.text(options.fullText);
	if(fitHeight) {
		self._setOptions({
			height : window.innerHeight - 10,
			width : oldWidth
		});
		self._position('center');
	}
	self._position('center');
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
var dialogIframe;
function openDialogIframe(url,dialogWidth,dialogHeight,fitScreenHeight) {
	$jqPm('body').css('overflow','hidden');
	dialogIframe = $jqPm('<iframe class="dialogIFrame" frameborder="0" marginheight="0" marginwidth="0" src="'+url+'"></iframe>').dialog({
		bgiframe: true,
		modal: true,
		width:dialogWidth,
		height:dialogHeight,
		fitHeight:(typeof(fitScreenHeight)!='undefined' && fitScreenHeight ? true:false),
		close: function(event, ui) {$jqPm('body').css('overflow','');},
		open: function (event,ui) {$jqPm(this).css('width','97%');}
	});
}
function closeDialogIframe() {
	$jqPm(dialogIframe).dialog("close");
}

var dialogInline;
function openDialogInline(contentId,dialogWidth,dialogHeight,fitScreenHeight) {
	$jqPm('body').css('overflow','hidden');
	dialogInline = $jqPm(contentId).dialog({
		modal: true,
		width:dialogWidth,
		height:dialogHeight,
		fitHeight:(typeof(fitScreenHeight)!='undefined' && fitScreenHeight ? true:false),
		close: function(event, ui) {$jqPm('body').css('overflow',''); },
		open: function (event,ui) {$jqPm(this).css('width','93%');}
	});
}

function closeDialogInline() {
	$jqPm(dialogInline).dialog("close");
}
function reloadPanel(idPanel) {
	var url = $jqPm('#'+idPanel).attr('rel');
	if(!url) show_info('Attribute rel is not set for panel '+idPanel);
	$jqPm('#'+idPanel).load(url);
}
function loadPanel(idPanel,url) {
	$jqPm('#'+idPanel).attr('rel',url);
	reloadPanel(idPanel);
}
function loadTabPanel(tabPanelId,li,ul) {
	var indexTab = $jqPm(li).index(ul);

	$jqPm(tabPanelId).tabs( "load" , indexTab, function(response, status, xhr) {
		if (status == "error") {
		    //alert(msgAjaxError);
		    return;
		  }
	} );
}
function show_info(content) {
	$jqPm.jGrowl(content,{ themeState: 'ui-state-highlight' });
}
function show_error(content) {
	$jqPm.jGrowl(content,{ sticky: true, themeState: 'ui-state-error' });
	hidePageLoader();
}
function objectToarray (o,e) {
	a = new Array;
	for (var i=1; i<o.length; i++) {
		a.push(parseInt(o[i][e]));
	}
	return a;
}

function loadAjaxLink() {
	$jqPm('.ajax_script_load').die('click').live('click', function() {
		if($jqPm(this).hasClass('pm_confirm') && !confirm($jqPm(this).attr('title'))) return false;
		var rel = $jqPm(this).attr('rel');
		if(rel) {
			var relSplit = rel.split(/_/g);
			if(relSplit[0] == 'tab') {
				var tabId = '#'+relSplit[1];
				var tabIndex = parseInt(relSplit[2]);
				$jqPm(tabId).unbind( "tabsload").bind( "tabsload", function(event, ui) {
					$jqPm(window).scrollTo("#wrapConfigTab",1000);
				});
				$jqPm(tabId).tabs( "url" , tabIndex , $jqPm(this).attr('href') );
				$jqPm(tabId).tabs( "load" , tabIndex );
				return false;
			}
		}
		$jqPm.ajax( {
			type : "GET",
			url : $jqPm(this).attr('href'),
			dataType : "script",
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				//alert(msgAjaxError);
			}
		});
		return false;
	});
	$jqPm('.open_on_dialog_iframe').die('click').live('click', function() {
		var rel = $jqPm(this).attr('rel');
		var dialogWidth = 900;
		var dialogHeight = 600;
		var dialogFixHeight = false;
		if(rel) {
			var relSplit = rel.split(/_/g);
			if(typeof(relSplit[0]) != 'undefined' && typeof(relSplit[1]) != 'undefined') {
				dialogWidth = relSplit[0];
				dialogHeight = relSplit[1];
				dialogFixHeight = (typeof(relSplit[2])!='undefined' && relSplit[2] ? true:false);
			}
		}

		openDialogIframe($jqPm(this).attr('href'),dialogWidth,dialogHeight,dialogFixHeight);
		return false;
	});
	$jqPm('.ajax_load_on_blc').die('click').live('click', function() {
		var rel = $jqPm(this).attr('rel');
		if(rel) {
			loadPanel(rel,$jqPm(this).attr('href'));
		}
		return false;
	});

	$jqPm('.hide_class_show_id').die('click').live('click', function() {
		var e = $jqPm(this);
		var rel = $jqPm(e).attr('rel');

		if(rel) {
			var relSplit = rel.split(/@/g);
			if(typeof(relSplit[0]) != 'undefined' && typeof(relSplit[1]) != 'undefined') {
				class_to_hide = relSplit[0];
				id_to_show = relSplit[1];
			}
			//Hide other block
			$jqPm('.'+class_to_hide).slideUp('fast',function() {
				//Show selected block
				$jqPm('#'+id_to_show).slideDown('fast');
			});
		}
		return false;
	});
}

function bindFillNextSize() {
	$jqPm('.fill_next_size').unbind('click').click(function() {
		$jqPm(this).nextAll('input.ui-input-pm-size[type=text]').val($jqPm(this).prev('input[type=text]').val());
	})
}
function initMakeGradient() {
	$jqPm('.makeGradient').unbind('click').click(function() {
		var e = $jqPm(this).parent('span').prev('span');
		if($jqPm(e).css('display') == 'inline')
			$jqPm(this).parent('span').prev('span').hide();
		else
			$jqPm(this).parent('span').prev('span').show();
	});
}
function checkChildrenCheckbox(e) {
	if($jqPm(e).children('input[type=checkbox]:checked').length)
		$jqPm(e).children('input[type=checkbox]').removeAttr('checked');
	else
		$jqPm(e).children('input[type=checkbox]').attr('checked','checked');
}
function unCheckAllChildrenCheckbox(e) {
	$jqPm(e).find('input[type=checkbox]').removeAttr('checked');
}
function display(message) {
	$jqPm.jGrowl(message, { sticky: true, themeState: 'ui-state-highlight'  });
}
function hide(message) {
	$jqPm.jGrowl('close');
}
function displayGroupBoxFromPermissions(id) {
	if($jqPm(id).val() == 2)
		$jqPm('#blc_groupBox').slideDown("fast");
	else $jqPm('#blc_groupBox').slideUp("fast");
}
var timerLoader = false;
function showPageLoader() {
	//Remove prev loader if exists
	if($jqPm('#pm_page_loader').length) $jqPm('#pm_page_loader').remove();
	//Body append loader
	$jqPm('body').append('<div id="pm_page_loader" style="display:none;"></div>');
	//Hide body scroll
	$jqPm('body,html').css('overflow','hidden');
	//Set page loader size recursively
	timerLoader = setInterval(function() {
		var documentHeight = $jqPm(document).height();
		var documentWidth = $jqPm(document).width();
		$jqPm('#pm_page_loader').css('height',documentHeight+'px');
		$jqPm('#pm_page_loader').css('width',documentWidth+'px');
	}, 100);
	//Show page loader
	$jqPm('#pm_page_loader').fadeTo('slow', 0.8);
}
function hidePageLoader() {
	//Hide page loader
	setTimeout(function() {
		$jqPm('body,html').css('overflow','');
		if(timerLoader) { clearInterval(timerLoader); timerLoader = false;}
		if($jqPm('#pm_page_loader').length) {
			$jqPm('#pm_page_loader').fadeOut('slow',function() {$jqPm(this).remove();});
		}
	},500);
}
function initTips(e) {
	$jqPm(document).ready(function() {
		$jqPm(e+"-tips").tipTip();
	});
}
$jqPm(document).ready(function() {
	loadAjaxLink();
	$jqPm(".pm_tips").tipTip();
	$jqPm('link[href$="js/jquery/datepicker/datepicker.css"]').remove();
	$jqPm('div#addons-rating-container p.dismiss a').click(function() {
		$jqPm('div#addons-rating-container').hide(500);
		$jqPm.ajax({type : "GET", url : window.location+'&dismissRating=1' });
		return false;
	});
});
showPageLoader();
$jqPm(window).load(function() {
	hidePageLoader();
});