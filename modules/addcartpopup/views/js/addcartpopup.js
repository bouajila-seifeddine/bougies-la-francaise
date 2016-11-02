

/*************************************************************
 * This function display popup
 */
function displayPopupAddToCart() {
    $popupCart = $("#popup-cart").clone();
    $("#popup-cart").remove();
    $popupCart.appendTo('body');
    
    $("#popup-cart").fadeIn(200);
    
    middlePopup();
    $(window).on('resize', middlePopup);
    
    $("#close, #continu").click(function() {
        $(window).unbind('resize');
        $("#popup-cart").fadeOut(200);
        
        return false;
    });
}


/*************************************************************
 * This function permit to put the popup always on center of the page
 */
function middlePopup() {
    $windowHeight = $(window).height();
    $popupHeight = $("#popup-cart-inner").height();
    
    positionPopup = (($windowHeight - $popupHeight) / 2);
    $("#popup-cart-inner").css('margin-top', positionPopup + 'px');
}


/*************************************************************
 * Here we override function AjaxCart.add function defined in module blockcart.  
 */
ajaxCart.add = function(idProduct, idCombination, addedFromProductPage, callerElement, quantity, wishlist) {
    
    if (addedFromProductPage && !checkCustomizations())
    {
        alert(fieldRequired);
        return ;
    }
    emptyCustomizations();
    //disabled the button when adding to not double add if user double click
    if (addedFromProductPage)
    {
        $('#add_to_cart input').attr('disabled', true).removeClass('exclusive').addClass('exclusive_disabled');
        $('.filled').removeClass('filled');
    }
    else
        $(callerElement).attr('disabled', true);

    if ($('#cart_block_list').hasClass('collapsed'))
        this.expand();
    //send the ajax request to the server
    $.ajax({
        type: 'POST',
        headers: { "cache-control": "no-cache" },
        url: baseUri + '?rand=' + new Date().getTime(),
        async: true,
        cache: false,
        dataType : "json",
        data: 'controller=cart&add=1&ajax=true&qty=' + ((quantity && quantity != null) ? quantity : '1') + '&id_product=' + idProduct + '&token=' + static_token + ( (parseInt(idCombination) && idCombination != null) ? '&ipa=' + parseInt(idCombination): ''),
        success: function(jsonData,textStatus,jqXHR)
        {
            // add appliance to wishlist module
            if (wishlist && !jsonData.errors)
                WishlistAddProductCart(wishlist[0], idProduct, idCombination, wishlist[1]);

            // add the picture to the cart
            var $element = $(callerElement).parent().parent().find('a.product_image img,a.product_img_link img');
            if (!$element.length)
                $element = $('#bigpic');
            var $picture = $element.clone();
            var pictureOffsetOriginal = $element.offset();
            pictureOffsetOriginal.right = $(window).innerWidth() - pictureOffsetOriginal.left - $element.width();

            if ($picture.length)
            {
                $picture.css({
                    position: 'absolute',
                    top: pictureOffsetOriginal.top,
                    right: pictureOffsetOriginal.right
                });
            }

            var pictureOffset = $picture.offset();
            var cartBlock = $('#cart_block');
            if (!$('#cart_block')[0] || !$('#cart_block').offset().top || !$('#cart_block').offset().left)
                cartBlock = $('#shopping_cart');
            var cartBlockOffset = cartBlock.offset();
            cartBlockOffset.right = $(window).innerWidth() - cartBlockOffset.left - cartBlock.width();

            // Check if the block cart is activated for the animation
            if (cartBlockOffset != undefined && $picture.length /*Added by addpopupcart module*/ && animate==0/*End Added*/)
            {
                $picture.appendTo('body');
                $picture
                    .css({
                        position: 'absolute',
                        top: pictureOffsetOriginal.top,
                        right: pictureOffsetOriginal.right,
                        zIndex: 4242
                    })
                    .animate({
                        width: $element.attr('width')*0.66,
                        height: $element.attr('height')*0.66,
                        opacity: 0.2,
                        top: cartBlockOffset.top + 30,
                        right: cartBlockOffset.right + 15
                    }, 1000)
                    .fadeOut(100, function() {
                        ajaxCart.updateCartInformation(jsonData, addedFromProductPage);
                        $(this).remove();
                    });
            }
            else
                ajaxCart.updateCartInformation(jsonData, addedFromProductPage);
            
            /*Added by addpopupcart module*/
            if(quantity > 0) {
                displayPopupAddToCart();
            }
            /*End Added*/
        },
        error: function(XMLHttpRequest, textStatus, errorThrown)
        {
            alert("Impossible to add the product to the cart.\n\ntextStatus: '" + textStatus + "'\nerrorThrown: '" + errorThrown + "'\nresponseText:\n" + XMLHttpRequest.responseText);
            //reactive the button when adding has finished
            if (addedFromProductPage)
                $('#add_to_cart input').removeAttr('disabled').addClass('exclusive').removeClass('exclusive_disabled');
            else
                $(callerElement).removeAttr('disabled');
        }
    });
}
