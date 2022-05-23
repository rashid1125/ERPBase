var Login = function () {
    var errorflagTime = "";
    Window.reloadFlag = false;
    let setIntervalTimeFlag = 0;
    let elapsedTime = 0;
    var fetch = function (code) {
        $('.btnMobCode .fa-spinner').removeClass('d-none');
        $.ajax({
            url: base_url + '/getValidateUserOTPCode',
            type: 'POST',
            data: { 'uid': $.trim($('#txtLoginDataUserID').val()), 'uname': $.trim($('#txtLoginDataUserName').val()), 'fn_id': $.trim($('#txtLoginDataFn_ID').val()), 'code': code, 'user_agent': 'web' },
            dataType: 'JSON',
            success: function (response) {
                $('.btnMobCode .fa-spinner').addClass('d-none');
                var cls = 'danger';
                if (response.status) {
                    cls = 'success';
                }

                $('.btnMobCode .fa-spinner').addClass('d-none');
                if (response.status === true && response.data !== null) {
                    txtAPP_VERSION = ($('#txtAPP_VERSION').val());
                    txtAPP_NEW_VERSION = ($('#txtAPP_NEW_VERSION').val());
                    if (txtAPP_NEW_VERSION > txtAPP_VERSION) {
                        $("#progressBardefult").show();
                        setIntervalTimeFlag = setInterval(function () { progressBarTimer(); }, 250);
                        getSoftwareUpdate(response);
                    } else {
                        $.notify({ message: response.message }, { type: cls });
                        location.reload();
                    }
                } else if (response.status == false && response.location !== null) {
                    $.notify({ message: response.message }, { type: cls });
                    window.location = base_url + '/';
                } else {
                    $.notify({ message: response.message }, { type: cls });
                    location.reload();
                }
            },
            error: function (xhr, status, error) {
                $('.btnMobCode .fa-spinner').addClass('d-none');
                console.log(xhr.responseText);
            }
        });
    };
    const AlertMessage = (title = "Error", _message = "", ClassType = "danger") => {
        $.notify({
            // options
            title: '<strong>' + title + '</strong>',
            message: "<br>" + _message,
            icon: 'glyphicon glyphicon-remove-sign',
        }, {
            // settings
            element: 'body',
            position: null,
            type: ClassType,
            allow_dismiss: true,
            newest_on_top: false,
            showProgressbar: false,
            placement: {
                from: "top",
                align: "right"
            },
            offset: 20,
            spacing: 10,
            z_index: 1031,
            delay: 3300,
            timer: 1000,
            url_target: '_blank',
            mouse_over: null,
            animate: {
                enter: 'animated flipInY',
                exit: 'animated flipOutX'
            },
            onShow: null,
            onShown: null,
            onClose: null,
            onClosed: null,
            icon_type: 'class',
        });
    };
    /**
* getSoftwareUpdate
* * Here We Can Updateing Software
* @return bool
* */
    const getSoftwareUpdate = (response) => {
        $.ajax({
            url: base_url + '/softwareUpdate',
            type: 'POST',
            dataType: 'JSON',
            async: false,
            success: function (data) {

            }, error: function (xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    };

    var Re_Send_OTP_Code = function () {
        $.ajax({
            url: base_url + '/resendptpcode',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'JSON',
            success: function (response) {
                var cls = 'danger';
                if (response.status) {
                    cls = 'success';
                }

                $.notify(response.message, { type: cls });
                $.trim($('.text_otp').text('Code will be expire after'));
                if (response.status === true) {
                    location.reload();
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    };


    var validateSignIn = function () {

        var errorFlag = 0;
        // remove the error class first
        $('.inputerror').removeClass('inputerror');
        $('.save-elem').each(function (ind, elem) {
            if ($.trim($(this).val()) === '') {
                if ($(this).hasClass('chosen')) {
                    $("#" + $(this).prop('id') + "_chzn").addClass('inputerror');
                } else {
                    $(this).addClass('inputerror');
                }

                if (!$(this).hasClass('d-none')) {
                    errorFlag += 1;
                }
            }

        });
        return errorFlag;
    };

    var resetFields = function () {
        $('.form-control').each(function (ind, elem) {
            if ($(this).hasClass('not-reset')) {
                return true;
            } else if ($(this).hasClass('ts_datepicker')) {
                $(this).datepicker('update', new Date());
            } else {
                $(this).val('').trigger('input');
            }
        });
    };
    var calcTime = function () {
        var mins = $.trim($('small span.min').text());
        var secs = $.trim($('small span.secs').text());
        if (secs == '0' || secs == '00') {
            $('small span.min').text((mins - 1).toString().padStart(2, '0'));
            $('small span.secs').text((59).toString().padStart(2, '0'));
        } else {
            $('small span.secs').text((secs - 1).toString().padStart(2, "0"));
        }
    };
    var kt_login_signin_form = function () {
        window.logoutintimated = false;
        if (document.getElementById('kt_login_signin_form')) {
            setInterval(function () {
                var mins = $.trim($('small span.min').text());
                var secs = $.trim($('small span.secs').text());
                if ((mins) > $.trim($('#setting_otp_code_time').val()) && !window.logoutintimated) {
                    window.logoutintimated = true;
                    window.location = base_url + '/login';
                } else {
                    if (mins != '0' && mins != '00') {
                        calcTime();
                    } else {
                        if (secs != '0' && secs != '00') {
                            calcTime();
                            $('.Code_will_be_expire_after').removeClass('Code_will_be_expire_after_error');
                            errorflagTime = false;
                        } else {
                            errorflagTime = true;
                            $('.timer').addClass('d-none');
                            $('.text_otp').text('OTP Expired');
                            $('.Code_will_be_expire_after').addClass('Code_will_be_expire_after_error');
                            $('small span.min').text('00');
                            $('small span.secs').text('00');
                            $('#verification_form').removeAttr('id');
                            $('#kt_login_resendotp_submit').attr('disabled', false);
                            $('#kt_login_signin_submit').attr('disabled', 'disabled');
                            $('#kt_login_resendotp_submit').css('opacity', 1);
                            $('#kt_login_signin_submit').css('opacity', 0.5);
                        }
                    }
                }

            }, 1000);
        }
    };
    var InputFieldsValidate = function (InputLocation) {
        var InputValue = $(InputLocation).val();
        var Required = $.trim($(InputLocation).attr('required'));
        // Checking Empty Fields
        $(InputLocation).removeClass('is-invalid');
        if (InputValue.length > 0) {
            // $(InputLocation).addClass('is-valid');
        } else {
            if (Required) {
                if (!$(InputLocation).val()) {
                    $(InputLocation).addClass('is-invalid');
                    $.notify('Please Fill Out Fields With Asterisk (*) Marked In Red', { positions: 'middle', className: 'error urdu_fontnotfiy' });
                }
            } else {
                $(InputLocation).removeClass('is-valid');
                $(InputLocation).removeClass('is-invalid');
            }
        }
    };

    const progressBar = (percent, version) => {
        txtAPP_VERSION = ($('#txtAPP_VERSION').val());
        document.getElementById("progressBar1").style.width = percent + '%';
        document.getElementById("progress1").style.color = "#000";
        document.getElementById("progress1").innerHTML = " Updating Software Version " + percent + '%';
    };
    const progressBarTimer = () => {
        if (elapsedTime > 100) {
            document.getElementById("progress1").style.color = "#000";
            document.getElementById("progress1").style.textAlign = "left";
            document.getElementById("progress1").innerHTML = "Successfully Updated...";
            if (elapsedTime >= 107) {
                Window.reloadFlag = true;
                // $.notify({ message: 'Please await for reloading the page going to Dashboard !!!' }, { type: 'success' });
                clearInterval(setIntervalTimeFlag);
                history.go(-1);
            }
        }
        else {
            progressBar(elapsedTime);
        }
        elapsedTime++;
    };


    return {
        init: function () {
            this.bindUI();
            resetFields();
            $('#txtUsernameCode').focus();
            $('.timer').removeClass('d-none');
            $('#kt_login_resendotp_submit').attr('disabled', true);
            $('#kt_login_resendotp_submit').css('opacity', 0.5);
            kt_login_signin_form();
            $('[data-mask]').inputmask();
            // $('#txtUsernameCode').inputmask();

        },

        bindUI: function () {
            var self = this;
            $('#kt_login_signin_form').on('submit', function (e) {
                e.preventDefault();
                self.initSignIn();
            });

            $('.btnMobCode').on('click', function (e) {
                e.preventDefault();
                self.initSignIn();
            });

            $('.btnMobCode').on('keypress', function (e) {
                e.preventDefault();
                if (e.keyCode === 13) {

                    self.initSignIn();
                }
            });

            $('.save-elem').on('paste', function (e) {
                e.preventDefault();
                var pasteData = e.originalEvent.clipboardData.getData('text');
                var splittedInput = pasteData.split('');
                var currentInp = $(this);
                $.each(splittedInput, function (ind, val) {
                    currentInp.val(val);
                    currentInp = currentInp.next().focus();
                    if (ind == 3) {
                        return false;
                    }
                });
            });

            $('.save-elem').on('keyup', function (e) {
                if (e.keyCode == 13) {
                    $('.btnMobCode').trigger('click');
                } else if ($(this).val().length == 1 && e.keyCode != 9 && e.keyCode != 16) {
                    $(this).next().focus();
                } else if (e.keyCode == 8) {
                    $(this).prev().focus();
                }
            });

            shortcut.add("shift+tab", function () {
                $(document.activeElement).prev().focus();
            });

            shortcut.add("tab", function (e) {
                if ($(document.activeElement).data('last'))
                    $('#kt_login_signin_submit').focus();
                else
                    $(document.activeElement).next().focus();
            });

            $(".glyphicon22-eye-open").mousedown(function () {
                $("#txtPassowrd").attr('type', 'text');
            }).mouseup(function () {
                $("#txtPassowrd").attr('type', 'password');
            }).mouseout(function () {
                $("#txtPassowrd").attr('type', 'password');
            });

            $('#kt_login_forgot_form').on('submit', function (e) {
                e.preventDefault();
                self.initForgetPass();
            });
            $('#kt_login_resendotp_submit').on('click', function (e) {
                e.preventDefault();
                Re_Send_OTP_Code();
            });
            $('input').on('change', function (e) {
                e.preventDefault();
                InputFieldsValidate(this);
            });

        },
        initSignIn: function () {
            var errors = validateSignIn();
            var otp_code = "";
            if (errors === 0) {
                $('.save-elem').each(function (ind, elem) {
                    if ($(this).is('input') || $(this).is('select') || $(this).is('textarea')) {
                        otp_code += $.trim($(this).val());
                    }
                });
                fetch(otp_code);
            } else {
                AlertMessage('Error!!!', 'Please Fill Out 4 Digit Verification Code...', 'danger');
            }
        },
        resetVoucher: function () {

            $('#txtPassowrd').val('');
            $('#txtEmail').val('');
            $('#txtUsernameCode').val('');
        }
    };

};

var login = new Login();
login.init();

$(document).ajaxStart(function () {
    $(".loader").show();
});

$(document).ajaxComplete(function (event, xhr, settings) {
    $(".loader").hide();
});
