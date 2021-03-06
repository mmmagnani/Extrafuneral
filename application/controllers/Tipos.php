<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}


    /**
     * author: Marcelo Magnani 
     * email: marcelommagnani@uol.com.br
     * 
     */

class Tipos extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if ((!session_id()) || (!$this->session->userdata('logado'))) {
            redirect('fedd/login');
        }

        $this->load->model('Tipo_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        if (!$this->permission->check($this->session->userdata('permissao'), 'cTipos')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_view') . ' ' . $this->lang->line('tipos'));
            redirect(base_url());
        }

        $data['view'] = 'tipo/tipo_list';
        $this->load->view('tema/topo', $data, false);
    }

    public function datatable()
    {

        if (!$this->permission->check($this->session->userdata('permissao'), 'cTipos')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_view') . ' ' . $this->lang->line('tipos'));
            redirect(base_url());
        }

        $this->load->model('Tipo_model');
        $result_data = $this->Tipo_model->get_datatables();
        $data = array();

        foreach ($result_data as $row) {
            $line = array();

            $line[] = $row->id_tipo;
            $line[] = $row->Tipo;
			$line[] = $row->isFe ? $this->lang->line('app_yes') : $this->lang->line('app_no');
            $line[] = $row->active ? $this->lang->line('app_active') : $this->lang->line('app_inactive');

            $color = $row->active ? 'btn-danger' : 'btn-success';
            $icon = $row->active ? 'fa fa-window-close' : 'fa fa-check';
            $title = $row->active ? $this->lang->line('app_disable') : $this->lang->line('app_activate');

            $line[] = '<a href="' . site_url('tipos/update/' . $row->id_tipo) . '" class="btn btn-info" title="' . $this->lang->line('app_edit') . '"><i class="fa fa-edit"></i></a>
                       <a href="' . site_url('tipos/status/' . $row->id_tipo) . '" class="btn '.$color.' delete" title="' . $title . '"><i class="'.$icon.'"></i></a>';
            $data[] = $line;
        }

        $output = array(
            'draw' => intval($this->input->post('draw')),
            'recordsTotal' => $this->Tipo_model->get_all_data(),
            'recordsFiltered' => $this->Tipo_model->get_filtered_data(),
            'data' => $data,
        );
        echo json_encode($output);
    }


    public function create()
    {
        if (!$this->permission->check($this->session->userdata('permissao'), 'cTipos')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_add') . ' ' . $this->lang->line('tipos'));
            redirect(base_url());
        }

        $data = array(
            'button' => '<i class="fa fa-plus"></i> ' . $this->lang->line('app_create'),
            'action' => site_url('tipos/create_action'),
            'id_tipo' => set_value('id_tipo'),
            'Tipo' => set_value('Tipo'),
            'isFe' => set_value('isFe'),
            'active' => set_value('active'),
        );

        $data['view'] = 'tipo/tipo_form';
        $this->load->view('tema/topo', $data, false);

    }

    public function create_action()
    {
        if (!$this->permission->check($this->session->userdata('permissao'), 'cTipos')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_add') . ' ' . $this->lang->line('tipos'));
            redirect(base_url());
        }

        $this->_rules();

        if ($this->form_validation->run() == false) {
            $this->create();
        } else {

            $data = array(
                'Tipo' => $this->input->post('Tipo', true),
                'isFe' => $this->input->post('isFe', true),
                'active' => $this->input->post('active', true),
            );

            $this->Tipo_model->insert($data);
            $this->session->set_flashdata('success', $this->lang->line('app_add_message'));
            redirect(site_url('tipos'));
        }
    }

    public function update($id)
    {
        if (!is_numeric($id)) {
            $this->session->set_flashdata('error', $this->lang->line('app_not_found'));
            redirect('tipos');
        }

        if (!$this->permission->check($this->session->userdata('permissao'), 'cTipos')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_edit') . ' ' . $this->lang->line('tipos'));
            redirect(base_url());
        }

        $row = $this->Tipo_model->get($id);

        if ($row) {
            $data = array(
                'button' => '<i class="fa fa-edit"></i> ' . $this->lang->line('app_edit'),
                'action' => site_url('tipos/update_action'),
                'id_tipo' => set_value('id_tipo', $row->id_tipo),
                'Tipo' => set_value('Tipo', $row->Tipo),
                'isFe' => set_value('isFe', $row->isFe),
                'active' => set_value('active', $row->active),
            );
            $data['view'] = 'tipo/tipo_form';
            $this->load->view('tema/topo', $data, false);

        } else {
            $this->session->set_flashdata('error', $this->lang->line('app_not_found'));
            redirect(site_url('tipos'));
        }
    }

    public function update_action()
    {
        if (!$this->permission->check($this->session->userdata('permissao'), 'cTipos')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_edit') . ' ' . $this->lang->line('tipos'));
            redirect(base_url());
        }

        $this->_rules();

        if ($this->form_validation->run() == false) {
            $this->update($this->input->post('id_tipo', true));
        } else {

            $data = array(
                'Tipo' => $this->input->post('Tipo', true),
                'isFe' => $this->input->post('isFe', true),
                'active' => $this->input->post('active', true),
            );

            $this->Tipo_model->update($data, $this->input->post('id_tipo', true));
            $this->session->set_flashdata('success', $this->lang->line('app_edit_message'));
            redirect(site_url('tipos'));
        }
    }

    public function status($id_tipo)
    {
        if (!is_numeric($id_tipo)) {
            $this->session->set_flashdata('error', $this->lang->line('app_not_found'));
            redirect('tipos');
        }

        if (!$this->permission->check($this->session->userdata('permissao'), 'cTipos')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_edit') . ' ' . $this->lang->line('tipos'));
            redirect(base_url());
        }

        $row = $this->Tipo_model->get($id_tipo);
        $ajax = $this->input->get('ajax');

        if ($row) {
            if ($this->Tipo_model->update(array('active' => !$row->active), $id_tipo)) {

                if ($ajax) {
                    echo json_encode(array('result' => true, 'message' => $this->lang->line('app_edit_message')));die();
                }
                $this->session->set_flashdata('success', $this->lang->line('app_edit_message'));
                redirect(site_url('tipos'));
            } else {

                if ($ajax) {
                    echo json_encode(array('result' => false, 'message' => $this->lang->line('app_error')));die();
                }

                $this->session->set_flashdata('error', $this->lang->line('app_error'));
                redirect(site_url('tipos'));
            }

        } else {

            if ($ajax) {
                echo json_encode(array('result' => false, 'message' => $this->lang->line('app_not_found')));die();
            }
            $this->session->set_flashdata('error', $this->lang->line('app_not_found'));
            redirect(site_url('tipos'));
        }

    }


    public function _rules()
    {
        $this->form_validation->set_rules('Tipo', '<b>' . $this->lang->line('tipo') . '</b>', 'trim|required');
		//$this->form_validation->set_rules('isFe', '<b>' . $this->lang->line('isFe') . '</b>', 'trim|required');
        $this->form_validation->set_rules('active', '<b>' . $this->lang->line('situacao') . '</b>', 'trim|required');

        $this->form_validation->set_rules('id_tipo', 'id_tipo', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Tipos.php */
/* Location: ./application/controllers/Tipos.php */
