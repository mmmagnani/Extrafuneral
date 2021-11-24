<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class Relatorios_model extends MY_Model
{

    public $table = 'tb_registros';
    public $primary_key = 'registro_id';
    public $select_column = array('tb_registros.registro_id', 'tb_opcao.desc_opcao', 'tb_registros.nr_cautela', 'tb_cadastro.nome', 'tb_posto.posto', 'tb_registros.cpf', 'CONCAT(tb_registros.ano,"OB", tb_registros.numero_ob) AS OB', 'tb_registros.data_ob', 'FORMAT(tb_registros.valor,2,"de_DE") AS valor2', 'tb_tipo.Tipo');

    public $order_column = array('registro_id', 'desc_opcao', 'nr_cautela', 'nome', 'posto', 'cpf', 'OB', 'data_ob', 'valor2', 'Tipo');
    public $timestamps = false;

    public function __construct()
    {
        parent::__construct();

		$this->has_one['tipo'] = array('Tipo_model', 'id_tipo', 'tipo_id');
    }

    public function get_query($id=NULL)
    {		
        $this->db->select($this->select_column);
        $this->db->from($this->table);
		$this->db->join('tb_cadastro', 'tb_registros.cpf = tb_cadastro.cpf', 'left');
		$this->db->join('tb_posto', 'tb_cadastro.posto_id = tb_posto.id_posto', 'left');	
		$this->db->join('tb_tipo', 'tipo_id = tb_tipo.id_tipo', 'left');
		$this->db->join('tb_opcao', 'tb_registros.registro_fe = tb_opcao.opcao', 'left');		
		$this->db->where('tb_tipo.isFe', '1');
		$this->db->where('tb_registros.resgatado', 'N');
		$this->db->where('tb_registros.reg_ug', $this->session->userdata('om_id'));	
		$this->db->where('MONTH(tb_registros.data_ob) = '.$id);
        if (isset($_POST["search"]["value"])) {
			$this->db->group_start();
            $this->db->like("tb_registros.cpf", $_POST["search"]["value"]);
            $this->db->or_like("nr_cautela", $_POST["search"]["value"]);
			$this->db->or_like("nome", $_POST["search"]["value"]);
			$this->db->or_like("data_ob", $_POST["search"]["value"]);
			$this->db->or_like("Tipo", $_POST["search"]["value"]);
			$this->db->group_end();
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('cpf', 'ASC');
        }
    }

    public function get_datatables($id=NULL)
    {
        $this->get_query($id);
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data($id=NULL)
    {
        $this->get_query($id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_all_data($id=NULL)
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
	
	public function get_summary($id)
	{
		$this->db->select('tb_tipo.id_tipo,	tb_tipo.`Tipo`, SUM(tb_registros.valor) AS subtotal, extdb.tb_gestores.contabilidade');
		$this->db->from($this->table);
		$this->db->join('tb_tipo', 'tb_registros.tipo_id = tb_tipo.id_tipo', 'left');
		$this->db->join('tb_ug', 'tb_ug.id_ug = tb_registros.reg_ug', 'left');
		$this->db->join('tb_gestores', 'tb_gestores.gestores_ug = tb_ug.id_ug', 'left');
		$this->db->where('tb_tipo.isFe', '1'); 
		$this->db->where('tb_registros.resgatado', 'N'); 
		$this->db->where('MONTH(tb_registros.data_ob)', $id);
		$this->db->group_by('tb_tipo.id_tipo');
		$this->db->order_by('tb_registros.tipo_id', 'ASC');
		$this->db->order_by('tb_registros.nr_cautela', 'ASC');
		return $this->db->get()->result();
	}
	
	public function get_total($id)
	{
		$this->db->select('Sum(tb_registros.valor) AS total');
		$this->db->from($this->table);
		$this->db->join('tb_cadastro', 'tb_registros.cpf = tb_cadastro.cpf', 'left');
		$this->db->join('tb_tipo', 'tb_registros.tipo_id = tb_tipo.id_tipo', 'left');
		$this->db->where('tb_registros.reg_ug', $this->session->userdata('om_id'));
		$this->db->where('tb_registros.resgatado', 'N'); 
		$this->db->where('tb_tipo.isFe', '1'); 
		$this->db->where('MONTH(tb_registros.data_ob)', $id); 	
		return $this->db->get()->row();
	}
	public function get_locale()
	{
		$this->db->select('local_ug');
		$this->db->where('id_ug', $this->session->userdata('om_id'));
		return $this->db->get('tb_ug')->row();
	}
	
	public function instituidorCustom($order)
	{
		$this->db->select('tb_cadastro.cadastro_id, tb_cadastro.cad_ug, tb_cadastro.cpf AS cpf_instituido, tb_cadastro.nome AS instituido, tb_cadastro.posto_id, tb_cadastro.situacao_id, tb_cadastro.instituidor, tb_cadastro.nr, tb_cadastro.grupo_saque, tb_cadastro.cpf_instituidor, tb_cadastro.banco, tb_cadastro.agencia, tb_cadastro.conta_corrente, tb_posto_inst.posto_inst');
		$this->db->from('tb_cadastro');
		$this->db->join('tb_posto_inst', 'tb_cadastro.posto_instituidor_id = tb_posto_inst.id_posto_inst');
		$this->db->where('tb_cadastro.situacao_id IN (5, 6, 7)');
		$this->db->where('tb_cadastro.instituidor IS NOT NULL');
		$this->db->order_by($order, 'ASC');
		return $this->db->get()->result();
	}
	public function TiposFe()
	{
		$this->db->select('tb_tipo.Tipo', 'tb_tipo.id_tipo');
		$this->db->from('tb_tipo');
		$this->db->where('tb_tipo.isFe', '1');
		$this->db->where('tb_tipo.active', '1');
		$this->db->order_by('tb_tipo.id_tipo', 'ASC');
		return $this->db->get()->result();
	}

}

/* End of file Relatorios_model.php */
/* Location: ./application/models/Relatorios_model.php */
