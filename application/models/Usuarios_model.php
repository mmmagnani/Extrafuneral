<?php if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

class Usuarios_model extends MY_Model
{

    public $table = 'tb_usuario';
    public $primary_key = 'usu_id';
    public $select_column = array('usu_id', 'usu_ug','usu_nome', 'usu_email', 'usu_senha', 'usu_active', 'permissao_id', 'permissoes.nome as permissao');

    public $order_column = array('usu_id', 'usu_nome', 'usu_active', 'permissao_id',null);
    public $timestamps = false;

    public function __construct()
    {
        parent::__construct();
        $this->has_one['permissao'] = array('Permissoes_model','IdPermissao','permissao_id');
    }

    public function get_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        $this->db->join('permissoes', 'permissoes.IdPermissao = permissao_id', 'left');
        
        if (isset($_POST["search"]["value"])) {
            $this->db->like("usu_id", $_POST["search"]["value"]);
            $this->db->or_like("usu_nome", $_POST["search"]["value"]);
        }
        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('usu_id', 'ASC');
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

    public function total_rows($q = null)
    {
        if ($q) {

            $this->db->like('usu_id', $q);
            $this->db->or_like('usu_nome', $q);
        }
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function get_limit_data($limit, $start = 0, $q = null)
    {
        $this->db->order_by($this->primary_key, $this->order);
        if ($q) {

            $this->db->like('usu_id', $q);
            $this->db->or_like('usu_nome', $q);
        }

        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

}

/* End of file Usuarios_model.php */
/* Location: ./application/models/Usuarios_model.php */
