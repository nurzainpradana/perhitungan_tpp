<!-- Content Wrapper. Contains page content -->
<div class="loading"></div>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Voucher History</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Voucher History</li>
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
                        <form action="#" id="historyVoucherForm" method="post" target="_blank">
                            <div class="card-body">
                                <!-- <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Period</label>
                                            <select class="form-control form-control-border" id="inputPeriod" required>
                                                <option value="">-- Choose Period --</option>
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
                                            <label for="exampleSelectBorder">Employee</label>
                                            <select class="form-control form-control-border" id="inputEmployee" name="Employee" data-default-employee="<?= isset($user_id) ? $user_id : NULL; ?>" required>
                                                <option value="ALL">-- All Employee --</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Type</label>
                                            <select class="form-control form-control-border" id="inputType" name="Type" required>
                                                <option value="">-- Choose Type --</option>
                                                <option value="IN">IN</option>
                                                <option value="OUT">OUT</option>
                                                <option value="RETURN">RETURN</option>
                                                <option value="MOVE">MOVE</option>
                                                <option value="DISPOSAL">DISPOSAL</option>
                                                <option value="RESTORE">RESTORE</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
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
                                <!-- <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Factory</label>
                                            <select class="form-control form-control-border" id="inputFactory" required>
                                                <option value="">-- Choose Factory --</option>
                                            </select>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Location</label>
                                            <select class="form-control form-control-border" id="inputLocation" name="Location" required>
                                                <option value="">-- Choose Location --</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">

                                        <button type="button" id="btnFilter" class="btn bg-navy">Filter</button>
                                        <button type="button" id="btnExportExcel" class="btn bg-success">Excel</button>
                                        <button type="button" id="btnExportPDF" class="btn bg-danger">PDF</button>
                                        <button type="button" id="btnCancel" class="btn btn-secondary">Reset</button>
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
                                Voucher History List
                                <br>

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <table id="tableHistoryVoucher" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Employee Name</th>
                                                <th>Type</th>
                                                <th>Voucher No</th>
                                                <th>Payment To</th>
                                                <th>Bank Name</th>
                                                <th>Currency</th>
                                                <th>Location</th>
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
<script src="<?= base_url() . 'application/views/voucher_history/voucher_history.js'; ?>"></script>
<!-- 
<script>
    
</script> -->