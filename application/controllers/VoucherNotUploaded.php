<?php
defined('BASEPATH') or exit('No direct script access allowed');

class VoucherNotUploaded extends CI_Controller
{
    var $module;

    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged') !== TRUE) {
            redirect(base_url() . 'index.php/Login');
        }
        $this->load->library('Pdf');

        $this->load->model(array('M_voucher_not_uploaded', 'M_crud'));
        $this->module       = "VOUCHER_NOT_UPLOAD";
    }

    function index()
    {
        $datas['page_title']        = "Voucher Not Uploaded";

        $this->load->view("layout/v_header", $datas);
        $this->load->view("layout/v_top_menu");
        $this->load->view("layout/v_sidebar");
        $this->load->view("voucher_not_uploaded/v_voucher_not_uploaded.php");
        $this->load->view("layout/v_footer");
    }

    /**
     * DATATABLES NOT UPLOADED VOUCHER
     */

    function loadVoucherList()
    {
        $voucher_not_uploaded_lists      = $this->M_voucher_not_uploaded->loadVoucherNotUploadedList();

        $data               = array();

        $no                 = $_POST['start'];

        $i                  = 0;


        foreach ($voucher_not_uploaded_lists as $item) {
            $no++;
            $row        = array();
            $row[]      = $item->item_storage_code;
            $row[]      = "<input id='VoucherNo$i' type='text' value='$item->VoucherNo' hidden/>$item->VoucherNo";
            $row[]      = "<span  data-toggle='tooltip' data-placement='bottom' title='$item->Particulars'>$item->PaymentTo</span>";
            $row[]      = $item->BankName;
            $row[]      = $item->Currency;
            $row[]      = $item->location_name;

            if ($item->softcopy_scan) {
                $filename_replace       = base_url() . "/upload/softcopy_scan/$item->softcopy_scan.pdf";

                $row[]      = "<button data-id='$item->voucher_id' class='btn btn-sm btn-success' onclick='showUpModalUpload($i)' title='Upload Attachment'><i class='fa fa-edit'></i></button>
                
                <button class='btn btn-sm btn-primary' data-toggle='modal' data-target='#modalPreviewPDF' onclick='showModalPreviewPDF($i)' id='btnPreview$i' data-url-file='$filename_replace' title='Preview Attachment'><i class='fa fa-file-pdf'></i></button>";
            } else {
                $row[]      = "<button data-id='$item->voucher_id' class='btn btn-sm btn-success' onclick='showUpModalUpload($i)' title='Upload Attachment'><i class='fa fa-edit'></i></button>";
            }



            $data[]     = $row;
            $i++;
        }

        $output         = array(
            "draw"              => $_POST['draw'],
            "recordsTotal"      => $this->M_voucher_not_uploaded->count_all(),
            "recordsFiltered"   => $this->M_voucher_not_uploaded->count_filtered(),
            "data"              => $data,
        );

        // output to json format

        echo json_encode($output);
    }

    /**
     * API - Auto Complete Payment To Not Uploaded Voucher
     */
    function getPaymentToArray()
    {
        $response_data          = array();

        $PaymentTo           = $this->M_voucher_not_uploaded->loadPaymentToListOption();

        if ($PaymentTo) {
            foreach ($PaymentTo as $item) {
                $response_data[]    = $item->PaymentTo;
            }
        }

        echo json_encode($response_data);
    }

    // API

    function loadVoucherFactoryListOption()
    {
        $currency           = $this->M_voucher_not_uploaded->loadVoucherFactoryList();

        $result     = "<option value=''>-- Choose Factory --</option>";

        foreach ($currency as $item) {
            $result .= "<option value='$item->factory'>$item->factory</option>";
        }

        echo $result;
    }


    function loadVoucherLocationListOption()
    {
        $currency           = $this->M_voucher_not_uploaded->loadVoucherLocationList();

        $result     = "<option value=''>-- Choose Location --</option>";

        foreach ($currency as $item) {
            $result .= "<option value='$item->location'>$item->location</option>";
        }

        echo $result;
    }

    function loadVoucherBankListOption()
    {
        $bank           = $this->M_voucher_not_uploaded->loadVoucherBankList();

        $result     = "<option value=''>-- Choose Bank --</option>";

        foreach ($bank as $item) {
            $result .= "<option value='$item->BankName'>$item->BankName</option>";
        }

        echo $result;
    }

    function loadVoucherPaymentToListOption()
    {
        $payment_to           = $this->M_voucher_not_uploaded->loadVoucherPaymentToList();

        $result     = "<option value=''>-- Choose Payment To --</option>";

        foreach ($payment_to as $item) {
            $result .= "<option value='$item->PaymentTo'>$item->PaymentTo</option>";
        }

        echo $result;
    }

    function loadVoucherCurrencyListOption()
    {
        $currency           = $this->M_voucher_not_uploaded->loadVoucherCurrencyList();

        $result     = "<option value=''>-- Choose Currency --</option>";

        foreach ($currency as $item) {
            $result .= "<option value='$item->Currency'>$item->Currency</option>";
        }

        echo $result;
    }
}
