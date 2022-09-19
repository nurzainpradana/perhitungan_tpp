<!-- Content Wrapper. Contains page content -->
<div class="loading"></div>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Role</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item">Setting</li>
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

                        <form action="#" id="roleForm" method="post">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Role Name <code class="text-danger">*</code></label>
                                            <input type="text" name="role" id="inputRole" placeholder="Role Name" class="form-control" maxlength="50" style="text-transform:uppercase">
                                            <span class='form-control-feedback text-danger'></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <button type="button" id="btnSave" onclick="saveRole()" class="btn btn-primary">Save</button>
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
                        <table id="tableRole" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Role</th>
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
            <div class="modal fade" id="roleMenuModal" tabindex="-1" role="dialog" aria-labelledby="roleMenuModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">ROLE MENU</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <input type="text" id="inputRoleId" hidden></input>
                                        <label for="exampleInputBorderWidth2">Role Name <code class="text-danger">*</code></label>
                                        <input name="edit_role_name" type="text" class="form-control form-control-border border-width-2" id="editRoleName" autocomplete="off" required placeholder="Role Name">
                                        <span class='form-control-feedback text-danger'></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="exampleInputBorderWidth2">Menu <code class="text-danger">*</code></label>
                                        <select name="edit" class="form-control" id="editMenuSelect">
                                            <option value="">-- Choose Menu --</option>
                                            <?php
                                            if (isset($menu_list)) {
                                                foreach ($menu_list as $menu) {
                                            ?>
                                                    <option value="<?= $menu->id; ?>"><?= $menu->menu_name; ?></option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                        <span class='form-control-feedback text-danger'></span>
                                    </div>
                                </div>
                                <div class="col-6">

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <table id="tableMenuRole" class="table table-bordered table-striped" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Menu</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button id="btnProcessRestore" type="button" class="btn btn-primary">Process</button>
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
<script src="<?= base_url() . 'application/views/role/role.js'; ?>"></script>
<!-- 
<script>
    
</script> -->