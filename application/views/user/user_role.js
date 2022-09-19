var getUrl = window.location;
var baseUrl =
	getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split("/")[1];
var save_method; //for save method string
var table1;

$(document).ready(function () {
	$(".loading").hide();
	$("#btnUpdate").attr("hidden", "hidden");

	table1 = $("#tableUserRole").DataTable({
		processing: true,
		serverSide: true,
		searching: false,
		ordering: false,
		paging: false,

		ajax: {
			url: baseUrl + "/User/datatablesUserRole",
			type: "POST",
			data: function (data) {
				data.user_id = $("#inputUserID").val();
			},
		},
	});
});

function updateRole() {
	if (checkInputForm()) {
		$(".loading").show();

		$.ajax({
			url: baseUrl + "/role/updateRole",
			type: "POST",
			data: $("#roleForm").serialize(),
			dataType: "JSON",
			success: function (response) {
				$(".loading").hide();
				if (response.status == "success") {
					Swal.fire({
						icon: "success",
						title: "Success!",
						text: response.message,
					});
				} else if (response.status == "failed") {
					Swal.fire({
						icon: "error",
						title: "Failed!",
						text: response.message,
					});
				} else {
					Swal.fire({
						icon: "error",
						title: "Failed!",
						text: "Failed when update Role",
					});
				}
			},
			error: function () {
				Swal.fire({
					icon: "error",
					title: "Failed!",
					text: "Failed to update Role",
				});
			},
		});
	}
}

function addRole() {
	if (checkEmptyInputWithMessage("#inputRoleSelect")) {
		$.ajax({
			url: baseUrl + "/user/addUserRole",
			type: "POST",
			dataType: "JSON",
			data: {
				role_id: $("#inputRoleSelect").val(),
				user_id: $("#inputUserID").val(),
			},
			success: function (response) {
				$(".loading").hide();
				if (response.status == "success") {
					Swal.fire({
						icon: "success",
						title: "Success!",
						text: response.message,
					});
				} else if (response.status == "failed") {
					Swal.fire({
						icon: "error",
						title: "Failed!",
						text: response.message,
					});
				} else {
					Swal.fire({
						icon: "error",
						title: "Failed!",
						text: "Failed when add Role",
					});
				}
				reload_table();
			},
			error: function () {
				Swal.fire({
					icon: "error",
					title: "Failed!",
					text: "Failed to add Role",
				});
				reload_table();
			},
		});
	}
}

function deleteUserRole(id) {
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
				url: baseUrl + "/User/deleteUserRole",
				type: "POST",
				data: {
					user_role_id: id,
				},
				dataType: "JSON",
				success: function (response) {
					$(".loading").hide();
					if (response.status == "success") {
						Swal.fire({
							icon: "success",
							title: "Deleted!",
							text: "User Role has been deleted",
						});
					} else if (response.status == "failed") {
						var message = "User Role failed to Delete";

						if (response.message !== "") {
							message = response.message;
						}
						Swal.fire({
							icon: "error",
							title: "Failed!",
							text: message,
						});
					}
					reload_table();
				},
				error: function (response) {
					$(".loading").hide();
					reload_table();
					Swal.fire({
						icon: "error",
						title: "Failed!",
						text: "Your User Role is failed to deleted.",
					});
				},
			});
		}
	});
}

function reload_table() {
	table1.ajax.reload(null, false); //reload datatable ajax
}

function checkInputForm() {
	checkEmptyInputWithMessage("#inputRoleName");

	if (
		checkEmptyInputWithMessage("#inputRoleName") &&
		$("#inputRoleId").val() != "" &&
		$("#inputRoleId").val() != null
	) {
		return true;
	} else {
		return false;
	}
}
