//  JavaScript Document
//  for 1.5 version 
/*-------------------------------------------------------------------------------------------------------------------*/
/* -------------------------------------------INIT--------------------------------------------------- */
/*-------------------------------------------------------------------------------------------------------------------*/
var page_en_cours_360 = 1;
var page_en_cours_generate_360 = 1;
var type_file_in_open_360 = "none";
var onglet_360_trad_title = "title_onglet";
var header_tab_360_trad_file_name = "File name" ;
var header_tab_360_trad_type = "Type";
var header_tab_360_trad_position = "Position";
var header_tab_360_trad_date_add = "Date add";
var no_create_360_trad = "Explication no creation 360";
var nom_360_trad = "Nom";
var actif_360_trad = "Active";
var trad_no_nom_360 ="non_name_360";
var action_360_trad = "action_360_trad";
var seleciton_file_trad = "seleciton_file_trad";
var seleciton_file_del_trad = "seleciton_file_del_trad";
var seleciton_360_del_trad = "seleciton_360_del_trad";
var erreur_format_upload ="erreur_format_upload";
var no_file_in_360_trad = "no_file_in_360_trad";
var selection_360_trad = "selection_360_trad";
var trop_swf_trad = "trop_swf_trad";
var melange_type_trad = "melange_type_trad";
var no_add_swf_in_360_image = "no_add_swf_in_360_image";
var no_add_img_in_360_swf = "no_add_img_in_360_swf";
var generated_360_trad = "generated_360_trad";
var width_no_number = "width_no_number";
var height_no_number = "height_no_number";
var ratio_no_repected = "ratio_no_repected";
var erreur_geeneration_360 = "erreur_geeneration_360";
var send_360_legend = "Envoyer vos fichiers";
var you360_legend = "Vos 360s";
var zip_comromppui = "Zip corrompu";
var display_360_trad = "Type d'affichage";
$(document).ready(function()
{
installTab() ;
});




