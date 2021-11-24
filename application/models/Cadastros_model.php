<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class Cadastros_model extends MY_Model
{

    public $table = 'tb_cadastro';
    public $primary_key = 'cadastro_id';
    public $select_column = array('cadastro_id', 'cad_ug', 'cpf', 'nome', 'situacao_id', 'tb_situacao.situacao AS situacao', 'posto_id', 'tb_posto.posto AS posto', 'instituidor', 'nr', 'grupo_saque', 'tb_grupo_de_saque.grupo_de_saque AS saque', 'posto_instituidor_id', 'tb_posto_inst.posto_inst AS posto_instituidor', 'cpf_instituidor', 'banco', 'tb_bancos.codigo_comp AS banco_c', 'agencia', 'conta_corrente');

    public $order_column = array(null, 'cadastro_id', 'nome', 'cpf');
    public $timestamps = false;

    public function __construct()
    {
        parent::__construct();
		$this->has_one['saque'] = array('Saque_model','id_grupo','grupo_saque');
		$this->has_one['situacao'] = array('Situacao_model', 'id_situacao', 'situacao_id');
		$this->has_one['banco_c'] = array('Banco_model', 'banco_id', 'banco');
		$this->has_one['posto'] = array('Posto_model', 'id_posto', 'posto_id');
		$this->has_one['posto_inst'] = array('Postoinst_model', 'id_posto_inst', 'posto_instituidor_id');
    }

    public function get_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
		$this->db->join('tb_posto', 'posto_id = tb_posto.id_posto', 'left');
		$this->db->join('tb_situacao', 'situacao_id = tb_situacao.id_situacao', 'left');
		$this->db->join('tb_grupo_de_saque', 'grupo_saque = tb_grupo_de_saque.id_grupo', 'left');
		$this->db->join('tb_posto_inst', 'posto_instituidor_id = tb_posto_inst.id_posto_inst', 'left');
		$this->db->join('tb_bancos', 'banco = tb_bancos.banco_id', 'left');
        if (isset($_POST["search"]["value"])) {
            $this->db->like("cpf", $_POST["search"]["value"]);
            $this->db->or_like("nome", $_POST["search"]["value"]);
        }
        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('cadastro_id', 'ASC');
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

    public function delete_many($items)
    {
        $this->db->where_in($this->primary_key, $items);
        return $this->db->delete($this->table);
    }

	function pesquisar($termo)
    {
        $data = array();
        // buscando cadastros
        $this->db->like('cpf', $termo);
		$this->db->or_like('nome', $termo);
        $this->db->where('cad_ug', $this->session->userdata('om_id'));
        $this->db->limit(10);
        return $this->db->get($this->table)->result();
	}
	
	function busca_beneficiado($cpf)
	{
		$this->db->select('tb_cadastro.nome, tb_bancos.codigo_comp AS banco, tb_cadastro.agencia, tb_cadastro.conta_corrente');
		$this->db->from($this->table);
		$this->db->join('tb_bancos', 'tb_cadastro.banco = tb_bancos.banco_id', 'left');
		$this->db->where('tb_cadastro.cpf', $cpf);
		$this->db->where('tb_cadastro.cad_ug', $this->session->userdata('om_id'));
		return $this->db->get()->row();
	}

}

/* End of file Cadastros_model.php */
/* Location: ./application/models/Cadastros_model.php */
