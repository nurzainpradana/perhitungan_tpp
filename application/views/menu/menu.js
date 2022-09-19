var getUrl = window.location;
var baseUrl =
	getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split("/")[1];
var save_method; //for save method string
var table;

$(document).ready(function () {
	$(".loading").hide();
	$("#btnUpdate").attr("hidden", "hidden");

	table = $("#table").DataTable({
		processing: true, //Feature control the processing indicator.
		serverSide: true, //Feature control DataTables' server-side processing mode.
		searching: false,
		ordering: false,

		// Load data for the table's content from an Ajax source
		ajax: {
			url: baseUrl + "/menu/datatablesList",
			type: "POST",
			data: function (data) {
				data.menu_name = $("#inputMenuName").val();
				data.url = $("#inputUrl").val();
				data.menu_level = $("#inputMenuLevel").val();
				data.is_parent_menu = $("#inputIsParentMenu").val();
				data.parent_menu = $("#inputParentMenu").val();
				data.status = $("#inputStatus").val();
			},
		},

		//Set column definition initialisation properties.
		columnDefs: [
			{
				targets: [-1], // Last Column
				orderable: false, // set not orderable
			},
		],
	});

	$("#btnCancel").on("click", function (e) {
		$("#btnUpdate").attr("hidden", "hidden");
		$("#btnSave").removeAttr("hidden");

		$("#inputFactory").val("");
		$("#inputLocation").val("");
		$("#inputColumn").val("");
		$("#inputRow").val("");

		$(".form-control-feedback").empty();

		table.ajax.reload(null, false); //just reload table
	});
	$("#btnFilter").click(function () {
		$(".form-control-feedback").empty();
		//button filter event click
		table.ajax.reload(null, false); //just reload table
	});

	$("#inputMenuLevel").on("change", function () {
		if ($(this).val() != "") {
			$.ajax({
				url: baseUrl + "/Menu/loadParentMenu",
				type: "POST",
				data: {
					level: $(this).val(),
				},
				success: function (response) {
					$("#inputParentMenu").empty();
					$("#inputParentMenu").append(response);
				},
			});
		}
	});

	$("#editMenuLevel").on("change", function () {
		if ($(this).val() != "") {
			$.ajax({
				url: baseUrl + "/Menu/loadParentMenu",
				type: "POST",
				data: {
					level: $(this).val(),
				},
				success: function (response) {
					$("#editParentMenu").empty();
					$("#editParentMenu").append(response);
				},
			});
		}
	});

	$("#inputMenuIcon").on("input", function () {
		$("#previewIcon").attr("class", "fa " + $("#inputMenuIcon").val());
	});
	$("#editMenuIcon").on("input", function () {
		$("#editPreviewIcon").attr("class", "fa " + $("#editMenuIcon").val());
	});
});

function updateMenu() {
	if (checkEditForm()) {
		$.ajax({
			url: baseUrl + "/menu/processUpdateMenu",
			data: $("#editMenuForm").serialize(),
			type: "POST",
			dataType: "JSON",
			success: function (response) {
				if (response.status == "success") {
					Swal.fire({
						icon: "success",
						title: "Success!",
						text: "Update Menu Successfully!",
					});
					reload_table();
					clearEditForm();
					$("#editMenuModal").modal("hide");
				} else {
					Swal.fire({
						icon: "error",
						title: "Failed!",
						text: response.message,
					});
				}
			},
			error: function (response) {
				Swal.fire({
					icon: "error",
					title: "Failed!",
					text: "Failed to update!",
				});
			},
		});
	}
}

