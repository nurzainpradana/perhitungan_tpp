var getUrl = window.location;
var baseUrl =
	getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split("/")[1];
var save_method; //for save method string
var table;

$(document).ready(function () {
	$(".loading").hide();
	$("#btnUpdate").attr("hidden", "hidden");

	table = $("#tableLocation").DataTable({
		processing: true, //Feature control the processing indicator.
		serverSide: true, //Feature control DataTables' server-side processing mode.
		searching: false,

		// Load data for the table's content from an Ajax source
		ajax: {
			url: baseUrl + "/Location/loadLocationList",
			type: "POST",
			data: function (data) {
				data.factory = $("#inputFactory").val();
				data.location = $("#inputLocation").val();
				data.column = $("#inputColumn").val();
				data.row = $("#inputRow").val();
				data.box = $("#inputBox").val();
				data.bantex = $("#inputBantex").val();
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

		clearFormLocation();

		$(".form-control-feedback").empty();
		table.ajax.reload(null, false); //just reload table
	});
	$("#btnFilter").click(function () {
		$(".form-control-feedback").empty();
		table.ajax.reload(null, false); //just reload table
	});
});

function deleteLocation(location_id) {
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
				url: baseUrl + "/Location/deleteLocation",
				type: "POST",
				data: {
					location_id: location_id,
				},
				dataType: "JSON",
				success: function (response) {
					$(".loading").hide();
					if (response.status == "success") {
						reload_table();
						Swal.fire({
							icon: "success",
							title: "Deleted!",
							text: "Delete Location successfully",
						});
					} else if (response.status == "failed") {
						var message = "Failed when Delete Location";

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
						text: "Failed to Delete Location",
					});
				},
			});
		}
	});
}

function saveLocation() {
	if (checkInputForm()) {
		var url = baseUrl + "/location/insert";
		$(".loading").show();
		// ajax adding data to database
		$.ajax({
			url: url,
			type: "POST",
			data: $("#locationForm").serialize(),
			dataType: "JSON",
			success: function (data) {
				$(".loading").hide();
				if (data.status == "true") {
					$(".loading").hide();

					clearFormLocation();
					reload_table();

					Swal.fire({
						icon: "success",
						title: "Success!",
						text: "Insert Location Successfully!",
					});
				} else if (data.status == "false") {
					var message = "Failed when insert Location";

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
	var check1 = checkEmptyInputWithMessage("#inputFactory");
	var check2 = checkEmptyInputWithMessage("#inputLocation");
	var check3 = checkEqualLengthInputWithMessage("#inputColumn", 3);
	var check4 = checkEqualLengthInputWithMessage("#inputRow", 3);
	var check5 = checkEqualLengthInputWithMessage("#inputBox", 3);
	var check6 = checkEqualLengthInputWithMessage("#inputBantex", 4);

	if (check1 && check2 && check3 && check4 && check5 && check6) {
		return true;
	} else {
		return false;
	}
}

function clearFormLocation() {
	$("#inputFactory").val("");
	$("#inputLocation").val("");
	$("#inputColumn").val("");
	$("#inputRow").val("");
	$("#inputBox").val("");
	$("#inputBantex").val("");
}
