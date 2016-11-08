
<script type="text/javascript">
    var animate = {$animate}; {*Use in line 90 of addcartpopup.js*}
</script>

<style>
    #popup-cart #popup-cart-inner {
        background-color: {$background_color}; 
        color: {$font_color};
    }
    
    #popup-cart #result {
        color: {$message_font_color};
    }
    
    #popup-cart #order {
        background-color: {$basket_background_color};
        color: {$basket_font_color}
    }
    
    #popup-cart #order:hover {
        background-color: {$basket_hover_color};
    }
    
    #popup-cart #continu {
        background-color: {$continue_background_color};
        color: {$continue_font_color}
    }
    
    #popup-cart #continu:hover {
        background-color: {$continue_hover_color};
    }
</style>

<div id="popup-cart">
    <div id="popup-cart-inner">
        <p id="result">{l s='You have just added this item to your cart' mod='addcartpopup'}</p>
        <img src="{$link->getImageLink($product->link_rewrite, $image.id_image)}" alt="{$product->name}" />
        <div id="link">
            <a id="order" href="{$link->getPageLink("$order_process", true)|escape:'html'}">{l s='Complete your order' mod='addcartpopup'}</a>
            <a id="continu" href="">{l s='Continue shopping' mod='addcartpopup'}</a>
        </div>
        <p>{$product->name}</p>
        <p id="price">{convertPrice price=$productPrice}</p>
    </div>
</div>