function save() {
	if (checkInputForm()) {
		var url = baseUrl + "/menu/insert";

		$(".loading").show();

		// ajax adding data to database
		$(".loading").show();
		$.ajax({
			url: url,
			type: "POST",
			data: $("#menuForm").serialize(),
			dataType: "JSON",
			success: function (data) {
				$(".loading").hide();
				if (data.status == "true") {
					$(".loading").hide();

					clearForm();

					reload_table();
					Swal.fire({
						icon: "success",
						title: "Good job!",
						text: "Data has been save!",
					});
				} else if (data.status == "false") {
					var message = "Failed to insert";

					if (data.message !== null && data.message !== "") {
						message = data.message;
					}
					$(".loading").hide();
					reload_table();
					Swal.fire({
						icon: "error",
						title: "Failed!",
						text: message,
					});
				}
			},
			error: function (response) {
				$(".loading").hide();
				Swal.fire({
					icon: "error",
					title: "Failed!",
					text: "Failed to save!",
				});
			},
		});
	}
}

function reload_table() {
	table.ajax.reload(null, false); //reload datatable ajax
}

function checkInputForm() {
	var level = $("#inputLevel").val();

	if (level == 1) {
		checkEmptyInputWithMessage("#inputMenuName");
		checkEmptyInputWithMessage("#inputMenuLevel");
		checkEmptyInputWithMessage("#inputIsParentMenu");
		checkEmptyInputWithMessage("#inputStatus");

		if (
			checkEmptyInputWithMessage("#inputMenuName") &&
			checkEmptyInputWithMessage("#inputMenuLevel") &&
			checkEmptyInputWithMessage("#inputIsParentMenu") &&
			checkEmptyInputWithMessage("#inputStatus")
		) {
			return true;
		} else {
			return false;
		}
	} else {
		checkEmptyInputWithMessage("#inputMenuName");
		checkEmptyInputWithMessage("#inputMenuLevel");
		checkEmptyInputWithMessage("#inputIsParentMenu");
		checkEmptyInputWithMessage("#inputParentMenu");
		checkEmptyInputWithMessage("#inputStatus");

		if (
			checkEmptyInputWithMessage("#inputMenuName") &&
			checkEmptyInputWithMessage("#inputMenuLevel") &&
			checkEmptyInputWithMessage("#inputIsParentMenu") &&
			checkEmptyInputWithMessage("#inputParentMenu") &&
			checkEmptyInputWithMessage("#inputStatus")
		) {
			return true;
		} else {
			return false;
		}
	}
}

function checkEditForm() {
	var level = $("#editMenuLevel").val();

	if (level == 1) {
		checkEmptyInputWithMessage("#editMenuName");
		checkEmptyInputWithMessage("#editMenuLevel");
		checkEmptyInputWithMessage("#editIsParentMenu");
		checkEmptyInputWithMessage("#editStatus");

		if (
			checkEmptyInputWithMessage("#editMenuName") &&
			checkEmptyInputWithMessage("#editMenuLevel") &&
			checkEmptyInputWithMessage("#editIsParentMenu") &&
			checkEmptyInputWithMessage("#editStatus")
		) {
			return true;
		} else {
			return false;
		}
	} else {
		checkEmptyInputWithMessage("#editMenuName");
		checkEmptyInputWithMessage("#editMenuLevel");
		checkEmptyInputWithMessage("#editParentMenu");
		checkEmptyInputWithMessage("#editIsParentMenu");
		checkEmptyInputWithMessage("#editStatus");

		if (
			checkEmptyInputWithMessage("#editMenuName") &&
			checkEmptyInputWithMessage("#editMenuLevel") &&
			checkEmptyInputWithMessage("#editParentMenu") &&
			checkEmptyInputWithMessage("#editIsParentMenu") &&
			checkEmptyInputWithMessage("#editStatus")
		) {
			return true;
		} else {
			return false;
		}
	}
}

function clearForm() {
	$("#inputMenuName").val("");
	$("#inputUrl").val("");
	$("#inputMenuLevel").val("");
	$("#inputIsParentMenu").val("");
	$("#inputParentMenu").val("0");
	$("#inputMenuIcon").val("");
	$("#inputStatus").val("1");
	$("#previewIcon").attr("class", "fa ");
}

