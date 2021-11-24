<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class Tipo_model extends MY_Model
{

    public $table = 'tb_tipo';
    public $primary_key = 'id_tipo';
    public $select_column = array('id_tipo', 'Tipo', 'isFe', 'active');

    public $order_column = array('id_tipo', 'Tipo', 'isFe', null);
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
            $this->db->like("id_tipo", $_POST["search"]["value"]);
            $this->db->or_like("Tipo", $_POST["search"]["value"]);
        }
        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_tipo', 'ASC');
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
	
	function get_all($where=NULL)
	{
		if(isset($where))
        {
				$this->db->where($where);
		}

		$query = $this->db->get('tb_tipo');
		if($query->num_rows() > 0)
            {
                $data = $query->result_array();
                $data = $this->trigger('after_get', $data);
                $data = $this->_prep_after_read($data,TRUE);
                $this->_write_to_cache($data);
                return $data;
            }
            else
            {
                return FALSE;
            }
	}


}

/* End of file Tipo_model.php */
/* Location: ./application/models/Tipo_model.php */
