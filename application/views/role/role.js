var getUrl = window.location;
var baseUrl =
	getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split("/")[1];
var save_method; //for save method string
var table;
var table1;

$(document).ready(function () {
	$(".loading").hide();
	$("#btnUpdate").attr("hidden", "hidden");

	table1 = $("#tableMenuRole").DataTable({
		processing: true,
		serverSide: true,
		searching: false,
		ordering: false,
		paging: false,

		ajax: {
			url: baseUrl + "/role/datatablesRoleMenu",
			type: "POST",
			data: function (data) {
				data.role_id = $("#inputRoleId").val();
			},
		},
	});

	table = $("#tableRole").DataTable({
		processing: true, //Feature control the processing indicator.
		serverSide: true, //Feature control DataTables' server-side processing mode.
		searching: false,

		// Load data for the table's content from an Ajax source
		ajax: {
			url: baseUrl + "/role/datatablesRoleList",
			type: "POST",
			data: function (data) {
				data.factory = $("#inputFactory").val();
				data.location = $("#inputLocation").val();
				data.column = $("#inputColumn").val();
				data.row = $("#inputRow").val();
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
});

function deleteRole(role_id) {
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
				url: baseUrl + "/Role/deleteRole",
				type: "POST",
				data: {
					role_id: role_id,
				},
				dataType: "JSON",
				success: function (response) {
					$(".loading").hide();
					if (response.status == "success") {
						reload_table();
						Swal.fire({
							icon: "success",
							title: "Successfully!",
							text: "Delete Role Successfully",
						});
					} else if (response.status == "failed") {
						var message = "Failed when Delete Role";

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
						text: "Failed to Delete Role",
					});
				},
			});
		}
	});
}

function roleMenu(id) {
	$("#inputRoleId").val(id);
	$.ajax({
		url: baseUrl + "/role/loadDetailRole",
		data: {
			role_id: id,
		},
		type: "POST",
		dataType: "JSON",
		success: function (response) {
			if (response.status == "success") {
				var data = response.data;

				$("#editRoleName").val(data.role_name);
				table1.ajax.reload(null, false); //reload datatable ajax
			} else {
			}
		},
		error: function (response) {},
	});
	$("#roleMenuModal").modal("show");
}

function saveRole() {
	if (checkInputForm()) {
		var url = baseUrl + "/role/insert";

		$(".loading").show();

		// ajax adding data to database
		$(".loading").show();
		$.ajax({
			url: url,
			type: "POST",
			data: $("#roleForm").serialize(),
			dataType: "JSON",
			success: function (data) {
				$(".loading").hide();
				if (data.status == "true") {
					$(".loading").hide();

					$("#inputRole").val("");
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
	checkEmptyInputWithMessage("#inputRole");

	if (checkEmptyInputWithMessage("#inputRole")) {
		return true;
	} else {
		return false;
	}
}
