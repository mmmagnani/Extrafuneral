<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}


    /**
     * author: Marcelo Magnani 
     * email: marcelommagnani@uol.com.br
     * 
     */

class Gestores extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if ((!session_id()) || (!$this->session->userdata('logado'))) {
            redirect('fedd/login');
        }

        $this->load->model('Gestor_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        if (!$this->permission->check($this->session->userdata('permissao'), 'cGestores')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_view') . ' ' . $this->lang->line('gestores'));
            redirect(base_url());
        }
		
		$data['view'] = 'gestor/gestor_list';
		
        $this->load->view('tema/topo', $data, false);
    }

    public function datatable()
    {

        if (!$this->permission->check($this->session->userdata('permissao'), 'cGestores')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_view') . ' ' . $this->lang->line('Gestores'));
            redirect(base_url());
        }

        $this->load->model('Gestor_model');
        $result_data = $this->Gestor_model->get_datatables();
        $data = array();

        foreach ($result_data as $row) {
            $line = array();

            $line[] = $row->id_gestores;
            $line[] = $row->sigla_ug;
			$line[] = $row->ordenador;
			$line[] = $row->agente;
			$line[] = $row->financas;
			$line[] = $row->contabilidade;
			
            $line[] = '<a href="' . site_url('gestores/update/' . $row->id_gestores) . '" class="btn btn-info" title="' . $this->lang->line('app_edit') . '"><i class="fa fa-edit"></i></a>';
            $data[] = $line;
        }

        $output = array(
            'draw' => intval($this->input->post('draw')),
            'recordsTotal' => $this->Gestor_model->get_all_data(),
            'recordsFiltered' => $this->Gestor_model->get_filtered_data(),
            'data' => $data,
        );
        echo json_encode($output);
    }


    public function create()
    {
        if (!$this->permission->check($this->session->userdata('permissao'), 'cGestores')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_add') . ' ' . $this->lang->line('gestores'));
            redirect(base_url());
        }
		
		$this->load->model('Ug_model');
        $sigla_ug = $this->Ug_model->as_dropdown('sigla_ug')->get_all();
		$sigla_ug[0] = '';
		ksort($sigla_ug);	

        $data = array(
            'button' => '<i class="fa fa-plus"></i> ' . $this->lang->line('app_create'),
            'action' => site_url('gestores/create_action'),
            'id_gestores' => set_value('id_gestores'),
            'gestores_ug' => set_value('gestores_ug'),
			'sigla_ug' => $sigla_ug,
			'ordenador' => set_value('ordenador'),
			'agente' => set_value('agente'),
			'financas' => set_value('financas'),
			'contabilidade' => set_value('contabilidade'),
			'checkBoxCargo' => set_value('cargo'),
			'checkBoxDelegado' => set_value('delegado')
        );

        $data['view'] = 'gestor/gestor_form';
        $this->load->view('tema/topo', $data, false);

    }

    public function create_action()
    {
        if (!$this->permission->check($this->session->userdata('permissao'), 'cGestores')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_add') . ' ' . $this->lang->line('gestores'));
            redirect(base_url());
        }

        $this->_rules();

        if ($this->form_validation->run() == false) {
            $this->create();
        } else {

            $data = array(
                'gestores_ug' => $this->input->post('gestores_ug', true),
				'ordenador' => $this->input->post('ordenador', true),
				'agente' => $this->input->post('agente', true),
				'financas' => $this->input->post('financas', true),
				'contabilidade' => $this->input->post('contabilidade', true),
				'cargo' => $this->input->post('checkBoxCargo', true),
				'delegado' => $this->input->post('checkBoxDelegado', true),
            );

            $this->Gestor_model->insert($data);
            $this->session->set_flashdata('success', $this->lang->line('app_add_message'));
            redirect(site_url('gestores'));
        }
    }

    public function update($id)
    {
        if (!is_numeric($id)) {
            $this->session->set_flashdata('error', $this->lang->line('app_not_found'));
            redirect('gestores');
        }

        if (!$this->permission->check($this->session->userdata('permissao'), 'cGestores')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_edit') . ' ' . $this->lang->line('gestores'));
            redirect(base_url());
        }
		
		$this->load->model('Ug_model');
        $sigla_ug = $this->Ug_model->as_dropdown('sigla_ug')->get_all();
		$sigla_ug[0] = '';
		ksort($sigla_ug);	

        $row = $this->Gestor_model->get($id);

        if ($row) {
            $data = array(
                'button' => '<i class="fa fa-edit"></i> ' . $this->lang->line('app_edit'),
                'action' => site_url('gestores/update_action'),
                'id_gestores' => set_value('id_gestores', $row->id_gestores),
                'gestores_ug' => set_value('gestores_ug', $row->gestores_ug),
				'sigla_ug' => $sigla_ug,
				'ordenador' => set_value('ordenador', $row->ordenador),
				'agente' => set_value('agente', $row->agente),
				'financas' => set_value('financas', $row->financas),
				'contabilidade' => set_value('contabilidade', $row->contabilidade),
				'checkBoxCargo' => set_value('cargo', $row->cargo),
				'checkBoxDelegado' => set_value('delegado', $row->delegado),
            );
            $data['view'] = 'gestor/gestor_form';
            $this->load->view('tema/topo', $data, false);

        } else {
            $this->session->set_flashdata('error', $this->lang->line('app_not_found'));
            redirect(site_url('gestores'));
        }
    }

    public function update_action()
    {
        if (!$this->permission->check($this->session->userdata('permissao'), 'cGestores')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_edit') . ' ' . $this->lang->line('gestores'));
            redirect(base_url());
        }

        $this->_rules();

        if ($this->form_validation->run() == false) {
            $this->update($this->input->post('id_gestores', true));
        } else {

            $data = array(
				'gestores_ug' => $this->input->post('gestores_ug', true),
				'ordenador' => $this->input->post('ordenador', true),
				'agente' => $this->input->post('agente', true),
                'financas' => $this->input->post('financas', true),
				'contabilidade' => $this->input->post('contabilidade', true),
				'cargo'  => $this->input->post('checkBoxCargo', true),
				'delegado' => $this->input->post('checkBoxDelegado', true),
            );

            $this->Gestor_model->update($data, $this->input->post('id_gestores', true));
            $this->session->set_flashdata('success', $this->lang->line('app_edit_message'));
            redirect(site_url('gestores'));
        }
    }

    public function status($id_gestores)
    {
        if (!is_numeric($id_gestores)) {
            $this->session->set_flashdata('error', $this->lang->line('app_not_found'));
            redirect('gestores');
        }

        if (!$this->permission->check($this->session->userdata('permissao'), 'cGestores')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_edit') . ' ' . $this->lang->line('gestores'));
            redirect(base_url());
        }

        $row = $this->Gestor_model->get($id_gestores);
        $ajax = $this->input->get('ajax');

        if ($row) {
            if ($this->Gestor_model->update(array('ativo' => !$row->ativo), $id_gestores)) {

                if ($ajax) {
                    echo json_encode(array('result' => true, 'message' => $this->lang->line('app_edit_message')));die();
                }
                $this->session->set_flashdata('success', $this->lang->line('app_edit_message'));
                redirect(site_url('gestores'));
            } else {

                if ($ajax) {
                    echo json_encode(array('result' => false, 'message' => $this->lang->line('app_error')));die();
                }

                $this->session->set_flashdata('error', $this->lang->line('app_error'));
                redirect(site_url('gestores'));
            }

        } else {

            if ($ajax) {
                echo json_encode(array('result' => false, 'message' => $this->lang->line('app_not_found')));die();
            }
            $this->session->set_flashdata('error', $this->lang->line('app_not_found'));
            redirect(site_url('gestores'));
        }

    }


    public function _rules()
    {
        $this->form_validation->set_rules('gestores_ug', '<b>' . $this->lang->line('gestores_ug') . '</b>', 'trim|required');
		$this->form_validation->set_rules('ordenador', '<b>' . $this->lang->line('ordenador') . '</b>', 'trim|required');
		$this->form_validation->set_rules('agente', '<b>' . $this->lang->line('agente') . '</b>', 'trim|required');
		$this->form_validation->set_rules('financas', '<b>' . $this->lang->line('financas') . '</b>', 'trim|required');
		$this->form_validation->set_rules('contabilidade', '<b>' . $this->lang->line('contabilidade') . '</b>', 'trim|required');

        $this->form_validation->set_rules('id_gestores', 'id_gestores', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Gestores.php */
/* Location: ./application/controllers/Gestores.php */
