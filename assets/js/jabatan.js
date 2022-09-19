var getUrl = window.location;
var baseUrl =
	getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split("/")[1];
var save_method;
var table;

$(document).ready(function () {
	$(".loading").hide();

	loadJabatanOptionList();


	table = $("#tableJabatan").DataTable({
		processing: true, //Feature control the processing indicator.
		serverSide: true, //Feature control DataTables' server-side processing mode.
		searching: true,
		paging: true,
		lengthChange: true,
		pageLength: 10,

		// Load data for the table's content from an Ajax source
		ajax: {
			url: baseUrl + "/Jabatan/loadJabatanListDatatables",
			type: "POST",
			data: function (data) {
				
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

	$("#btnSave").click(function(e){
		checkEmptyInput("#inputNamaJabatan");
		checkEmptyInput("#inputUnitKerja");

		if(checkEmptyInput("#inputNamaJabatan") &&
		checkEmptyInput("#inputUnitKerja"))
		{
			$.ajax({
				url: baseUrl + '/Jabatan/Add',
				type: "POST",
				data: $("#jabatanForm").serialize(),
				dataType: "JSON",
				success: function (response) {
					$("#jabatanForm")[0].reset();
					if(response.status == 'success')
					{
						Swal.fire({
							icon: "success",
							title: "Berhasil!",
							text: response.message,
						});
					} else {
						Swal.fire({
							icon: "error",
							title: "Gagal!",
							text: response.message,
						});
					}
					reload_table();
				},
				error: function (response) {
					Swal.fire({
						icon: "error",
						title: "Gagal!",
						text: "Gagal melakukan proses simpan Jabatan",
					});
				}
			});
		}
	});

	$("#btnUpdate").click(function(e){
		checkEmptyInput("#inputNamaJabatan");
		checkEmptyInput("#inputUnitKerja");

		if(checkEmptyInput("#inputNamaJabatan") &&
		checkEmptyInput("#inputUnitKerja"))
		{
			$.ajax({
				url: baseUrl + '/Jabatan/Update',
				type: "POST",
				data: $("#jabatanForm").serialize(),
				dataType: "JSON",
				success: function (response) {
					$("#jabatanForm")[0].reset();
					$("#btnUpdate").attr("hidden", "hidden");
					$("#btnSave").removeAttr("hidden");

					if(response.status == 'success')
					{
						Swal.fire({
							icon: "success",
							title: "Berhasil!",
							text: response.message,
						});
					} else {
						Swal.fire({
							icon: "error",
							title: "Gagal!",
							text: response.message,
						});
					}
					reload_table();
				},
				error: function (response) {
					Swal.fire({
						icon: "error",
						title: "Gagal!",
						text: "Gagal melakukan proses Update Jabatan",
					});
				}
			});
		}
	});

	$("#btnCancel").click(function (e) {
		$("#jabatanForm")[0].reset();

		$("#btnSave").removeAttr("hidden");
		$("#btnUpdate").attr("hidden","hidden");

		reload_table();
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

function loadJabatanOptionList()
{
	$.ajax({
		url: baseUrl + "/Pegawai/loadJabatanListOption",
		type: "POST",
		success: function (response) {
			$("#inputJabatan").empty();

			$("#inputJabatan").append(response);
		},
	});
}


function reload_table() {
	table.ajax.reload(null, false); //reload datatable ajax
}

function editJabatan(id)
{
	$("#jabatanForm")[0].reset();
	$.ajax({
		url: baseUrl + "/Jabatan/edit",
		type: "POST",
		dataType: "JSON",
		data: {
			id_jabatan		: id
		},
		success: function (response) {
			if(response.status == 'success')
			{
				var data 	= response.data;
				$("#inputNamaJabatan").val(data.nama_jabatan);
				$("#inputUnitKerja").val(data.unit_kerja);
				$("#inputIdJabatan").val(data.id_jabatan);

				$("#inputNamaJabatan").focus();

				$("#btnSave").attr("hidden", "hidden");
				$("#btnUpdate").removeAttr("hidden");
			} else {
				Swal.fire({
					icon: "error",
					title: "Gagal!",
					text: "Gagal mendapatkan Data Jabatan!",
				});
			}
		},
		error: function(response)
		{
			Swal.fire({
				icon: "error",
				title: "Gagal!",
				text: "Gagal memproses Data Pegawai!",
			});
		}
	});
}

function deleteJabatan(id)
{
	Swal.fire({
		title: "Konfirmasi",
		text: "Apakah anda ingin menghapus data Jabatan ini ?",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Yes",
	}).then((result) => {
		if (result.isConfirmed) {
			$(".loading").show();
			$.ajax({
				url: baseUrl + "/Jabatan/delete",
				type: "POST",
				data: {
					id_jabatan: id,
				},
				dataType: "JSON",
				success: function (response) {
					$(".loading").hide();

					reload_table();

					if (response.status == "success") {
						reload_table();
						Swal.fire({
							icon: "success",
							title: "Berhasil!",
							text: response.message,
						});
					} else if (response.status == "failed") {
						var message = "Gagal menghapus Data Jabatan";

						if (response.message !== "") {
							message = response.message;
						}

						Swal.fire({
							icon: "error",
							title: "Gagal!",
							text: message,
						});
					}
				},
				error: function (response) {
					$(".loading").hide();
					reload_table();
					Swal.fire({
						icon: "error",
						title: "Gagal!",
						text: "Gagal memproses Hapus Data Jabatan!",
					});
				},
			});
		}
	});
}
