<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Test extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model(array('M_login', 'M_voucher_registered', 'M_test'));
    }

    function testFilter()
    {
        $filter_data            = array(
            'factory'       => "ZIP1",
            'location'      => "1",
            'column'        => "1",
            'row'           => "A"
        );

        foreach ($filter_data as $item) {
            echo $item;
            echo "<br>";
        }
    }

    function testEmail()
    {
        // Konfigurasi email
        $config = [
            'mailtype'      => 'html',
            'charset'       => 'utf-8',
            'protocol'      => 'smtp',

            'smtp_host'     => '10.246.6.24',
            'smtp_crypto'   => 'ssl',
            'smtp_port'     => 25,
            'crlf'          => "\r\n",
            'newline'       => "\r\n"
        ];

        // Load library email dan konfigurasinya
        $this->load->library('email', $config);

        // Email dan nama pengirim
        $this->email->from('zain.pradana@ykk.com', 'Zain Pradana');

        // Email penerima
        $this->email->to('zain.pradana@ykk.com'); // Ganti dengan email tujuan

        // Lampiran email, isi dengan url/path file
        $this->email->attach('https://images.pexels.com/photos/169573/pexels-photo-169573.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940');

        // Subject email
        $this->email->subject('Kirim Email dengan SMTP Gmail CodeIgniter | MasRud.com');

        // Isi email
        $this->email->message("Ini adalah contoh email yang dikirim menggunakan SMTP Gmail pada CodeIgniter.<br><br> Klik <strong><a href='https://masrud.com/kirim-email-codeigniter/' target='_blank' rel='noopener'>disini</a></strong> untuk melihat tutorialnya.");

        // Tampilkan pesan sukses atau error
        if ($this->email->send()) {
            echo 'Sukses! email berhasil dikirim.';
        } else {
            echo 'Error! email tidak dapat dikirim.';
            echo "<br>" . $this->email->print_debugger();
        }
    }

    function export_excel()
    {
        // $sdate = $_POST['sdate'];
        // $edate = $_POST['edate'];
        // $category = $_POST['category'];
        // $createdby = $_POST['created'];

        //load our new PHPExcel library
        $this->load->library('Excel');
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Laporan PPB');

        //Setting Width
        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(13);
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(50);
        $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
        $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('S')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('T')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('U')->setWidth(35);

        // $this->excel->getActiveSheet()->setCellValue('A1', 'Laporan Permintaan Pengadaan Barang');
        // $this->excel->getActiveSheet()->setCellValue('A2', 'Periode : '.$sdate.' /s.d/ '.$edate);
        // $this->excel->getActiveSheet()->setCellValue('A3', 'Category : '.$category);

        //Header
        $this->excel->getActiveSheet()->setCellValue('A5', 'NO');
        $this->excel->getActiveSheet()->mergeCells('A5:A6');
        $this->excel->getActiveSheet()->setCellValue('B5', 'PPB NO');
        $this->excel->getActiveSheet()->mergeCells('B5:B6');
        $this->excel->getActiveSheet()->setCellValue('C5', 'PPB DATE');
        $this->excel->getActiveSheet()->mergeCells('C5:C6');
        $this->excel->getActiveSheet()->setCellValue('D5', 'COST CENTRE ID');
        $this->excel->getActiveSheet()->mergeCells('D5:D6');
        $this->excel->getActiveSheet()->setCellValue('E5', 'COST CENTRE NAME');
        $this->excel->getActiveSheet()->mergeCells('E5:E6');
        $this->excel->getActiveSheet()->setCellValue('F5', 'CATEGORY');
        $this->excel->getActiveSheet()->mergeCells('F5:F6');
        $this->excel->getActiveSheet()->setCellValue('G5', 'ITEM CODE');
        $this->excel->getActiveSheet()->mergeCells('G5:G6');
        $this->excel->getActiveSheet()->setCellValue('H5', 'ITEM NAME');
        $this->excel->getActiveSheet()->mergeCells('H5:H6');
        $this->excel->getActiveSheet()->setCellValue('I5', 'QTY');
        $this->excel->getActiveSheet()->mergeCells('I5:I6');
        $this->excel->getActiveSheet()->setCellValue('J5', 'UNIT');
        $this->excel->getActiveSheet()->mergeCells('J5:J6');
        $this->excel->getActiveSheet()->setCellValue('K5', 'REQUEST');
        $this->excel->getActiveSheet()->mergeCells('K5:R5');
        $this->excel->getActiveSheet()->setCellValue('K6', 'DATE 1');
        $this->excel->getActiveSheet()->setCellValue('L6', 'QTY 1');
        $this->excel->getActiveSheet()->setCellValue('M6', 'DATE 2');
        $this->excel->getActiveSheet()->setCellValue('N6', 'QTY 2');
        $this->excel->getActiveSheet()->setCellValue('O6', 'DATE 3');
        $this->excel->getActiveSheet()->setCellValue('P6', 'QTY 3');
        $this->excel->getActiveSheet()->setCellValue('Q6', 'DATE 4');
        $this->excel->getActiveSheet()->setCellValue('R6', 'QTY 4');
        $this->excel->getActiveSheet()->setCellValue('S5', 'PO NUMBER');
        $this->excel->getActiveSheet()->mergeCells('S5:S5');
        $this->excel->getActiveSheet()->setCellValue('T5', 'PO DATE');
        $this->excel->getActiveSheet()->mergeCells('T5:T5');
        $this->excel->getActiveSheet()->setCellValue('U5', 'PO REMARK');
        $this->excel->getActiveSheet()->mergeCells('U5:U5');

        $norow = 7;

        // $data = $this->ppb->get_ppb_excel($sdate,$edate,$category,$createdby);

        // foreach($data->result_array() as $dt) {
        //     $this->excel->getActiveSheet()->setCellValue('A'.$norow, $norow-6);
        //     $this->excel->getActiveSheet()->getStyle('A'.$norow, $norow-6)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //     $this->excel->getActiveSheet()->setCellValue('B'.$norow, '');
        //     $this->excel->getActiveSheet()->setCellValue('C'.$norow, '');
        //     $this->excel->getActiveSheet()->setCellValue('D'.$norow, $dt['cost_centre']);
        //     $this->excel->getActiveSheet()->setCellValue('E'.$norow, $dt['CostCenterDesc']);
        //     $this->excel->getActiveSheet()->setCellValue('F'.$norow, $dt['category']);
        //     $this->excel->getActiveSheet()->setCellValue('G'.$norow, $dt['item_code']);
        //     $this->excel->getActiveSheet()->setCellValue('H'.$norow, $dt['item_name']);
        //     $this->excel->getActiveSheet()->setCellValue('I'.$norow, $dt['qty']);
        //     $this->excel->getActiveSheet()->setCellValue('J'.$norow, $dt['qty_unit']);
        //     $this->excel->getActiveSheet()->setCellValue('K'.$norow, $dt['del1']);
        //     $this->excel->getActiveSheet()->setCellValue('L'.$norow, $dt['qty1']);
        //     $this->excel->getActiveSheet()->setCellValue('M'.$norow, $dt['del2']);
        //     $this->excel->getActiveSheet()->setCellValue('N'.$norow, $dt['qty2']);
        //     $this->excel->getActiveSheet()->setCellValue('O'.$norow, $dt['del3']);
        //     $this->excel->getActiveSheet()->setCellValue('P'.$norow, $dt['qty3']);
        //     $this->excel->getActiveSheet()->setCellValue('Q'.$norow, $dt['del4']);
        //     $this->excel->getActiveSheet()->setCellValue('R'.$norow, $dt['qty4']);
        //     $this->excel->getActiveSheet()->setCellValue('S'.$norow, '');
        //     $this->excel->getActiveSheet()->setCellValue('T'.$norow, '');
        //     $this->excel->getActiveSheet()->setCellValue('U'.$norow, '');

        //     $norow++;
        // }


        $norow = $norow - 1;
        //Border
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

        //Setting CELL
        $this->excel->getActiveSheet()->getStyle('A5:U' . $norow)->applyFromArray($styleArray);
        unset($styleArray);
        $this->excel->getActiveSheet()->getStyle('A5:U6')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => '0099cc')));
        $this->excel->getActiveSheet()->getStyle('A1:U6')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A5:U6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A5:U6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $filename = 'Laporan PPB ' . date('Ymd His') . '.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' 
        //(and adjust the filename extension, also the header mime type)

        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }

    function pdf()
    {
        $this->load->library("fpdf2");

        function GenerateWord()
        {
            // Get a random word
            $nb = rand(3, 10);
            $w = '';
            for ($i = 1; $i <= $nb; $i++)
                $w .= chr(rand(ord('a'), ord('z')));
            return $w;
        }

        function GenerateSentence($words = 500)
        {
            // Get a random sentence
            $nb = rand(20, $words);
            $s = '';
            for ($i = 1; $i <= $nb; $i++)
                $s .= GenerateWord() . ' ';
            return substr($s, 0, -1);
        }

        $pdf = new fpdf2('P', 'pt');
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->MultiCell(0, 15, 'VOUCHER REGISTERED');
        $pdf->SetFont('Arial', 'I', 10);
        $pdf->MultiCell(0, 15, 'Accounting Storage System');

        $pdf->SetFont('Arial', '', 8);
        $pdf->tablewidths = array(90, 90, 90, 90, 90, 90);
        $data[] = array("No", "Voucher No", "Payment To", "Bank Name", "Currency", "Location");

        // $data       = $this->M_voucher_registered->getVoucherRegisteredExport();

        // foreach ($data as $i) {
        //     print_r($i);
        //     echo "<hr>";
        // }

        for ($i = 0; $i < 5; $i++) {
            $data[] = array(GenerateSentence(), GenerateSentence(), GenerateSentence(), GenerateSentence(), GenerateSentence(), GenerateSentence());
        }
        $pdf->morepagestable($data);
        $pdf->Output();
    }

    function GenerateWord()
    {
        // Get a random word
        $nb = rand(3, 10);
        $w = '';
        for ($i = 1; $i <= $nb; $i++)
            $w .= chr(rand(ord('a'), ord('z')));
        return $w;
    }

    function GenerateSentence($words = 500)
    {
        // Get a random sentence
        $nb = rand(20, $words);
        $s = '';
        for ($i = 1; $i <= $nb; $i++)
            $s .= $this->GenerateWord() . ' ';
        return substr($s, 0, -1);
    }

    function testt()
    {
        $this->GenerateSentence();
    }

    function testMerge()
    {
        // $this->load->library("fpdf2");

        $filename = "TEST";
        $fileout = 'upload/softcopy_scan.' . $filename;


        $this->load->library("fpdf_merge");
        $merge = new FPDF_Merge();
        // $merge->add($_SERVER['DOCUMENT_ROOT'] . "\upload\softcopy_scan\VCRSCN_O04_2207_006.pdf");
        // $merge->add($_SERVER['DOCUMENT_ROOT'] . "\upload\softcopy_scan\VCRSCN_O04_2207_025.pdf");
        // $merge->add("././upload/softcopy_scan/VCRSCN_O04_2207_006.pdf");
        // $merge->add("././upload/softcopy_scan/VCRSCN_O04_2207_025.pdf");

        // $merge->add("././upload/softcopy_scan/doc1.pdf");
        $merge->add("././upload/softcopy_scan/VCRSCN_O04_2207_005.pdf");
        // $merge->add("././upload/softcopy_scan/doc3.pdf");

        // $merge->add("VCRSCN_O04_2207_006.pdf");
        // $merge->add("VCRSCN_O04_2207_025.pdf");

        // $merge->add('.pdf');
        // $merge->add('doc2.pdf');
        $merge->output();
    }

    function testMerge2()
    {
        include APPPATH . '/libraries/PDFMerger.php';

        $pdf = new PDFMerger; // or use $pdf = new \PDFMerger; for Laravel

        // $pdf->addPDF($_SERVER['DOCUMENT_ROOT'] . "\upload\softcopy_scan\VCRSCN_O04_2207_006.pdf", '1, 3, 4');
        // $pdf->addPDF($_SERVER['DOCUMENT_ROOT'] . "\upload\softcopy_scan\VCRSCN_O04_2207_006.pdf", '1');
        // $pdf->addPDF($_SERVER['DOCUMENT_ROOT'] . "\upload\softcopy_scan\VCRSCN_O04_2207_006.pdf", '1');
        // $pdf->addPDF($_SERVER['DOCUMENT_ROOT'] . "\upload\softcopy_scan\VCRSCN_O04_2207_006.pdf", '1');


        $pdf->addPDF($_SERVER['DOCUMENT_ROOT'] . "\upload\softcopy_scan\O04-2108-275a.pdf", 'all');
        $pdf->addPDF($_SERVER['DOCUMENT_ROOT'] . "\upload\softcopy_scan\O04-2108-275b.pdf", 'all');





        // $pdf->addPDF('samplepdfs/two.pdf', '1-2');
        // $pdf->addPDF('samplepdfs/three.pdf', 'all');


        // $pdf->merge('file', 'samplepdfs/TEST2.pdf'); // generate the file

        // $pdf->merge('download', 'samplepdfs/test.pdf'); // force download

        $pdf->merge('file', $_SERVER['DOCUMENT_ROOT'] . "\upload\softcopy_scan\TEST2" . date("YmdHis") . ".pdf"); // generate the file

        // $pdf->merge('download', $_SERVER['DOCUMENT_ROOT'] . "\upload\softcopy_scan\test" . date("YmdHis") . ".pdf"); // force download

        // REPLACE 'file' WITH 'browser', 'download', 'string', or 'file' for output options

    }

    function loadSideBarMenu()
    {
        $role_id        = $this->M_test->loadMenuList('nzainpradana', 1, 0);

        $html_out       = "Test -> ";

        foreach ($role_id as $menu1) {

            if ($menu1->is_parent_menu == 1) {
                if ($menu1->url != "" && $menu1->url != null) {
                    $html_out .= "
                    <li class='nav-header'>
                        <a href='" . base_url() . $menu1->url . "' class='nav-link  " . $this->router->fetch_class() == 'Dashboard' ? 'active' : '' . ">
                            <i class='fa fa-home nav-icon'></i>
                            Dashboard
                        </a>
                    </li>
                    ";
                }



                echo ">$menu1->menu_name";
                echo "<br>";

                $child1        = $this->M_test->loadMenuList('nzainpradana', 2, $menu1->id);

                foreach ($child1 as $menu2) {
                    echo ">> $menu2->menu_name";
                    echo "<br>";
                    if ($menu2->is_parent_menu == 1) {
                        $child2        = $this->M_test->loadMenuList('nzainpradana', 3, $menu2->id);

                        foreach ($child2 as $menu3) {
                            echo ">>> $menu3->menu_name";
                            echo "<br>";
                        }
                    }
                }
            } else {
                if ($menu1->url != "" && $menu1->url != null) {
                    $html_out .= `
                    <li class="nav-header">$menu1->menu_name</li>
                    `;
                }

                echo "$menu1->menu_name";
                echo "<br>";
            }
            echo "<hr>";
        }


        return $html_out;
    }
}
