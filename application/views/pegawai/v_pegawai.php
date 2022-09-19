<!-- Content Wrapper. Contains page content -->
<div class="loading"></div>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pegawai</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Pegawai</li>
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
                    <div class="card card-primary card-outline">
                        <form action="#" id="pegawaiForm" method="post" target="_blank">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">NIP Pegawai</label>
                                            <input type="text" name="id_pegawai" id="inputIdPegawai" hidden>
                                            <input name="nip_pegawai" type="text" class="form-control form-control-border border-width-2" id="inputNIPPegawai" autocomplete="off" required placeholder="NIP Pegawai">
                                            <span class='form-control-feedback text-danger'></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Nama Pegawai <span class="text-danger">*</span></label>
                                            <input name="nama_pegawai" type="text" class="form-control form-control-border border-width-2" id="inputNamaPegawai" autocomplete="off" required placeholder="Nama Pegawai">
                                            <span class='form-control-feedback text-danger'></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Jabatan <span class="text-danger">*</span></label>
                                            <select class="form-control form-control-border" id="inputJabatan" name="jabatan" required>
                                                <option value="">-- Pilih Jabatan --</option>
                                            </select>
                                            <span class='form-control-feedback text-danger'></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">User ID</label>
                                            <input name="user_id" type="text" class="form-control form-control-border border-width-2" id="inputUserId" autocomplete="off" required placeholder="User ID">
                                            <span class='form-control-feedback text-danger'></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                    <div class="form-group">
                                            <label for="exampleSelectBorder">Level User</label>
                                            <select class="form-control form-control-border" id="inputLevel" name="level_user" required>
                                                <option value="">-- Pilih Level User --</option>
                                                <option value="1">Admin Umpeg</option>
                                                <option value="2">Admin Keuangan</option>
                                                <option value="3">Kasubag Umpeg</option>
                                                <option value="4">Camat</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Password</label>
                                            <input name="password" type="password" class="form-control form-control-border border-width-2" id="inputPassword" autocomplete="off" required placeholder="Password">
                                            <span class='form-control-feedback text-danger'></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <button type="button" id="btnSave" class="btn btn-primary">Save</button>
                                        <button type="button" id="btnUpdate" class="btn btn-success" hidden>Update</button>
                                        <!-- <a id="btnExportExcel" class="btn btn-secondary" href="<?= base_url() . '/index.php/VoucherRegistered/excel'; ?>">Export Excel</a> -->
                                        <button type="reset" id="btnCancel" class="btn btn-secondary">Reset</button>
                                    </div>
                                </div>
                            </div>
                    </div>
                    </form>

                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="card-title">
                                Daftar Pegawai
                                <br>
                            </div>
                        </div>
                        <div class="card-body">
                            
                            <div class="row">
                                <div class="col-12">
                                    <table id="tablePegawai" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <!-- <th>#</th> -->
                                                <th>NIP Pegawai</th>
                                                <th>Nama Pegawai</th>
                                                <th>Jabatan</th>
                                                <th>User Id</th>
                                                <th>Level</th>
                                                <th>Action</th>
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
<script src="<?= base_url() . 'assets/js/pegawai.js'; ?>"></script>