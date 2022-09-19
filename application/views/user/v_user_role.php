<!-- Content Wrapper. Contains page content -->
<div class="loading"></div>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">User Role</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item">Setting</li>
                        <li class="breadcrumb-item">User</li>
                        <li class="breadcrumb-item active">Role</li>
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
                        <div class="card-header">
                            <div class="card-title">
                                Role List
                            </div>
                            <!-- 
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div> -->
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <span class="text-bold">Employee : <span class="text-primary text-bold"> <?= $employee_name; ?></span></span> <br><br>
                                </div>
                            </div>
                            <div class=" row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <input type="text" id="inputUserID" value="<?= $id; ?>" hidden>
                                        <label class="col-sm-2 col-form-label" for="exampleInputBorderWidth2">Role <code class="text-danger">*</code></label>
                                        <div class="col-sm-6">
                                            <select name="role" class="form-control" id="inputRoleSelect">
                                                <option value="">-- Choose Role --</option>
                                                <?php
                                                if (isset($role)) {
                                                    foreach ($role as $i) {
                                                ?>
                                                        <option value="<?= $i->id; ?>"><?= $i->role_name; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>

                                            <span class='form-control-feedback text-danger'></span>
                                        </div>
                                        <div class="col-4">
                                            <button class="btn btn-success" onclick="addRole()">Add</button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <table id="tableUserRole" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Role</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                            </table>
                            <br>
                            <button type="button" onclick="history.back()" class="btn btn-default">Back</button>
                        </div>
                    </div>
                </div>
                <!-- /.col-md-6 -->
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<!-- jQuery -->
<script type="text/javascript">

</script>
<script src="<?= base_url() . 'application/views/user/user_role.js'; ?>"></script>
<!-- 
<script>
    
</script> -->