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
            <?php
            if ($this->session->flashdata('error')) {
            ?>
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h4><i class="icon fa fa-ban"></i> Caution !</h4>
                            <?php
                            echo $this->session->flashdata('error');
                            ?>
                        </div>
                    </div>
                </div>
            <?php
            } elseif ($this->session->flashdata('success')) {
            ?>
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h4><i class="icon fa fa-check"></i> Success</h4>
                            <?php
                            echo $this->session->flashdata('success');
                            ?>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
            <div class="row">

                <!-- /.col-md-6 -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card card-primary card-outline">

                        <form action="#" id="locationForm" method="post">
                            <div class="card-header">
                                <h5 class="m-0">Create New</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleSelectBorder">Factory <code class="text-danger">*</code></label>
                                    <select name="factory" class="custom-select form-control-border" id="exampleSelectBorder" required>
                                        <option value="">-- Choose Factory --</option>
                                        <option value="ZIP1">Zipco 1</option>
                                        <option value="ZIP2">Zipco 2</option>
                                        <option value="ZIP3">Zipco 3</option>
                                        <option value="ZIP5">Zipco 5</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleSelectBorder">Location <code class="text-danger">*</code></label>
                                    <select name="location" class="custom-select form-control-border" id="exampleSelectBorder" required>
                                        <option value="">-- Choose Location --</option>
                                        <option value="1">Storage 1</option>
                                        <option value="2">Storage 2</option>
                                        <option value="3">Storage 3</option>
                                        <option value="4">Storage 5</option>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="exampleInputBorderWidth2">Column <code class="text-danger">*</code></label>
                                            <input name="columns" type="text" class="form-control form-control-border border-width-2" id="exampleInputBorderWidth2" required placeholder="Column">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="exampleInputBorderWidth2">Row <code class="text-danger">*</code></label>
                                            <input name="row" type="text" class="form-control form-control-border border-width-2" id="exampleInputBorderWidth2" required placeholder="Row">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="button" id="btnSave" onclick="saveLocation()" class="btn btn-primary">Submit</button>
                                <button type="reset" id="btnCancel" onclick="saveLocation()" class="btn btn-secondary">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-8 col-md-6 col-sm-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="m-0">Location List</h5>
                        </div>
                        <div class="card-body">
                            <table id="tableLocation" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Location</th>
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
<script src="<?= base_url(); ?>/assets/dist/js/customize/location.js"></script>
<!-- 
<script>
    
</script> -->