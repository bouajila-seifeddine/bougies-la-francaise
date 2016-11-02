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
<div class="modal fade" id="tw-form-lostpassword" tabindex="-1" role="dialog" aria-labelledby="popinMdp">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <p class="modal-title">{tr _id=7441}Mot de passe oublié ?{/tr}</p>
            </div>
            <div class="modal-body">
                <div id="lostPasswordMessage" style="display: none;">
                    <div class="alert alert-success" role="alert">
                        <ul class="fa-ul">
                            <li>
                                <i class="fa-tw-alert fa-tw-success fa-li"></i>

                                <p></p>
                            </li>
                        </ul>
                    </div>
                </div>
                <form method="post" id="lostPasswordForm" action="/lostpassword/sendnewpassword">
                    <div class="form-group">
                        <label for="EMAIL">{tr _id=7519}Veuillez saisir votre adresse email :{/tr}</label>
                        <input type="email" name="EMAIL" class="email form-control" required="required"
                               placeholder="{tr _id=43662}Email{/tr}"/>
                    </div>
                    <div class="text-right"><input type="submit" id="tw-form-lostpassword-submit"
                                                   class="btn btn-red btn-lg" value="{tr _id=7521}Valider{/tr}"/></div>
                </form>
            </div>
        </div>
    </div>
</div>
