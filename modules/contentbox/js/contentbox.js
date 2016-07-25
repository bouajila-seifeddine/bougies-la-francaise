jQuery(document).ready(function(){
	$(".fileDelete").on( "click", function(){
		var fileToDelete = $(this).parent().data("filename");
		var confirmDelete = confirm("Do you really want to delete this file?");
		if ( confirmDelete ) {
			$("#ignore_changes").val(1);
			$("#delete_file").val( fileToDelete );
			$("#delete_file").closest("form").submit();
		}
	});
	$(".fileUrl").on("click",function(){
		var base_path = $(this).parent().data("filepath");
		var fileName = $(this).parent().data("filename");
		prompt("File Url",base_path+"content/"+fileName);
	})
	$("#contentbox_shop_select, #contentbox_language_select").on("change",function(){
		$("#ignore_changes").val(1);
		$(this).closest("form").submit();
	})
})