var PrivillagesGroup = function () {
    const validateSignIn = () => {
        var errorFlag = false;
        $('.is-invalid').removeClass('is-invalid');
        const user_name = $('#txtUsername').val().trim();
        const user_pass = $('#txtPassowrd').val().trim();
        const financialyear = $.trim($('#txtfinancialyear').val());
        if (user_name === '' || user_name === null) {
            $('#txtUsername').addClass('is-invalid');
            errorFlag = true;
        }
        if (user_pass === '' || user_pass === null) {
            $('#txtPassowrd').addClass('is-invalid');
            errorFlag = true;
        }

        if (financialyear === '' || financialyear === null) {
            $("#" + 'select2-' + 'txtfinancialyear' + '-container').addClass('is-invalid');
            errorFlag = true;
        }
        return errorFlag;
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
    var validateAuthCode = function () {
        var errorFlag = [];
        var name = $.trim($("#txtCode").val());
        // remove previous errors
        $(".login-error").remove();

        if (name === "" || name === null) {
            $("#txtUsername").addClass("inputerror");
            errorFlag.push("Enter Security Code to Login.");
        }

        return errorFlag;
    };

    var validateSignInMobCode = function () {
        var errorFlag = [];
        var name = $.trim($("#txtUsername").val());
        var pass = $.trim($("#txtPassowrd").val());

        // remove previous errors
        $(".login-error").remove();

        if (name === "" || name === null) {
            $("#txtUsername").addClass("inputerror");
            errorFlag.push("Enter Username.");
        }
        if (pass === "" || pass === null) {
            $("#txtPassowrd").addClass("inputerror");
            errorFlag.push("Enter Password.");
        }

        return errorFlag;
    };
    var fetch = function (user_name, user_pass, financialyear, logindata) {
        $.ajax({
            url: base_url + '/userlogin',
            type: 'POST',
            data: { 'user_name': user_name, 'user_pass': user_pass, 'financialyear': financialyear, 'logindata': logindata, 'user_agent': 'web' },
            dataType: 'JSON',
            success: function (response) {
                if (response.status == false && response.data == null) {
                    AlertMessage('Error!', response.message, 'danger');
                }
                else if (response.status === true) {
                    AlertMessage('Success!', response.message, 'success');
                }
                setTimeout(function () {
                    if (response.status === true) {
                        window.location = base_url + '/verificationemail';
                    }
                }, 3000);
            }, error: function (xhr, status, error) {
                window.location = base_url;
                console.log(xhr.responseText);
            }
        });
    };

    var authCode = function (mcode) {
        $.ajax({
            url: base_url + "/authlogincode",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: { mcode: mcode },
            dataType: "JSON",
            success: function (data) {
                if (data.errormsg && data.errormsg === "not_secure") {
                    window.location = base_url + "/login";
                } else if (data == false) {
                    var span =
                        "<span class='login-error'>Invalid Security Code entered.</span>";
                    $(span).appendTo(".errors_section");
                } else {
                    window.location = base_url + "/user/dashboardnew";
                }
            },
            error: function (xhr, status, error) { },
        });
    };

    var fetchCode = function (uname, pass) {
        $.ajax({
            url: base_url + "/logincode",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: { uname: uname, pass: pass },
            dataType: "JSON",
            success: function (data) {
                if (data == true) {
                    alert("Mobile Code Send Successfuly To Your Cell.....");
                } else {
                    alert("code sending error");
                    var span =
                        "<span class='login-error'>Mobile Code Sending Error. Try Again!...</span>";
                    $(span).appendTo(".errors_section");
                    window.location = base_url + "/login";
                }
            },
            error: function (xhr, status, error) {
                alert("send error");
                console.log(xhr.responseText);
            },
        });
    };
    const validateEmail = function (sEmail) {
        var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
        if (pattern.test(sEmail)) {
            return true;
        } else {
            return false;
        }
    };
    return {
        init: function () {
            this.bindUI();
            $(document).ready(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
        },

        bindUI: function () {
            var self = this;

            $("#login_form input").on("keypress", function (e) {
                if (e.keyCode == 13) {
                    $(".btnSignin").trigger("click");
                }
            });
            $('#txtEmail').on('change', function () {
                var sEmail = $('#txtEmail').val();
                // Checking Empty Fields
                if (validateEmail(sEmail)) {
                    $('#txtEmail').addClass('is-valid');
                    $('#txtEmail').removeClass('is-invalid');
                } else {
                    AlertMessage('Error!!!', 'Invalid E-Mail Address', 'danger');
                    $('#txtEmail').addClass('is-invalid');
                    $('#txtEmail').focus();
                }
            });
            $(".btnSignin").on("click", function (e) {
                e.preventDefault();
                self.initSignIn();
            });
            $(".glyphicon22-eye-open2").mousedown(function () {
                $("#txtPassowrd").attr('type', 'text');
            }).mouseup(function () {
                $("#txtPassowrd").attr('type', 'password');
            }).mouseout(function () {
                $("#txtPassowrd").attr('type', 'password');
            });

            $("#mobilecode_form").on("submit", function (e) {
                e.preventDefault();
                self.initAuthCode();
            });

            $(".btnAuthCode").on("click", function (e) {
                e.preventDefault();
                self.initAuthCode();
            });

            $(".btnMobCode").on("click", function (e) {
                e.preventDefault();
                self.initSignInCode();
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        },

        initSignIn: function () {
            var errors = validateSignIn();
            if (errors == 0) {
                $('.btnSignin').attr('disabled', 'disabled');
                $('.btnSignin .fa').removeClass('hide');
                var logindata = [];
                const uname = $.trim($('#txtUsername').val());
                const pass = $.trim($('#txtPassowrd').val());
                const financialyear = $.trim($('#txtfinancialyear').val());
                $.getJSON('https://api.ipify.org/?format=json', function (ip, response) {
                    console.log("success Ip Working");
                }).done(function (ip) {
                    $.getJSON('https://freegeoip.app/json/' + ip.ip + '', function (logindata) {
                        console.log("success");
                    }).done(function (logindata) {
                        fetch(uname, pass, financialyear, logindata);
                    }).fail(function () {
                        fetch(uname, pass, financialyear, logindata);
                        console.log('fail https://freegeoip.app/json/');
                    });
                }).fail(function () {
                    fetch(uname, pass, financialyear, logindata);
                    console.log('fail https://api.ipify.org/?format=json');
                });
            } else {
                AlertMessage('Error!', 'Enter valid Username or Password...', 'danger');
            }
        },

        initAuthCode: function () {
            var errors = validateAuthCode();

            if (errors.length == 0) {
                var mcode = $.trim($("#txtCode").val());
                authCode(mcode);
            } else {
                var spans = "";
                $.each(errors, function (index, elem) {
                    spans += "<span class='login-error'>" + elem + "</span>";
                });
                // show the errors on the screen
                $(spans).appendTo(".errors_section");
            }
        },

        initSignInCode: function () {
            var errors = validateSignInMobCode();

            if (errors.length == 0) {
                var uname = $.trim($("#txtUsername").val());
                var pass = $.trim($("#txtPassowrd").val());
                fetchCode(uname, pass);
            } else {
                var spans = "";
                $.each(errors, function (index, elem) {
                    spans += "<span class='login-error'>" + elem + "</span>";
                });
                // show the errors on the screen
                $(spans).appendTo(".errors_section");
            }
        },

        resetVoucher: function () {
            $("#txtIdHidden").val("");
            $("#txtName").val("");
            $('input[type="checkbox"]').prop("checked", false);
            getMaxId();
        },
    };
};

var privillagesGroup = new PrivillagesGroup();
privillagesGroup.init();
