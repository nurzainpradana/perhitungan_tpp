<?php
defined('BASEPATH') or exit('No direct script access allowed');

class VoucherUnregistered extends CI_Controller
{
    var $module;

    function __construct()
    {
        parent::__construct();

        /**
         * CHECK LOGIN
         * ============
         */
        if ($this->session->userdata('logged') !== TRUE) {
            redirect(base_url() . 'index.php/Login');
        }

        /**
         * CHECK USER ACCESS
         * =================
         */
        if (!$this->menulibrary->checkUserAccess()) {
            redirect(base_url() . 'index.php');
        }

        $this->load->model(array('M_voucher_unregistered'));
        $this->module   = "VOUCHER_UNREGISTERED";
    }

    function index()
    {
        $datas['page_title']        = "Voucher Unregistered";

        $this->load->view('layout/v_header', $datas);
        $this->load->view('layout/v_top_menu');
        $this->load->view('layout/v_sidebar');
        $this->load->view('voucher_unregistered/v_voucher_unregistered');
        $this->load->view('layout/v_footer');
    }

    function register()
    {
        $vouchers       = $this->input->post("voucherSelected");
        $location       = $this->input->post("location_name");
        $user           = $this->session->userdata("user_id");

        // SA
        $this->userlog->saveLogWithData($this->module, "Process Register Voucher", "START", array('vouchers' => $vouchers, 'location' => $location));

        $exists                     = array();
        $faileds                    = array();
        $location_unregistereds     = NULL;

        $response_message   = "";

        $success_query_count          = 0;

        if ($location != "" && count($vouchers) > 0) {
            foreach ($vouchers as $voucher) {

                $data       = array(
                    'voucher'           => $voucher,
                    'location_name'     => $location,
                    'user'              => $user,
                    'doc_type'          => 'VCR'
                );

                $insert     = $this->M_voucher_unregistered->registerVoucher($data);

                if ($insert) {
                    if ($insert->Result == "exists") {
                        $this->userlog->saveLogWithData($this->module, "Failed to register, Voucher Exists", "FAILED", array('voucher' => $voucher, 'location' => $location));

                        $exists[]       = $voucher;
                    } else if ($insert->Result == "failed") {
                        $this->userlog->saveLogWithData($this->module, "Failed when process register", "FAILED", array('voucher' => $voucher, 'location' => $location));

                        $faileds[]      = $voucher;
                    } else if ($insert->Result == "location unregistered") {
                        $this->userlog->saveLogWithData($this->module, "Failed to register, Location Unregistered", "FAILED", array('voucher' => $voucher, 'location' => $location));

                        $location_unregistereds   = $location;
                    } else if ($insert->Result == "success") {
                        $this->userlog->saveLogWithData($this->module, "Register Voucher Successfully", "SUCCESS", array('voucher' => $voucher, 'location' => $location));

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
            } else {
                $response_message       .= "Empty Location!";
                $response_status        = "failed";
            }
        }

        if (count($exists) > 0) {
            $response_message      .= " Exist Voucher Data ";
            foreach ($exists as $exist) {
                $response_message      .= "$exist,";
            }
        }

        if (count($faileds) > 0) {
            $response_message       .= " Failed Register Data ";
            foreach ($faileds as $failed) {
                $response_message      .= "$failed,";
            }
        }

        if ($location_unregistereds != NULL) {
            $response_message       .= " Location $location_unregistereds unregistered ";
        }

        if ($success_query_count == count($vouchers)) {
            $response_status        = "success";
        } else {
            $response_status        = "failed";
        }

        echo json_encode(array("status" => $response_status, "message" => $response_message));
    }

    /**
     * DATATABLES VOUCHER UNREGISTERED
     * ===================================
     */
    function loadVoucherUnregisteredList()
    {

        $voucher_unregistered_lists      = $this->M_voucher_unregistered->loadVoucherUnregisteredList();

        $data               = array();

        $no                 = $_POST['start'];


        foreach ($voucher_unregistered_lists as $item) {
            $no++;
            $row        = array();
            $row[]      = "<input class='cbVoucherList' type='checkbox' name='vouchers[]' id='cb$item->ID' value='$item->VouncherNo'> ";
            $row[]      = $item->VouncherNo;
            $row[]      = "<span  data-toggle='tooltip' data-placement='bottom' title='$item->Particulars'>$item->PaymentTo</span>";
            $row[]      = $item->BankName;
            $row[]      = $item->Currency;

            $data[]     = $row;
        }

        $output         = array(
            "draw"              => $_POST['draw'],
            "recordsTotal"      => $this->M_voucher_unregistered->count_all(),
            "recordsFiltered"   => $this->M_voucher_unregistered->count_filtered(),
            "data"              => $data,
        );

        // output to json format

        echo json_encode($output);
    }

    // API

    function loadVoucherBankListOption()
    {
        $bank           = $this->M_voucher_unregistered->loadVoucherBankList();

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
        $currency           = $this->M_voucher_unregistered->loadVoucherPaymentToList();

        $result     = "<option value=''>-- Choose Payment To --</option>";

        foreach ($currency as $item) {
            $result .= "<option value='$item->PaymentTo'>$item->PaymentTo</option>";
        }

        echo $result;
    }

    function loadVoucherCurrencyListOption()
    {
        $currency           = $this->M_voucher_unregistered->loadVoucherCurrencyList();

        $result     = "<option value=''>-- Choose Currency --</option>";

        foreach ($currency as $item) {
            $result .= "<option value='$item->Currency'>$item->Currency</option>";
        }

        echo $result;
    }

    function getPaymentToArray()
    {
        $response_data          = array();

        $PaymentTo           = $this->M_voucher_unregistered->loadPaymentToListOption();

        if ($PaymentTo) {
            foreach ($PaymentTo as $item) {
                $response_data[]    = $item->PaymentTo;
            }
        }

        echo json_encode($response_data);
    }
}
