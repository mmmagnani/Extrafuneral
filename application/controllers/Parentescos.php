<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}


    /**
     * author: Marcelo Magnani 
     * email: marcelommagnani@uol.com.br
     * 
     */

class Parentescos extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if ((!session_id()) || (!$this->session->userdata('logado'))) {
            redirect('fedd/login');
        }

        $this->load->model('Parentesco_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        if (!$this->permission->check($this->session->userdata('permissao'), 'cParentescos')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_view') . ' ' . $this->lang->line('parentescos'));
            redirect(base_url());
        }

        $data['view'] = 'parentesco/parentesco_list';
        $this->load->view('tema/topo', $data, false);
    }

    public function datatable()
    {

        if (!$this->permission->check($this->session->userdata('permissao'), 'cParentescos')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_view') . ' ' . $this->lang->line('parentescos'));
            redirect(base_url());
        }

        $this->load->model('Parentesco_model');
        $result_data = $this->Parentesco_model->get_datatables();
        $data = array();

        foreach ($result_data as $row) {
            $line = array();

            $line[] = $row->id_parentesco;
            $line[] = $row->parentesco;

            $line[] = '<a href="' . site_url('parentescos/update/' . $row->id_parentesco) . '" class="btn btn-info" title="' . $this->lang->line('app_edit') . '"><i class="fa fa-edit"></i></a>';
            $data[] = $line;
        }

        $output = array(
            'draw' => intval($this->input->post('draw')),
            'recordsTotal' => $this->Parentesco_model->get_all_data(),
            'recordsFiltered' => $this->Parentesco_model->get_filtered_data(),
            'data' => $data,
        );
        echo json_encode($output);
    }


    public function create()
    {
        if (!$this->permission->check($this->session->userdata('permissao'), 'cParentescos')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_add') . ' ' . $this->lang->line('parentescos'));
            redirect(base_url());
        }

        $data = array(
            'button' => '<i class="fa fa-plus"></i> ' . $this->lang->line('app_create'),
            'action' => site_url('parentescos/create_action'),
            'id_parentesco' => set_value('id_parentesco'),
            'parentesco' => set_value('parentesco'),
        );

        $data['view'] = 'parentesco/parentesco_form';
        $this->load->view('tema/topo', $data, false);

    }

    public function create_action()
    {
        if (!$this->permission->check($this->session->userdata('permissao'), 'cParentescos')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_add') . ' ' . $this->lang->line('parentescos'));
            redirect(base_url());
        }

        $this->_rules();

        if ($this->form_validation->run() == false) {
            $this->create();
        } else {

            $data = array(
                'parentesco' => $this->input->post('parentesco', true),
            );

            $this->Parentesco_model->insert($data);
            $this->session->set_flashdata('success', $this->lang->line('app_add_message'));
            redirect(site_url('parentescos'));
        }
    }

    public function update($id)
    {
        if (!is_numeric($id)) {
            $this->session->set_flashdata('error', $this->lang->line('app_not_found'));
            redirect('parentescos');
        }

        if (!$this->permission->check($this->session->userdata('permissao'), 'cParentescos')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_edit') . ' ' . $this->lang->line('parentescos'));
            redirect(base_url());
        }

        $row = $this->Parentesco_model->get($id);

        if ($row) {
            $data = array(
                'button' => '<i class="fa fa-edit"></i> ' . $this->lang->line('app_edit'),
                'action' => site_url('parentescos/update_action'),
                'id_parentesco' => set_value('id_parentesco', $row->id_parentesco),
                'parentesco' => set_value('parentesco', $row->parentesco),
            );
            $data['view'] = 'parentesco/parentesco_form';
            $this->load->view('tema/topo', $data, false);

        } else {
            $this->session->set_flashdata('error', $this->lang->line('app_not_found'));
            redirect(site_url('parentescos'));
        }
    }

    public function update_action()
    {
        if (!$this->permission->check($this->session->userdata('permissao'), 'cParentescos')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_edit') . ' ' . $this->lang->line('parentescos'));
            redirect(base_url());
        }

        $this->_rules();

        if ($this->form_validation->run() == false) {
            $this->update($this->input->post('id_parentesco', true));
        } else {

            $data = array(
                'parentesco' => $this->input->post('parentesco', true),
            );

            $this->Parentesco_model->update($data, $this->input->post('id_parentesco', true));
            $this->session->set_flashdata('success', $this->lang->line('app_edit_message'));
            redirect(site_url('parentescos'));
        }
    }

    public function status($id_parentesco)
    {
        if (!is_numeric($id_parentesco)) {
            $this->session->set_flashdata('error', $this->lang->line('app_not_found'));
            redirect('parentescos');
        }

        if (!$this->permission->check($this->session->userdata('permissao'), 'cParentescos')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_edit') . ' ' . $this->lang->line('parentescos'));
            redirect(base_url());
        }

        $row = $this->Parentesco_model->get($id_parentesco);
        $ajax = $this->input->get('ajax');

        if ($row) {
            if ($this->Parentesco_model->update(array('ativo' => !$row->ativo), $id_parentesco)) {

                if ($ajax) {
                    echo json_encode(array('result' => true, 'message' => $this->lang->line('app_edit_message')));die();
                }
                $this->session->set_flashdata('success', $this->lang->line('app_edit_message'));
                redirect(site_url('parentescos'));
            } else {

                if ($ajax) {
                    echo json_encode(array('result' => false, 'message' => $this->lang->line('app_error')));die();
                }

                $this->session->set_flashdata('error', $this->lang->line('app_error'));
                redirect(site_url('parentescos'));
            }

        } else {

            if ($ajax) {
                echo json_encode(array('result' => false, 'message' => $this->lang->line('app_not_found')));die();
            }
            $this->session->set_flashdata('error', $this->lang->line('app_not_found'));
            redirect(site_url('parentescos'));
        }

    }


    public function _rules()
    {
        $this->form_validation->set_rules('parentesco', '<b>' . $this->lang->line('parentesco') . '</b>', 'trim|required');

        $this->form_validation->set_rules('id_parentesco', 'id_parentesco', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Parentescos.php */
/* Location: ./application/controllers/Parentescos.php */
