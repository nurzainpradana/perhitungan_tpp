var getUrl = window.location;
var baseUrl =
	getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split("/")[1];
var save_method;
var table;

$(document).ready(function () {
	$(".loading").hide();

	loadPaymentToListOption();

	init();
	$(".form-control-feedback").empty();

	table = $("#tableUnregisteredVoucher").DataTable({
		processing: true, //Feature control the processing indicator.
		serverSide: true, //Feature control DataTables' server-side processing mode.
		searching: false,
		paging: false,
		fixedHeader: true,

		// Load data for the table's content from an Ajax source
		ajax: {
			url: baseUrl + "/VoucherUnregistered/loadVoucherUnregisteredList",
			type: "POST",
			data: function (data) {
				data.Currency = $("#inputCurrency").val();
				data.PaymentTo = $("#inputPaymentTo").val();
			},
		},

		//Set column definition initialisation properties.
		columnDefs: [
			{
				targets: [0],
				orderable: false, // set not orderable
			},
		],
	});

	$("#btnFilter").click(function (e) {
		table.ajax.reload(null, false); //just reload table
	});

	$("#btnProcessRegister").click(function (e) {
		var voucherSelected = new Array();

		$(".cbVoucherList:checked").each(function () {
			voucherSelected.push($(this).val());
		});

		if (voucherSelected.length == 0) {
			$("#inputLocationModal").modal("hide");
			swalShow("error", "Failed!", "Please Check Selected Voucher!");
		} else if (checkLengthInputWithMessage("#inputLocation", 25)) {
			$(".loading").show();
			$.ajax({
				url: baseUrl + "/VoucherUnregistered/register",
				type: "POST",
				data: {
					location_name: $("#inputLocation").val(),
					voucherSelected: voucherSelected,
				},
				dataType: "JSON",
				success: function (response) {
					$(".loading").hide();
					$("#inputLocationModal").modal("hide");

					if (response.status == "success") {
						swalShow("success", "Success!", "Data has been save");
						init();
						reload_table();
					} else if (response.status == "failed") {
						swalShow("error", "Failed!", response.message);
					}
				},
				error: function (response) {
					$(".loading").hide();
					$("#inputLocationModal").modal("hide");
					swalShow("error", "Failed!", "Failed when process register!");
				},
			});
		}
	});

	$("#btnCancel").click(function (e) {
		$("#inputBank").val("");
		$("#inputCurrency").val("");
		$("#inputPaymentTo").val("");

		reload_table();
	});

	$("#btnRegister").click(function (e) {
		$("#inputLocation").val("");

		var voucherSelected = new Array();

		$(".cbVoucherList:checked").each(function () {
			voucherSelected.push($(this).val());
		});

		if (voucherSelected.length == 0) {
			swalShow("error", "Failed!", "Please Select The Voucher");
		} else {
			$("#inputLocationModal").modal("show");
			loadLocationListOption();

			$(".form-control-feedback").empty();
		}
	});

	$("#btnSelectAll").click(function (e) {
		var checkboxes = $(".cbVoucherList");

		for (var checkbox of checkboxes) {
			checkbox.checked = this.checked;
		}
	});
});

function loadVoucherBankListOption() {
	$.ajax({
		url: baseUrl + "/VoucherUnregistered/loadVoucherBankListOption",
		type: "POST",
		success: function (response) {
			$("#inputBank").empty();

			$("#inputBank").append(response);
		},
	});
}

function loadVoucherCurrencyListOption() {
	$.ajax({
		url: baseUrl + "/VoucherUnregistered/loadVoucherCurrencyListOption",
		type: "POST",
		success: function (response) {
			$("#inputCurrency").empty();

			$("#inputCurrency").append(response);
		},
	});
}

// function loadVoucherPaymentToListOption() {
// 	$.ajax({
// 		url: baseUrl + "/VoucherUnregistered/loadVoucherPaymentToListOption",
// 		type: "POST",
// 		success: function (response) {
// 			$("#inputPaymentTo").empty();

// 			$("#inputPaymentTo").append(response);
// 		},
// 	});
// }

function loadLocationListOption() {
	var data = [];

	$.ajax({
		url: baseUrl + "/api/getLocationArray",
		type: "POST",
		dataType: "JSON",
		success: function (response) {
			data = response;
			$("#inputLocation").autocomplete({
				source: data,
				appendTo: $("#inputLocation").parent(),
			});
		},
	});
}

function loadPaymentToListOption() {
	var data = [];

	$.ajax({
		url: baseUrl + "/VoucherUnregistered/getPaymentToArray",
		type: "POST",
		dataType: "JSON",
		success: function (response) {
			data = response;
			$("#inputPaymentTo").autocomplete({
				source: data,
				appendTo: $("#inputPaymentTo").parent(),
			});
		},
	});
}

function init() {
	loadVoucherBankListOption();
	loadVoucherCurrencyListOption();
	// loadVoucherPaymentToListOption();
}

function reload_table() {
	table.ajax.reload(null, false); //reload datatable ajax
}
