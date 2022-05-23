
getAllRecordData=(etype)=> {
	if (typeof ViewAllRecordData != 'undefined') {
		ViewAllRecordData.fnDestroy();
		$('#' + etype + 'table thead').remove();
		$('#' + etype + 'tableBody').empty();
	}
	$.ajax({
		url: base_url + '/voucher/setupviewall',
		type: 'POST',
		data: { 'etype': etype },
		dataType: 'JSON',
		success: function (response) {
			if (response.status == false && response.data == null) {
				_getAlertMessage('Error!', response.message, 'danger');
			} else if (response.status === true && response.data !== null) {
				getPopulateAllRecordData(response.data, response.etype);
			}
		}, error: function (xhr, status, error) {
			console.log(xhr.responseText);
		}
	});
};
getPopulateAllRecordData = function (data, etype) {
	if (data.length !== 0) {
		var Columns = [];
		var columncount = 0;
		var sr = 0;
		Serail = "Sr #";
		clas = 'text-left';
		var TableHeader = "<thead class='thead-light dthead'><tr><th class='" + clas + "'>" + Serail + "</th>";
		// Loop For Table Header
		$.each(data[0], function (key, value) {
			var clas = '';
			var x = key;
			if (key.indexOf("_hide") < 0) {
				var header = [];
				if (key.indexOf("_num") < 0) {
					header = x.replace("_sum", "");
					clas = 'text-left';
				} else if (key.indexOf("_avg") > 0) {
					var vhead = x.split("_");
					header = vhead[0];
				} else {
					header = x.replace("_num", "");
					clas = 'text-right';
				}
				TableHeader += '<th class="' + clas + '" >' + header + '</th>';
				columncount += 1;
				Columns.push(header);
			}
		});
		TableHeader += "<th class='text-right'>Action</th></thead></tr>";

		$('#' + etype + 'table').append(TableHeader);
		// Loop For Table Header End


		for (var i = 0; i < data.length; i++) {
			var TableHeader2 = "<tr class='item-row-td'>";
			var x = 0;
			var vrnoa = '';
			var _fn_id = '';
			var _company_id = '';
			var href = '';
			var _vrnoa = '';
			$.each(data[i], function (key, value) {
				if (key === 'etype_hide') {
					etype = value;
				}
				if (key === 'vrnoa_hide') {
					vrnoa = value;
				} else if (key === 'pid_hide') {

					vrnoa = value;
				}
				if (key === 'refurl_hide') {
					href = value;
				}
				if (key === 'fn_id_hide') {
					_fn_id = value;
				}
				if (key === 'company_id_hide') {
					_company_id = value;
				}
			});

			if (vrnoa && vrnoa != '') {
				_vrnoa = ('vrnoa_hide', vrnoa);
				TableHeader2 += '<td class="' + clas + ' text-vrnoa-td">' + parseInt(sr + 1) + '</td>';
			} else {
				TableHeader2 += '<td class="' + clas + ' text-vrnoa-td">' + parseInt(sr + 1) + '</td>';
			}
			sr = sr + 1;

			$.each(data[i], function (key, value) {

				var tdDate = moment(value, "YYYY-MM-DD", true);

				if (key.indexOf("_sum") >= 0) {

					if (tdDate.isValid()) {
						value = (value) ? getFormattedDate(value) : "-";
						clas = 'text-left';
					} else {
						value = (value) ? Number.parseFloat(value) + value.toString().replace(/[^a-zA-Z]+/g, '') : Number.parseFloat(0).toFixed(2);
					}
					clas = 'text-right';

				} else if (key.indexOf("_num") >= 0) {

					if (tdDate.isValid()) {
						value = (value) ? getFormattedDate(value) : "-";
						clas = 'text-left';
					} else {
						value = (value) ? Number.parseFloat(value) + value.replace(/[^a-zA-Z]+/g, '') : Number.parseFloat(0).toFixed(2);
					}
					clas = 'text-right';

				} else {

					if (tdDate.isValid()) {
						value = (value) ? getFormattedDate(value) : "-";
						clas = 'text-left';
					} else {
						value = (value) ? value : '-';
					}
					clas = 'text-left';
				}

				if (key.indexOf("_hide") < 0) {
					TableHeader2 += "<td class=" + clas + ">" + value + "</td>";
					x += 1;
				}
			});

			TableHeader2 += '<td class="text-right"><a href="#" data-vrnoa_hide="' + _vrnoa + '" class="text-right btn btn-sm btn-primary btn-edit-' + etype + '"><span class="fa fa-edit"></span></a></td></tr>';
			$('#' + etype + 'tableBody').append(TableHeader2);
		}

		getLoadDataTableForSetupVoucher(etype);
	}
};
getLoadDataTableForSetupVoucher = (etype) => {
	var dontSort = [];
	$('#' + etype + 'table').each(function () {
		if ($(this).hasClass('no_sort')) {
			dontSort.push({
				"bSortable": false
			});
		} else {
			dontSort.push(null);
		}
	});
	ViewAllRecordData = $('#' + etype + 'table').dataTable({
		"paging": true,
		"lengthChange": false,
		"searching": true,
		"ordering": true,
		"info": true,
		"autoWidth": false,
		"responsive": true,
	});
	$.extend($.fn.dataTableExt.oStdClasses, {
		"s`": "dataTables_wrapper form-inline"
	});
};