
$(document).ready(function() {
    $('#homeimageblock').isotope({
        itemSelector : '.item',
        layoutMode : 'fitRows'
    });
    
    if (typeof margin_animation != 'undefined') {
        $margin = margin_animation;     //margin_animation is define in home.tpl
    }
    $('#homeimageblock .animate').hover(function() {
        $width = parseInt($(this).find('img').attr('width'))-$margin*2;
        $height = parseInt($(this).find('img').attr('height'))-$margin*2;
        $(this).find('img').stop(true, true).animate({
            'margin-top': $margin+"px",
            'margin-left': $margin+"px",
            'width': $width+"px",
            'height': $height+"px"
        }, 200);
    }, function() {
        $width = parseInt($(this).find('img').attr('width'));
        $height = parseInt($(this).find('img').attr('height'));
        $(this).find('img').stop(true, true).animate({
            'margin-top': "0px",
            'margin-left': "0px",
            'width': $width+"px",
            'height': $height+"px"
        }, 200);
    });
    
})