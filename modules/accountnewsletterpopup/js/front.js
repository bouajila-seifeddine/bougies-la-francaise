
$(document).ready(function() {

    $("#close-newsletter").click(function() {
        $("#newsletter-popup-container").fadeOut();
        return false;
    });

    $("#newsletter-popup-container").fadeIn();
});
