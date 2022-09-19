
<?php
defined('BASEPATH') or exit('No Direct script access allowed');

class M_voucher_unregistered extends CI_Model
{

    var $table      = "dbo.RPA_BankBook BB";
    var $column     = array("", "BB.VouncherNo", "BB.PaymentTo", "BB.BankName", "BB.Currency");
    var $order      = array("BB.VouncherNo" => "asc");

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->search   = '';
    }

    public function loadVoucherBankList()
    {
        return $this->db->query("SELECT DISTINCT BB.BankName FROM dbo.RPA_BankBook BB
        LEFT JOIN dbo.storage_voucher_registered VR ON VR.VoucherNo =  BB.VouncherNo
        WHERE VR.id IS NULL
        ORDER BY BB.BankName ASC
        ")->result();
    }

    public function loadVoucherPaymentToList()
    {
        return $this->db->query("SELECT DISTINCT BB.PaymentTo FROM dbo.RPA_BankBook BB
        LEFT JOIN dbo.storage_voucher_registered VR ON VR.VoucherNo =  BB.VouncherNo
        WHERE VR.id IS NULL
        ORDER BY BB.PaymentTo ASC
        ")->result();
    }

    public function loadVoucherCurrencyList()
    {
        return $this->db->query("SELECT DISTINCT BB.Currency FROM dbo.RPA_BankBook BB
        LEFT JOIN dbo.storage_voucher_registered VR ON VR.VoucherNo =  BB.VouncherNo
        WHERE VR.id IS NULL
        ORDER BY BB.Currency ASC
        ")->result();
    }



    private function _get_datatables_query()
    {
        $this->db->select("BB.*");
        $this->db->from($this->table);
        $this->db->join("dbo.storage_voucher_registered VR", "VR.VoucherNo = BB.VouncherNo", "left");
        $this->db->group_start();
        $this->db->where("VR.id IS NULL");
        $this->db->group_end();

        if ($this->input->post("BankName")) {
            $this->db->where("BB.BankName", $this->input->post("BankName"));
        }

        if ($this->input->post("Currency")) {
            $this->db->where("BB.Currency", $this->input->post("Currency"));
        }

        if ($this->input->post("PaymentTo")) {
            $this->db->where("BB.PaymentTo", $this->input->post("PaymentTo"));
        }


        $i      = 0;

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


    function loadVoucherunregisteredList()
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

        $this->db->join("dbo.storage_voucher_registered VR", "VR.VoucherNo = BB.VouncherNo", "left");
        $this->db->where("VR.id IS NULL");
        return $this->db->count_all_results();
    }

    public function registerVoucher($data)
    {
        $sp         = "sp_voucherregister ?,?,?, ?";
        $query     = $this->db->query($sp, $data);

        return $query->first_row();
    }

    function loadPaymentToListOption()
    {
        return $this->db->query("SELECT DISTINCT BB.PaymentTo FROM RPA_BankBook BB LEFT JOIN storage_voucher_registered VR ON VR.VoucherNo = BB.VouncherNo WHERE ( VR.id IS NULL ) ORDER BY BB.PaymentTo ASC")->result();
    }
}
