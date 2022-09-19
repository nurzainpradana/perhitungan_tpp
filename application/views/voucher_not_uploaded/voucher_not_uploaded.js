var getUrl = window.location;
var baseUrl =
	getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split("/")[1];
var save_method;
var table;

$(document).ready(function () {
	$(".loading").hide();

	init();

	//

	$("#locationErrorFeedback").hide();
	$("#softcopyScanErrorFeedback").hide();

	table = $("#tableNotUploadedVoucher").DataTable({
		processing: true, //Feature control the processing indicator.
		serverSide: true, //Feature control DataTables' server-side processing mode.
		searching: false,
		paging: true,
		lengthChange: false,
		pageLength: 10,

		// Load data for the table's content from an Ajax source
		ajax: {
			url: baseUrl + "/VoucherNotUploaded/loadVoucherList",
			type: "POST",
			data: function (data) {
				data.PaymentTo = $("#inputPaymentTo").val();
				data.BankName = $("#inputBank").val();
				data.Currency = $("#inputCurrency").val();
				data.Factory = $("#inputFactory").val();
				data.Location = $("#inputLocation").val();
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

	$("#btnCancel").click(function (e) {
		$("#inputBank").val("");
		$("#inputCurrency").val("");
		$("#inputFactory").val("");
		$("#inputLocation").val("");
		$("#inputPaymentTo").val("");

		reload_table();
	});

	$("#btnProcessUpload").click(function (e) {
		$("#softcopyScanErrorFeedback").hide();
		// Check Empty File
		if ($("#inputSoftcopyScan")[0].files.length == 0) {
			$("#softcopyScanErrorFeedback").show();
			// Swal.fire({
			// 	icon: "error",
			// 	title: "Failed",
			// 	text: "Check Your selected file!",
			// });
		} else {
			const fileupload = $("#inputSoftcopyScan").prop("files")[0];
			var voucher_no = $("#inputVoucherNoUpload").val();

			var formData = new FormData();

			formData.append("softcopy_scan", fileupload);
			formData.append("voucherno", voucher_no);

			$(".loading").show();
			$.ajax({
				type: "POST",
				url: baseUrl + "/VoucherRegistered/uploadSoftcopyScan",
				data: formData,
				dataType: "json", // what to expect back from the PHP script, if anything
				cache: false,
				contentType: false,
				processData: false,
				success: function (response) {
					$(".loading").hide();
					if (response.status == "success") {
						table.ajax.reload(null, false); //just reload table

						reload_table();
						$("#inputSoftcopyScan").val(null);

						var $el = $(".custom-file-input");
						var label = "Choose Softcopy Scan";
						$el.next(".custom-file-label").html(label);

						$("#inputUploadModal").modal("hide");

						Swal.fire({
							icon: "success",
							title: "Good Job!",
							text: "File Scan has been Uploaded",
						});
					} else if (response.status == "failed") {
						var message = "File Scan Failed to Upload";

						if (response.message !== "") {
							message = response.message;
						}

						Swal.fire({
							icon: "error",
							title: "Failed!",
							text: message,
						});
					}
				},
				error: function (response) {
					$(".loading").hide();
					var message = "File Failed to Upload";

					if (response.message !== "") {
						message = response.message;
					}

					Swal.fire({
						icon: "error",
						title: "Failed!",
						text: message,
					});
				},
			});
		}
	});

	$(".custom-file-input").change(function () {
		var $el = $(this);
		var files = $el[0].files;
		if (files[0] == null) {
			label = "Choose Softcopy File";
		} else {
			label = files[0].name;
		}

		if (files.length > 1) {
			label = label + " and " + String(files.length - 1) + " more files";
		}
		$el.next(".custom-file-label").html(label);
	});
});

function showUpModalUpload(id) {
	$("#inputUploadModal").modal("show");
	$("#inputVoucherNoUpload").val("");
	$("#inputVoucherNoUpload").val($("#VoucherNo" + id).val());
	$("#spanVoucherNoUpload").empty();
	$("#spanVoucherNoUpload").html($("#VoucherNo" + id).val());
}

function loadVoucherBankListOption() {
	$.ajax({
		url: baseUrl + "/VoucherNotUploaded/loadVoucherBankListOption",
		type: "POST",
		success: function (response) {
			$("#inputBank").empty();

			$("#inputBank").append(response);
		},
	});
}

function loadVoucherCurrencyListOption() {
	$.ajax({
		url: baseUrl + "/VoucherNotUploaded/loadVoucherCurrencyListOption",
		type: "POST",
		success: function (response) {
			$("#inputCurrency").empty();

			$("#inputCurrency").append(response);
		},
	});
}

function loadFactoryListOption() {
	$.ajax({
		url: baseUrl + "/VoucherNotUploaded/loadVoucherFactoryListOption",
		type: "POST",
		success: function (response) {
			$("#inputFactory").empty();

			$("#inputFactory").append(response);
		},
	});
}

function loadVoucherPaymentToListOption() {
	$.ajax({
		url: baseUrl + "/VoucherNotUploaded/loadVoucherPaymentToListOption",
		type: "POST",
		success: function (response) {
			$("#inputPaymentTo").empty();

			$("#inputPaymentTo").append(response);
		},
	});
}

function loadLocationListOption() {
	$.ajax({
		url: baseUrl + "/VoucherNotUploaded/loadVoucherLocationListOption",
		type: "POST",
		success: function (response) {
			$("#inputLocation").empty();

			$("#inputLocation").append(response);
		},
	});
}

function loadLocationListSuggest() {
	var data = [];

	$.ajax({
		url: baseUrl + "/api/getLocationArray",
		type: "POST",
		dataType: "JSON",
		success: function (response) {
			data = response;
			$("#inputMoveLocation").autocomplete({
				source: data,
				appendTo: $("#inputMoveLocation").parent(),
			});
		},
	});
}

function init() {
	// loadVoucherPaymentToListOption();
	loadVoucherBankListOption();
	loadVoucherCurrencyListOption();
	loadFactoryListOption();
	loadLocationListOption();
	loadLocationListSuggest();

	loadPaymentToListOption();
}

function reload_table() {
	table.ajax.reload(null, false); //reload datatable ajax
}

function loadPaymentToListOption() {
	var data = [];

	$.ajax({
		url: baseUrl + "/VoucherNotUploaded/getPaymentToArray",
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
