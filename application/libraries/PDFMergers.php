<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . "/libraries/PDFMerger.php";

class PDFMergers extends PDFMerger
{
    public function __construct()
    {
        parent::__construct();
    }
}
