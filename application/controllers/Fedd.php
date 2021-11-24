<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fedd extends CI_Controller {


    /**
     * author: Marcelo Magnani 
     * email: marcelommagnani@uol.com.br
     * 
     */
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Fedd_model','',TRUE);
        $this->load->helper('formater');
    }

    public function index() {
        if( (!session_id()) || (!$this->session->userdata('logado'))){
            redirect('fedd/login');
        }

        $this->data['menuPainel'] = 'Painel';
        $this->data['view'] = 'fedd/painel';
        $this->load->view('tema/topo', $this->data);      
    }

    public function conta() {
        if( (!session_id()) || (!$this->session->userdata('logado'))){
            redirect('fedd/login');
        }

        $this->data['usuario'] = $this->Fedd_model->getById($this->session->userdata('id'));
        $this->data['view'] = 'fedd/minhaConta';
        $this->load->view('tema/topo',  $this->data);
     
    }

    public function alterarSenha() {
        if( (!session_id()) || (!$this->session->userdata('logado'))){
            redirect('fedd/login');
        }

        $oldSenha = $this->input->post('oldSenha');
        $senha = $this->input->post('novaSenha');
        $result = $this->Fedd_model->alterarSenha($senha,$oldSenha,$this->session->userdata('id'));
        if($result){
            $this->session->set_flashdata('success','Senha Alterada com sucesso!');
            redirect(base_url() . 'index.php/fedd/conta');
        }
        else{
            $this->session->set_flashdata('error','Ocorreu um erro ao tentar alterar a senha!');
            redirect(base_url() . 'index.php/fedd/conta');
            
        }
    }

    public function pesquisar() {
        if( (!session_id()) || (!$this->session->userdata('logado'))){
            redirect('fedd/login');
        }
        
        $termo = $this->input->get('termo');
        $data['results'] = $this->Fedd_model->pesquisar($termo);
        $this->data['cadastros'] = $data['results']['cadastros'];
        $this->data['fes'] = $data['results']['fes'];
        $this->data['dds'] = $data['results']['dds'];
        $this->data['view'] = 'fedd/pesquisa';
        $this->load->view('tema/topo', $this->data);
      
    }

    public function login(){
        
        $this->load->view('fedd/login');
        
    }
    public function sair(){
        $this->session->sess_destroy();
        redirect('fedd/login');
    }


    public function verificarLogin(){
        
        header('Access-Control-Allow-Origin: '.base_url());
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Max-Age: 1000');
        header('Access-Control-Allow-Headers: Content-Type');
        
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'E-mail', 'valid_email|required|trim');
        $this->form_validation->set_rules('senha', 'Senha', 'required|trim');
        $this->form_validation->set_rules('anofiscal', 'Ano Fiscal', 'required|trim');
        if ($this->form_validation->run() == false) {
            $json = array('result' => false, 'message' => validation_errors());
            echo json_encode($json);
        }
        else {
            $email = $this->input->post('email');
            $password = $this->input->post('senha');
            $anofiscal = $this->input->post('anofiscal');
            $this->load->model('Fedd_model');
            $user = $this->Fedd_model->check_credentials($email);

            if($user){
                if(password_verify($password, $user->usu_senha)){
                    $session_data = array(
                        'nome' => $user->usu_nome,
                        'email' => $user->usu_email,
                        'id' => $user->usu_id,
                        'permissao' => $user->permissao_id,
                        'om_id' => $user->usu_ug,
                        'logado' => true,
                        'anofiscal' => $anofiscal);
                    $this->session->set_userdata($session_data);
                    $json = array('result' => true);
                    echo json_encode($json);
                }
                else{
                    $json = array('result' => false, 'message' => 'Os dados de acesso estão incorretos.');
                    echo json_encode($json);
                }
            }
            else{
                $json = array('result' => false, 'message' => 'Usuário não encontrado, verifique se suas credenciais estão corretass.');
                echo json_encode($json);
            }
        }
        die();
    }


    public function backup(){

        if( (!session_id()) || (!$this->session->userdata('logado'))){
            redirect('fedd/login');
        }

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'cBackup')){
           $this->session->set_flashdata('error','Você não tem permissão para efetuar backup.');
           redirect(base_url());
        }

        
        
        $this->load->dbutil();
        $prefs = array(
                'format'      => 'zip',
                'foreign_key_checks' => false,
                'filename'    => 'backup'.date('d-m-Y').'.sql'
              );

        $backup = $this->dbutil->backup($prefs);

        $this->load->helper('file');
        write_file(base_url().'backup/backup.zip', $backup);

        $this->load->helper('download');
        force_download('backup'.date('d-m-Y H:m:s').'.zip', $backup);
    }
	
}
