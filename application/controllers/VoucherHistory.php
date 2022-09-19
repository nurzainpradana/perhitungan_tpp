<?php
defined('BASEPATH') or exit('No direct script access allowed');

class VoucherHistory extends CI_Controller
{
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
        $this->load->model(array('M_voucher_history'));

        $this->start_date     = date("Y-m");
        $this->start_date     = "$this->start_date-01";

        $this->end_date       = date("Y-m-d");
    }

    function index()
    {
        $datas['page_title']        = "Voucher History";

        $employee_name      = $this->session->userdata('employee_name');
        $user_id      = $this->session->userdata('user_id');
        $employee           = $this->M_voucher_history->loadVoucherEmployeeList();

        $data                   = array(
            'start_date'        => $this->start_date,
            'end_date'          => $this->end_date,
            'employee_name'     => $employee_name,
            'employee'          => $employee,
            'user_id'           => $user_id
        );

        $this->load->view('layout/v_header', $datas);
        $this->load->view('layout/v_top_menu');
        $this->load->view('layout/v_sidebar');
        $this->load->view('voucher_history/v_voucher_history', $data);
        $this->load->view('layout/v_footer');
    }

    function loadVoucherHistoryList()
    {

        $voucher_registered_lists      = $this->M_voucher_history->loadVoucherHistoryList();

        $data               = array();

        $no                 = $_POST['start'];


        foreach ($voucher_registered_lists as $item) {
            $no++;
            $row        = array();
            $row[]      = $item->date;
            $row[]      = $item->employee_name;
            $row[]      = $item->type;
            $row[]      = $item->VoucherNo;

            $row[]      = "<span  data-toggle='tooltip' data-placement='bottom' title='$item->Particulars'>$item->PaymentTo</span>";
            $row[]      = $item->BankName;
            $row[]      = $item->Currency;
            $row[]      = $item->location_name;

            $data[]     = $row;
        }

        $output         = array(
            "draw"              => $_POST['draw'],
            "recordsTotal"      => $this->M_voucher_history->count_all(),
            "recordsFiltered"   => $this->M_voucher_history->count_filtered(),
            "data"              => $data,
        );

        // output to json format

        echo json_encode($output);
    }

    function loadVoucherBankListOption()
    {
        $bank           = $this->M_voucher_history->loadVoucherBankList();

        $result     = "<option value=''>-- Choose Bank --</option>";

        foreach ($bank as $item) {
            $result .= "<option value='$item->BankName'>$item->BankName</option>";
        }

        echo $result;
    }

    function loadVoucherCurrencyListOption()
    {
        $currency           = $this->M_voucher_history->loadVoucherCurrencyList();

        $result     = "<option value=''>-- Choose Currency --</option>";

        foreach ($currency as $item) {
            $result .= "<option value='$item->Currency'>$item->Currency</option>";
        }

        echo $result;
    }

    function loadVoucherLocationListOption()
    {
        $currency           = $this->M_voucher_history->loadVoucherLocationList();

        $result     = "<option value=''>-- Choose Location --</option>";

        foreach ($currency as $item) {
            $result .= "<option value='$item->location_id'>$item->location_name</option>";
        }

        echo $result;
    }

    function loadVoucherPeriodListOption()
    {
        $period           = $this->M_voucher_history->loadVoucherPeriodList();

        $result     = "<option value=''>-- Choose Period --</option>";

        foreach ($period as $item) {
            $result .= "<option value='$item->period'>$item->period</option>";
        }

        echo $result;
    }

    function loadVoucherEmployeeListOption()
    {
        $employee           = $this->M_voucher_history->loadVoucherEmployeeList();

        $result     = "<option value='ALL'>-- All Employee --</option>";

        foreach ($employee as $item) {
            $result .= "<option value='$item->created_by'>$item->employee_name</option>";
        }

        echo $result;
    }

    function excel()
    {
        $this->load->library('Excel');

        $objPHPExcel = new PHPExcel();

        $objPHPExcel->getProperties()->setCreator("IT DEV ZIPCO");
        $objPHPExcel->getProperties()->setLastModifiedBy("IT DEV ZIPCO");
        $objPHPExcel->getProperties()->setTitle("VOUCHER HISTORY LIST");
        // $objPHPExcel->getProperties()->setSubject("Content Subject");
        // $objPHPExcel->getProperties()->setDescription("Content Description");

        //activate worksheet number 1
        $objPHPExcel->setActiveSheetIndex(0);
        //name the worksheet
        $objPHPExcel->getActiveSheet()->setTitle('VOUCHER HISTORY LIST');

        //Setting Width
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(60);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(30);


        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'VOUCHER HISTORY LIST');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'ACCOUNTING STORAGE SYSTEM');
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Export Date ' . date("Y-m-d H:i:s"));

        //Header
        $objPHPExcel->getActiveSheet()->setCellValue('A5', 'NO');
        $objPHPExcel->getActiveSheet()->setCellValue('B5', 'DATE');
        $objPHPExcel->getActiveSheet()->setCellValue('C5', 'EMPLOYEE NAME');
        $objPHPExcel->getActiveSheet()->setCellValue('D5', 'TYPE');
        $objPHPExcel->getActiveSheet()->setCellValue('E5', 'VOUCHER NO');
        $objPHPExcel->getActiveSheet()->setCellValue('F5', 'PAYMENT TO');
        $objPHPExcel->getActiveSheet()->setCellValue('G5', 'PARTICULARS');
        $objPHPExcel->getActiveSheet()->setCellValue('H5', 'BANK NAME');
        $objPHPExcel->getActiveSheet()->setCellValue('I5', 'CURRENCY');
        $objPHPExcel->getActiveSheet()->setCellValue('J5', 'LOCATION');

        $row        = 6;
        $no         = 1;

        $data       = $this->M_voucher_history->loadVoucherHistoryList();

        if ($data) {
            foreach ($data as $i) {
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $no);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $i->date);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $i->employee_name);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $i->type);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $i->VoucherNo);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $i->PaymentTo);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $i->Particulars);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $i->BankName);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $i->Currency);
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, $i->location_name);
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
        $objPHPExcel->getActiveSheet()->getStyle('A5:J' . $row)->applyFromArray($styleArray);
        unset($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('A5:J5')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => '68a7d9')));
        $objPHPExcel->getActiveSheet()->getStyle('A1:J5')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A5:J' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A5:J' . $row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('F5:G' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(false);


        $filename = 'VOUCHER_HISTORY_' . time() . '.xls'; //save our workbook as this file name


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


        $this->load->library('Pdf');

        $pdf = new FPDF1('P', 'mm', 'A4'); // ukuran kertas atau  new FPDF('P','mm','A4');  
        $pdf->AddPage('portrait');
        $pdf->setTitle('VOUCHER HISTORY');
        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(190, 5, 'VOUCHER HISTORY', 0, 1, 'L');
        $pdf->SetFont('Times', 'I', 10);
        $pdf->Cell(190, 5, 'Accounting Storage System', 0, 1, 'L');
        $pdf->SetFont('Times', 'B', 6);

        $pdf->Cell(190, 1, '', 0, 1, 'L');
        $pdf->Cell(190, 1, '', 0, 1, 'L');


        $pdf->Cell(5, 4, 'NO', 1, 0, 'C');
        $pdf->Cell(15, 4, 'DATE', 1, 0, 'C');
        $pdf->Cell(34, 4, 'EMPLOYEE NAME', 1, 0, 'L');
        $pdf->Cell(13, 4, 'TYPE', 1, 0, 'C');
        $pdf->Cell(20, 4, 'VOUCHER NO', 1, 0, 'C');
        $pdf->Cell(45, 4, 'PAYMENT TO', 1, 0, 'L');
        $pdf->Cell(15, 4, 'BANK NAME', 1, 0, 'C');
        $pdf->Cell(14, 4, 'CURRENCY', 1, 0, 'C');
        $pdf->Cell(29, 4, 'LOCATION', 1, 1, 'C');

        $no         = 1;

        $data       = $this->M_voucher_history->loadVoucherHistoryList();

        $pdf->SetFont('Times', '', 6);
        if ($data) {
            foreach ($data as $i) {
                $pdf->Cell(5, 4, $no, 1, 0, 'C');
                $pdf->Cell(15, 4, $i->date, 1, 0, 'C');
                $pdf->Cell(34, 4, $i->employee_name, 1, 0, 'L');
                $pdf->Cell(13, 4, $i->type, 1, 0, 'C');
                $pdf->Cell(20, 4, $i->VoucherNo, 1, 0, 'C');
                $pdf->Cell(45, 4, $i->PaymentTo, 1, 0, 'L');
                $pdf->Cell(15, 4, $i->BankName, 1, 0, 'C');
                $pdf->Cell(14, 4, $i->Currency, 1, 0, 'C');
                $pdf->Cell(29, 4, $i->location_name, 1, 1, 'C');



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

        $pdf->Output('VOUCHER_HISTORY_' . date("YmdHis") . '.pdf', 'I');
    }

    /**
     * API - Auto Complete Payment To Register Voucher
     */
    function getPaymentToArray()
    {
        $response_data          = array();

        $PaymentTo           = $this->M_voucher_history->loadPaymentToListOption();

        if ($PaymentTo) {
            foreach ($PaymentTo as $item) {
                $response_data[]    = $item->PaymentTo;
            }
        }

        echo json_encode($response_data);
    }
}
