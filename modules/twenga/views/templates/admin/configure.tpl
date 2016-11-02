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
<div class="tw-install tw-box {$stepClass|escape:'htmlall':'UTF-8'} tw-onboarding-{$productStatus|escape:'htmlall':'UTF-8'|lower}" id="tw-step-container">
    <div class="tw-box-title tw-box-content">
            {tr _id=84537}Installer Twenga Solutions{/tr}
    </div>

    {include file="./configure/step1.tpl"}

    {include file="./configure/step2.tpl"}

</div>

<!-- POPIN MOT DE PASSE OUBLIE -->
{include file="./configure/popin.tpl"}

<script type="text/javascript">
    var tw_formSignUpUrl = "{$formSignUpUrl|escape:'javascript'}";
    var tw_formLoginUrl = "{$formLoginUrl|escape:'javascript'}";
    var tw_lostPasswordUrl = "{$lostPasswordUrl|escape:'javascript'}";
    var tw_currentStepDone = {$currentStepDone|escape:'htmlall':'UTF-8'};
    var tw_currentAccountType = "{$currentAccountType|escape:'htmlall':'UTF-8'}";

    {if isset($merchantInfo)}
    var tw_merchantInfo = {$merchantInfo|json_encode};
    {else}
    var tw_merchantInfo = null;
    {/if}
</script>
