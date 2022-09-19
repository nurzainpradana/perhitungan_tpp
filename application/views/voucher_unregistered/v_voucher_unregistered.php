<!-- Content Wrapper. Contains page content -->
<div class="loading"></div>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Voucher Unregistered</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Voucher Unregistered</li>
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
                        <form action="#" id="registerVoucherForm" method="post">
                            <div class="card-body">

                                <!-- <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Payment To</label>
                                            <select name="payment_to" class="form-control form-control-border" id="inputPaymentTo" required>
                                                <option value="">-- Choose Payment To --</option>
                                            </select>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Bank Name</label>
                                            <select name="bank" class="form-control form-control-border" id="inputBank" required>
                                                <option value="">-- Choose Bank Name --</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Currency</label>
                                            <select name="storage_location" class="form-control form-control-border" id="inputCurrency" required>
                                                <option value="">-- Choose Currency --</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="exampleInputBorderWidth2">Payment To <code class="text-danger">*</code></label>
                                            <input name="payment_to" type="text" class="form-control form-control-border border-width-2" id="inputPaymentTo" autocomplete="off" required placeholder="Payment To">
                                            <span class='form-control-feedback text-danger'></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">


                                        <button type="button" id="btnFilter" class="btn bg-navy">Filter</button>
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
                                Voucher Unregistered List
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <button type="button" id="btnRegister" class="btn btn-primary text-right">Register</button>
                                    <br><br>
                                    <div class="custom-control custom-checkbox p-0 m-0">
                                        <input class="" type="checkbox" id="btnSelectAll">
                                        <label for="btnSelectAll" class="">Select All</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <table id="tableUnregisteredVoucher" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Voucher No</th>
                                                <th>Payment To</th>
                                                <th>Bank Name</th>
                                                <th>Currency</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- MODAL -->
                <div class="modal fade" id="inputLocationModal" tabindex="-1" role="dialog" aria-labelledby="inputLocationModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Register Voucher</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="POST" id="formInputLocation" method="post">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="exampleInputBorderWidth2">Input Location <code class="text-danger">*</code></label>
                                                <input name="location" type="text" class="form-control form-control-border border-width-2" id="inputLocation" maxlength="10" autocomplete="off" required placeholder="Location">
                                                <span class='form-control-feedback text-danger'></span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button id="btnProcessRegister" type="button" class="btn btn-primary">Process</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END MODAL -->
            </div>
        </div>
    </div>
</div>
<!-- /.content-wrapper -->
<script src="<?= base_url() . 'application/views/voucher_unregistered/voucher_unregistered.js'; ?>"></script>