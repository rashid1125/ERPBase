var UserVoucher = function () {
    // checks for the empty fields
    const _getvalidateSave = () => {
        
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
        return obj;
    };

    // saves the data into the database
    const save = (obj) => {
        general.disableSave();
        $.ajax({
            url: base_url + '/financialyear/financialyearsave',
            type: 'POST',
            data: { 'obj': JSON.stringify(obj), 'voucher_type_hidden': $('#vouchertypehidden').val(), 'etype': 'financialyearvoucher' },
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
            OptionComponents._getroleGroupOption('#txtUserRoleGroup');
            OptionComponents._getCompanyOption('#txtUserCompany');
            
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
                getAllRecordData('financialyearvoucher');
            });
            $('#txtUserForm').validate({
                rules: {
                    uname: {
                        required: true,
                    },
                    pass: {
                        required: true,
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
                    pass: {
                        required: "Please enter password",
                        minlength: "Your password must be at least 8 characters long"
                    },
                    fullname: {
                        required: "Please enter full name",
                    },
                    email: {
                        required: "Please enter full name",
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
            var errors = _getvalidateSave();	// checks for the empty fields
            var saveObj = _getSaveObject();	// returns the class detail object to save into database
            $.validator.setDefaults({
                submitHandler: function () {
                    var errors = _getvalidateSave();
                    save(saveObj);
                }
            });
            

            if (errors == 0) {
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