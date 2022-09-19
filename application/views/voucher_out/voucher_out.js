var getUrl = window.location;
var baseUrl =
	getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split("/")[1];
var save_method;
var table;

$(document).ready(function () {
	$(".loading").hide();

	init();

	$("#softcopyScanErrorFeedback").hide();

	table = $("#tableOutVoucher").DataTable({
		processing: true, //Feature control the processing indicator.
		serverSide: true, //Feature control DataTables' server-side processing mode.
		searching: false,
		paging: false,

		// Load data for the table's content from an Ajax source
		ajax: {
			url: baseUrl + "/VoucherOut/loadVoucherOutList",
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

	$("#btnSelectAll").click(function (e) {
		var checkboxes = $(".cbVoucherList");

		for (var checkbox of checkboxes) {
			checkbox.checked = this.checked;
		}
	});

	$("#btnReturn").click(function (e) {
		var voucherSelected = new Array();

		$(".cbVoucherList:checked").each(function () {
			voucherSelected.push($(this).val());
		});

		if (voucherSelected.length > 0) {
			Swal.fire({
				title: "Confirmation",
				text: "Are You Sure ?",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Yes",
			}).then((result) => {
				if (result.isConfirmed) {
					$(".loading").show();
					$.ajax({
						url: baseUrl + "/VoucherOut/Return",
						type: "POST",
						data: {
							voucherSelected: voucherSelected,
						},
						dataType: "JSON",
						success: function (response) {
							$(".loading").hide();
							if (response.status == "success") {
								table.ajax.reload(null, false); //just reload table

								reload_table();
								Swal.fire({
									icon: "success",
									title: "Good Job!",
									text: "Vouchers has been Out",
								});
							} else if (response.status == "failed") {
								var message = "Vouchers Out Failed";

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
							reload_table();
							Swal.fire({
								icon: "error",
								title: "Failed!",
								text: "Failed when process Voucher Out!",
							});
						},
					});
				}
			});
		} else {
			$("#inputLocationModal").modal("hide");
			Swal.fire({
				icon: "error",
				title: "Failed!",
				text: "Please check selected Voucher!",
			});
		}
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

			$.ajax({
				type: "POST",
				url: baseUrl + "/VoucherRegistered/uploadSoftcopyScan",
				data: formData,
				dataType: "json", // what to expect back from the PHP script, if anything
				cache: false,
				contentType: false,
				processData: false,
				success: function (response) {
					if (response.status == "success") {
						table.ajax.reload(null, false); //just reload table
						$("#inputSoftcopyScan").val(null);

						reload_table();

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
					var message = "File to Upload";

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
		var $el = $(this),
			files = $el[0].files,
			label = files[0].name;
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
		url: baseUrl + "/VoucherRegistered/loadVoucherBankListOption",
		type: "POST",
		success: function (response) {
			$("#inputBank").empty();

			$("#inputBank").append(response);
		},
	});
}

function loadVoucherCurrencyListOption() {
	$.ajax({
		url: baseUrl + "/VoucherRegistered/loadVoucherCurrencyListOption",
		type: "POST",
		success: function (response) {
			$("#inputCurrency").empty();

			$("#inputCurrency").append(response);
		},
	});
}

function loadFactoryListOption() {
	$.ajax({
		url: baseUrl + "/VoucherRegistered/loadVoucherFactoryListOption",
		type: "POST",
		success: function (response) {
			$("#inputFactory").empty();

			$("#inputFactory").append(response);
		},
	});
}

function loadVoucherPaymentToListOption() {
	$.ajax({
		url: baseUrl + "/VoucherRegistered/loadVoucherPaymentToListOption",
		type: "POST",
		success: function (response) {
			$("#inputPaymentTo").empty();

			$("#inputPaymentTo").append(response);
		},
	});
}

function loadLocationListOption() {
	$.ajax({
		url: baseUrl + "/VoucherRegistered/loadVoucherLocationListOption",
		type: "POST",
		success: function (response) {
			$("#inputLocation").empty();

			$("#inputLocation").append(response);
		},
	});
}

function showModalPreviewPDF(id) {
	$("#spanVoucherNoUploadPreview").empty();
	$("#spanVoucherNoUploadPreview").html($("#VoucherNo" + id).val());

	$("#embedPdf").attr("src", "");
	var filename = $("#btnPreview" + id).data("url-file");
	$("#embedPdf").attr("src", filename);
}

function init() {
	// loadVoucherPaymentToListOption();
	loadVoucherBankListOption();
	loadVoucherCurrencyListOption();
	loadFactoryListOption();
	loadLocationListOption();
	loadPaymentToListOption();
}

function reload_table() {
	table.ajax.reload(null, false); //reload datatable ajax
}

function loadPaymentToListOption() {
	var data = [];

	$.ajax({
		url: baseUrl + "/VoucherOut/getPaymentToArray",
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
