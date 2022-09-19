var getUrl = window.location;
var baseUrl =
	getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split("/")[1];
var save_method; //for save method string
var table;

$(document).ready(function () {
	$(".loading").hide();
	$("#btnUpdate").attr("hidden", "hidden");

	table = $("#tableUser").DataTable({
		processing: true, //Feature control the processing indicator.
		serverSide: true, //Feature control DataTables' server-side processing mode.
		searching: false,

		// Load data for the table's content from an Ajax source
		ajax: {
			url: baseUrl + "/User/datatablesUserList",
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

function editUser(id) {
	$(".loading").show();
	$("#editUserId").val("");
	$("#editRole").val("");
	$("#employeeName").empty();

	$.ajax({
		url: baseUrl + "/user/detailUser",
		type: "POST",
		dataType: "JSON",
		data: {
			id: id,
		},
		success: function (response) {
			$(".loading").hide();

			if (response.status == "success") {
				var data = response.data;
				$("#editUserId").val(data.id);
				$("#editRole").val(data.user_role);
				$("#employeeName").append(data.employee_name);

				$("#updateUserModal").modal("show");
			} else if (response.status == "failed") {
				Swal.fire({
					icon: "error",
					title: "failed!",
					text: response.message,
				});
			} else {
				Swal.fire({
					icon: "error",
					title: "Success!",
					text: "Failed to get User Detail",
				});
			}
		},
		error: function (response) {},
	});
}

function updateUser() {
	if (checkEmptyInputWithMessage("#editRole")) {
		$.ajax({
			url: baseUrl + "/user/updateUser",
			type: "POST",
			dataType: "JSON",
			data: {
				id: $("#editUserId").val(),
				role_id: $("#editRole").val(),
			},
			success: function (response) {
				if (response.status == "success") {
					Swal.fire({
						icon: "success",
						title: "Success!",
						text: response.message,
					});
					$("#updateUserModal").modal("hide");
					reload_table();
				} else {
					var message = "Failed when update User";

					if (response.message != "" && response.message != null) {
						message = response.message;
					}
					Swal.fire({
						icon: "error",
						title: "Success!",
						text: message,
					});
				}

				reload_table();
			},
			error: function (response) {
				Swal.fire({
					icon: "error",
					title: "Failed!",
					text: "Failed to update User",
				});
			},
		});
	}
}

function deleteUser(id) {
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
				url: baseUrl + "/User/deleteUser",
				type: "POST",
				data: {
					id: id,
				},
				dataType: "JSON",
				success: function (response) {
					$(".loading").hide();
					if (response.status == "success") {
						reload_table();
						Swal.fire({
							icon: "success",
							title: "Deleted!",
							text: "Delete User Successfully",
						});
					} else if (response.status == "failed") {
						var message = "Your User Failed when process delete";

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
						text: "Your User Failed to delete.",
					});
				},
			});
		}
	});
}

function saveUser() {
	if (checkInputForm()) {
		var url = baseUrl + "/user/insert";

		$(".loading").show();

		// ajax adding data to database
		$(".loading").show();
		$.ajax({
			url: url,
			type: "POST",
			data: $("#userForm").serialize(),
			dataType: "JSON",
			success: function (data) {
				$(".loading").hide();
				if (data.status == "true") {
					$(".loading").hide();

					$("#inputEmployee").val("");
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
	checkEmptyInputWithMessage("#inputEmployee");

	if (checkEmptyInputWithMessage("#inputEmployee")) {
		return true;
	} else {
		return false;
	}
}
