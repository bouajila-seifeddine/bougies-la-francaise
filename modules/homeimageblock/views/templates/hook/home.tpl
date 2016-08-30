
{if !empty($images)}
    <ul id="homeimageblock" style="margin-left: -{$left_margin}px">
        <!-- product attribute to add at cart when click on add button -->
        {foreach from=$images item=image}
            <li class="item" style="margin-left: {$left_margin}px; margin-bottom: {$bottom_margin}px">
                {if $image.url != ""}
                    <a href="{$image.url}" title="{$image.legend}" {if $animate == 1}class="animate"{/if}>
                {/if}
                        <img src="{$image.image}" alt="{$image.legend}" width="{$image.image_width}" height="{$image.image_height}" style="display: block;"/>
                 {if $image.url != ""}
                    </a>
                {/if}    
            </li>
        {/foreach}
    </ul>
    <script type="text/javascript">
        var margin_animation = {$animate_px};
    </script>  

<ul id="homeimageblock" style="margin-left: -{$left_margin}px">	
	<aside id="right-column">
    <div id="home-featured" style="margin-top: 20px">
	<h1>Bougies la Française </h1>
	<p>Entrez dans l'univers de Bougies la Française : découvrez des ambiances d'intérieur originales et des parfums subtils au travers des collections.
	</br>
	Être <strong>fabricant de bougie</strong> et fabriquer une <strong>bougie Française</strong>, c’est avant tout faire confiance à des femmes et des hommes, à leur savoir-faire, à leurs gestes minutieux, hérités d’un art ancestral, unique et rare… Notre savoir-faire s'est développé au fil des décennies, pour devenir l’un des acteurs incontournables du monde de <strong>la bougie</strong>, <strong>des senteurs</strong> et <strong>des diffuseurs de parfum</strong> de la maison. Cinq générations de <strong>Maître-Ciriers</strong> ont créées et perpétuées l’esprit de «Grande Maison» ! Parce qu’une <strong>fabrication artisanale</strong> donne une part d’humanité à l’objet que l’homme façonne, chacune de nos bougies porte en elle une part de cette épopée collective. Bougies la Française œuvre avec <strong>les plus grands spécialistes Français du parfum</strong>, depuis 1902, Bougies la française s'attache à vous offrir des <strong>bougies de haute qualité</strong>, alliant maitrise et innovations, dans le respect des normes en vigueur, un style siglé « <strong>BLF</strong> » que vous ne trouverez nulle part ailleurs. </br>
Rendez-nous visite régulièrement sur bougies-la-francaise.com et inscrivez-vous à notre newsletter pour bénéficier de nos offres exclusives. La communauté Bougies la Française grandit de jour en jour, rejoignez-la ! Venez partager vos coups de cœur et participer à nos jeux-concours sur Facebook, Pinterest, YouTube, Google+ ou Instagram pour gagner des bons cadeaux.
	</br></br>
<h2><strong>Nos produits</strong></h2> : <a href="https://www.bougies-la-francaise.com/3-toutes-nos-collections">Grandes collections de bougies</a>, <a href="https://www.bougies-la-francaise.com/41-bougies-parfumees">Bougies parfumées</a>, <a href="https://www.bougies-la-francaise.com/50-diffuseurs-parfumes">Diffuseurs parfumés</a>, <a href="https://www.bougies-la-francaise.com/62-recharges">Recharges de diffuseurs de parfum</a>, <a href="https://www.bougies-la-francaise.com/59-vaporisateurs">Vaporisateurs d’ambiance</a>, <a href="https://www.bougies-la-francaise.com/65-bougies-couleurs">Bougies couleurs</a>, <a href="https://www.bougies-la-francaise.com/72-accessoires">Accessoires</a>, <a href="https://www.bougies-la-francaise.com/31-cadeaux">Cadeaux parfumés</a>, <a href="https://www.bougies-la-francaise.com/39-bien-etre">Bien-être</a>, <a href="https://www.bougies-la-francaise.com/7-offres-speciales">Offres spéciales</a>
	</p>
	</div>
	</aside>
</ul>
{/if}