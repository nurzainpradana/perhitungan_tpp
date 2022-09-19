<!-- Content Wrapper. Contains page content -->
<div class="loading"></div>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Role Menu</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item">Setting</li>
                        <li class="breadcrumb-item">Role</li>
                        <li class="breadcrumb-item active">Menu</li>
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
                                            <input type="text" name="role_id" id="inputRoleId" value="<?= $role_id; ?>" hidden>
                                            <label for="exampleSelectBorder">Role Name <code class="text-danger">*</code></label>
                                            <input type="text" name="role_name" id="inputRoleName" placeholder="Role Name" class="form-control" maxlength="50" style="text-transform:uppercase" value="<?= $role_name; ?>">
                                            <span class='form-control-feedback text-danger'></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <button type="button" id="btnSave" onclick="updateRole()" class="btn btn-primary">Update</button>
                                        <button type="button" onclick="history.back()" class="btn btn-default">Back</button>
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
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label" for="exampleInputBorderWidth2">Menu <code class="text-danger">*</code></label>
                                    <div class="col-sm-6">
                                        <select name="edit" class="form-control" id="inputMenuSelect">
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
                                    <div class="col-4">
                                        <button class="btn btn-success" onclick="addMenu()">Add</button>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <table id="tableRoleMenu" class="table table-bordered table-striped">
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
<script src="<?= base_url() . 'application/views/role/role_menu.js'; ?>"></script>
<!-- 
<script>
    
</script> -->