var getUrl = window.location;
var baseUrl =
	getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split("/")[1];
var save_method;
var table;

$(document).ready(function () {
	$(".loading").hide();

	loadVoucherPaymentToListOption();
	loadVoucherBankListOption();
	loadVoucherCurrencyListOption();

	table = $("#tableDisposalVoucher").DataTable({
		processing: true, //Feature control the processing indicator.
		serverSide: true, //Feature control DataTables' server-side processing mode.
		searching: false,
		paging: false,

		// Load data for the table's content from an Ajax source
		ajax: {
			url: baseUrl + "/VoucherDisposal/loadVoucherDisposalList",
			type: "POST",
			data: function (data) {
				data.PaymentTo = $("#inputPaymentTo").val();
				data.BankName = $("#inputBank").val();
				data.Currency = $("#inputCurrency").val();
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
		$("#inputPaymentTo").val("");

		reload_table();
	});

	$("#btnRestore").click(function (e) {
		loadLocationListOption();
	});

	$("#btnProcessRestore").click(function (e) {
		var location_name = $("#inputLocation").val();

		var voucherSelected = new Array();

		$(".cbVoucherList:checked").each(function () {
			voucherSelected.push($(this).val());
		});

		if (location_name !== "" && voucherSelected.length > 0) {
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
		} else {
			$("#inputLocationModal").modal("hide");
			Swal.fire({
				icon: "error",
				title: "Failed!",
				text: "Please check selected Voucher!",
			});
		}
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
					$.ajax({
						url: baseUrl + "/VoucherRegistered/Out",
						type: "POST",
						data: {
							voucherSelected: voucherSelected,
						},
						dataType: "JSON",
						success: function (response) {
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

	$("#btnProcessDisposal").click(function (e) {
		var voucherSelected = new Array();

		$(".cbVoucherList:checked").each(function () {
			voucherSelected.push($(this).val());
		});

		var reason = $("#inputReason").val();

		if (voucherSelected.length > 0 && reason !== "") {
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
					$.ajax({
						url: baseUrl + "/VoucherRegistered/Disposal",
						type: "POST",
						data: {
							voucherSelected: voucherSelected,
							reason: reason,
						},
						dataType: "JSON",
						success: function (response) {
							if (response.status == "success") {
								table.ajax.reload(null, false); //just reload table

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
		} else {
			$("#inputLocationModal").modal("hide");
			Swal.fire({
				icon: "error",
				title: "Failed!",
				text: "Please check selected Voucher and input Your Reason!",
			});
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

function loadVoucherPaymentToListOption() {
	$.ajax({
		url: baseUrl + "/VoucherDisposal/loadVoucherPaymentToListOption",
		type: "POST",
		success: function (response) {
			$("#inputPaymentTo").empty();

			$("#inputPaymentTo").append(response);
		},
	});
}

function loadLocationListOption() {
	var data = [];

	$.ajax({
		url: baseUrl + "/api/getLocationArray",
		type: "POST",
		dataType : "JSON",
		success: function(response) {
			data	= response;
			$("#inputLocation").autocomplete({
				source: data,
				appendTo : $("#inputLocation").parent()
			});
			
		}
	});
}

function reload_table() {
	table.ajax.reload(null, false); //reload datatable ajax
}
