<?php
defined('BASEPATH') or exit('No Direct script access allowed');

class M_voucher_disposal extends CI_Model
{
    var $table      = "dbo.storage_voucher_disposal";
    var $column     = array("", "VoucherNo", "created_date");
    var $order      = array("created_date" => "desc");


    var $start_date;
    var $end_date;

    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->search       = '';


        $this->start_date     = date("Y-m");
        $this->start_date     = "$this->start_date-01";

        $this->end_date       = date("Y-m-d");
    }

    public function _get_datatables_query()
    {
        $this->db->from($this->table);

        if ($this->input->post("Date")) {
            $this->db->like("Datetime", $this->input->post("Date"));
        }

        if ($this->input->post("PaymentTo")) {
            $this->db->where("PaymentTo", $this->input->post("PaymentTo"));
        }

        if ($this->input->post("BankName")) {
            $this->db->where("BankName", $this->input->post("BankName"));
        }

        if ($this->input->post("Currency")) {
            $this->db->where("Currency", $this->input->post("Currency"));
        }

        if ($this->input->post("StartDate") && $this->input->post("EndDate")) {
            $this->db->where("FORMAT(created_date, 'yyyy-MM-dd') >=", $this->input->post('StartDate'));
            $this->db->where("FORMAT(created_date, 'yyyy-MM-dd') <=", $this->input->post('EndDate'));
        } else {
            $this->db->where("FORMAT(created_date, 'yyyy-MM-dd') >=", $this->start_date);
            $this->db->where("FORMAT(created_date, 'yyyy-MM-dd') <=", $this->end_date);
        }


        $i       = 0;

        foreach ($this->column as $item) {
            if (isset($_POST['search'])) {
                if ($_POST['search']['value']) ($i === 0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);
                $column[$i]     = $item;
            }

            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order      = $this->order;

            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function loadVoucherDisposalList()
    {
        $this->_get_datatables_query();

        if (isset($_POST['length'])) {
            if ($_POST['length'] != -1)
                $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query      = $this->db->get();

        return $query->result();
    }

    public function count_filtered()
    {
        $this->_get_datatables_query();

        $query  = $this->db->get();

        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function loadVoucherBankList()
    {
        return $this->db->query("SELECT DISTINCT BankName FROM dbo.storage_voucher_disposal
        WHERE status = 1
        ORDER BY BankName ASC
        ")->result();
    }

    public function loadVoucherCurrencyList()
    {
        return $this->db->query("SELECT DISTINCT Currency FROM dbo.storage_voucher_disposal
        WHERE status = 1
        ORDER BY Currency ASC
        ")->result();
    }

    public function loadVoucherPaymentToList()
    {
        return $this->db->query("SELECT DISTINCT PaymentTo FROM dbo.storage_voucher_disposal
        WHERE status = 1
        ORDER BY PaymentTo ASC
        ")->result();
    }

    public function restoreVoucher($data)
    {
        $sp         = "sp_voucherrestore ?,?,?";
        $query     = $this->db->query($sp, $data);

        return $query->first_row();
    }

    function loadPaymentToListOption()
    {
        return $this->db->query("SELECT DISTINCT PaymentTo FROM storage_voucher_disposal ORDER BY PaymentTo ASC")->result();
    }
}
