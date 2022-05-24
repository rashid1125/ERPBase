const _getAlertMessage = (title = "Error", _message = "", ClassType = "danger") => {
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
			from: "bottom",
			align: "center"
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
var populateDateValue = function (date_id, date, checkFormat = null) {
	var dates = getFormattedDate(date, null, checkFormat);

	$('#' + date_id).datepicker('update', dates);
};
const getFormattedDate = (date, format = null, checkFormat = null) => {
	if (!format)
		format = $('#default_date_format').val();
	var dt = moment(date);
	if (checkFormat)
		dt = moment(date, checkFormat.toUpperCase());
	return dt.format(format.toUpperCase());
};
var General = function () {
	if (!String.prototype.trim) {
		String.prototype.trim = function () {
			return this.replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g, '');
		};
	}

	return {
		init: function () {
			this.bindUI();

		},

		bindUI: function () {
			var self = this;
			$('.select2').select2({
				width: '100%'
			});

			$('[data-mask]').inputmask();
			$('.datepicker').datepicker({
				format: 'yyyy/mm/dd',
				todayHighlight: true,
				todayBtn: 'linked',
				toggleActive: true,
			});
			$('.datepicker').datepicker('update', new Date());

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			// bind application wide loader
			$(document).ajaxStart(function () {
				$(".loader").show();
			});

			$(document).ajaxComplete(function (event, xhr, settings) {
				$(".loader").hide();
			});
		},
		enableSave: function () {
			$('.btnSave,.btnSave1').attr("disabled", "disabled");
			$('.btnDelete,.btnDelete1').attr("disabled", "disabled");
			shortcut.remove("F10");
			shortcut.remove("F12");
			$('.btnSave,.btnSave1').removeAttr("disabled");
			$('.btnDelete,.btnDelete1').removeAttr("disabled");
			shortcut.add("F10", function () {
				$('.btnSave').get()[0].click();
			});
			shortcut.add("F12", function () {
				$('.btnDelete').get()[0].click();
			});
		},
		disableSave: function () {
			$('.btnSave,.btnSave1').attr("disabled", "disabled");
			$('.btnDelete,.btnDelete1').attr("disabled", "disabled");
			shortcut.remove("F10");
			shortcut.remove("F12");
		},
	};
};

var general = new General();
general.init();
$.validator.addMethod("uppercaseLetterFlag", function (value) {
	return /[A-Z]/.test(value); // has an uppercase letter
}, "The password must contain at least one uppercase letter");
$.validator.addMethod("lowercaseLetterFlag", function (value) {
	return /[a-z]/.test(value); // has a lowercase letter
}, "The password must contain at least one lowercase letter");
$.validator.addMethod("consecutiveIdenticalCharactersFlag", function (value) {
	return !(/(.)\1\1/.test(value)); // does not contain 3 consecutive identical chars
}, "The password must not contain 3 consecutive identical characters");
$.validator.addMethod("specialCharacterFlag", function (value) {
	return /[!@#$%^&*()_=\[\]{};':"\\|,.<>\/?+-]/.test(value)
}, "The password must contain at least one special character");
$.validator.addMethod("Numberdigits", function (value) {
	return /\d/.test(value); // has a lowercase letter
}, "The password must contain at least one digits number");
