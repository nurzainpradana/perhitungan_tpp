
<?php
defined('BASEPATH') or exit('No Direct script access allowed');

class M_voucher_out extends CI_Model
{

    var $table      = "dbo.storage_voucher_registered VR";
    var $column     = array("", "VoucherNo", "PaymentTo", "BankName", "Currency", "location_name");
    var $order      = array("VoucherNo" => "asc", "out_date" => "asc");

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->search   = '';
    }

    private function _get_datatables_query()
    {
        $this->db->select("VR.*, L.factory, L.location, L.location_name, (SELECT TOP 1 employee_name FROM ZipcoAdm.dbo.V_user WHERE ZipcoAdm.dbo.V_user.user_id = out_by) employee_name,
        (SELECT TOP 1 email FROM ZipcoAdm.dbo.MT_User WHERE ZipcoAdm.dbo.MT_User.user_id = out_by) email");
        $this->db->from($this->table);
        $this->db->join("storage_location L", "L.id = VR.location_id", "left");
        $this->db->where("VR.status", 0);

        if ($this->input->post("PaymentTo")) {
            $this->db->where("PaymentTo", $this->input->post("PaymentTo"));
        }

        if ($this->input->post("BankName")) {
            $this->db->where("BankName", $this->input->post("BankName"));
        }

        if ($this->input->post("Currency")) {
            $this->db->where("Currency", $this->input->post("Currency"));
        }

        if ($this->input->post("Factory")) {
            $this->db->where("Factory", $this->input->post("Factory"));
        }

        if ($this->input->post("Location")) {
            $this->db->where("Location", $this->input->post("Location"));
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


    function loadVoucherOutList()
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
        $this->db->where("status", 0);
        return $this->db->count_all_results();
    }

    public function loadVoucherBankList()
    {
        return $this->db->query("SELECT DISTINCT BankName FROM dbo.storage_voucher_registered
        WHERE status = 0
        ORDER BY BankName ASC
        ")->result();
    }

    public function loadVoucherCurrencyList()
    {
        return $this->db->query("SELECT DISTINCT Currency FROM dbo.storage_voucher_registered
        WHERE status = 0
        ORDER BY Currency ASC
        ")->result();
    }

    public function loadVoucherPaymentToList()
    {
        return $this->db->query("SELECT DISTINCT PaymentTo FROM dbo.storage_voucher_registered
        WHERE status = 0
        ORDER BY PaymentTo ASC
        ")->result();
    }

    public function loadVoucherLocationList()
    {
        return $this->db->query("
        SELECT DISTINCT location 
        FROM storage_voucher_registered VR 
        LEFT JOIN storage_location L ON L.id = VR.location_id
        WHERE VR.status = 0
        ORDER BY location ASC
        ")->result();
    }

    public function loadVoucherFactoryList()
    {
        return $this->db->query("
        SELECT DISTINCT factory 
        FROM storage_voucher_registered VR 
        LEFT JOIN storage_location L ON L.id = VR.location_id
        WHERE VR.status = 0
        ORDER BY factory ASC
        ")->result();
    }

    public function return($data)
    {
        $sp         = "sp_voucherreturn ?,?";
        $query     = $this->db->query($sp, $data);

        return $query->first_row();
    }

    function loadPaymentToListOption()
    {
        return $this->db->query("SELECT DISTINCT VR.PaymentTo FROM storage_voucher_registered VR WHERE status = 0 ORDER BY VR.PaymentTo ASC")->result();
    }
}
