<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_voucher_history extends CI_Model
{
    var $table      = "v_storage_voucher_history";
    var $column     = array("date", "employee_name", "Type",  "VoucherNo", "PaymentTo", "BankName", "Currency", "location_name", "location_id");
    var $order      = array("created_date" => "DESC");

    var $start_date;
    var $end_date;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->search   = '';

        $this->start_date     = date("Y-m");
        $this->start_date     = "$this->start_date-01";

        $this->end_date       = date("Y-m-d");
    }

    private function _get_datatables_query()
    {
        $this->db->from($this->table);
        // $this->db->join("storage_location", "storage_location.id = storage_voucher_history", "left");

        if ($this->input->post("PaymentTo")) {
            $this->db->where("PaymentTo", $this->input->post("PaymentTo"));
        }

        if ($this->input->post("BankName")) {
            $this->db->where("BankName", $this->input->post("BankName"));
        }

        if ($this->input->post("Currency")) {
            $this->db->where("Currency", $this->input->post("Currency"));
        }

        if ($this->input->post("Location")) {
            $this->db->where("location_id", $this->input->post("Location"));
        }

        if ($this->input->post("Employee") && $this->input->post("Employee") != "ALL") {
            $this->db->where("created_by", $this->input->post("Employee"));
        }

        if ($this->input->post("Period")) {
            $this->db->where("period", $this->input->post("Period"));
        }

        if ($this->input->post("Type")) {
            $this->db->where("type", $this->input->post("Type"));
        }

        if ($this->input->post("StartDate") && $this->input->post("EndDate")) {
            $this->db->where("date >=", $this->input->post('StartDate'));
            $this->db->where("date <=", $this->input->post('EndDate'));
        } else {
            $this->db->where("date >=", $this->start_date);
            $this->db->where("date <=", $this->end_date);
        }

        $i          = 0;
        foreach ($this->column as $item) {
            if (isset($_POST['search'])) {
                if ($_POST['search']['value']) ($i === 0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);
                $column[$i]     = $item;
            }

            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        // else if(isset($this->order))
        // {
        //     $order      = $this->order;

        //     $this->db->order_by(key($order), $order[key($order)]);
        // }

        $this->db->order_by("created_date", "desc");
    }

    function loadVoucherHistoryList()
    {
        $this->_get_datatables_query();

        if (isset($_POST['length'])) {
            if ($_POST['length'] != -1)
                $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query      = $this->db->get();

        return $query->result();
    }

    function count_filtered()
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
        return $this->db->query("SELECT DISTINCT BankName FROM $this->table
        WHERE BankName IS NOT NULL
        ORDER BY BankName ASC
        ")->result();
    }

    public function loadVoucherCurrencyList()
    {
        return $this->db->query("SELECT DISTINCT Currency FROM $this->table
        WHERE Currency IS NOT NULL
        ORDER BY Currency ASC
        ")->result();
    }

    public function loadVoucherPaymentToList()
    {
        return $this->db->query("SELECT DISTINCT PaymentTo FROM $this->table
        WHERE PaymentTo IS NOT NULL AND status = 0
        ORDER BY PaymentTo ASC
        ")->result();
    }

    public function loadVoucherLocationList()
    {
        return $this->db->query("
        SELECT DISTINCT l.location_name, VH.location_id
        FROM storage_voucher_history VH
		LEFT JOIN storage_location l ON l.id = VH.location_id
        WHERE l.location_name IS NOT NULL
        ORDER BY l.location_name ASC
        ")->result();
    }

    public function loadVoucherPeriodList()
    {
        return $this->db->query("
        SELECT DISTINCT period
        FROM $this->table
        ORDER BY period ASC
        ")->result();
    }

    public function loadVoucherEmployeeList()
    {
        return $this->db->query("
        SELECT DISTINCT employee_name, created_by
        FROM storage_voucher_history
		LEFT JOIN ZipcoAdm.dbo.V_User u ON u.user_id = storage_voucher_history.created_by
        ORDER BY employee_name ASC
        ")->result();
    }

    function loadPaymentToListOption()
    {
        return $this->db->query("SELECT DISTINCT PaymentTo FROM v_storage_voucher_history ORDER BY PaymentTo ASC")->result();
    }
}
