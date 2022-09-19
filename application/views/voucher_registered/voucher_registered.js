var getUrl = window.location;
var baseUrl =
	getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split("/")[1];
var save_method;
var table;

$(document).ready(function () {
	$(".loading").hide();

	init();

	$("#reasonErrorFeedback").hide();
	$("#locationErrorFeedback").hide();
	$("#softcopyScanErrorFeedback").hide();

	table = $("#tableRegisteredVoucher").DataTable({
		processing: true, //Feature control the processing indicator.
		serverSide: true, //Feature control DataTables' server-side processing mode.
		searching: false,
		paging: true,
		lengthChange: false,
		pageLength: 10,

		// Load data for the table's content from an Ajax source
		ajax: {
			url: baseUrl + "/VoucherRegistered/loadVoucherRegisteredList",
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

	$("#btnExportExcel").click(function (e) {
		$("#registerVoucherForm").attr(
			"action",
			baseUrl + "/VoucherRegistered/excel"
		);
		$("#registerVoucherForm").submit();
	});

	$("#btnExportPDF").click(function (e) {
		$("#registerVoucherForm").attr(
			"action",
			baseUrl + "/VoucherRegistered/pdf"
		);
		$("#registerVoucherForm").submit();
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

	$("#btnOut").click(function (e) {
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
						url: baseUrl + "/VoucherRegistered/Out",
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

	$("#btnDisposal").click(function (e) {
		if (checkEmptySelectedVoucher()) {
			$("#inputReason").val("");
			$("#inputReasonModal").modal("show");
		} else {
			swalShow("error", "Failed!", "Please Check Your Selected Voucher");
		}
	});

	$("#btnProcessDisposal").click(function (e) {
		$("#reasonErrorFeedback").hide();

		var voucherSelected = new Array();

		$(".cbVoucherList:checked").each(function () {
			voucherSelected.push($(this).val());
		});

		var reason = $("#inputReason").val();

		if (voucherSelected.length == 0) {
			$("#inputReasonModal").modal("hide");
			Swal.fire({
				icon: "error",
				title: "Failed!",
				text: "Please check selected Voucher!",
			});
		} else if (reason == "" || reason == null) {
			$("#reasonErrorFeedback").show();
		} else if (reason !== "" && reason !== null && voucherSelected.length > 0) {
			Swal.fire({
				title: "Confirmation",
				text: "Are You Sure to Disposal This Voucher ?",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Yes",
			}).then((result) => {
				if (result.isConfirmed) {
					$(".loading").show();
					$.ajax({
						url: baseUrl + "/VoucherRegistered/Disposal",
						type: "POST",
						data: {
							voucherSelected: voucherSelected,
							reason: reason,
						},
						dataType: "JSON",
						success: function (response) {
							$(".loading").hide();
							if (response.status == "success") {
								table.ajax.reload(null, false); //just reload table

								init();
								reload_table();
								$("#inputReasonModal").modal("hide");
								Swal.fire({
									icon: "success",
									title: "Good Job!",
									text: "Vouchers has been Deleted",
								});
							} else if (response.status == "failed") {
								var message = "Vouchers Disposal Failed";

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
								text: "Failed when process Voucher Deleted!",
							});
						},
					});
				}
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

	$("#btnMove").click(function (e) {
		if (checkEmptySelectedVoucher()) {
			$("#inputMoveLocation").val("");
			$("#inputMoveModal").modal("show");
			$("#locationErrorFeedback").hide();
			loadLocationListSuggest();
		} else {
			swalShow("error", "Failed!", "Please Check Your Selected Voucher");
		}
	});

	$("#btnProcessMove").click(function (e) {
		$("#locationErrorFeedback").hide();
		var location_name = $("#inputMoveLocation").val();
		var voucherSelected = new Array();

		$(".cbVoucherList:checked").each(function () {
			voucherSelected.push($(this).val());
		});

		if (voucherSelected.length == 0) {
			$("#inputMoveModal").modal("hide");
			Swal.fire({
				icon: "error",
				title: "Failed!",
				text: "Please check selected Voucher!",
			});
		} else if (location_name == "" || location_name == null) {
			$("#locationErrorFeedback").show();
			$("#inputMoveLocation").focus();
		} else if (
			voucherSelected.length > 0 &&
			location_name !== null &&
			location_name !== ""
		) {
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
						url: baseUrl + "/VoucherRegistered/Move",
						type: "POST",
						data: {
							voucherSelected: voucherSelected,
							location_name: location_name,
						},
						dataType: "JSON",
						success: function (response) {
							$(".loading").hide();
							$("#inputMoveModal").modal("hide");

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

function showModalPreviewPDF(id) {
	$("#spanVoucherNoUploadPreview").empty();
	$("#spanVoucherNoUploadPreview").html($("#VoucherNo" + id).val());

	$("#embedPdf").attr("src", "");
	var filename = $("#btnPreview" + id).data("url-file");
	$("#embedPdf").attr("src", filename);
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

function checkEmptySelectedVoucher() {
	var voucherSelected = new Array();

	$(".cbVoucherList:checked").each(function () {
		voucherSelected.push($(this).val());
	});

	if (voucherSelected.length > 0) {
		return true;
	} else {
		return false;
	}
}

function loadPaymentToListOption() {
	var data = [];

	$.ajax({
		url: baseUrl + "/VoucherRegistered/getPaymentToArray",
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
