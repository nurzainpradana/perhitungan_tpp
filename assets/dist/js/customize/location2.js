var getUrl = window.location;
var baseUrl =
	getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split("/")[1];
var save_method; //for save method string
var table;

$(document).ready(function () {
	$(".loading").hide();
	$("#btnUpdate").attr('hidden', 'hidden');

	table = $("#tableLocation").DataTable({
		processing: true, //Feature control the processing indicator.
		serverSide: true, //Feature control DataTables' server-side processing mode.
		"searching": false,

		// Load data for the table's content from an Ajax source
		ajax: {
			url: baseUrl + "/api/loadLocationList",
			type: "POST",
            data: function ( data ) {
                data.factory = $('#inputFactory').val();
                    }
		},

		//Set column definition initialisation properties.
		columnDefs: [
			{
				targets: [-1], // Last Column
				orderable: false, // set not orderable
			},
		],
	});

	$('#btnCancel').on('click', function(e){
		$('#btnUpdate').attr('hidden', 'hidden');
		$('#btnSave').removeAttr('hidden');


	});

    $('#btnFilter').click(function(){ //button filter event click
        table.ajax.reload(null,false);  //just reload table
    });

	
});

function saveLocation() {
	var url = baseUrl + "/location/insert";

	if (
		$(document.getElementsByName("factory")).val() == "" ||
		$(document.getElementsByName("location")).val() == "" ||
		$(document.getElementsByName("columns")).val() == "" ||
		$(document.getElementsByName("row")).val() == ""
	) {
		swal("Can't Process this data", "Please check required fields!", "error");
	} else {
		$(".loading").show();

		// ajax adding data to database
		$.ajax({
			url: url,
			type: "POST",
			data: $("#locationForm").serialize(),
			dataType: "JSON",
			success: function (data) {
				console.log(data);
				console.log(data.status);
				if (data.status == "true") {
					$(".loading").hide();
					reload_table();
					swal("Good job!", "Data has been save!", "success");
				} else if (data.status == "false") {
					var message = "Failed to insert";

					if (data.message !== null && data.message !== "") {
						message = data.message;
					}
					$(".loading").hide();
					reload_table();
					swal("Failed!", message, "error");
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				$(".loading").hide();
				swal("Failed!", "Failed to save!", "error");
			},
		});
	}
}

function editLocation(id_location) {
	$(".loading").show();

	// ajax adding data to database
	$.ajax({
		url: baseUrl + "/api/getDetailLocation",
		type: "POST",
		data: {
			location_id		: id_location
		},
		success: function(response) {
			$("#btnUpdate").removeAttr('hidden');
			$("#btnSave").attr('hidden', 'hidden');
			var data		= response.data;
			$('#id_location').val(data.id);
			$('#inputFactory').val(data.factory).trigger("change");
			$('#inputLocation').val(data.location).trigger("change");
			$('#inputColumn').val(data.columns);
			$('#inputRow').val(data.row);
			
			$(".loading").hide();
		},
		error: function(response) {
			$(".loading").hide();
		},
	});
}

function reload_table() {
	table.ajax.reload(null, false); //reload datatable ajax
}
