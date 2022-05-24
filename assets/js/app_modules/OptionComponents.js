const getOptionCallComponent = function () {
    return {
        _getroleGroupOption: function (ID, active, etype, company_id) {
            $.ajax({
                type: "POST",
                url: base_url + '/OptionCallComponent/getroleGroupOption',
                data: { 'active': active, 'etype': etype, 'company_id': company_id },
                dataType: "JSON",
                success: function (response) {
                    $('.txtRolegroup-dropdown-text-message').html('');
                    if (response.status == false && response.data == null) {
                        _getAlertMessage('Error!', response.message, 'danger');
                    } else if (response.status === true) {
                        $('.txtRolegroup-dropdown-text-message').html(response.message);
                        setTimeout(() => {
                            $(ID).html(response.data);
                            $('.txtRolegroup-dropdown-text-message').html('');
                        }, 2000);
                    }

                }, error: function (xhr, status, error) {
                    _getAlertMessage('Error!', xhr.responseText, 'danger');
                }
            });
        },
        _getCompanyOption: function (ID, active, etype, company_id) {
            $.ajax({
                type: "POST",
                url: base_url + '/OptionCallComponent/getCompanyOption',
                data: { 'active': active, 'etype': etype, 'company_id': company_id },
                dataType: "JSON",
                success: function (response) {
                    $('.txtCompany-dropdown-text-message').html('');
                    if (response.status == false && response.data == null) {
                        _getAlertMessage('Error!', response.message, 'danger');
                    } else if (response.status === true) {
                        $('.txtCompany-dropdown-text-message').html(response.message);
                        setTimeout(() => {
                            $(ID).html(response.data);
                            $('.txtCompany-dropdown-text-message').html('');
                        }, 2000);

                    }
                }, error: function (xhr, status, error) {
                    _getAlertMessage('Error!', xhr.responseText, 'danger');
                }
            });
        },
        _getFinancialYearOption: function (ID, multiple, active, etype, company_id) {
            $.ajax({
                type: "POST",
                url: base_url + '/OptionCallComponent/getFinancialYearOption',
                data: { 'active': active, 'etype': etype, 'company_id': company_id, 'multiple': multiple },
                dataType: "JSON",
                success: function (response) {
                    $('.txtFinancialYear-dropdown-text-message').html('');
                    if (response.status == false && response.data == null) {
                        _getAlertMessage('Error!', response.message, 'danger');
                    } else if (response.status === true) {
                        $('.txtFinancialYear-dropdown-text-message').html(response.message);
                        setTimeout(() => {
                            $(ID).html(response.data);
                            $('.txtFinancialYear-dropdown-text-message').html('');
                        }, 2000);

                    }
                }, error: function (xhr, status, error) {
                    _getAlertMessage('Error!', xhr.responseText, 'danger');
                }
            });
        },
        _getLevel3Option: function (ID, multiple, active, etype, company_id) {
            $.ajax({
                type: "POST",
                url: base_url + '/OptionCallComponent/getLevel3Option',
                data: { 'active': active, 'etype': etype, 'company_id': company_id, 'multiple': multiple },
                dataType: "JSON",
                success: function (response) {
                    $('.txtLevel3-dropdown-text-message').html('');
                    if (response.status == false && response.data == null) {
                        _getAlertMessage('Error!', response.message, 'danger');
                    } else if (response.status === true) {
                        $('.txtLevel3-dropdown-text-message').html(response.message);
                        setTimeout(() => {
                            $(ID).html(response.data);
                            $('.txtLevel3-dropdown-text-message').html('');
                        }, 2000);

                    }
                }, error: function (xhr, status, error) {
                    _getAlertMessage('Error!', xhr.responseText, 'danger');
                }
            });
        },
        _getUserOption: function (ID, multiple, active, etype, company_id) {
            $.ajax({
                type: "POST",
                url: base_url + '/OptionCallComponent/getUserOption',
                data: { 'active': active, 'etype': etype, 'company_id': company_id, 'multiple': multiple },
                dataType: "JSON",
                success: function (response) {
                    $('.txtUser-dropdown-text-message').html('');
                    if (response.status == false && response.data == null) {
                        _getAlertMessage('Error!', response.message, 'danger');
                    } else if (response.status === true) {
                        $('.txtUser-dropdown-text-message').html(response.message);
                        setTimeout(() => {
                            $(ID).html(response.data);
                            $('.txtUser-dropdown-text-message').html('');
                        }, 2000);

                    }
                }, error: function (xhr, status, error) {
                    _getAlertMessage('Error!', xhr.responseText, 'danger');
                }
            });
        },

    };
};
const OptionComponents = new getOptionCallComponent();