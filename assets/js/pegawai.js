var getUrl = window.location;
var baseUrl =
	getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split("/")[1];
var save_method;
var table;

$(document).ready(function () {
	$(".loading").hide();

	loadJabatanOptionList();


	table = $("#tablePegawai").DataTable({
		processing: true, //Feature control the processing indicator.
		serverSide: true, //Feature control DataTables' server-side processing mode.
		searching: true,
		paging: true,
		lengthChange: true,
		pageLength: 10,

		// Load data for the table's content from an Ajax source
		ajax: {
			url: baseUrl + "/Pegawai/loadPegawaiListDatatables",
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
		checkEmptyInput("#inputUserId");
		checkEmptyInput("#inputNamaPegawai");

		if(checkEmptyInput("#inputUserId") &&
		checkEmptyInput("#inputNamaPegawai"))
		{
			$.ajax({
				url: baseUrl + '/Pegawai/AddPegawai',
				type: "POST",
				data: $("#pegawaiForm").serialize(),
				dataType: "JSON",
				success: function (response) {
					$("#pegawaiForm")[0].reset();
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
						text: "Gagal melakukan proses simpan Pegawai",
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
				url: baseUrl + '/Jabatan/update',
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
		$("#pegawaiForm")[0].reset();

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

function editPegawai(id)
{
	$("#pegawaiForm")[0].reset();
	$.ajax({
		url: baseUrl + "/Pegawai/edit",
		type: "POST",
		dataType: "JSON",
		data: {
			id_pegawai		: id
		},
		success: function (response) {
			if(response.status == 'success')
			{
				var data 	= response.data;
				$("#inputNIPPegawai").val(data.nip_pegawai);
				$("#inputNamaPegawai").val(data.nama);
				$("#inputJabatan").val(data.id_jabatan);
				$("#inputUserId").val(data.user_id);
				$("#inputLevel").val(data.level);
				$("#inputIdPegawai").val(data.id_pegawai);

				$("#inputNIPPegawai").focus();

				$("#btnSave").attr("hidden", "hidden");
				$("#btnUpdate").removeAttr("hidden");
			} else {
				Swal.fire({
					icon: "error",
					title: "Gagal!",
					text: "Gagal mendapatkan Data Pegawai!",
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

function deletePegawai(id)
{
	Swal.fire({
		title: "Konfirmasi",
		text: "Apakah anda ingin menghapus data pegawai ini ?",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Yes",
	}).then((result) => {
		if (result.isConfirmed) {
			$(".loading").show();
			$.ajax({
				url: baseUrl + "/Pegawai/delete",
				type: "POST",
				data: {
					id_pegawai: id,
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
						var message = "Gagal menghapus Data Pegawai";

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
						text: "Gagal memproses Hapus Data Pegawai!",
					});
				},
			});
		}
	});
}
