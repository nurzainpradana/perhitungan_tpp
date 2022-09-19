<!-- Content Wrapper. Contains page content -->
<div class="loading"></div>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">User</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item">Setting</li>
                        <li class="breadcrumb-item active">User</li>
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
                        <!-- <div class="card-header">
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div> -->

                        <form action="#" id="userForm" method="post">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Employee <code class="text-danger">*</code></label>
                                            <select name="employee" class="form-control form-control-border" id="inputEmployee" required>
                                                <option value="">-- Choose Employee --</option>
                                                <?php
                                                if (isset($employee)) {
                                                    foreach ($employee as $e) {
                                                ?>
                                                        <option value="<?= $e->user_id; ?>"><?= "$e->idnpk - $e->employee_name"; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <span class='form-control-feedback text-danger'></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <button type="button" id="btnSave" onclick="saveUser()" class="btn btn-primary">Save</button>
                                        <!-- <button type="button" id="btnUpdate" onclick="UpdateLocation()" class="btn btn-primary">Update</button> -->
                                        <!-- <button type="reset" id="btnCancel" class="btn btn-secondary">Reset</button> -->
                                    </div>
                                </div>
                        </form>

                    </div>
                    <div class="card-footer">

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <div class="card-title">
                            User List
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
                        <table id="tableUser" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Employee</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                        </table>

                    </div>
                </div>
            </div>
            <!-- /.col-md-6 -->
        </div>

        <div class="row">
            <!-- MODAL -->
            <div class="modal fade" id="updateUserModal" tabindex="-1" role="dialog" aria-labelledby="updateUserModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Update User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <span class="text-bold">Employee Name : </span><span id="employeeName"></span>
                                    <br><br>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="updateUser()">Update</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END MODAL -->
        </div>

        <!-- /.row -->
    </div><!-- /.container-fluid -->

</div>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->


<!-- jQuery -->
<script type="text/javascript">

</script>
<script src="<?= base_url() . 'application/views/user/user.js'; ?>"></script>
<!-- 
<script>
    
</script> -->