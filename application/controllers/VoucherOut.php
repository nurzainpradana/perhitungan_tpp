<?php
defined('BASEPATH') or exit('No direct script access allowed');

class VoucherOut extends CI_Controller
{
    var $module;

    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged') !== TRUE) {
            redirect(base_url() . 'index.php/Login');
        }

        if (!$this->menulibrary->checkUserAccess()) {
            redirect(base_url() . 'index.php');
        }

        $this->load->model(array('M_voucher_out'));
        $this->module   = "VOUCHER_OUT";
    }

    function index()
    {
        $datas['page_title']        = "Voucher Out";

        $this->load->view('layout/v_header', $datas);
        $this->load->view('layout/v_top_menu');
        $this->load->view('layout/v_sidebar');
        $this->load->view('voucher_out/v_voucher_out');
        $this->load->view('layout/v_footer');
    }

    function return()
    {
        $vouchers       = $this->input->post("voucherSelected");
        $user           = $this->session->userdata("user_id");

        $this->userlog->saveLogWithData($this->module, "Process Voucher Return", "START", array('vouchers' => $vouchers));

        $faileds                    = array();
        $unregistered               = NULL;

        $response_message   = "";

        $success_query_count          = 0;

        if (count($vouchers) > 0) {
            foreach ($vouchers as $voucher) {

                $data       = array(
                    'voucher'       => $voucher,
                    'user'          => $user
                );

                $insert     = $this->M_voucher_out->return($data);

                if ($insert) {
                    if ($insert->Result == "failed") {
                        $this->userlog->saveLogWithData($this->module, "Voucher Return Failed", "FAILED", array('voucher' => $voucher));
                        $faileds[]      = $voucher;
                    } else if ($insert->Result == "voucher unregistered") {
                        $this->userlog->saveLogWithData($this->module, "Voucher Return Failed, Voucher Unregistered", "FAILED", array('voucher' => $voucher));
                        $unregistered   = $voucher;
                    } else if ($insert->Result == "success") {
                        $this->userlog->saveLogWithData($this->module, "Voucher Return Successfully", "SUCCESS", array('voucher' => $voucher));
                        $success_query_count++;
                    }
                } else {
                    $faileds[]      = $voucher;
                }
            }
        } else {
            if (count($vouchers) == 0) {
                $response_message       .= "Empty Voucher!";
                $response_status        = "failed";

                $this->userlog->saveLog($this->module, "Empty Voucher", "FAILED");
            } else {

                $this->userlog->saveLog($this->module, "Empty Location", "FAILED");
                $response_message       .= "Empty Location!";
                $response_status        = "failed";
            }
        }
        if (count($faileds) > 0) {
            $response_message       .= " Failed Register Data ";
            foreach ($faileds as $failed) {
                $response_message      .= "$failed,";
            }
        }

        if ($unregistered != NULL) {
            $response_message       .= " Voucher $unregistered unregistered ";
        }

        if ($success_query_count == count($vouchers)) {
            $response_status        = "success";
        } else {
            $response_status        = "failed";
        }

        echo json_encode(array("status" => $response_status, "message" => $response_message));
    }

    function loadVoucherOutList()
    {

        $voucher_out_lists      = $this->M_voucher_out->loadVoucherOutList();

        $data               = array();

        $no                 = $_POST['start'];


        $i  = 0;
        foreach ($voucher_out_lists as $item) {
            $no++;
            $row        = array();
            $row[]      = "<input class='cbVoucherList' type='checkbox' name='vouchers[]' id='cb$item->id' value='$item->VoucherNo'> ";
            $row[]      = $item->item_storage_code;
            $row[]      = "<input id='VoucherNo$i' type='text' value='$item->VoucherNo' hidden/>$item->VoucherNo";
            $row[]      = "<span  data-toggle='tooltip' data-placement='bottom' title='$item->Particulars'>$item->PaymentTo</span>";
            $row[]      = $item->BankName;
            $row[]      = $item->Currency;
            $row[]      = $item->location_name;
            $row[]      = Date("Y-m-d", strtotime($item->out_date));
            $row[]      = $item->employee_name;

            if ($item->softcopy_scan) {

                $filename_replace       = base_url() . "/upload/softcopy_scan/$item->softcopy_scan.pdf";

                $row[]      = "<button class='btn btn-sm btn-success' onclick='showUpModalUpload($i)'><i class='fa fa-edit'></i></button>
                <button class='btn btn-sm btn-primary' data-toggle='modal' data-target='#modalPreviewPDF' onclick='showModalPreviewPDF($i)' id='btnPreview$i' data-url-file='$filename_replace'><i class='fa fa-file-pdf'></i></button>";
            } else {
                $row[]      = "<button class='btn btn-sm btn-success' onclick='showUpModalUpload($i)'><i class='fa fa-edit'></i></button>";
            }

            $data[]     = $row;
            $i++;
        }

        $output         = array(
            "draw"              => $_POST['draw'],
            "recordsTotal"      => $this->M_voucher_out->count_all(),
            "recordsFiltered"   => $this->M_voucher_out->count_filtered(),
            "data"              => $data,
        );

        // output to json format

        echo json_encode($output);
    }

    // API

    function loadVoucherBankListOption()
    {
        $bank           = $this->M_voucher_out->loadVoucherBankList();

        $result     = "<option value=''>-- Choose Bank --</option>";

        foreach ($bank as $item) {
            $result .= "<option value='$item->BankName'>$item->BankName</option>";
        }

        echo $result;
    }

    function loadLocationListOption()
    {
        $bank           = $this->M_location->loadLocationListOption();

        $result     = "<option value=''>-- Choose Location --</option>";

        foreach ($bank as $item) {
            $result .= "<option value='$item->id'>$item->location_name</option>";
        }

        echo $result;
    }

    function loadVoucherPaymentToListOption()
    {
        $currency           = $this->M_voucher_out->loadVoucherPaymentToList();

        $result     = "<option value=''>-- Choose Payment To --</option>";

        foreach ($currency as $item) {
            $result .= "<option value='$item->PaymentTo'>$item->PaymentTo</option>";
        }

        echo $result;
    }

    function loadVoucherCurrencyListOption()
    {
        $currency           = $this->M_voucher_out->loadVoucherCurrencyList();

        $result     = "<option value=''>-- Choose Currency --</option>";

        foreach ($currency as $item) {
            $result .= "<option value='$item->Currency'>$item->Currency</option>";
        }

        echo $result;
    }

    /**
     * API - Auto Complete Payment To Register Voucher
     */
    function getPaymentToArray()
    {
        $response_data          = array();

        $PaymentTo           = $this->M_voucher_out->loadPaymentToListOption();

        if ($PaymentTo) {
            foreach ($PaymentTo as $item) {
                $response_data[]    = $item->PaymentTo;
            }
        }

        echo json_encode($response_data);
    }
}
