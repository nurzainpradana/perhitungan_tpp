var getUrl = window.location;
var baseUrl =
	getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split("/")[1];
var save_method;
var table;

$(document).ready(function () {
	$(".loading").hide();

	// loadVoucherPaymentToListOption();
	loadVoucherBankListOption();
	loadVoucherCurrencyListOption();
	loadPaymentToListOption();

	$("#locationErrorFeedback").hide();

	table = $("#tableDisposalVoucher").DataTable({
		processing: true, //Feature control the processing indicator.
		serverSide: true, //Feature control DataTables' server-side processing mode.
		searching: false,
		paging: true,
		lengthChange: false,
		pageLength: 10,

		// Load data for the table's content from an Ajax source
		ajax: {
			url: baseUrl + "/VoucherDisposal/loadVoucherDisposalList",
			type: "POST",
			data: function (data) {
				data.PaymentTo = $("#inputPaymentTo").val();
				data.BankName = $("#inputBank").val();
				data.Currency = $("#inputCurrency").val();
				data.StartDate = $("#inputStartDate").val();
				data.EndDate = $("#inputEndDate").val();
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
		reload_table();
	});

	$("#btnReset").click(function (e) {
		$("#inputBank").val("");
		$("#inputCurrency").val("");
		$("#inputPaymentTo").val("");

		$("#inputStartDate").val($("#inputStartDate").data("default-start-date"));
		$("#inputEndDate").val($("#inputEndDate").data("default-end-date"));

		reload_table();
	});

	$("#btnRestore").click(function (e) {
		var voucherSelected = new Array();

		$(".cbVoucherList:checked").each(function () {
			voucherSelected.push($(this).val());
		});

		if (voucherSelected.length == 0) {
			Swal.fire({
				icon: "error",
				title: "Failed!",
				text: "Please check selected Voucher!",
			});
		} else {
			$("#inputLocationModal").modal("show");
			loadLocationListOption();
			$("#locationErrorFeedback").hide();
		}
	});

	$("#btnExportExcel").click(function (e) {
		$("#disposalVoucherForm").attr(
			"action",
			baseUrl + "/VoucherDisposal/excel"
		);
		$("#disposalVoucherForm").submit();
	});

	$("#btnExportPDF").click(function (e) {
		$("#disposalVoucherForm").attr("action", baseUrl + "/VoucherDisposal/pdf");
		$("#disposalVoucherForm").submit();
	});

	$("#btnProcessRestore").click(function (e) {
		var location_name = $("#inputLocation").val();

		var voucherSelected = new Array();

		$(".cbVoucherList:checked").each(function () {
			voucherSelected.push($(this).val());
		});

		if (voucherSelected.length == 0) {
			$("#inputLocationModal").modal("hide");
			Swal.fire({
				icon: "error",
				title: "Failed!",
				text: "Please check selected Voucher!",
			});
		} else if (location_name == "" || location_name == null) {
			$("#locationErrorFeedback").show();
		} else if (
			location_name !== "" &&
			location_name !== null &&
			voucherSelected.length > 0
		) {
			$.ajax({
				url: baseUrl + "/VoucherDisposal/restore",
				type: "POST",
				data: {
					location_name: location_name,
					voucherSelected: voucherSelected,
				},
				dataType: "JSON",
				success: function (response) {
					$("#inputLocationModal").modal("hide");
					if (response.status == "success") {
						Swal.fire({
							icon: "success",
							title: "Good Job!",
							text: "Data has been restore!",
						});

						reload_table();
					} else if (response.status == "failed") {
						Swal.fire({
							icon: "error",
							title: "Failed!",
							text: response.message,
						});
					}
				},
				error: function (response) {
					$("#inputLocationModal").modal("hide");
					Swal.fire({
						icon: "error",
						title: "Failed!",
						text: "Failed when process restore!",
					});
				},
			});
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
		url: baseUrl + "/VoucherDisposal/loadVoucherBankListOption",
		type: "POST",
		success: function (response) {
			$("#inputBank").empty();

			$("#inputBank").append(response);
		},
	});
}

function loadVoucherCurrencyListOption() {
	$.ajax({
		url: baseUrl + "/VoucherDisposal/loadVoucherCurrencyListOption",
		type: "POST",
		success: function (response) {
			$("#inputCurrency").empty();

			$("#inputCurrency").append(response);
		},
	});
}

// function loadVoucherPaymentToListOption() {
// 	$.ajax({
// 		url: baseUrl + "/VoucherDisposal/loadVoucherPaymentToListOption",
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

function reload_table() {
	table.ajax.reload(null, false); //reload datatable ajax
}

function loadPaymentToListOption() {
	var data = [];

	$.ajax({
		url: baseUrl + "/VoucherDisposal/getPaymentToArray",
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
