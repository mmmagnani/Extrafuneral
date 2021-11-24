<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}


    /**
     * author: Marcelo Magnani 
     * email: marcelommagnani@uol.com.br
     * 
     */

class Bancos extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if ((!session_id()) || (!$this->session->userdata('logado'))) {
            redirect('fedd/login');
        }

        $this->load->model('Banco_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        if (!$this->permission->check($this->session->userdata('permissao'), 'cBancos')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_view') . ' ' . $this->lang->line('bancos'));
            redirect(base_url());
        }

        $data['view'] = 'banco/banco_list';
        $this->load->view('tema/topo', $data, false);
    }

    public function datatable()
    {

        if (!$this->permission->check($this->session->userdata('permissao'), 'cBancos')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_view') . ' ' . $this->lang->line('bancos'));
            redirect(base_url());
        }

        $this->load->model('Banco_model');
        $result_data = $this->Banco_model->get_datatables();
        $data = array();

        foreach ($result_data as $row) {
            $line = array();

            $line[] = $row->banco_id;
            $line[] = $row->codigo_comp;
			$line[] = $row->nome_instituicao;
            $line[] = $row->ativo ? $this->lang->line('app_active') : $this->lang->line('app_inactive');

            $color = $row->ativo ? 'btn-danger' : 'btn-success';
            $icon = $row->ativo ? 'fa fa-window-close' : 'fa fa-check';
            $title = $row->ativo ? $this->lang->line('app_disable') : $this->lang->line('app_activate');

            $line[] = '<a href="' . site_url('bancos/update/' . $row->banco_id) . '" class="btn btn-info" title="' . $this->lang->line('app_edit') . '"><i class="fa fa-edit"></i></a>
                       <a href="' . site_url('bancos/status/' . $row->banco_id) . '" class="btn '.$color.' delete" title="' . $title . '"><i class="'.$icon.'"></i></a>';
            $data[] = $line;
        }

        $output = array(
            'draw' => intval($this->input->post('draw')),
            'recordsTotal' => $this->Banco_model->get_all_data(),
            'recordsFiltered' => $this->Banco_model->get_filtered_data(),
            'data' => $data,
        );
        echo json_encode($output);
    }


    public function create()
    {
        if (!$this->permission->check($this->session->userdata('permissao'), 'cBancos')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_add') . ' ' . $this->lang->line('bancos'));
            redirect(base_url());
        }

        $data = array(
            'button' => '<i class="fa fa-plus"></i> ' . $this->lang->line('app_create'),
            'action' => site_url('bancos/create_action'),
            'banco_id' => set_value('banco_id'),
            'codigo_comp' => set_value('codigo_comp'),
            'nome_instituicao' => set_value('nome_instituicao'),
            'ativo' => set_value('ativo'),
        );

        $data['view'] = 'banco/banco_form';
        $this->load->view('tema/topo', $data, false);

    }

    public function create_action()
    {
        if (!$this->permission->check($this->session->userdata('permissao'), 'cBancos')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_add') . ' ' . $this->lang->line('bancos'));
            redirect(base_url());
        }

        $this->_rules();

        if ($this->form_validation->run() == false) {
            $this->create();
        } else {

            $data = array(
                'codigo_comp' => $this->input->post('codigo_comp', true),
                'nome_instituicao' => $this->input->post('nome_instituicao', true),
                'ativo' => $this->input->post('ativo', true),
            );

            $this->Banco_model->insert($data);
            $this->session->set_flashdata('success', $this->lang->line('app_add_message'));
            redirect(site_url('bancos'));
        }
    }

    public function update($id)
    {
        if (!is_numeric($id)) {
            $this->session->set_flashdata('error', $this->lang->line('app_not_found'));
            redirect('bancos');
        }

        if (!$this->permission->check($this->session->userdata('permissao'), 'cBancos')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_edit') . ' ' . $this->lang->line('bancos'));
            redirect(base_url());
        }

        $row = $this->Banco_model->get($id);

        if ($row) {
            $data = array(
                'button' => '<i class="fa fa-edit"></i> ' . $this->lang->line('app_edit'),
                'action' => site_url('bancos/update_action'),
                'banco_id' => set_value('banco_id', $row->banco_id),
                'codigo_comp' => set_value('codigo_comp', $row->codigo_comp),
                'nome_instituicao' => set_value('nome_instituicao', $row->nome_instituicao),
                'ativo' => set_value('ativo', $row->ativo),
            );
            $data['view'] = 'banco/banco_form';
            $this->load->view('tema/topo', $data, false);

        } else {
            $this->session->set_flashdata('error', $this->lang->line('app_not_found'));
            redirect(site_url('bancos'));
        }
    }

    public function update_action()
    {
        if (!$this->permission->check($this->session->userdata('permissao'), 'cBancos')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_edit') . ' ' . $this->lang->line('bancos'));
            redirect(base_url());
        }

        $this->_rules();

        if ($this->form_validation->run() == false) {
            $this->update($this->input->post('banco_id', true));
        } else {

            $data = array(
                'codigo_comp' => $this->input->post('codigo_comp', true),
                'nome_instituicao' => $this->input->post('nome_instituicao', true),
                'ativo' => $this->input->post('ativo', true),
            );

            $this->Banco_model->update($data, $this->input->post('banco_id', true));
            $this->session->set_flashdata('success', $this->lang->line('app_edit_message'));
            redirect(site_url('bancos'));
        }
    }

    public function status($banco_id)
    {
        if (!is_numeric($banco_id)) {
            $this->session->set_flashdata('error', $this->lang->line('app_not_found'));
            redirect('bancos');
        }

        if (!$this->permission->check($this->session->userdata('permissao'), 'cBancos')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_edit') . ' ' . $this->lang->line('bancos'));
            redirect(base_url());
        }

        $row = $this->Banco_model->get($banco_id);
        $ajax = $this->input->get('ajax');

        if ($row) {
            if ($this->Banco_model->update(array('ativo' => !$row->ativo), $banco_id)) {

                if ($ajax) {
                    echo json_encode(array('result' => true, 'message' => $this->lang->line('app_edit_message')));die();
                }
                $this->session->set_flashdata('success', $this->lang->line('app_edit_message'));
                redirect(site_url('bancos'));
            } else {

                if ($ajax) {
                    echo json_encode(array('result' => false, 'message' => $this->lang->line('app_error')));die();
                }

                $this->session->set_flashdata('error', $this->lang->line('app_error'));
                redirect(site_url('bancos'));
            }

        } else {

            if ($ajax) {
                echo json_encode(array('result' => false, 'message' => $this->lang->line('app_not_found')));die();
            }
            $this->session->set_flashdata('error', $this->lang->line('app_not_found'));
            redirect(site_url('bancos'));
        }

    }


    public function _rules()
    {
        $this->form_validation->set_rules('codigo_comp', '<b>' . $this->lang->line('codigo_comp') . '</b>', 'trim|required');
		$this->form_validation->set_rules('nome_instituicao', '<b>' . $this->lang->line('nome_instituicao') . '</b>', 'trim|required');
        $this->form_validation->set_rules('ativo', '<b>' . $this->lang->line('situacao') . '</b>', 'trim|required');

        $this->form_validation->set_rules('banco_id', 'banco_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Bancos.php */
/* Location: ./application/controllers/Bancos.php */
