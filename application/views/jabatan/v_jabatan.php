<!-- Content Wrapper. Contains page content -->
<div class="loading"></div>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Jabatan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Jabatan</li>
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
                                            <label for="exampleSelectBorder">Nama Jabatan <span class="text-danger">*</span></label>
                                            <input type="text" name="id_jabatan" id="inputIdJabatan" hidden>
                                            <input name="nama_jabatan" type="text" class="form-control form-control-border border-width-2" id="inputNamaJabatan" autocomplete="off" required placeholder="Nama Jabatan">
                                            <span class='form-control-feedback text-danger'></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Unit Kerja <span class="text-danger">*</span></label>
                                            <input name="unit_kerja" type="text" class="form-control form-control-border border-width-2" id="inputUnitKerja" autocomplete="off" required placeholder="Unit Kerja">
                                            <span class='form-control-feedback text-danger'></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <button type="button" id="btnSave" class="btn btn-primary">Save</button>
                                        <button type="button" id="btnUpdate" class="btn btn-success" hidden>Update</button>
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
                    <div class="card card-success card-outline">
                        <div class="card-header">
                            <div class="card-title">
                                Daftar Jabatan
                                <br>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-12">
                                    <table id="tableJabatan" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nama Jabatan</th>
                                                <th>Unit Kerja</th>
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
<script src="<?= base_url() . 'assets/js/jabatan.js'; ?>"></script>