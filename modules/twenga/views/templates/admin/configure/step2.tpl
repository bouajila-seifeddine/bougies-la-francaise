{*
 * Copyright (c) 2016 Twenga
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
 * DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
 * OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE
 * OR OTHER DEALINGS IN THE SOFTWARE.
 * 
 * @author    Twenga
 * @copyright 2016 Twenga
 * @license   http://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
 *}
<div class="tw-step tw-step2 step-wait" data-step="2">
    <p class="tw-title tw-padding">
        <b>{tr _id=84927 step=2}Etape %s :{/tr}</b> {tr _id=84577}Finaliser l'installation du module Twenga Solutions{/tr}
    </p>

    <!-- ETAPE VALIDATION SI NOUVEAU COMPTE -->
    <div class="tw-step-content tw-step-final-ongoing">
        <div class="tw-alert tw-padding-bottom tw-step-margin">
            <p>
                <i class="tw-icon tw-icon-success"></i>
                {tr _id=84697}Votre url de flux catalogue a bien été généré :{/tr}
                <a target="'_blank"
                   href="{$twengaFeedUrl|escape:'htmlall':'UTF-8'}">{$twengaFeedUrl|escape:'htmlall':'UTF-8'}</a>
            </p>
        </div>
        <div class="tw-alert tw-padding-bottom tw-step-margin">
            <div>
                <i class="tw-icon tw-icon-warning"></i> {tr _id=84627}Attention : Nous avons bien pris en compte votre demande, afin de bénéficier de nos services vous devez finaliser votre inscription.{/tr}
            </div>
        </div>
        <div class="button-wrap tw-padding">
            <a class="btn btn-red btn-lg tw-autolog-link" href="{$twsDomain|escape:'htmlall':'UTF-8'}"
               target="_blank">{tr _id=84637}Finalisez votre inscription{/tr}</a>
        </div>
    </div>

    <!-- ETAPE VALIDATION SI COMPTE EXISTANT -->
    <div class="tw-step-content tw-step-final-completed">
        <div class="tw-alert tw-padding-bottom tw-step-margin">
            <p>
                <i class="tw-icon tw-icon-success"></i> {tr _id=84647}Félicitation, vous avez bien installé le Tracking Twenga !{/tr}
            </p>

            <p>{tr _id=84657}Avec le Tracking Twenga{/tr}</p>
            <ul>
                <li>{tr _id=84667}Je mesure la qualité de mon trafic en suivant mes taux de conversion et mes coûts d’acquisitions par catégorie.{/tr}</li>
                <li>{tr _id=84677}J’optimise mon budget en privilégiant les offres les plus performantes grâce aux règles automatiques Twenga.{/tr}</li>
                <li>{tr _id=84687}Je sécurise ma performance grâce au suivi proactif et aux recommandations des équipes Twenga.{/tr}</li>
            </ul>
        </div>
        <div class="tw-alert tw-padding-bottom tw-step-margin">
            <p>
                <i class="tw-icon tw-icon-success"></i>
                {tr _id=84697}Votre url de flux catalogue a bien été généré :{/tr}
                <a target="'_blank"
                   href="{$twengaFeedUrl|escape:'htmlall':'UTF-8'}">{$twengaFeedUrl|escape:'htmlall':'UTF-8'}</a>
            </p>
        </div>
        <div class="tw-alert tw-padding-bottom tw-step-margin">
            <p>
                <i class="tw-icon tw-icon-success"></i> {tr _id=64107}Votre catalogue sera référencé sous 72H environ.{/tr}
            </p>

            <p>{tr _id=64117}Une fois vos produits publiés, vous recevrez un apport régulier et qualifié d’acheteurs qui vous sera facturé au CPC (Coût par Clic).{/tr}</p>

            <p>{tr _id=84737}Vous bénéficierez depuis votre compte Twenga solutions d’une suite complète d’outils marketing et analytiques.{/tr}</p>
        </div>
        <div class="button-wrap tw-padding">
            <a class="btn btn-red btn-lg tw-autolog-link" href="{$twsDomain|escape:'htmlall':'UTF-8'}"
               target="_blank">{tr _id=84727}Accéder à votre interface{/tr}</a>
        </div>
    </div>
</div>
