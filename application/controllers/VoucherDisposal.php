<?php
defined('BASEPATH') or exit('No direct script allowd');

class VoucherDisposal extends CI_Controller
{
    var $module;
    var $start_date;
    var $end_date;

    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged') !== TRUE) {
            redirect(base_url() . 'index.php/Login');
        }

        if (!$this->menulibrary->checkUserAccess()) {
            redirect(base_url() . 'index.php');
        }

        $this->load->model('M_voucher_disposal');

        $this->start_date     = date("Y-m");
        $this->start_date     = "$this->start_date-01";

        $this->end_date       = date("Y-m-d");
        $this->module       = "VOUCHER_DISPOSAL";
    }

    function index()
    {
        $data['page_title']     = "Voucher Disposal";


        $this->load->view('layout/v_header', $data);
        $this->load->view('layout/v_top_menu');
        $this->load->view('layout/v_sidebar');

        $data                   = array(
            'start_date'        => $this->start_date,
            'end_date'          => $this->end_date
        );


        $this->load->view('voucher_disposal/v_voucher_disposal', $data);
        $this->load->view('layout/v_footer');
    }

    function loadVoucherDisposalList()
    {
        $voucher_disposal_lists      = $this->M_voucher_disposal->loadVoucherDisposalList();

        $data               = array();

        $no                 = $_POST['start'];


        foreach ($voucher_disposal_lists as $item) {
            $no++;
            $row        = array();
            $row[]      = "<input class='cbVoucherList' type='checkbox' name='vouchers[]' id='cb$item->VoucherNo' value='$item->VoucherNo'> ";

            $row[]      = Date("Y-m-d", strtotime($item->created_date));


            $row[]      = $item->VoucherNo;
            $row[]      = "<span  data-toggle='tooltip' data-placement='bottom' title='$item->Particulars'>$item->PaymentTo</span>";
            $row[]      = $item->BankName;
            $row[]      = $item->Currency;
            $row[]      = $item->reason;

            $data[]     = $row;
        }

        $output         = array(
            "draw"              => $_POST['draw'],
            "recordsTotal"      => $this->M_voucher_disposal->count_all(),
            "recordsFiltered"   => $this->M_voucher_disposal->count_filtered(),
            "data"              => $data,
        );

        // output to json format

        echo json_encode($output);
    }

    function loadVoucherBankListOption()
    {
        $bank           = $this->M_voucher_disposal->loadVoucherBankList();

        $result     = "<option value=''>-- Choose Bank --</option>";

        foreach ($bank as $item) {
            $result .= "<option value='$item->BankName'>$item->BankName</option>";
        }

        echo $result;
    }

    function loadVoucherLocationListOption()
    {
        $currency           = $this->M_voucher_disposal->loadVoucherLocationList();

        $result     = "<option value=''>-- Choose Location --</option>";

        foreach ($currency as $item) {
            $result .= "<option value='$item->location'>$item->location</option>";
        }

        echo $result;
    }

    function loadVoucherPaymentToListOption()
    {
        $payment_to           = $this->M_voucher_disposal->loadVoucherPaymentToList();

        $result     = "<option value=''>-- Choose Payment To --</option>";

        foreach ($payment_to as $item) {
            $result .= "<option value='$item->PaymentTo'>$item->PaymentTo</option>";
        }

        echo $result;
    }

    function loadVoucherCurrencyListOption()
    {
        $currency           = $this->M_voucher_disposal->loadVoucherCurrencyList();

        $result     = "<option value=''>-- Choose Currency --</option>";

        foreach ($currency as $item) {
            $result .= "<option value='$item->Currency'>$item->Currency</option>";
        }

        echo $result;
    }

    function restore()
    {
        $vouchers       = $this->input->post("voucherSelected");
        $location       = $this->input->post("location_name");
        $user           = $this->session->userdata("user_id");

        $this->userlog->saveLogWithData($this->module, "Process Voucher Restore", "START", array('vouchers' => $vouchers, 'location' => $location, 'user' => $user));

        $exists                     = array();
        $faileds                    = array();
        $location_unregistereds     = NULL;

        $response_message   = "";

        $success_query_count          = 0;

        if ($location != "" && count($vouchers) > 0) {
            foreach ($vouchers as $voucher) {

                $data       = array(
                    'voucher'           => $voucher,
                    'location_name'      => $location,
                    'user'              => $user
                );

                $this->userlog->saveLogWithData($this->module, "Restore Voucher $voucher", "PROCESS", array('voucher' => $voucher, 'location' => $location, 'user' => $user));

                $insert     = $this->M_voucher_disposal->restoreVoucher($data);

                if ($insert) {
                    if ($insert->Result == "exists") {
                        $this->userlog->saveLog($this->module, "Process Voucher Return $voucher Failed, Voucher is Exists", "FAILED");
                        $exists[]       = $voucher;
                    } else if ($insert->Result == "failed") {
                        $this->userlog->saveLog($this->module, "Process Voucher Return $voucher Failed", "FAILED");
                        $faileds[]      = $voucher;
                    } else if ($insert->Result == "location unregistered") {
                        $this->userlog->saveLog($this->module, "Process Voucher Return $voucher Failed, Location $location is not registered", "FAILED");
                        $location_unregistereds   = $location;
                    } else if ($insert->Result == "success") {
                        $this->userlog->saveLog($this->module, "Process Voucher Return $voucher Successfully", "SUCCESS");
                        $success_query_count++;
                    }
                } else {
                    $faileds[]      = $voucher;
                }
            }
        } else {
            if (count($vouchers) == 0) {
                $this->userlog->saveLog($this->module, "Empty Voucher!", "FAILED");
                $response_message       .= "Empty Voucher!";
                $response_status        = "failed";
            } else if ($location == '' || $location == null) {
                $this->userlog->saveLog($this->module, "Empty Location!", "FAILED");
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

    function excel()
    {
        $this->load->library('Excel');

        $objPHPExcel = new PHPExcel();

        $objPHPExcel->getProperties()->setCreator("IT DEV ZIPCO");
        $objPHPExcel->getProperties()->setLastModifiedBy("IT DEV ZIPCO");
        $objPHPExcel->getProperties()->setTitle("VOUCHER DISPOSAL LIST");
        // $objPHPExcel->getProperties()->setSubject("Content Subject");
        // $objPHPExcel->getProperties()->setDescription("Content Description");

        //activate worksheet number 1
        $objPHPExcel->setActiveSheetIndex(0);
        //name the worksheet
        $objPHPExcel->getActiveSheet()->setTitle('VOUCHER DISPOSAL LIST');

        //Setting Width
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);


        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'VOUCHER DISPOSAL LIST');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'ACCOUNTING STORAGE SYSTEM');
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Export Date ' . date("Y-m-d H:i:s"));

        //Header
        $objPHPExcel->getActiveSheet()->setCellValue('A5', 'NO');
        $objPHPExcel->getActiveSheet()->setCellValue('B5', 'DATE');
        $objPHPExcel->getActiveSheet()->setCellValue('C5', 'VOUCHER NO');
        $objPHPExcel->getActiveSheet()->setCellValue('D5', 'PAYMENT TO');
        $objPHPExcel->getActiveSheet()->setCellValue('E5', 'BANK NAME');
        $objPHPExcel->getActiveSheet()->setCellValue('F5', 'CURRENCY');
        $objPHPExcel->getActiveSheet()->setCellValue('G5', 'REASON');

        $row        = 6;
        $no         = 1;

        $data       = $this->M_voucher_disposal->loadVoucherDisposalList();

        if ($data) {
            foreach ($data as $i) {
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $no);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, Date("Y-m-d", strtotime($i->created_date)));
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $i->VoucherNo);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $i->PaymentTo);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $i->BankName);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $i->Currency);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $i->reason);
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
        $objPHPExcel->getActiveSheet()->getStyle('A5:G' . $row)->applyFromArray($styleArray);
        unset($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('A5:G5')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => '68a7d9')));
        $objPHPExcel->getActiveSheet()->getStyle('A1:G5')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A5:G' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A5:G' . $row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('D5:D' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle('G5:G' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(false);


        $filename = 'VOUCHER_DISPOSAL_' . time() . '.xls'; //save our workbook as this file name


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
        $this->load->library("pdf");
        $pdf = new FPDF1('P', 'mm', 'A4'); // ukuran kertas atau  new FPDF('P','mm','A4');  
        $pdf->AddPage('portrait');
        $pdf->setTitle('VOUCHER DISPOSAL');
        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(190, 5, 'VOUCHER DISPOSAL', 0, 1, 'L');
        $pdf->SetFont('Times', 'I', 10);
        $pdf->Cell(190, 5, 'Accounting Storage System', 0, 1, 'L');
        $pdf->SetFont('Times', 'B', 8);

        $pdf->Cell(190, 1, '', 0, 1, 'L');
        $pdf->Cell(190, 1, '', 0, 1, 'L');


        $pdf->Cell(7, 4, 'NO', 1, 0, 'C');
        $pdf->Cell(20, 4, 'DATE', 1, 0, 'C');
        $pdf->Cell(30, 4, 'VOUCHER NO', 1, 0, 'C');
        $pdf->Cell(50, 4, 'PAYMENT TO', 1, 0, 'L');
        $pdf->Cell(25, 4, 'BANK NAME', 1, 0, 'C');
        $pdf->Cell(25, 4, 'CURRENCY', 1, 0, 'C');
        $pdf->Cell(35, 4, 'REASON', 1, 1, 'L');

        $no         = 1;

        $data       = $this->M_voucher_disposal->loadVoucherDisposalList();

        $pdf->SetFont('Times', '', 7);
        if ($data) {
            foreach ($data as $i) {
                $pdf->Cell(7, 4, $no, 1, 0, 'C');
                $pdf->Cell(20, 4, Date("Y-m-d", strtotime($i->created_date)), 1, 0, 'C');
                $pdf->Cell(30, 4, $i->VoucherNo, 1, 0, 'C');
                $pdf->Cell(50, 4, $i->PaymentTo, 1, 0, 'L');
                $pdf->Cell(25, 4, $i->BankName, 1, 0, 'C');
                $pdf->Cell(25, 4, $i->Currency, 1, 0, 'C');
                $pdf->Cell(35, 4, $i->reason, 1, 1, 'L');

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

        $pdf->Output('VOUCHER_DISPOSAL_' . date("YmdHis") . '.pdf', 'I');
    }

    function getPaymentToArray()
    {
        $response_data          = array();

        $PaymentTo           = $this->M_voucher_disposal->loadPaymentToListOption();

        if ($PaymentTo) {
            foreach ($PaymentTo as $item) {
                $response_data[]    = $item->PaymentTo;
            }
        }

        echo json_encode($response_data);
    }
}
