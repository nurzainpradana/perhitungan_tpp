<?php
defined('BASEPATH') or exit('No direct script access allowed');

class VoucherRegistered extends CI_Controller
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

        $this->load->library('Pdf');

        $this->load->model(array('M_voucher_registered', 'M_crud'));
        $this->module       = "VOUCHER_REGISTERED";
    }

    function index()
    {
        $datas['page_title']            = "Voucher Registered";

        $is_can_disposal            = false;

        $check_role                 = $this->M_voucher_registered->checkRoleDisposal($this->session->userdata("user_id"));
        if (count($check_role) > 0) {
            $is_can_disposal        = true;
        }

        $data['is_can_disposal']    = $is_can_disposal;

        $this->load->view('layout/v_header', $datas);
        $this->load->view('layout/v_top_menu');
        $this->load->view('layout/v_sidebar');
        $this->load->view('voucher_registered/v_voucher_registered', $data);
        $this->load->view('layout/v_footer');
    }

    function out()
    {
        $vouchers       = $this->input->post('voucherSelected');

        $this->userlog->saveLogWithData($this->module, "Process Voucher Out", "START", array('vouchers' => $vouchers));


        $success_query_count        = 0;
        $faileds                     = array();

        if (count($vouchers) > 0) {
            foreach ($vouchers as $voucher) {
                $data       = array(
                    'voucher'   => $voucher,
                    'user'      => $this->session->userdata('user_id')
                );

                $out        = $this->M_voucher_registered->out($data);

                if ($out) {
                    if ($out->Result == "failed") {
                        $this->userlog->saveLogWithData($this->module, "Voucher Out Failed", "FAILED", array('voucher' => $voucher));
                        $faileds[]      = $voucher;
                    } else if ($out->Result == "success") {
                        $this->userlog->saveLogWithData($this->module, "Voucher Out Successfully", "SUCCESS", array('voucher' => $voucher));
                        $success_query_count++;
                    } else if ($out->Result == "voucher unregistered") {
                        $this->userlog->saveLogWithData($this->module, "Voucher Out Failed, Voucher Unregistered", "FAILED", array('voucher' => $voucher));
                        $faileds[]      = $voucher;
                    }
                } else {
                    $faileds[]      = $voucher;
                }
            }
        } else {
            $response_message       = "Empty Voucher Selected!";
            $this->userlog->saveLog($this->module, "Empty Voucher Selected", "FAILED");
        }

        if (count($faileds) > 0) {
            $response_message       .= " Failed Vouchers Out ";
            foreach ($faileds as $item) {
                $response_message       .= "$item,";
            }
        }

        if ($success_query_count == count($vouchers)) {
            $response_status        = "success";
            $response_message       = "Successfully";
        } else {
            $response_status        = "failed";
        }

        echo json_encode(array("status" => $response_status, "message" => $response_message));
    }

    function move()
    {
        $vouchers       = $this->input->post('voucherSelected');
        $location       = $this->input->post("location_name");

        $this->userlog->saveLogWithData($this->module, "Process Voucher Move", "START", array('vouchers' => $vouchers, 'location' => $location));


        $success_query_count        = 0;
        $faileds                     = array();
        $voucher_unregistered       = array();
        $location_unregistered      = array();

        $response_message           = "";

        if ($location != "" && $location != null && count($vouchers) > 0) {
            foreach ($vouchers as $voucher) {
                $data       = array(
                    'voucher'   => $voucher,
                    'location'  => $location,
                    'user'      => $this->session->userdata('user_id')
                );

                $out        = $this->M_voucher_registered->move($data);

                if ($out) {
                    if ($out->Result == "failed") {
                        $this->userlog->saveLogWithData($this->module, "Voucher Move Failed", "FAILED", array('voucher' => $voucher));
                        $faileds[]      = $voucher;
                    } else if ($out->Result == "success") {
                        $this->userlog->saveLogWithData($this->module, "Voucher Move Successfully", "SUCCESS", array('voucher' => $voucher));
                        $success_query_count++;
                    } else if ($out->Result == "location unregistered") {
                        $this->userlog->saveLogWithData($this->module, "Voucher Move Failed, Location Unregistered", "FAILED", array('location' => $location));
                        $location_unregistered[]    = $voucher;
                    } else if ($out->Result == "voucher unregistered") {
                        $this->userlog->saveLogWithData($this->module, "Voucher Move Failed, Voucher Unregistered", "FAILED", array('voucher' => $voucher));
                        $voucher_unregistered[]      = $voucher;
                    }
                } else {
                    $faileds[]      = $voucher;
                }
            }
        } else {
            $response_message       = "Empty Location or Voucher Selected!";
            $this->userlog->saveLog($this->module, "Empty Location or Voucher Selected", "FAILED");
        }

        if (count($location_unregistered) > 0) {
            $response_message       .= "Location $location is not registered";
        }

        if (count($voucher_unregistered) > 0) {
            $response_message       .= "Voucher not registered";
            foreach ($voucher_unregistered as $item) {
                $response_message       .= "$voucher ,";
            }
        }


        if (count($faileds) > 0) {
            $response_message       .= " Failed Vouchers Move ";
            foreach ($faileds as $item) {
                $response_message       .= "$item,";
            }
        }


        if ($success_query_count == count($vouchers)) {
            $response_status        = "success";
            $response_message       = "Successfully";
        } else {
            $response_status        = "failed";
        }

        echo json_encode(array("status" => $response_status, "message" => $response_message));
    }


    function Disposal()
    {
        $vouchers       = $this->input->post('voucherSelected');
        $reason         = $this->input->post('reason');
        $this->userlog->saveLogWithData($this->module, "Process Voucher Disposal", "START", array('vouchers' => $vouchers, 'reason' => $reason));


        $success_query_count        = 0;
        $faileds                    = array();

        $response_message           = "";

        if (count($vouchers) > 0) {
            foreach ($vouchers as $voucher) {
                $data       = array(
                    'voucher'   => $voucher,
                    'reason'    => $reason,
                    'user'      => $this->session->userdata('user_id')
                );

                $out        = $this->M_voucher_registered->disposal($data);

                if ($out) {
                    if ($out->Result == "failed") {
                        $this->userlog->saveLogWithData($this->module, "Voucher Disposal Failed", "FAILED", array('voucher' => $voucher, 'reason' => $reason));

                        $faileds[]      = $voucher;
                    } else if ($out->Result == "success") {
                        $this->userlog->saveLogWithData($this->module, "Voucher Disposal Successfully", "SUCCESS", array('voucher' => $voucher, 'reason' => $reason));
                        $success_query_count++;
                    } else if ($out->Result == "voucher unregistered") {
                        $this->userlog->saveLogWithData($this->module, "Voucher Disposal Failed, Voucher Unregistered", "FAILED", array('voucher' => $voucher, 'reason' => $reason));
                        $faileds[]      = $voucher;
                    }
                } else {
                    $faileds[]      = $voucher;
                }
            }
        } else {
            $response_message       = "Empty Voucher Selected!";
            $this->userlog->saveLog($this->module, "Empty Voucher Selected", "FAILED");
        }

        if (count($faileds) > 0) {
            $response_message       .= " Failed Vouchers Out ";
            foreach ($faileds as $item) {
                $response_message       .= "$item,";
            }
        }

        if ($success_query_count == count($vouchers)) {
            $response_status        = "success";
            $response_message       = "Successfully";
        } else {
            $response_status        = "failed";
        }

        echo json_encode(array("status" => $response_status, "message" => $response_message));
    }

    function loadVoucherRegisteredList()
    {

        $voucher_registered_lists      = $this->M_voucher_registered->loadVoucherRegisteredList();

        $data               = array();

        $no                 = $_POST['start'];

        $i                  = 0;


        foreach ($voucher_registered_lists as $item) {
            $no++;
            $row        = array();
            $row[]      = "<input class='cbVoucherList' type='checkbox' name='vouchers[]' id='cb$item->VoucherNo' value='$item->VoucherNo'> ";

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
            "recordsTotal"      => $this->M_voucher_registered->count_all(),
            "recordsFiltered"   => $this->M_voucher_registered->count_filtered(),
            "data"              => $data,
        );

        // output to json format

        echo json_encode($output);
    }

    function excel()
    {
        $this->load->library('Excel');

        $objPHPExcel = new PHPExcel();

        $objPHPExcel->getProperties()->setCreator("IT DEV ZIPCO");
        $objPHPExcel->getProperties()->setLastModifiedBy("IT DEV ZIPCO");
        $objPHPExcel->getProperties()->setTitle("VOUCHER REGISTERED LIST");
        // $objPHPExcel->getProperties()->setSubject("Content Subject");
        // $objPHPExcel->getProperties()->setDescription("Content Description");
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle('Voucher Registered List');

        //activate worksheet number 1
        $objPHPExcel->setActiveSheetIndex(0);
        //name the worksheet
        $objPHPExcel->getActiveSheet()->setTitle('VOUCHER REGISTERED LIST');

        //Setting Width
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(80);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);


        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'VOUCHER REGISTERED LIST');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'ACCOUNTING STORAGE SYSTEM');
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Export Date ' . date("Y-m-d H:i:s"));

        //Header
        $objPHPExcel->getActiveSheet()->setCellValue('A5', 'NO');
        $objPHPExcel->getActiveSheet()->setCellValue('B5', 'ITEM STORAGE CODE');
        $objPHPExcel->getActiveSheet()->setCellValue('C5', 'VOUCHER NO');
        $objPHPExcel->getActiveSheet()->setCellValue('D5', 'PAYMENT TO');
        $objPHPExcel->getActiveSheet()->setCellValue('E5', 'BANK NAME');
        $objPHPExcel->getActiveSheet()->setCellValue('F5', 'PARTICULARS');
        $objPHPExcel->getActiveSheet()->setCellValue('G5', 'CURRENCY');
        $objPHPExcel->getActiveSheet()->setCellValue('H5', 'LOCATION');

        $row        = 6;
        $no         = 1;

        $data       = $this->M_voucher_registered->getVoucherRegisteredExport();

        if ($data) {
            foreach ($data as $i) {
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $no);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $i->item_storage_code);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $i->VoucherNo);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $i->PaymentTo);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $i->BankName);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $i->Particulars);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $i->Currency);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $i->location_name);
                $row++;
                $no++;
            }
        }

        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        $style_color = array(
            'color' => array(
                'rgb' => 'FF0000'
            )
        );

        $row    = $row - 1;

        //Setting CELL
        $objPHPExcel->getActiveSheet()->getStyle('A5:H' . $row)->applyFromArray($styleArray);
        unset($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('A5:H5')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => '68a7d9')));
        $objPHPExcel->getActiveSheet()->getStyle('A1:H5')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A5:H' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A5:H' . $row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('D5:D' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle('F5:F' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(false);


        $filename = 'VOUCHER_REGISTERED_' . time() . '.xls'; //save our workbook as this file name


        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();
        $objWriter->save('php://output');

        exit;
    }

    function pdf()
    {
        $pdf = new FPDF1('P', 'mm', 'A4'); // ukuran kertas atau  new FPDF('P','mm','A4');  
        $pdf->AddPage('portrait');
        $pdf->setTitle('VOUCHER REGISTERED');
        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(190, 5, 'VOUCHER REGISTERED', 0, 1, 'L');
        $pdf->SetFont('Times', 'I', 10);
        $pdf->Cell(190, 5, 'Accounting Storage System', 0, 1, 'L');
        $pdf->SetFont('Times', 'B', 8);

        $pdf->Cell(190, 1, '', 0, 1, 'L');
        $pdf->Cell(190, 1, '', 0, 1, 'L');


        $pdf->Cell(7, 4, 'NO', 1, 0, 'C');
        $pdf->Cell(20, 4, 'VOUCHER NO', 1, 0, 'C');
        $pdf->Cell(58, 4, 'PAYMENT TO', 1, 0, 'L');
        $pdf->Cell(30, 4, 'BANK NAME', 1, 0, 'C');
        $pdf->Cell(25, 4, 'CURRENCY', 1, 0, 'C');
        $pdf->Cell(50, 4, 'LOCATION', 1, 1, 'C');

        $no         = 1;

        $data       = $this->M_voucher_registered->getVoucherRegisteredExport();

        $pdf->SetFont('Times', '', 7);
        if ($data) {
            foreach ($data as $i) {
                $pdf->Cell(7, 4, $no, 1, 0, 'C');
                $pdf->Cell(20, 4, $i->VoucherNo, 1, 0, 'C');
                $pdf->Cell(58, 4, $i->PaymentTo, 1, 0, 'L');
                $pdf->Cell(30, 4, $i->BankName, 1, 0, 'C');
                $pdf->Cell(25, 4, $i->Currency, 1, 0, 'C');
                $pdf->Cell(50, 4, $i->location_name, 1, 1, 'C');

                $no++;
            }
        }


        $pdf->setLineWidth(0.2);

        $pdf->Cell(190, 4, '', 'B', 1, 'R');

        $dashed_line    = '';

        for ($i = 0; $i <= 115; $i++) {
            $dashed_line   .= '- ';
        }

        $pdf->Cell(95, 4, 'Print Date ' . date("m/d/Y H:i:s"), 0, 1, 'L');

        $pdf->SetFont('Times', '', 8);
        $pdf->setX(9);
        $pdf->Cell(190, 1, $dashed_line, 0, 1, 'L');

        $pdf->Output('VOUCHER_REGISTERED_' . date("YmdHis") . '.pdf', 'I');
    }

    // API

    function loadVoucherFactoryListOption()
    {
        $currency           = $this->M_voucher_registered->loadVoucherFactoryList();

        $result     = "<option value=''>-- Choose Factory --</option>";

        foreach ($currency as $item) {
            $result .= "<option value='$item->factory'>$item->factory</option>";
        }

        echo $result;
    }


    function loadVoucherLocationListOption()
    {
        $currency           = $this->M_voucher_registered->loadVoucherLocationList();

        $result     = "<option value=''>-- Choose Location --</option>";

        foreach ($currency as $item) {
            $result .= "<option value='$item->location'>$item->location</option>";
        }

        echo $result;
    }

    function loadVoucherBankListOption()
    {
        $bank           = $this->M_voucher_registered->loadVoucherBankList();

        $result     = "<option value=''>-- Choose Bank --</option>";

        foreach ($bank as $item) {
            $result .= "<option value='$item->BankName'>$item->BankName</option>";
        }

        echo $result;
    }

    function loadVoucherPaymentToListOption()
    {
        $payment_to           = $this->M_voucher_registered->loadVoucherPaymentToList();

        $result     = "<option value=''>-- Choose Payment To --</option>";

        foreach ($payment_to as $item) {
            $result .= "<option value='$item->PaymentTo'>$item->PaymentTo</option>";
        }

        echo $result;
    }

    function loadVoucherCurrencyListOption()
    {
        $currency           = $this->M_voucher_registered->loadVoucherCurrencyList();

        $result     = "<option value=''>-- Choose Currency --</option>";

        foreach ($currency as $item) {
            $result .= "<option value='$item->Currency'>$item->Currency</option>";
        }

        echo $result;
    }

    function uploadSoftcopyScan()
    {
        $VoucherNo  = $_POST["voucherno"];
        $datetime   = date("YmdHis");

        $response_status    = "failed";
        $response_message   = "";

        if (!empty($_FILES['softcopy_scan']) && $_FILES['softcopy_scan']['error'] != UPLOAD_ERR_NO_FILE) {


            $file_name      = str_replace("-", "_", "VCRSCN_$VoucherNo");
            $upload_path    = $_SERVER['DOCUMENT_ROOT'] . '/upload/softcopy_scan/';

            $merge_file       = false;


            if (file_exists($upload_path . $file_name . '.pdf')) {
                $file_name      = str_replace("-", "_", "VCRSCN_$VoucherNo" . "_" . "new");
                $merge_file     = true;
            }

            $config['upload_path']              =  $_SERVER['DOCUMENT_ROOT'] . '/upload/softcopy_scan/';
            $config['allowed_types']            = 'pdf';
            $config['file_name']                = $file_name;
            $config['overwrite']                = true;



            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('softcopy_scan')) {
                $response_message       = $this->upload->display_errors();
                $response_status        = "failed";
            } else {
                $response_message       = "File has been uploaded";
                $response_status        = "success";

                $data               = array(
                    "softcopy_scan"     => str_replace("-", "_", "VCRSCN_$VoucherNo"),
                    "last_upload_time"  => Date("Y-m-d H:i:s"),
                    "upload_by"         => $this->session->userdata("user_id")
                );

                $where              = array(
                    "VoucherNo"         => $VoucherNo
                );

                $update             = $this->M_crud->update("storage_voucher_registered", $data, $where);

                if ($merge_file) {
                    unset($this->fpdf);

                    include APPPATH . '/libraries/PDFMerger.php';

                    $pdf = new PDFMerger;

                    $file_name      = str_replace("-", "_", "VCRSCN_$VoucherNo");
                    $pdf->addPDF($_SERVER['DOCUMENT_ROOT'] . str_replace(" ", "", "\upload\softcopy_scan\ ") . $file_name . ".pdf", 'all');

                    $file_name      = str_replace("-", "_", "VCRSCN_$VoucherNo" . "_" . "new");
                    $pdf->addPDF($_SERVER['DOCUMENT_ROOT'] . str_replace(" ", "", "\upload\softcopy_scan\ ") . $file_name . ".pdf", 'all');

                    $file_name      = str_replace("-", "_", "VCRSCN_$VoucherNo");

                    $pdf->merge('file', $_SERVER['DOCUMENT_ROOT'] . str_replace(" ", "", "\upload\softcopy_scan\ ") . $file_name . ".pdf"); // generate the file

                    unlink($_SERVER['DOCUMENT_ROOT'] . str_replace(" ", "", "\upload\softcopy_scan\ ") . str_replace("-", "_", "VCRSCN_$VoucherNo" . "_" . "new") . ".pdf");
                }
            }
        } else {
            $response_message       = "File Empty";
        }

        $result     = array(
            'status'        => $response_status,
            'message'       => $response_message
        );

        echo json_encode($result);
    }

    /**
     * API - Auto Complete Payment To Register Voucher
     */
    function getPaymentToArray()
    {
        $response_data          = array();

        $PaymentTo           = $this->M_voucher_registered->loadPaymentToListOption();

        if ($PaymentTo) {
            foreach ($PaymentTo as $item) {
                $response_data[]    = $item->PaymentTo;
            }
        }

        echo json_encode($response_data);
    }
}
