<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class Ug_model extends MY_Model
{

    public $table = 'tb_ug';
    public $primary_key = 'id_ug';
    public $select_column = array('id_ug', 'sigla_ug',  'nome_ug', 'cod_ug', 'local_ug');

    public $order_column = array('id_ug', 'sigla_ug', 'nome_ug', 'cod_ug', 'local_ug');
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
            $this->db->like("id_ug", $_POST["search"]["value"]);
            $this->db->or_like("sigla_ug", $_POST["search"]["value"]);
        }
        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_ug', 'ASC');
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
	
	public function get_ug()
	{
		$this->db->where('id_ug', $this->session->userdata('om_id'));
		return $this->db->get('tb_ug')->row();
	}


}

/* End of file Ug_model.php */
/* Location: ./application/models/Ug_model.php */
