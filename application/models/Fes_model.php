<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class Fes_model extends MY_Model
{
    public $table = 'tb_registros';
    public $primary_key = 'registro_id';
    public $select_column = array('registro_id', 'reg_ug', 'tb_registros.cpf', 'tb_cadastro.nome AS nome', 'numero_ob', 'data_ob', 'valor', 'resgatado', 'tipo_id', 'ano', 'observacao', 'nr_cautela', 'emissao', 'tb_registros.grupo_saque', 'registro_fe', 'justificativa_reg_fe', 'amparo_id', 'bol_conce', 'mes_resgate', 'num_msg_siafi_aut', 'num_msg_siafi_sol', 'tb_tipo.Tipo AS tipo', 'tb_grupo_de_saque.grupo_de_saque AS saque', 'tb_bancos.codigo_comp AS banco_c', 'tb_cadastro.agencia AS agencia', 'tb_cadastro.conta_corrente AS conta_corrente', 'tb_bancos.nome_instituicao AS banco_n');
    public $order_column = array(null,'registro_id', 'cpf', 'nr_cautela', 'tipo', 'valor');
    public $timestamps = false;

    public function __construct()
    {
        parent::__construct();
		
		$this->has_one['cadastro'] = array('Cadastros_model', 'cpf', 'cpf');
		$this->has_one['saque'] = array('Saque_model','id_grupo','grupo_saque');
		$this->has_one['tipo'] = array('Tipo_model', 'id_tipo', 'tipo_id', 'isFe');
    }

    public function get_query()
    {		
        $this->db->select($this->select_column);
        $this->db->from($this->table);
		$this->db->join('tb_cadastro', 'tb_registros.cpf = tb_cadastro.cpf');		
		$this->db->join('tb_tipo', 'tipo_id = tb_tipo.id_tipo', 'left');
		$this->db->join('tb_bancos', 'tb_cadastro.banco = tb_bancos.banco_id', 'left');		
		$this->db->join('tb_grupo_de_saque', 'tb_registros.grupo_saque = tb_grupo_de_saque.id_grupo', 'left');
        $this->db->where('reg_ug', $this->session->userdata('om_id'));
		$this->db->where('tb_tipo.isFe', '1');
		//$this->db->where('tb_tipo.active', '1');	
		$this->db->where('ano', $this->session->userdata('anofiscal'));	
        if (isset($_POST["search"]["value"])) {
			$this->db->group_start();
            $this->db->like("tb_registros.cpf", $_POST["search"]["value"]);
            $this->db->or_like("nr_cautela", $_POST["search"]["value"]);
			$this->db->or_like("tipo", $_POST["search"]["value"]);
			$this->db->group_end();
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('cpf', 'ASC');
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
	
	public function get_one($id)
	{
		$this->db->select('tb_registros.cpf, tb_cadastro.nome AS nome, tb_cadastro.banco AS banco, tb_cadastro.agencia AS agencia, tb_cadastro.conta_corrente AS conta_corrente, tb_cadastro.instituidor AS instituidor, tb_registros.numero_ob, tb_registros.data_ob, tb_registros.resgatado, tb_registros.nr_cautela, tb_registros.emissao, tb_registros.registro_fe, tb_registros.justificativa_reg_fe, tb_registros.valor, tb_registros.tipo_id, tb_registros.ano, tb_registros.observacao, tb_registros.grupo_saque');
		$this->db->from($this->table);
		$this->db->join('tb_cadastro', 'tb_registros.cpf = tb_cadastro.cpf', 'left');
				$this->db->where('tb_registros.reg_ug', $this->session->userdata('om_id')); 
		$this->db->where('tb_registros.registro_id', $id);
		return $this->db->get()->row();
	}

	function pesquisar($termo)
    {
        
        // buscando FEs
        $this->db->join('tb_tipo', 'tb_registros.tipo_id = tb_tipo.id_tipo');
		$this->db->group_start();
        $this->db->like('cpf', $termo);
		$this->db->or_like('nr_cautela', $termo);
		$this->db->group_end();
        $this->db->where('reg_ug', $this->session->userdata('om_id'));
		$this->db->where('tb_tipo.isFe', '1');
		$this->db->where('ano', $this->session->userdata('anofiscal'));
        $this->db->limit(10);
        $query = $this->db->get('tb_registros');
		return $query->result();
	}
}

/* End of file Fes_model.php */
/* Location: ./application/models/Fes_model.php */
