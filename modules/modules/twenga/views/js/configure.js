/*******************************************************
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
 *******************************************************/
(function ($) {
    var $stepContainer;
    var currentStepDone;
    var currentAccountType = null;

    $(document).ready(function () {
        initPage();
        initEvents();
    });


    function initPage() {
        $stepContainer = $('#tw-step-container');
        currentStepDone = tw_currentStepDone;
        currentAccountType = tw_currentAccountType;
        changeStepAccountType(currentAccountType);

        if (currentStepDone == 3) {
            $('#tw-form-signup input, #tw-form-signup select').attr('disabled', 'disabled');
            $('#tw-form-signup .button-wrap').addClass('hide');
        }
        changeStepDone(currentStepDone);
        changStepSelected(currentStepDone);

        if (tw_merchantInfo != null) {
            setAutoLog(tw_merchantInfo.user.AUTO_LOG_URL);
            fillInSignupForm($.extend(tw_merchantInfo.merchant, tw_merchantInfo.user));
        }
    }

    function initEvents() {
        $(".tw-module").on('click', ".tw-step-done-2 .tw-step1 .tw-title", function () {
            changStepSelected($(this).parent().data('step'));
        });

        $(".tw-module").on("click", "#tw-form-signup-submit", submitSignUp);
        $(".tw-module").on("click", "#tw-form-login-submit", submitLogin);
        $(".tw-module").on("click", "#tw-form-lostpassword-submit", submitLostPassword);

        $(".tw-module").on("click", "#switch-signup", changeStepAccountType.bind(this, 'new'));
        $(".tw-module").on("click", "#switch-login", changeStepAccountType.bind(this, 'exist'));

        $('#lostpassword-btn').on('click', showLostpassword.bind(this));

        $('.modal .close').on('click', closeModal);
    }

    function showLostpassword()
    {
        $('#lostPasswordMessage').hide();
        $('#lostPasswordForm').show();
        $('#lostPasswordForm input[name=EMAIL]').val('');

        $('#tw-form-lostpassword')
            .show()
            .addClass('in');
    }

    function closeModal()
    {
        $(this).parents('.modal')
            .hide()
            .removeClass('in');
    }

    function setAutoLog(url) {
        $('.tw-autolog-link').attr('href', url);
        $('.tw-autolog-link').attr('href', url);
    }

    function fillInSignupForm(data) {
        $('#tw-form-signup input, #tw-form-signup select').attr('disabled', 'disabled');
        $('#tw-form-signup .button-wrap').addClass('hide');

        $.each(data, function (key, value) {
            $('#tw-form-signup *[name=' + key + ']').val(value);
        });
    }

    function changeOnboardingStatus(status) {
        $stepContainer
            .removeClass("tw-onboarding-ongoing tw-onboarding-completed")
            .addClass("tw-onboarding-" + status);
    }

    function changeStepDone(step) {
        $stepContainer
            .removeClass("tw-step-done-1 tw-step-done-2")
            .addClass("tw-step-done-" + step);
    }

    function changStepSelected(step) {
        removeMessages();
        if ($stepContainer.hasClass('tw-step-done-2') && $stepContainer.hasClass('tw-step-selected-' + step)) {
            $stepContainer
                .removeClass('tw-step-selected-' + step)
                .addClass("tw-step-selected-3");
        } else {
            $stepContainer
                .removeClass("tw-step-selected-1 tw-step-selected-2 tw-step-selected-3")
                .addClass("tw-step-selected-" + step);
        }
    }

    function changeStepAccountType(type) {
        $stepContainer
            .removeClass("tw-step-account-exist tw-step-account-new")
            .addClass("tw-step-account-" + type);
        return false;
    }

    function redirectToLogin(xhr) {
        var needLogin = xhr.getResponseHeader('Login');
        if (xhr.status == 200 && needLogin == 'true') {
            window.location.reload();
            return true;
        }
        return false;
    }

    function removeMessages() {
        $("#loginMessage").addClass('hide');
    }

    function addFormError(errors) {
        $.each(errors, function (label, message) {
            //$("#tw-form-field-msg-" + label).text(message);
            $("#tw-form-signup [name=" + label + ']')
                .closest('.form-group')
                .removeClass('tw-field-success')
                .addClass('tw-field-error');
        });
    }

    function addFormSuccess(errors) {
        $.each(errors, function (label, message) {
            $("#tw-form-field-msg-" + label).text('');
            $("#tw-form-signup [name=" + label + ']')
                .closest('.form-group')
                .removeClass('tw-field-error')
                .addClass('tw-field-success');
        });
    }

    function submitSignUp() {
        $.ajax({
            type: 'POST',
            url: tw_formSignUpUrl,
            dataType: 'json',
            data: $('#tw-form-signup').serialize(),
            success: function (data, status, xhr) {
                redirectToLogin(xhr);
                if (data.errors) {
                    addFormError(data.errors);
                    if (data.success) {
                        addFormSuccess(data.success);
                    }
                } else {
                    if (data.user) {
                        setAutoLog(data.user.AUTO_LOG_URL);
                        $('#tw-form-signup .button-wrap').addClass('hide');
                    }
                    changeStepDone(2);
                    changStepSelected(2);
                }
            },
            error: redirectToLogin
        });
        return false;
    }

    function submitLogin() {
        $.ajax({
            type: 'POST',
            url: tw_formLoginUrl,
            dataType: 'json',
            data: $('#tw-form-login').serialize(),
            success: function (data, status, xhr) {
                redirectToLogin(xhr);
                if (data.errors) {
                    $("#loginMessage").removeClass('hide');
                    $('#tw-form-login .form-group').addClass('tw-field-error');
                } else {
                    if (data.user && data.merchant) {
                        setAutoLog(data.user.AUTO_LOG_URL);
                        fillInSignupForm($.extend(data.merchant, data.user));
                    }
                    changeOnboardingStatus(data.product.status);
                    changeStepDone(2);
                    changStepSelected(2);
                }
            },
            error: redirectToLogin
        });
        return false;
    }

    function submitLostPassword() {
        $.ajax({
            type: 'POST',
            url: tw_lostPasswordUrl,
            dataType: 'json',
            data: $('#lostPasswordForm').serialize(),
            success: function (data, status, xhr) {
                redirectToLogin(xhr);
                if (data.errors) {
                    message = data.errors[0];
                    type = 'danger';
                } else {
                    message = data.success[0];
                    type = 'success';
                }

                $('#lostPasswordMessage p').html(message);
                $('#lostPasswordMessage .alert').removeClass('alert-danger alert-success').addClass('alert-' + type);
                $('#lostPasswordMessage .fa-tw-alert').removeClass('fa-tw-danger fa-tw-success').addClass('fa-tw-' + type);
                $('#lostPasswordMessage').show();
                if (!data.errors) {
                    $('#lostPasswordForm').hide();
                }
            },
            error: redirectToLogin
        });
        return false;
    }

})($j1113);
/**
 * jquery version defined using $this->context->controller->addJquery('1.11.3');
 * This method create a variable $j1113 with the given version
 */

