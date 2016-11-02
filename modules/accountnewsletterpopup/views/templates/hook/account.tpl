
<li id="newsletter-popup-container">
    <div id="newsletter-popup" style="background: url('{$POPUP_NEWSLETTER_IMAGE}') 0 0 no-repeat;">
        <h1>{l s='Subscribe Newsletter' mod='accountnewsletterpopup'}</h1>
        <h2>{l s='Discover in preview all our news and receive your welcome gift' mod='accountnewsletterpopup'}.</h2>
        <a id="subscribe-button" href="{$link->getPageLink('my-account', true)|escape:'html'}?subscribe=yes">{l s='Subscribe' mod='accountnewsletterpopup'}</a>
        <p>
            <strong>{l s='New, heart strokes, seasonal fragrances, special offers...' mod='accountnewsletterpopup'}</strong>
            {l s='Subscribe to our newsletter and discover every month exclusive offers preview!' mod='accountnewsletterpopup'}
        </p>
        <a id="close-newsletter" href="#"></a>
    </div>
</li>