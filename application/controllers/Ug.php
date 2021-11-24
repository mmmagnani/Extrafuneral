<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}


    /**
     * author: Marcelo Magnani 
     * email: marcelommagnani@uol.com.br
     * 
     */

class Ug extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if ((!session_id()) || (!$this->session->userdata('logado'))) {
            redirect('fedd/login');
        }

        $this->load->model('Ug_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        if (!$this->permission->check($this->session->userdata('permissao'), 'cUg')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_view') . ' ' . $this->lang->line('ug'));
            redirect(base_url());
        }

        $data['view'] = 'ug/ug_list';
        $this->load->view('tema/topo', $data, false);
    }

    public function datatable()
    {

        if (!$this->permission->check($this->session->userdata('permissao'), 'cUg')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_view') . ' ' . $this->lang->line('Ug'));
            redirect(base_url());
        }

        $this->load->model('Ug_model');
        $result_data = $this->Ug_model->get_datatables();
        $data = array();

        foreach ($result_data as $row) {
            $line = array();

            $line[] = $row->id_ug;
            $line[] = $row->sigla_ug;
			$line[] = $row->nome_ug;
			$line[] = $row->cod_ug;
			$line[] = $row->local_ug;
			
            $line[] = '<a href="' . site_url('ug/update/' . $row->id_ug) . '" class="btn btn-info" title="' . $this->lang->line('app_edit') . '"><i class="fa fa-edit"></i></a>';
            $data[] = $line;
        }

        $output = array(
            'draw' => intval($this->input->post('draw')),
            'recordsTotal' => $this->Ug_model->get_all_data(),
            'recordsFiltered' => $this->Ug_model->get_filtered_data(),
            'data' => $data,
        );
        echo json_encode($output);
    }


    public function create()
    {
        if (!$this->permission->check($this->session->userdata('permissao'), 'cUg')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_add') . ' ' . $this->lang->line('ug'));
            redirect(base_url());
        }

        $data = array(
            'button' => '<i class="fa fa-plus"></i> ' . $this->lang->line('app_create'),
            'action' => site_url('ug/create_action'),
            'id_ug' => set_value('id_ug'),
            'sigla_ug' => set_value('sigla_ug'),
			'nome_ug' => set_value('nome_ug'),
			'cod_ug' => set_value('cod_ug'),
			'local_ug' => set_value('local_ug'),
        );

        $data['view'] = 'ug/ug_form';
        $this->load->view('tema/topo', $data, false);

    }

    public function create_action()
    {
        if (!$this->permission->check($this->session->userdata('permissao'), 'cUg')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_add') . ' ' . $this->lang->line('ug'));
            redirect(base_url());
        }

        $this->_rules();

        if ($this->form_validation->run() == false) {
            $this->create();
        } else {

            $data = array(
                'sigla_ug' => $this->input->post('sigla_ug', true),
				'nome_ug' => $this->input->post('nome_ug', true),
				'cod_ug' => $this->input->post('cod_ug', true),
				'local_ug' => $this->input->post('local_ug', true),
            );

            $this->Ug_model->insert($data);
            $this->session->set_flashdata('success', $this->lang->line('app_add_message'));
            redirect(site_url('ug'));
        }
    }

    public function update($id)
    {
        if (!is_numeric($id)) {
            $this->session->set_flashdata('error', $this->lang->line('app_not_found'));
            redirect('ug');
        }

        if (!$this->permission->check($this->session->userdata('permissao'), 'cUg')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_edit') . ' ' . $this->lang->line('ug'));
            redirect(base_url());
        }

        $row = $this->Ug_model->get($id);

        if ($row) {
            $data = array(
                'button' => '<i class="fa fa-edit"></i> ' . $this->lang->line('app_edit'),
                'action' => site_url('ug/update_action'),
                'id_ug' => set_value('id_ug', $row->id_ug),
                'sigla_ug' => set_value('sigla_ug', $row->sigla_ug),
				'nome_ug' => set_value('nome_ug', $row->nome_ug),
				'cod_ug' => set_value('cod_ug', $row->cod_ug),
				'local_ug' => set_value('local_ug', $row->local_ug),
            );
            $data['view'] = 'ug/ug_form';
            $this->load->view('tema/topo', $data, false);

        } else {
            $this->session->set_flashdata('error', $this->lang->line('app_not_found'));
            redirect(site_url('ug'));
        }
    }

    public function update_action()
    {
        if (!$this->permission->check($this->session->userdata('permissao'), 'cUg')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_edit') . ' ' . $this->lang->line('ug'));
            redirect(base_url());
        }

        $this->_rules();

        if ($this->form_validation->run() == false) {
            $this->update($this->input->post('id_ug', true));
        } else {

            $data = array(
				'sigla_ug' => $this->input->post('sigla_ug', true),
				'nome_ug' => $this->input->post('nome_ug', true),
				'cod_ug' => $this->input->post('cod_ug', true),
                'local_ug' => $this->input->post('local_ug', true),
            );

            $this->Ug_model->update($data, $this->input->post('id_ug', true));
            $this->session->set_flashdata('success', $this->lang->line('app_edit_message'));
            redirect(site_url('ug'));
        }
    }

    public function status($id_ug)
    {
        if (!is_numeric($id_ug)) {
            $this->session->set_flashdata('error', $this->lang->line('app_not_found'));
            redirect('ug');
        }

        if (!$this->permission->check($this->session->userdata('permissao'), 'cUg')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_edit') . ' ' . $this->lang->line('ug'));
            redirect(base_url());
        }

        $row = $this->Ug_model->get($id_ug);
        $ajax = $this->input->get('ajax');

        if ($row) {
            if ($this->Ug_model->update(array('ativo' => !$row->ativo), $id_ug)) {

                if ($ajax) {
                    echo json_encode(array('result' => true, 'message' => $this->lang->line('app_edit_message')));die();
                }
                $this->session->set_flashdata('success', $this->lang->line('app_edit_message'));
                redirect(site_url('ug'));
            } else {

                if ($ajax) {
                    echo json_encode(array('result' => false, 'message' => $this->lang->line('app_error')));die();
                }

                $this->session->set_flashdata('error', $this->lang->line('app_error'));
                redirect(site_url('ug'));
            }

        } else {

            if ($ajax) {
                echo json_encode(array('result' => false, 'message' => $this->lang->line('app_not_found')));die();
            }
            $this->session->set_flashdata('error', $this->lang->line('app_not_found'));
            redirect(site_url('ug'));
        }

    }


    public function _rules()
    {
        $this->form_validation->set_rules('sigla_ug', '<b>' . $this->lang->line('sigla_ug') . '</b>', 'trim|required');
		$this->form_validation->set_rules('nome_ug', '<b>' . $this->lang->line('nome_ug') . '</b>', 'trim|required');
		$this->form_validation->set_rules('cod_ug', '<b>' . $this->lang->line('cod_ug') . '</b>', 'trim|required');
		$this->form_validation->set_rules('local_ug', '<b>' . $this->lang->line('local_ug') . '</b>', 'trim|required');

        $this->form_validation->set_rules('id_ug', 'id_ug', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Ug.php */
/* Location: ./application/controllers/Ug.php */
