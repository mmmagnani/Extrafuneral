<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class Banco_model extends MY_Model
{

    public $table = 'tb_bancos';
    public $primary_key = 'banco_id';
    public $select_column = array('banco_id', 'codigo_comp', 'nome_instituicao', 'ativo');

    public $order_column = array('banco_id', 'codigo_comp', 'nome_instituicao', null);
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
            $this->db->like("banco_id", $_POST["search"]["value"]);
            $this->db->or_like("codigo_comp", $_POST["search"]["value"]);
			$this->db->or_like("nome_instituicao", $_POST["search"]["value"]);
        }
        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('banco_id', 'ASC');
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
	public function get_banco($cod)
	{
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->where('codigo_comp', $cod);
		return $this->db->get()->row();
	}

}

/* End of file Banco_model.php */
/* Location: ./application/models/Banco_model.php */
