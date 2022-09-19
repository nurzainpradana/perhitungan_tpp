
<?php
defined('BASEPATH') or exit('No Direct script access allowed');

class M_voucher_registered extends CI_Model
{

    var $table      = "dbo.storage_voucher_registered";
    var $column     = array("", "VoucherNo", "PaymentTo", "BankName", "Currency", "location_name");
    var $order      = array("VoucherNo" => "asc");

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->search   = '';
    }





    private function _get_datatables_query()
    {
        $this->db->select("item_storage_code, storage_voucher_registered.id as voucher_id, VoucherNo, PaymentTo, Particulars, BankName, Currency, storage_location.location_name, softcopy_scan");
        $this->db->from("storage_voucher_registered");
        $this->db->join("storage_location", "storage_location.id = storage_voucher_registered.location_id", "left");
        $this->db->where("storage_voucher_registered.status", 1);

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


    function loadVoucherRegisteredList()
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
        $this->db->where("status", 1);
        return $this->db->count_all_results();
    }

    public function count_empty_scanfile()
    {
        $this->db->from($this->table);
        $this->db->where("softcopy_scan", NULL);
        return $this->db->count_all_results();
    }

    public function loadVoucherBankList()
    {
        return $this->db->query("SELECT DISTINCT BankName FROM dbo.storage_voucher_registered
        WHERE status = 1
        ORDER BY BankName ASC
        ")->result();
    }

    public function loadVoucherCurrencyList()
    {
        return $this->db->query("SELECT DISTINCT Currency FROM dbo.storage_voucher_registered
        WHERE status = 1
        ORDER BY Currency ASC
        ")->result();
    }

    public function loadVoucherPaymentToList()
    {
        return $this->db->query("SELECT DISTINCT PaymentTo FROM dbo.storage_voucher_registered
        WHERE status = 1
        ORDER BY PaymentTo ASC
        ")->result();
    }

    public function loadVoucherLocationList()
    {
        return $this->db->query("
        SELECT DISTINCT location 
        FROM storage_voucher_registered VR 
        LEFT JOIN storage_location L ON L.id = VR.location_id
        WHERE VR.status = 1
        ORDER BY location ASC
        ")->result();
    }

    public function loadVoucherFactoryList()
    {
        return $this->db->query("
        SELECT DISTINCT factory 
        FROM storage_voucher_registered VR 
        LEFT JOIN storage_location L ON L.id = VR.location_id
        WHERE VR.status = 1
        ORDER BY factory ASC
        ")->result();
    }

    public function out($data)
    {
        $sp         = "sp_voucherout ?,?";
        $query     = $this->db->query($sp, $data);

        return $query->first_row();
    }

    public function disposal($data)
    {
        $sp         = "sp_voucherdisposal ?,?,?";
        $query     = $this->db->query($sp, $data);

        return $query->first_row();
    }

    public function move($data)
    {
        $sp         = "sp_vouchermove ?,?,?";
        $query     = $this->db->query($sp, $data);

        return $query->first_row();
    }

    public function getVoucherRegisteredExport()
    {
        $this->db->select("storage_voucher_registered.item_storage_code, storage_voucher_registered.id as voucher_id, VoucherNo, PaymentTo, Particulars, BankName, Currency, storage_location.location_name, softcopy_scan");
        $this->db->from($this->table);
        $this->db->join("storage_location", "storage_location.id = storage_voucher_registered.location_id", "left");
        $this->db->where("storage_voucher_registered.status", 1);

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

        $this->db->order_by("storage_voucher_registered.id", "desc");

        return $this->db->get()->result();
    }

    function checkRoleDisposal($user_id)
    {
        return $this->db->query(
            "
            SELECT *
            FROM 
            storage_user su
            LEFT JOIN storage_user_role sur ON sur.id_user = su.id
            LEFT JOIN storage_role_menu srm ON srm.role_id = sur.role_id
            LEFT JOIN storage_menu sm ON sm.id = srm.menu_id 

            WHERE su.user_id = '$user_id' AND menu_name = 'DISPOSAL'
            "
        )->result();
    }

    function loadPaymentToListOption()
    {
        return $this->db->query("SELECT DISTINCT VR.PaymentTo FROM storage_voucher_registered VR WHERE status = 1 ORDER BY VR.PaymentTo ASC")->result();
    }
}
