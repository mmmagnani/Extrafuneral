<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class Gestor_model extends MY_Model
{

    public $table = 'tb_gestores';
    public $primary_key = 'id_gestores';
    public $select_column = array('id_gestores', 'gestores_ug',  'ordenador', 'agente', 'financas', 'contabilidade', 'cargo', 'delegado', 'tb_ug.sigla_ug AS sigla_ug');

    public $order_column = array('id_gestores', 'sigla_ug',  'ordenador', 'agente', 'financas', 'contabilidade', );
    public $timestamps = false;

    public function __construct()
    {
        parent::__construct();
		
		$this->has_one['ug'] = array('Ug_model', 'id_ug', 'gestores_ug');
    }
	
    public function get_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
		$this->db->join('tb_ug', 'tb_gestores.gestores_ug = tb_ug.id_ug', 'left');
        if (isset($_POST["search"]["value"])) {
            $this->db->like("id_gestores", $_POST["search"]["value"]);
            $this->db->or_like("ordenador", $_POST["search"]["value"]);
			$this->db->or_like("agente", $_POST["search"]["value"]);
			$this->db->or_like("financas", $_POST["search"]["value"]);
			$this->db->or_like("contabilidade", $_POST["search"]["value"]);
        }
        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_gestores', 'ASC');
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

/* End of file Gestor_model.php */
/* Location: ./application/models/Gestor_model.php */
