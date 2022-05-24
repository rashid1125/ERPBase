var UserVoucher = function () {
    // Geting photo 
    var _getImage = function () {
        var file = $('#itemImage').get(0).files[0];
        if (file) {
            if (!!file.type.match(/image.*/)) {
                if (window.FileReader) {
                    reader = new FileReader();
                    reader.onloadend = function (e) {
                        $('#itemImageDisplay').attr('src', e.target.result);
                        $('#removeImg').removeClass('d-none');
                        delete userVoucherObject.photo;
                    };
                    reader.readAsDataURL(file);
                }
            }
        }
        return file;
    };
    // returns the fee category object to save into database
    const _getSaveObject = function () {
        var obj = {};
        $('.save-elem').each(function (ind, elem) {
            if ($(this).is('input') || $(this).is('select') || $(this).is('textarea')) {
                if ($(this).hasClass('bs_switch')) {
                    obj[$(this).attr('name')] = $(this).bootstrapSwitch("state");
                } else if ($(this).prop('type') === 'radio') {
                    obj[$(this).attr('name')] = $("input[name='" + $(this).prop('name') + "']:checked").val();
                } else if ($(this).prop('type') === 'checkbox') {
                    var arr = [];
                    $.each($("input[name='" + $(this).prop('name') + "']:checked"), function () {
                        arr.push($(this).val());
                    });
                    obj[$(this).attr('name')] = arr.join(',');
                } else {
                    obj[$(this).attr('name')] = $.trim($(this).val());
                }
            }
        });

        if (userVoucherObject.photo != undefined) {
            userVoucherObject.photo_del = userVoucherObject.photo;
        }

        var form_data = new FormData();
        for (var key in obj) {
            form_data.append(key, obj[key]);
        }
        form_data.append("photo", _getImage());
        return form_data;
    };

    // saves the data into the database
    const save = (obj) => {
        general.disableSave();
        $.ajax({
            url: base_url + '/user/usersave',
            type: 'POST',
            data: obj,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (response) {
                if (response.status == false && response.data == null) {
                    _getAlertMessage('Error!', response.message, 'danger');
                } else if (response.status === true) {
                    _getAlertMessage('Success!', response.message, 'success');
                    _getResetFields();
                }
                general.enableSave();
            }, error: function (xhr, status, error) {
                _getAlertMessage('Error!', xhr.responseText, 'danger');
            }
        });
    };
    const _getResetFields = () => {
        $('#vouchertypehidden').val('new');
        $('.save-elem').each(function (ind, elem) {
            if ($(this).prop('type') === 'radio' || $(this).prop('type') === 'checkbox') {
                return true;
            } else if ($(this).hasClass('date-reset')) {
                $(this).datepicker('update', new Date());
            } else {
                $(this).val('').trigger('liszt:updated');
                $('#user_dropdwon').val('').trigger('liszt:updated');
            }
        });
        // _getAllRecordData('financialyearvoucher');
    };

    const getVoucher = (vrnoa) => {
        $.ajax({
            type: "POST",
            url: base_url + '/financialyear/getVoucher',
            data: { 'vrnoa': vrnoa },
            dataType: "JSON",
            success: function (response) {
                if (response.status == false && response.data == null) {
                    _getAlertMessage('Error!', response.message, 'danger');
                } else if (response.status === true) {
                    populateData(response.data);
                }
            }, error: function (xhr, status, error) {
                _getAlertMessage('Error!', xhr.responseText, 'danger');
            }
        });
    };
    // generates the view
    var populateData = function (data) {
        console.log(data);
        $('#vouchertypehidden').val('edit');
        $('.save-elem').each(function (ind, elem) {
            var col = $(this).attr('name');
            var name = $(this).prop('name');
            if ($(this).hasClass('bs_switch')) {
                $(this).bootstrapSwitch('state', (data[col] === "true") ? true : false);
            } else if ($(this).hasClass('datepicker')) {
                var id = $(this).attr('id');
                populateDateValue(id, data[col]);
            } else if ($(this).prop('type') === 'radio') {
                $("input[name='" + name + "'][value=" + data[col] + "]").prop("checked", true);
            } else if ($(this).prop('type') === 'checkbox') {
                $("input[name='" + name + "'][value=" + data[col] + "]").prop("checked", true);
            } else {
                $(this).val(data[col]).trigger('liszt:updated');
                $('#user_dropdwon').val(data.uid).trigger('liszt:updated');
            }
        });
    };
    return {

        init: function () {
            $('#vouchertypehidden').val('new');
            this.bindUI();
            $(document).ready(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
            $('.select2').select2({
                width: 'element',
                minimumResultsForSearch: Infinity
            });
        },
        bindUI: function () {
            var self = this;

            shortcut.add("F10", function () {
                $('.btnSave').first().trigger('click');
            });
            shortcut.add("F6", function () {
                $('#txtId').focus();
            });
            shortcut.add("F3", function () {
                $('#vehicleLookupBtn').trigger('click');
            });
            shortcut.add("alt+1", function () {
                $('a[href="#addProgramType"]').trigger('click');
            });
            shortcut.add("alt+2", function () {
                $('a[href="#ViewAll"]').trigger('click');
            });

            shortcut.add("F5", function () {
                self.resetVoucher();
            });

            $('#txtId').on('change', function () {
                fetch($(this).val());
            });
            // when save button is clicked
            $('.btnSave').on('click', function (e) {
                e.preventDefault();
                self.initSave();
            });

            // when the reset button is clicked
            $('.btnReset').on('click', function (e) {
                e.preventDefault();		// prevent the default behaviour of the link
                _getResetFields();
                // general.enableSave();
                // resets the voucher
            });

            // when edit button is clicked inside the table view
            $("body").on('click', '.btn-edit-financialyearvoucher', function (e) {
                e.preventDefault();
                getVoucher($(this).data('vrnoa_hide'));		// get the class detail by id
                $('a[href="#AddFinancialYear"]').trigger('click');
            });
            $('#txtViewAllQuery').on('click', function (e) {
                getAllRecordData('uservoucher');
            });
            // option
            $(document).on('click', '#txtUserRefreshRoleGroupdropdown', function (e) {
                e.preventDefault();
                $('#txtUserRoleGroup').html('');
                OptionComponents._getroleGroupOption('#txtUserRoleGroup');
            });
            $(document).on('click', '#txtUserRefreshCompanydropdown', function (e) {
                e.preventDefault();
                $('#txtUserCompany').html('');
                OptionComponents._getCompanyOption('#txtUserCompany');
            });
            $(document).on('click', '#txtUserRefreshFinancialYeardropdown', function (e) {
                e.preventDefault();
                $('#txtUserFinancialYear').html('');
                OptionComponents._getFinancialYearOption('#txtUserFinancialYear', true);
            });
            $(document).on('click', '#txtUserRefreshLevel3dropdown', function (e) {
                e.preventDefault();
                $('#txtUserLevel3').html('');
                OptionComponents._getLevel3Option('#txtUserLevel3', true);
            });
            $(document).on('click', '#txtUserRefreshUserdropdown', function (e) {
                e.preventDefault();
                $('#txtUserReportToAdmin').html('');
                OptionComponents._getLevel3Option('#txtUserReportToAdmin');
            });

            $(document).on('change', '#itemImage', function (e) {
                _getImage();
            });
            $(document).on('click', '#removeImg', function (e) {
                e.preventDefault();
                var src = $('#itemImageDisplay').attr('src');
                if (confirm("Are you sure to delete this image?") && src.length > 0) {
                    $('#itemImageDisplay').attr('src', base_url + '/assets/img/blank.png');
                    $('#removeImg').addClass('d-none');
                    $("#itemImage").val(null);
                    userVoucherObject.photo = '1';
                }
            });
            $(document).on('keyup', 'input[id$="txtUserPassword"]', function (e) {
                var pass = $(this).val();
                var format = /[ `!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
                $('#txtpassInfo').show();
                if ($('#txtlength').hasClass('valid') && $('#txtcapital').hasClass('valid') && $('#txtletter').hasClass('valid') && $('#txtnumber').hasClass('valid') && $('#txtspecialcharacter').hasClass('valid')) {
                    $('#txtpassInfo').hide();
                }
                if (pass.length < 8) {
                    $('#txtlength').removeClass('valid').addClass('invalid');
                } else {
                    $('#txtlength').removeClass('invalid').addClass('valid');
                }

                if (pass.match(/[a-z]/)) {
                    $('#txtletter').removeClass('invalid').addClass('valid');
                } else {
                    $('#txtletter').removeClass('valid').addClass('invalid');
                }

                if (pass.match(/[A-Z]/)) {
                    $('#txtcapital').removeClass('invalid').addClass('valid');
                } else {
                    $('#txtcapital').removeClass('valid').addClass('invalid');
                }

                if (pass.match(/\d/)) {
                    $('#txtnumber').removeClass('invalid').addClass('valid');
                } else {
                    $('#txtnumber').removeClass('valid').addClass('invalid');
                }
                if (format.test(pass)) {
                    $('#txtspecialcharacter').removeClass('invalid').addClass('valid');
                } else {
                    $('#txtspecialcharacter').removeClass('valid').addClass('invalid');
                }
            }).focusout(function () {  
                $('#txtpassInfo').hide();
            });

            $('#txtUserForm').validate({
                rules: {
                    uname: {
                        required: true,
                    },
                    pass: {
                        required: true,
                        uppercaseLetterFlag: true,
                        lowercaseLetterFlag: true,
                        specialCharacterFlag: true,
                        Numberdigits: true,
                        minlength: 8
                    },
                    confrimpass: {
                        required: true,
                        uppercaseLetterFlag: true,
                        lowercaseLetterFlag: true,
                        specialCharacterFlag: true,
                        Numberdigits: true,
                        equalTo: "#txtUserPassword",
                        minlength: 8
                    },
                    fullname: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    rgid: {
                        required: true,
                    },
                    company_id: {
                        required: true,
                    },
                },
                messages: {
                    uname: {
                        required: "Please enter username",
                    },
                    confrimpass:{
                        required: "Please enter full name",
                    },
                    fullname: {
                        required: "Please enter full name",
                    },
                    email: {
                        required: "Please enter E-Mail",
                        email: "Please enter a vaild email address"
                    },
                    rgid: {
                        required: "Please enter rolegroup",
                    },
                    company_id: {
                        required: "Please enter company",
                    }
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    var element_id = element.attr('id') + '-error';
                    $('#' + element_id).remove();

                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                    $(element).addClass('is-valid');
                }
            });
        },

        // makes the voucher ready to save
        initSave: function () {
            var errors = $("#txtUserForm").valid();	// checks for the empty fields
            var saveObj = _getSaveObject();	// returns the class detail object to save into database
            if (errors) {
                save(saveObj);
            } else {
                _getAlertMessage('Error!', 'Correct the errors...!!!', 'danger');
            }
        },
        // resets the voucher
        resetVoucher: function () {
            general.reloadWindow();
        }
    };
};

const userVoucherObject = new UserVoucher();
userVoucherObject.init();
$(document).ready(function () {
    setTimeout(() => {
        // OptionComponents._getroleGroupOption('#txtUserRoleGroup');
        // OptionComponents._getCompanyOption('#txtUserCompany');
        // OptionComponents._getFinancialYearOption('#txtUserFinancialYear', true);
        // OptionComponents._getLevel3Option('#txtUserLevel3', true);
        // OptionComponents._getUserOption('#txtUserReportToAdmin');
    }, 1000);

});