function addslashes (str) 
{
 return (str + '').replace(/[\\"']/g, '\\$&').replace(/\u0000/g, '\\0');
}

function isNumber(fData)
{
  var reg = new RegExp("^[-]?[0-9]+[\.]?[0-9]+$");
  return reg.test(fData);
}


function installTab()
{
   $(".tab").append('<li class="tab-row"><a class="tab-page" id="link-scancube360" href="#">ScanCube 360</a></li>') ;
   var m  =   $("#tabPane1");
   $("#tabPane1").append('<div id="product-tab-content-scancube360" class="product-tab-content" style="display:none">') ;
   $("#link-scancube360").click(charge360Form) ;
}

/*-------------------------------------------------------------------------------------------------------------------*/
/*--------------------------------GESTION ONGLET ON FICHE PRODUIT------------------------------------------------------*/
/*-------------------------------------------------------------------------------------------------------------------*/
function charge360Form()
{
    var html_content = "\
				<fieldset class='fieldset_upload' style='margin-bottom:10px;'>\
					<legend>"+send_360_legend+" : </legend>\
					<input type='file' id='uploader_img'  />\
				</fieldset>\
				<fieldset class='fieldset_form_360' style='margin-bottom:10px;'>\
					<legend>"+you360_legend+" : </legend>\
					<div id='360_listing_contener'><div class='contener_loader_360'><img src='"+window.scancubeBoSettings.link_module_360+"img/ajax-loader.gif' /></div></div>\
				</fieldset>\
				<fieldset class='fieldset_modification' style='display:none;margin-bottom:10px;'>\
					<legend>Modification d'un 360 : </legend>\
					<div id='form_mod_360'>\
						<input type='hidden' id='id_360'/>\
						<p><span id='name_360_txt'></span></p>\
						<div id='form_modif_360_info'></div>\
						<div id='contener_list_tri_360'>\
						</div>\
					<div>\
				</fieldset>";		
	
        
        

    $("#product-tab-content-scancube360").html(html_content);
     //$("#step8").html(html_content);   1.4 version 
    $('#uploader_img').uploadify
    ({
      
	'buttonText' : 'Select zip file',
	'formData':{'id_product':window.scancubeBoSettings.id_product_for_360 },
	'swf':window.scancubeBoSettings.link_module_360+'js/uploadify/uploadify.swf',
        'uploader':window.scancubeBoSettings.link_module_360+'ajax/uploadify.php',
        'fileObjName': 'Filedata',
        'multi': false,
        'fileTypeDesc': 'Zip files',
        'fileTypeExts': '*.zip;',
        'sizeLimit': 8000   ,
	'onUploadSuccess' : function(file, data, response)
	   {
	    if(response)
	    {
		try
		{
		   var result = $.parseJSON(data) ; 
		   if(result.Error)
		   {
		    alert("Error "+result.Message) ;
		   }
		   else
		   {
		    getAll360();
		   }
		   
		}
		catch(errr)
		{
                  alert(data) ;
		}
	    }
            else
	    {
	       alert("no response  from server !")
	    }
           },
	   'onUploadError' : function(file, errorCode, errorMsg, errorString)
	   {
            alert('The file ' + file.name + ' could not be uploaded: ' + errorString+'  '+errorCode);
           }
 

	
    });
	
    getAll360();
	

}
/*-------------------------------------------------------------------------------------------------------------------*/
/*-------------------------------------------------------------------------------------------------------------------*/
/*-------------------------------------------------------------------------------------------------------------------*/


function getAll360(page_number)
{
    if(typeof(page_number) != "undefined" && page_number > 0)
    {
     page_en_cours_generate_360 = page_number;
    }

    $("#360_listing_contener").html("<div id='contener_total_360'></div><div id='360_listing'><div class='contener_loader_360'><img src='"+window.scancubeBoSettings.link_module_360+"img/ajax-loader.gif' /></div></div><div id='contener_pagination_360' style='margin-top:10px;margin-bottom:10px;'></div><div id='contener_action_360'></div>");		
    $.ajax({
        type: "POST",
        url: window.scancubeBoSettings.link_module_360+"ajax/getFromGenerate360.php",
        data: "id_product="+window.scancubeBoSettings.id_product_for_360+"&page="+page_en_cours_generate_360,
        dataType: 'json',
        success: function(data)
        {
            traitement360Listing(data);
            getSetting360();
        }
    });
}


function traitement360Listing(data)
{
    var html = '\
			<div class="contener_tab_file_360">\
				<table cellspacing="0" cellpadding="0" class="table tableDnD" > \
					<thead> \
						<tr class="nodrag nodrop"> \
						<th><input type="checkbox" class="noborder" id="checkallcontroler360" onclick="checkAll360();"></th>\
						<th>'+nom_360_trad+'</th> \
						<th>'+header_tab_360_trad_date_add+'</th> \
						<th>'+display_360_trad+'</th> \
						<th>'+actif_360_trad+'</th> \
						<th>'+action_360_trad+'</th> \
					</thead>\
					<tbody>	\
			';
			
    if(data.length == 0){
        html += '\
					<tr id="tr_1_2_0"> \
						<td colspan="4">Aucun 360</td>\
					</tr> \
				';
    }
    for(var i = 0 ; i < data.length ; i++){
        html += '\
					<tr id="tr_1_2_0"> \
						<td class="center"><input type="checkbox" class="select_case_file360" value="'+data[i].id_360+'" ></td>';
						
        html += '\
						<td>'+data[i].name+'</td> \
						<td>'+data[i].date_add+'</td> \
						<td>'+data[i].display+'</td> \
						<td>'+((data[i].active == 1)?"oui":"non")+'</td> \
						<td class="action_td"><span style="cursor:pointer;" onclick="modif360('+data[i].id_360+', \''+addslashes(data[i].name)+'\', '+data[i].active+', \''+addslashes(data[i].display)+'\');">Modifier</span> - <span style="cursor:pointer;" onclick="supprimer360Ajax(['+data[i].id_360+'])">Supprimer</span> - <a style="color:inherit;font-size:inherit;" href="'+window.scancubeBoSettings.dir_presta+'modules/nq_360/controllers/popup-back.php?id_360='+data[i].id_360+'" target="_blank">Voir</a></td> \
					</tr> \
				';
    }
			
    html += '\
					</tbody>\
				</table>\
			</div> \
			';
			
                      
                        
                        
    $("#360_listing").html(html);	
}


function modif360(_id, _name, _active, _display)
{
	
    $(".fieldset_modification").css("display", "block");
    $("#form_mod_360").css("display", "block");
    $("#name_360_txt").html(_name);
    $("#id_360").val(_id);
    $("#form_modif_360_info").html("\
			<label>Activer</label>\
			<select onchange='changeActiveVal()' id='active_360'>\
				<option value='1' "+((_active == 1)?"selected='selected'":"")+">oui</option>\
				<option value='0' "+((_active == 0)?"selected='selected'":"")+">non</option>\
			</select>\
			<br/>\
			<br/>\
			<label>Position dans la page produit</label>\
			<select onchange='changeDisplayVal()' id='display_360'>\
				<option value='onglet' "+((_display == 'onglet')?"selected='selected'":"")+">En onglet</option>\
				<option value='bouton' "+((_display == 'bouton')?"selected='selected'":"")+">En dessous des boutons d'action (affichage en popup)</option>\
				<option value='extraLeft' "+((_display == 'extraLeft')?"selected='selected'":"")+">En dessous des images produits</option>\
				<option value='extraRight' "+((_display == 'extraRight')?"selected='selected'":"")+">En dessous des informations du produit</option>\
			</select>\
		");
		
	
}


function getSetting360(){
    $.ajax({
        type: "POST",
        url: window.scancubeBoSettings.link_module_360+"ajax/getSettings360.php",
        data: "id_product="+window.scancubeBoSettings.id_product_for_360,
        dataType: 'json',
        success: function(data) {
            traitementSettingListing360(data);
        }
    });
}


function traitementSettingListing360(data)
{
    if(data.nbr_page_max != 0 && page_en_cours_generate_360 > data.nbr_page_max)
    {
        getAll360(data.nbr_page_max);
        return;
    }
    $("#contener_total_360").html(data.nbr_file+" scancube 360");
    var html_pagination = '';
    if(page_en_cours_generate_360 != 1 && page_en_cours_generate_360 != data.nbr_page_max){
        $("#contener_pagination_360").html('\
			<span>\
				<input type="image" onclick="getAll360(1)" src="../img/admin/list-prev2.gif">\
				<input type="image" onclick="getAll360('+(page_en_cours_generate_360-1)+')" src="../img/admin/list-prev.gif">\
				Page <b>'+page_en_cours_generate_360+'</b> / '+data.nbr_page_max+' \
				<input type="image" onclick="getAll360('+(page_en_cours_generate_360+1)+')" src="../img/admin/list-next.gif">\
				<input type="image" onclick="getAll360('+(data.nbr_page_max)+')" src="../img/admin/list-next2.gif">\
			</span>\
		');
    }else{
        if(page_en_cours_generate_360 == 1){
            $("#contener_pagination_360").html('\
				<span>\
					Page <b>'+page_en_cours_generate_360+'</b> / '+data.nbr_page_max+' \
					<input type="image" onclick="getAll360('+(page_en_cours_generate_360+1)+')" src="../img/admin/list-next.gif">\
				<input type="image" onclick="getAll360('+(data.nbr_page_max)+')" src="../img/admin/list-next2.gif">\
				</span>\
			');
        }else{
            $("#contener_pagination_360").html('\
				<span>\
					<input type="image" onclick="getAll360(1)" src="../img/admin/list-prev2.gif">\
					<input type="image" onclick="getAll360('+(page_en_cours_generate_360-1)+')" src="../img/admin/list-prev.gif">\
					Page <b>'+page_en_cours_generate_360+'</b> / '+data.nbr_page_max+' \
				</span>\
			');
        }
    }
	
    $("#contener_action_360").html('\
		<input class="button" type="button" value="Supprimer les 360 selectionnés" onclick="supprimeSelection360()">\
	');

}
function changeActiveVal()
{
    $.ajax({
        type: "POST",
        url: window.scancubeBoSettings.link_module_360+"ajax/setActive360.php",
        data: "id_360="+$("#id_360").val()+"&active="+$("#active_360").val()+"&id_product="+window.scancubeBoSettings.id_product_for_360,
        dataType: 'json',
        success: function(data)
	{
         getAll360();
        },
	error:function(jqXHR, textStatus,errorThrown )
	{
	  alert("ajax error "+jqXHR.responseText ) ;   
	}
    });
	
}


function changeDisplayVal()
{
    $.ajax({
        type: "POST",
        url: window.scancubeBoSettings.link_module_360+"ajax/setDisplay360.php",
        data: "id_360="+$("#id_360").val()+"&display="+$("#display_360").val(),
        dataType: 'json',
        success: function(data) {
            getAll360();
        }
    });
}


function supprimeSelection360()
{
    var t_file_checked = $(".select_case_file360:checked");
    var t_id_file_del = new Array();
    for(var i = 0 ; i < t_file_checked.length ; i++)
    {
        t_id_file_del.push($(t_file_checked[i]).val());
        if($(t_file_checked[i]).val() == $("#id_360").val())
        {
            $("#form_mod_360").css("display", "none");
            $("#id_360").val("");
        }
    }
    if(t_id_file_del.length == 0)
    {
        alert(seleciton_360_del_trad);
        return;
    }
    supprimer360Ajax(t_id_file_del);
}

function supprimer360Ajax(t_id_file_del)
{
	
    $(".fieldset_modification").css("display", "none");
	
    $.ajax({
        type: "POST",
        url: window.scancubeBoSettings.link_module_360+"ajax/delFile360.php",
        data: "t_id_file[]="+t_id_file_del.join("&t_id_file[]="),
        dataType: 'json',
        success: function(data) 
        {
            getAll360();
        }
    });	
}


function checkAll360()
{
    if($("#checkallcontroler360").attr("checked"))
    {
     $(".select_case_file360").attr("checked", true);
    }
    else
    {
     $(".select_case_file360").attr("checked", false);	
    }
}
