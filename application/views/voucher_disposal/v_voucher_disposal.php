<!-- Content Wrapper. Contains page content -->
<div class="loading"></div>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Voucher Disposal</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Voucher Disposal</li>
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
                        <form action="#" id="disposalVoucherForm" method="post" target="_blank">
                            <div class="card-body">
                                <!-- <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Payment To</label>
                                            <select class="form-control form-control-border" id="inputPaymentTo" required>
                                                <option value="">-- Choose Payment To --</option>
                                            </select>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="control-label">Start Date</label>
                                            <input type="date" id="inputStartDate" name="StartDate" data-default-start-date="<?= isset($start_date) ? $start_date : NULL; ?>" class="form-control" value="<?= isset($start_date) ? $start_date : NULL; ?>">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="control-label">End Date</label>
                                            <input type="date" id="inputEndDate" name="EndDate" data-default-end-date="<?= isset($end_date) ? $end_date : NULL; ?>" class="form-control" value="<?= isset($end_date) ? $end_date : NULL; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Bank Name</label>
                                            <select class="form-control form-control-border" id="inputBank" name="BankName" required>
                                                <option value="">-- Choose Bank Name --</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Currency</label>
                                            <select class="form-control form-control-border" id="inputCurrency" name="Currency" required>
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
                                        <button type="button" id="btnExportExcel" class="btn btn-success">Excel</button>
                                        <button type="button" id="btnExportPDF" class="btn btn-danger">PDF</button>
                                        <button type="button" id="btnReset" class="btn btn-secondary">Reset</button>
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
                                Voucher Disposal List
                                <br>

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <button type="button" id="btnRestore" class="btn btn-primary text-right">Restore</button>
                                    <br><br>
                                    <!-- <div class="custom-control custom-checkbox text-left p-0 m-0">
                                        <input class="" type="checkbox" id="btnSelectAll">
                                        <label for="btnSelectAll" class="">Select All</label>
                                    </div> -->

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <table id="tableDisposalVoucher" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Voucher No</th>
                                                <th>Payment To</th>
                                                <th>Bank Name</th>
                                                <th>Currency</th>
                                                <th>Reason</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <!-- MODAL -->
                                <div class="modal fade" id="inputLocationModal" tabindex="-1" role="dialog" aria-labelledby="inputLocationModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Vouchers Restore</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="exampleInputBorderWidth2">Input Location <code class="text-danger">*</code></label>
                                                            <input name="location" type="text" class="form-control form-control-border border-width-2" id="inputLocation" autocomplete="off" required placeholder="Location">
                                                            <span id="locationErrorFeedback" class="text-red">Location is required</span>
                                                        </div>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.content-wrapper -->
</script>
<script src="<?= base_url() . 'application/views/voucher_disposal/voucher_disposal.js'; ?>"></script>
<!-- 
<script>
    
</script> -->