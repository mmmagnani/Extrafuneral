<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    
    /**
     * author: Marcelo Magnani 
     * email: marcelommagnani@uol.com.br
     * 
     */
    
class Usuarios extends CI_Controller{
    
    public function __construct(){
        parent::__construct();

        if( (!session_id()) || (!$this->session->userdata('logado'))){
            redirect('fedd/login');
        }

        $this->load->model('Usuarios_model');
        $this->load->library('form_validation');
    }

    
    public function index(){
        if(!$this->permission->check($this->session->userdata('permissao'),'cUsuario')){
           $this->session->set_flashdata('error', $this->lang->line('app_permission_view').' '.$this->lang->line('users'));
           redirect(base_url());
        }

        $data['view'] = 'usuarios/usuarios_list';
        $this->load->view('tema/topo', $data, false);
    }

    public function datatable(){

        if(!$this->permission->check($this->session->userdata('permissao'),'cUsuario')){
            $this->session->set_flashdata('error', $this->lang->line('app_permission_view').' '.$this->lang->line('users'));
            redirect(base_url());
         }

        $this->load->model('Usuarios_model');  
        $result_data = $this->Usuarios_model->get_datatables();  
        $data = array(); 

        foreach($result_data as $row){  
            $line = array(); 
            
	        $line[] = $row->usu_id;
	        $line[] = $row->usu_nome;
	        $line[] = $row->usu_active ? $this->lang->line('app_active') : $this->lang->line('app_inactive');
	        $line[] = $row->permissao;
	 
            $color = $row->usu_active ? 'btn-danger' : 'btn-success';
            $icon = $row->usu_active ? 'fa fa-window-close' : 'fa fa-check';
            $title = $row->usu_active ? $this->lang->line('app_disable') : $this->lang->line('app_activate');

            $line[] = '<a href="'.site_url('usuarios/read/' . $row->usu_id) .'" class="btn btn-dark" title="'.$this->lang->line('app_view').'"><i class="fa fa-eye"></i> </a> 
                       <a href="'.site_url('usuarios/update/' . $row->usu_id) .'" class="btn btn-info" title="'.$this->lang->line('app_edit').'"><i class="fa fa-edit"></i></a> 
                       <a href="'.site_url('usuarios/status/' . $row->usu_id) . '" class="btn '.$color.' delete" title="' . $title . '"><i class="'.$icon.'"></i></a>';
            $data[] = $line;  
        }  

        $output = array(  
            'draw'                => intval($this->input->post('draw')),  
            'recordsTotal'        => $this->Usuarios_model->get_all_data(),  
            'recordsFiltered'     => $this->Usuarios_model->get_filtered_data(),  
            'data'                => $data  
        );  
        echo json_encode($output);
    }

    public function read($id){

        if(!is_numeric($id)){
            $this->session->set_flashdata('error', $this->lang->line('app_not_found'));
            redirect('usuarios');
        }

        if(!$this->permission->check($this->session->userdata('permissao'),'cUsuario')){
           $this->session->set_flashdata('error', $this->lang->line('app_permission_view').' '.$this->lang->line('users'));
           redirect(base_url());
        }

        $row = $this->Usuarios_model->with('permissao')->get($id);
        if ($row){
            $data = array(
		        'usu_id' => $row->usu_id,
		        'usu_nome' => $row->usu_nome,
		        'usu_email' => $row->usu_email,
		        'usu_active' => $row->usu_active,
		        'permissoes_id' => $row->permissao_id,
		        'permissao' => $row->permissao->nome,
	        );

            $data['view'] = 'usuarios/usuarios_read';
            $this->load->view('tema/topo', $data, false);
        } else {
            $this->session->set_flashdata('error', $this->lang->line('app_not_found'));
            redirect(site_url('usuarios'));
        }
    }

    public function create(){
        if(!$this->permission->check($this->session->userdata('permissao'),'cUsuario')){
           $this->session->set_flashdata('error',$this->lang->line('app_permission_add').' '.$this->lang->line('users'));
           redirect(base_url());
        }

        $this->load->model('Permissoes_model');
        $permissoes = $this->Permissoes_model->where('situacao','1')->as_dropdown('nome')->get_all();

        $data = array(
            'button' => '<i class="fa fa-plus"></i> '.$this->lang->line('app_create'),
            'action' => site_url('usuarios/create_action'),
	        'usu_id' => set_value('usu_id'),
	        'usu_nome' => set_value('usu_nome'),
	        'usu_email' => set_value('usu_email'),
	        'usu_senha' => set_value('usu_senha'),
	        'usu_active' => set_value('usu_active'),
            'permissao_id' => set_value('permissao_id'),
			'usu_ug' => $this->session->userdata('om_id'),
            'permissoes' => $permissoes
	    );
    
        $data['view'] = 'usuarios/usuarios_form';
        $this->load->view('tema/topo', $data, false);

    }
    
    public function create_action() {
        if(!$this->permission->check($this->session->userdata('permissao'),'cUsuario')){
           $this->session->set_flashdata('error',$this->lang->line('app_permission_add').' '.$this->lang->line('users'));
           redirect(base_url());
        }

        $this->_rules();
        $this->form_validation->set_rules('usu_senha', '<b>'.$this->lang->line('user_password').'</b>', 'trim|required');

        if ($this->form_validation->run() == false) {
            $this->create();
        } else {
            $data = array(
		        'usu_nome' => $this->input->post('usu_nome',true),
		        'usu_email' => $this->input->post('usu_email',true),
		        'usu_senha' => password_hash($this->input->post('usu_senha'), PASSWORD_DEFAULT),
		        'usu_active' => $this->input->post('usu_active',true),
		        'permissao_id' => $this->input->post('permissao_id',true),
				'usu_ug' => $this->input->post('usu_ug',true)
	        );

            $this->Usuarios_model->insert($data);
            $this->session->set_flashdata('success', $this->lang->line('app_add_message'));
            redirect(site_url('usuarios'));
        }
    }
    
