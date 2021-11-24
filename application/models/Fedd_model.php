<?php

class Fedd_model extends CI_Model
{

    /**
     * author: Marcelo Magnani 
     * email: marcelommagnani@uol.com.br
     * 
     */

    function __construct()
    {
        parent::__construct();
    }


    function get($table, $fields, $where = '', $perpage = 0, $start = 0, $one = false,
        $array = 'array')
    {

        $this->db->select($fields);
        $this->db->from($table);
        $this->db->limit($perpage, $start);
        if ($where)
        {
            $this->db->where($where);
        }

        $query = $this->db->get();

        $result = !$one ? $query->result() : $query->row();
        return $result;
    }

    function getById($id)
    {
        $this->db->from('tb_usuario');
        $this->db->select('tb_usuario.*, permissoes.nome as permissao');
        $this->db->join('permissoes', 'permissoes.IdPermissao = tb_usuario.permissao_id',
            'left');
        $this->db->where('usu_id', $id);
        $this->db->limit(1);
        return $this->db->get()->row();
    }

    public function alterarSenha($newSenha, $oldSenha, $id)
    {

        $this->db->where('usu_id', $id);
        $this->db->limit(1);
        $usuario = $this->db->get('tb_usuario')->row();
		$oldsenha = password_hash($oldSenha, PASSWORD_DEFAULT);
        if (password_verify($oldsenha, $usuario->senha))
        {
            return false;
        } else
        {
            $this->db->set('usu_senha', password_hash($newSenha, PASSWORD_DEFAULT));
            $this->db->where('usu_id', $id);
            return $this->db->update('tb_usuario');
        }


    }

    function pesquisar($termo)
    {
        $data = array();
        // buscando cadastros
        $this->db->like('cpf', $termo);
		$this->db->or_like('nome', $termo);
        $this->db->where('cad_ug', $this->session->userdata('om_id'));
        $this->db->limit(10);
        $data['cadastros'] = $this->db->get('tb_cadastro')->result();

        // buscando fe
        
        $this->db->group_start();
        $this->db->like('cpf', $termo);
		$this->db->or_like('nr_cautela', $termo);
		$this->db->group_end();
        $this->db->where('reg_ug', $this->session->userdata('om_id'));
		$this->db->where('tb_tipo.isFe', '1');
		$this->db->where('ano', $this->session->userdata('anofiscal'));
        $this->db->limit(10);
        $data['fes'] = $this->db->get('tb_registros')->result();

        // buscando dd
        $this->db->group_start();
        $this->db->like('cpf', $termo);
		$this->db->or_like('nr_cautela', $termo);
		$this->db->group_end();
        $this->db->where('reg_ug', $this->session->userdata('om_id'));
		$this->db->where('tb_tipo.isFe', '0');
		$this->db->where('ano', $this->session->userdata('anofiscal'));
        $this->db->limit(10);
        $data['dds'] = $this->db->get('tb_registros')->result();

        return $data;


    }


    function add($table, $data)
    {
        $this->db->insert($table, $data);
        if ($this->db->affected_rows() == '1')
        {
            return true;
        }

        return false;
    }

    function edit($table, $data, $fieldID, $ID)
    {
        $this->db->where($fieldID, $ID);
        $this->db->update($table, $data);

        if ($this->db->affected_rows() >= 0)
        {
            return true;
        }

        return false;
    }

    function delete($table, $fieldID, $ID)
    {
        $this->db->where($fieldID, $ID);
        $this->db->delete($table);
        if ($this->db->affected_rows() == '1')
        {
            return true;
        }

        return false;
    }


    function count($table)
    {
        $query = $this->db->query('SELECT COUNT(*) AS ' . $this->db->escape_identifiers
            ('numrows') . ' FROM ' . $table . ' WHERE om_id = ' . $this->session->userdata('om_id') .
            ' AND  situacao = 1');
        if ($query->num_rows() === 0)
        {
            return 0;
        }

        $query = $query->row();
        return (int)$query->numrows;

    }


    public function check_credentials($email)
    {
        $this->db->where('usu_email', $email);
        $this->db->where('usu_active', 1);
        $this->db->limit(1);
        return $this->db->get('tb_usuario')->row();
    }
}
