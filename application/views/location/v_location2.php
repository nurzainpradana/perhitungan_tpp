<!-- Content Wrapper. Contains page content -->
<div class="loading"></div>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Location</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item">Master Data</li>
                        <li class="breadcrumb-item active">Location</li>
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
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>

                        <form action="#" id="locationForm" method="post">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Factory <code class="text-danger">*</code></label>

                                            <input type="text" name="id_location" id="id_location" hidden>
                                            <select name="factory" class="form-control form-control-border" id="inputFactory" required>
                                                <option value="">-- Choose Factory --</option>
                                                <option value="ZIP1">Zipco 1</option>
                                                <option value="ZIP2">Zipco 2</option>
                                                <option value="ZIP3">Zipco 3</option>
                                                <option value="ZIP5">Zipco 5</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Location <code class="text-danger">*</code></label>
                                            <select name="location" class="form-control form-control-border" id="inputLocation" required>
                                                <option value="">-- Choose Location --</option>
                                                <option value="1">Storage 1</option>
                                                <option value="2">Storage 2</option>
                                                <option value="3">Storage 3</option>
                                                <option value="4">Storage 5</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputBorderWidth2">Column <code class="text-danger">*</code></label>
                                            <input name="columns" type="text" class="form-control form-control-border border-width-2" id="inputColumn" required placeholder="Column">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputBorderWidth2">Row <code class="text-danger">*</code></label>
                                            <input name="row" type="text" class="form-control form-control-border border-width-2" id="inputRow" required placeholder="Row">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <button type="button" id="btnSave" onclick="saveLocation()" class="btn btn-primary">Save</button>
                                        <button type="button" id="btnUpdate" onclick="UpdateLocation()" class="btn btn-primary">Update</button>
                                        <button type="button" id="btnFilter" class="btn btn-primary">Filter</button>
                                        <button type="reset" id="btnCancel" class="btn btn-secondary">Reset</button>
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
                            Location List
                        </div>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="tableLocation" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Location</th>
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


<!-- jQuery -->
<script type="text/javascript">

</script>
<script src="<?= base_url(); ?>/assets/dist/js/customize/location2.js"></script>
<!-- 
<script>
    
</script> -->