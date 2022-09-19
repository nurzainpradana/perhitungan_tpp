<?php

class Pdf
{

    function __construct()
    {
        include_once APPPATH . '/third_party/pdf/fpdf1.php';
    }

    function shortText($text, $limit)
    {
        $result    = "";

        if (strlen($text) > $limit) {
            $result        = substr($text, 0, $limit) . " ...";
        } else {
            $result       = $text;
        }

        return $result;
    }
}