    public function update($id){
        if(!is_numeric($id)){
            $this->session->set_flashdata('error', $this->lang->line('app_not_found'));
            redirect('usuarios');
        }

        if(!$this->permission->check($this->session->userdata('permissao'),'cUsuario')){
           $this->session->set_flashdata('error',$this->lang->line('app_permission_edit').' '.$this->lang->line('users'));
           redirect(base_url());
        }

        $row = $this->Usuarios_model->get($id);

        if ($row) {

            $this->load->model('Permissoes_model');
            $permissoes = $this->Permissoes_model->where('situacao','1')->as_dropdown('nome')->get_all();

            $data = array(
                'button' => '<i class="fa fa-edit"></i> '.$this->lang->line('app_edit'),
                'action' => site_url('usuarios/update_action'),
				'usu_ug' => set_value('usu_ug', $row->usu_ug),
		        'usu_id' => set_value('usu_id', $row->usu_id),
		        'usu_nome' => set_value('usu_nome', $row->usu_nome),
		        'usu_email' => set_value('usu_email', $row->usu_email),
		        'usu_senha' => '',
		        'usu_active' => set_value('usu_active', $row->usu_active),
                'permissao_id' => set_value('permissao_id', $row->permissao_id),
                'permissoes' => $permissoes
	        );
            $data['view'] = 'usuarios/usuarios_form';
            $this->load->view('tema/topo', $data, false);

        } else {
            $this->session->set_flashdata('error', $this->lang->line('app_not_found'));
            redirect(site_url('usuarios'));
        }
    }
    
    public function update_action(){
        if(!$this->permission->check($this->session->userdata('permissao'),'cUsuario')){
           $this->session->set_flashdata('error',$this->lang->line('app_permission_edit').' '.$this->lang->line('users'));
           redirect(base_url());
        }

        $this->_rules();

        if ($this->form_validation->run() == false) {
            $this->update($this->input->post('usu_id', true));
        } else {
            $data = array(
				'usu_ug' => $this->session->userdata('om_id', true),
		        'usu_nome' => $this->input->post('usu_nome',true),
		        'usu_email' => $this->input->post('usu_email',true),
		        'usu_active' => $this->input->post('usu_active',true),
		        'permissao_id' => $this->input->post('permissao_id',true),
            );
            // Change password if not blank
            if($this->input->post('usu_senha')){
                $senha = password_hash($this->input->post('usu_senha'), PASSWORD_DEFAULT);
                $data['usu_senha'] = $senha;
            } 

            $this->Usuarios_model->update($data, $this->input->post('usu_id', true));
            $this->session->set_flashdata('success', $this->lang->line('app_edit_message'));
            redirect(site_url('usuarios'));
        }
    }
    
    public function status($usu_id){

        if(!is_numeric($usu_id)){
            $this->session->set_flashdata('error', $this->lang->line('app_not_found'));
            redirect('usuarios');
        }

        if(!$this->permission->check($this->session->userdata('permissao'),'cUsuario')){
           $this->session->set_flashdata('error',$this->lang->line('app_permission_edit').' '.$this->lang->line('users'));
           redirect(base_url());
        } 

        $row = $this->Usuarios_model->get($usu_id);
        $ajax = $this->input->get('ajax');

        if ($row) {
            if($this->Usuarios_model->update(array('usu_active' => !$row->usu_active), $usu_id)){

                if($ajax){
                    echo json_encode(array('result' => true, 'message' => $this->lang->line('app_edit_message'))); die();
                }
                $this->session->set_flashdata('success', $this->lang->line('app_edit_message'));
                redirect(site_url('usuarios'));
            }else{

                if($ajax){
                    echo json_encode(array('result' => false, 'message' => $this->lang->line('app_error'))); die();
                }

                $this->session->set_flashdata('error', $this->lang->line('app_error'));
                redirect(site_url('usuarios'));
            }

        } else {

            if($ajax){
                echo json_encode(array('result' => false, 'message' => $this->lang->line('app_not_found'))); die();
            }
            $this->session->set_flashdata('error', $this->lang->line('app_not_found'));
            redirect(site_url('usuarios'));
        }

    }

    public function _rules() 
    {
	    $this->form_validation->set_rules('usu_nome', '<b>'.$this->lang->line('user_name').'</b>', 'trim|required');
	    $this->form_validation->set_rules('usu_email', '<b>'.$this->lang->line('user_email').'</b>', 'trim|required|valid_email');
	    $this->form_validation->set_rules('usu_senha', '<b>'.$this->lang->line('user_password').'</b>', 'trim');
	    $this->form_validation->set_rules('usu_active', '<b>'.$this->lang->line('user_status').'</b>', 'trim|required');
	    $this->form_validation->set_rules('permissao_id', '<b>'.$this->lang->line('user_group').'</b>', 'trim|required');
		
	    $this->form_validation->set_rules('usu_id', 'usu_id', 'trim');
	    $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Usuarios.php */
/* Location: ./application/controllers/Usuarios.php */