function clearEditForm() {
	$("#editMenuName").val("");
	$("#editUrl").val("");
	$("#editMenuLevel").val("");
	$("#editIsParentMenu").val("");
	$("#editParentMenu").val("0");
	$("#editMenuIcon").val("");
	$("#editStatus").val("1");
	$("#editPreviewIcon").attr("class", "fa ");
}

function edit(id) {
	$("#editMenuModal").modal("show");

	$(".loading").show();

	$.ajax({
		url: baseUrl + "/menu/editMenu",
		data: {
			menu_id: id,
		},
		type: "POST",
		dataType: "JSON",
		success: function (response) {
			$(".loading").hide();
			var status = response.status;

			if (status == "success") {
				var data = response.data;

				if (data.menu_level != "") {
					$.ajax({
						url: baseUrl + "/Menu/loadParentMenu",
						type: "POST",
						data: {
							level: data.menu_level,
						},
						success: function (response) {
							$("#editParentMenu").empty();
							$("#editParentMenu").append(response);

							$("#editParentMenu").val(data.parent_menu);
						},
					});
				}

				$("#editPreviewIcon").attr("class", "fa " + data.menu_icon);

				$("#editMenuName").val(data.menu_name);
				$("#editMenuLevel").val(data.menu_level);
				$("#editUrl").val(data.url);
				$("#editMenuIcon").val(data.menu_icon);
				$("#editParentMenu").val(data.parent_menu);
				$("#editIsParentMenu").val(data.is_parent_menu);
				$("#editStatus").val(data.status);
				$("#editMenuId").val(data.id);
			} else {
				clearEditForm();
			}
		},
		error: function (response) {
			$(".loading").hide();
			clearEditForm();
			Swal.fire({
				icon: "error",
				title: "Failed!",
				text: "Failed!",
			});
		},
	});
}

function orderup(id) {
	$(".loading").show();

	$.ajax({
		url: baseUrl + "/menu/orderup",
		type: "POST",
		dataType: "JSON",
		data: {
			menu_id: id,
		},
		success: function (response) {
			$(".loading").hide();
			reload_table();

			if (response.status == "success") {
				Swal.fire({
					icon: "success",
					title: "Success!",
					text: response.message,
				});
			} else {
				var message = "Failed when order up menu";

				if (response.message != "" && response.status != null) {
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
			Swal.fire({
				icon: "error",
				title: "Failed!",
				text: "Failed to order up menu",
			});
		},
	});
}

function orderdown(id) {
	$(".loading").show();

	$.ajax({
		url: baseUrl + "/menu/orderdown",
		type: "POST",
		dataType: "JSON",
		data: {
			menu_id: id,
		},
		success: function (response) {
			$(".loading").hide();
			reload_table();

			if (response.status == "success") {
				Swal.fire({
					icon: "success",
					title: "Success!",
					text: response.message,
				});
			} else {
				var message = "Failed when order down menu";

				if (response.message != "" && response.status != null) {
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
			Swal.fire({
				icon: "error",
				title: "Failed!",
				text: "Failed to order down menu",
			});
		},
	});
}

function deletemenu(menu_id) {
	Swal.fire({
		title: "Are you sure?",
		text: "This Data Will Be Deleted Permanently!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Yes, delete it!",
	}).then((result) => {
		if (result.isConfirmed) {
			$(".loading").show();
			$.ajax({
				url: baseUrl + "/Menu/deletemenu",
				type: "POST",
				data: {
					menu_id : menu_id,
				},
				dataType: "JSON",
				success: function (response) {
					$(".loading").hide();
					if (response.status == "success") {
						reload_table();
						Swal.fire({
							icon: "success",
							title: "Deleted!",
							text: "Delete Menu Successfully",
						});
					} else if (response.status == "failed") {
						var message = "Failed to Delete Menu";

						if (response.message !== "") {
							message = response.message;
						}

						reload_table();
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
						text: "Failed to Delete Menu",
					});
				},
			});
		}
	});
}
