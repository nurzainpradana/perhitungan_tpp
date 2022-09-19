<!-- Content Wrapper. Contains page content -->
<div class="loading"></div>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Menu</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item">Setting</li>
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

                        <form action="#" id="menuForm" method="post">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Menu Name <code class="text-danger">*</code></label>
                                            <input type="text" name="menu_name" id="inputMenuName" placeholder="Menu Name" class="form-control" maxlength="50" style="text-transform:uppercase">
                                            <span class='form-control-feedback text-danger'></span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Url</label>
                                            <input type="text" name="url" id="inputUrl" placeholder="URL" class="form-control" maxlength="100">
                                            <span class='form-control-feedback text-danger'></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Level <code class="text-danger">*</code></label>
                                            <select name="menu_level" id="inputMenuLevel" class="form-control">
                                                <option value="">-- Choose Level --</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                            </select>
                                            <span class='form-control-feedback text-danger'></span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Is Parent Menu <code class="text-danger">*</code></label>
                                            <select name="is_parent_menu" id="inputIsParentMenu" class="form-control">
                                                <option value="">-- Choose --</option>
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>
                                            <span class='form-control-feedback text-danger'></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Parent Menu</label>
                                            <select name="parent_menu" id="inputParentMenu" class="form-control">
                                                <option value="0">No Parent Menu</option>
                                            </select>
                                            <span class='form-control-feedback text-danger'></span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Icon <i>(Font Awesome)</i></label>
                                            <input type="text" name="menu_icon" id="inputMenuIcon" placeholder="Icon (Font Awesome)" class="form-control" maxlength="100">
                                            <i class="fa icon-nav" id="previewIcon"></i>
                                            <span class='form-control-feedback text-danger'></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Status <code class="text-danger">*</code></label>
                                            <select name="status" id="inputStatus" class="form-control">
                                                <option value="1">Enable</option>
                                                <option value="0">Disable</option>
                                            </select>
                                            <span class='form-control-feedback text-danger'></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                                        <button type="button" id="btnFilter" onclick="reload_table" class="btn btn-default">Filter</button>
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
                            Menu List
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
                        <table id="table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Level</th>
                                    <th>Order</th>
                                    <th>Menu</th>
                                    <th>URL</th>
                                    <th>Icon</th>
                                    <th>Parent Menu</th>
                                    <th>Status</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                        </table>

                    </div>
                </div>
            </div>
            <!-- /.col-md-6 -->
        </div>

        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<div class="row">
    <!-- MODAL -->
    <div class="modal fade" id="editMenuModal" tabindex="-1" role="dialog" aria-labelledby="editMenuModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Menu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editMenuForm">
                        <div class="row">
                            <div class="col-12">
                                <input type="text" class="form-control" id="editMenuId" name="edit_menu_id" hidden></input>
                                <div class="form-group">

                                    <label for="exampleInputBorderWidth2">Level <code class="text-danger">*</code></label>
                                    <select name="edit_menu_level" class="form-control" id="editMenuLevel">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select>
                                    <span class='form-control-feedback text-danger'></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="exampleInputBorderWidth2">Menu Name <code class="text-danger">*</code></label>
                                    <input name="edit_menu_name" type="text" class="form-control form-control-border border-width-2" maxlength="50" id="editMenuName" style="text-transform:uppercase" required placeholder="Menu Name">
                                    <span class='form-control-feedback text-danger'></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="exampleInputBorderWidth2">URL</label>
                                    <input name="edit_url" type="text" class="form-control form-control-border border-width-2" maxlength="50" id="editUrl" style="text-transform:uppercase" required placeholder="URL">
                                    <span class='form-control-feedback text-danger'></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="exampleInputBorderWidth2">Icon</label>
                                    <input name="edit_menu_icon" type="text" class="form-control form-control-border border-width-2" maxlength="50" id="editMenuIcon" required placeholder="ICON">
                                    <i class="fa icon-nav" id="editPreviewIcon"></i>
                                    <span class='form-control-feedback text-danger'></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="exampleInputBorderWidth2">Parent Menu <code class="text-danger">*</code></label>
                                    <select name="edit_parent_menu" class="form-control" id="editParentMenu">
                                        <option value="0">No Parent Menu</option>
                                    </select>
                                    <span class='form-control-feedback text-danger'></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="exampleInputBorderWidth2">Is Parent Menu <code class="text-danger">*</code></label>
                                    <select name="edit_is_parent_menu" class="form-control" id="editIsParentMenu">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                    <span class='form-control-feedback text-danger'></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="exampleInputBorderWidth2">Status <code class="text-danger">*</code></label>
                                    <select name="edit_status" class="form-control" id="editStatus">
                                        <option value="1">Enable</option>
                                        <option value="0">Disable</option>
                                    </select>
                                    <span class='form-control-feedback text-danger'></span>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="btnUpdateMenu" type="button" class="btn btn-primary" onclick="updateMenu()">Update</button>
                </div>
            </div>
        </div>
    </div>
    <!-- END MODAL -->
</div>


<!-- jQuery -->
<script type="text/javascript">

</script>
<script src="<?= base_url() . 'application/views/menu/menu.js'; ?>"></script>
<!-- 
<script>
    
</script> -->