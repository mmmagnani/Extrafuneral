<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class Saque_model extends MY_Model
{

    public $table = 'tb_grupo_de_saque';
    public $primary_key = 'id_grupo';
    public $select_column = array('id_grupo', 'grupo_de_saque');

    public $order_column = array('id_grupo', 'grupo_de_saque');
    public $timestamps = false;

    public function __construct()
    {
        parent::__construct();
    }

    public function get_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        if (isset($_POST["search"]["value"])) {
            $this->db->like("id_grupo", $_POST["search"]["value"]);
            $this->db->or_like("grupo_de_saque", $_POST["search"]["value"]);
        }
        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_grupo', 'ASC');
        }
    }

    public function get_datatables()
    {
        $this->get_query();
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data()
    {
        $this->get_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_all_data()
    {
        $this->db->select("*");
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

}

/* End of file Saque_model.php */
/* Location: ./application/models/Saque_model.php */
