/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {
    
    /*********************************
     * PRODUCT GALLERY
     */ 
    
    /*OPEN GALLERY********************/
    function displayGallery() {
        $("body > *:not('#productzoomimage')").fadeOut(function() {
            var indexShown = $("#thumbs_list li").index($("#thumbs_list li a.shown").parent());
            if(indexShown == -1) {
                indexShown = 0;
            }
            
            $("#gallery-full img").animate({'opacity': 0}, 0);
            $("#gallery-full img:eq(" + indexShown +")").animate({'opacity': 1}, 0).addClass('active');
            
            $("#gallery-small img").removeClass('active');
            $("#gallery-small img:eq(" + indexShown +")").addClass('active');
                        
            $("#gallery-full, #gallery-small, #gallery-detail").fadeIn();
            
            window.location.hash="popup";
        });
    }
    
    
    /*CLICK ON BIG IMAGE*************/
    $("#image-block").live("click", function(e) {
        
        //hide fancybox**************
        if($.fancybox != undefined) {
            $.fancybox.close();
        }

        //We place gallery under body root if not exist
        if($('body > #productzoomimage').length == 1) {
            displayGallery();
        }
        else {
            $newGallery = $('#productzoomimage').clone();
            $('#productzoomimage').remove();
            $('body').append($newGallery);
            
            $("#gallery-loader").fadeIn(400, function() {
                var nbrTotal = $('#gallery-full img').length;
                $('#gallery-full img').each(function() {
                    $(this).attr('src', $(this).attr('data-src'));
                });
                
                //wait image is loaded to display gallery
                $nbr = 0;
                $('#gallery-full img').load(function() {
                    $nbr++;

                    if($nbr == nbrTotal) {
                        $('#gallery-loader').fadeOut(400, function() {
                            displayGallery();
                        });
                    }
                });
            });
            
            return false;
        }
        
    });
    
    
    /*NAVIGATION GALLERY*************/
    $("#gallery-small li").live("click", function() {
        $("#gallery-small li img").removeClass("active");  
        $(this).find("img").addClass("active");

        var index = $("#gallery-small li").index($(this));
        $("#gallery-full img").removeClass('active-image');
        $("#gallery-full img:eq(" + index + ")").addClass('active-image');
        $("#gallery-full img:not(.active-image)").animate({'opacity': 0}, 1200); //fadeOut(1200);
        $("#gallery-full img:eq(" + index + ")").animate({'opacity': 1}, 1200);
    });
    
    
    /*CLOSE GALLERY******************/
    $("#gallery-close").live("click", function() {
        $("body > *:not('#productzoomimage, #popup-cart')").fadeIn();
        $("#gallery-loader, #gallery-detail, #gallery-full, #gallery-small").fadeOut();
        
        return false;
    });
    
    window.onhashchange=function() {
        if(window.location.hash == "") {
            $("body > *:not('#productzoomimage, #popup-cart')").fadeIn();
            $("#gallery-loader, #gallery-detail, #gallery-full, #gallery-small").fadeOut();
        }
    }
    
})
    
