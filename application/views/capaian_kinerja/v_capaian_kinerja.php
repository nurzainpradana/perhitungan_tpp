<!-- Content Wrapper. Contains page content -->
<div class="loading"></div>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Capaian Kinerja</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Beranda</a></li>
                        <li class="breadcrumb-item active">Capaian Kinerja</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-success card-outline">
                        <form action="#" id="jabatanForm" method="post" target="_blank">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Periode <span class="text-danger">*</span></label>
                                            <input name="periode" type="month" class="form-control form-control-border border-width-2" id="inputPeriode" value="<?= date("Y-m"); ?>" autocomplete=" off" required placeholder="Pilih Periode">
                                            <span class='form-control-feedback text-danger'></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-success card-outline">
                        <div class="card-header">
                            <div class="card-title">
                                Daftar Capaian Kinerja
                                <br>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <form action="#" id="capianKinerjaForm" method="post" target="_blank">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="exampleSelectBorder">Pegawai <span class="text-danger">*</span></label>
                                                    <select class="form-control form-control-border" id="inputPegawai" name="pegawai" required>
                                                        <option value="">-- Pilih Pegawai --</option>
                                                    </select>
                                                    <span class='form-control-feedback text-danger'></span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="exampleSelectBorder">Presentase Produktivitas <span class="text-danger">*</span></label>
                                                    <input name="presentase_produktivitas" type="number" class="form-control form-control-border border-width-2" id="inputPresentaseProduktivitas" autocomplete="off" min="0" max="100" required placeholder="Input Presentase Produktivitas">
                                                    <span class='form-control-feedback text-danger'></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <button type="button" id="btnSave" class="btn btn-primary">Simpan</button>
                                                <button type="button" id="btnUpdate" class="btn btn-success">Update</button>
                                                <button type="reset" id="btnCancel" class="btn btn-secondary">Reset</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <table id="tableCapaianKinerja" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nama Pegawai</th>
                                                <th>Jabatan</th>
                                                <th>Presentase Produktivitas<br>Kerja PNS</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.content-wrapper -->
<script src="<?= base_url() . 'assets/js/capaian_kinerja.js'; ?>"></script>