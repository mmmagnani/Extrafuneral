<?php if (!defined('BASEPATH')) { exit('No direct script access allowed'); }


    /**
     * author: Marcelo Magnani 
     * email: marcelommagnani@uol.com.br
     * 
     */
	 
class Cadastros extends CI_Controller
{
	 
    public function __construct()
    {
        parent::__construct();

        if ((!session_id()) || (!$this->session->userdata('logado'))) {
            redirect('fedd/login');
        }

        $this->load->model('Cadastros_model');
        $this->load->library('form_validation');
		$this->load->helper('formater');
    }

    public function index()
    {
        if (!$this->permission->check($this->session->userdata('permissao'), 'vCadastro')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_view') . ' ' . $this->lang->line('cadastros'));
            redirect(base_url());
        }

        $data['view'] = 'cadastros/cadastros_list';
        $this->load->view('tema/topo', $data, false);
    }

    public function datatable()
    {

        if (!$this->permission->check($this->session->userdata('permissao'), 'vCadastro')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_view') . ' ' . $this->lang->line('cadastros'));
            redirect(base_url());
        }

        $this->load->model('Cadastros_model');
        $result_data = $this->Cadastros_model->get_datatables();
        $data = array();

        foreach ($result_data as $row) {
            $line = array();
			if ($this->permission->check($this->session->userdata('permissao'), 'dCadastro')) {
              $line[] = '<input type="checkbox" class="remove" name="item_id[]" value="'.$row->cadastro_id.'">';
			} else {
			  $line[] = "";
			}
            $line[] = $row->cadastro_id;
            $line[] = $row->nome;
            $line[] = formatar('cpf', $row->cpf);
			if ($this->permission->check($this->session->userdata('permissao'), 'dCadastro')) {
            	$line[] = '<a href="' . site_url('cadastros/read/' . $row->cadastro_id) . '" class="btn btn-dark" title="' . $this->lang->line('app_view') . '"><i class="fa fa-eye"></i> </a>
                       <a href="' . site_url('cadastros/update/' . $row->cadastro_id) . '" class="btn btn-info" title="' . $this->lang->line('app_edit') . '"><i class="fa fa-edit"></i></a>
                       <a href="' . site_url('cadastros/delete/' . $row->cadastro_id) . '" class="btn btn-danger delete" title="' . $this->lang->line('app_delete') . '"><i class="fa fa-window-close"></i></a>';
			} else {
				$line[] = '<a href="' . site_url('cadastros/read/' . $row->cadastro_id) . '" class="btn btn-dark" title="' . $this->lang->line('app_view') . '"><i class="fa fa-eye"></i> </a>
                       <a href="' . site_url('cadastros/update/' . $row->cadastro_id) . '" class="btn btn-info" title="' . $this->lang->line('app_edit') . '"><i class="fa fa-edit"></i></a>';
			}
            $data[] = $line;
        }

        $output = array(
            'draw' => intval($this->input->post('draw')),
            'recordsTotal' => $this->Cadastros_model->get_all_data(),
            'recordsFiltered' => $this->Cadastros_model->get_filtered_data(),
            'data' => $data,
        );
        echo json_encode($output);
    }

    public function read($id)
    {
        if (!is_numeric($id)) {
            $this->session->set_flashdata('error', $this->lang->line('app_not_found'));
            redirect('cadastros');
        }

        if (!$this->permission->check($this->session->userdata('permissao'), 'vCadastro')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_view') . ' ' . $this->lang->line('cadastros'));
            redirect(base_url());
        }

        $row = $this->Cadastros_model->with('posto_inst')->with('posto')->with('situacao')->with('saque')->with('banco_c')->get($id);
        if ($row) {
            $data = array(
                'cadastro_id' => $row->cadastro_id,
				'cad_ug' => $row->cad_ug,
                'nome' => $row->nome,
                'cpf' => $row->cpf,
                'posto_id' => $row->posto_id,
                'situacao_id' => $row->situacao_id,
                'instituidor' => $row->instituidor,
                'nr' => $row->nr,
                'posto_instituidor_id' => $row->posto_instituidor_id,
                'cpf_instituidor' => $row->cpf_instituidor,
                'banco' => $row->banco,
                'agencia' => $row->agencia,
                'conta_corrente' => $row->conta_corrente,
            );
			if(!is_null($row->posto_id)){
				$data['posto'] = $row->posto->posto;
			} else {
				$data['posto'] = "";
			}			
			if(!is_null($row->situacao_id)){
				$data['situacao'] = $row->situacao->situacao;
			} else {
				$data['situacao'] = "";
			}
			if(!is_null($row->grupo_saque)){
				$data['grupo_de_saque'] = $row->saque->grupo_de_saque;
			} else {
				$data['grupo_de_saque'] = "";
			}
			if(!is_null($row->posto_instituidor_id)){
				$data['posto_instituidor'] = $row->posto_inst->posto_inst;
			} else {
				$data['posto_instituidor'] = "";
			}
			if(!is_null($row->banco)){
				$data['banco_c'] = $row->banco_c->codigo_comp . ' - ' . $row->banco_c->nome_instituicao;
			} else {
				$data['banco_c'] = "";
			}				
            $data['view'] = 'cadastros/cadastros_read';
            $this->load->view('tema/topo', $data, false);
        } else {
            $this->session->set_flashdata('error', $this->lang->line('app_not_found'));
            redirect(site_url('cadastros'));
        }
    }

    public function create()
    {
        if (!$this->permission->check($this->session->userdata('permissao'), 'aCadastro')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_add') . ' ' . $this->lang->line('cadastros'));
            redirect(base_url());
        }
		
		$this->load->model('Posto_model');
        $postos = $this->Posto_model->as_dropdown('posto')->get_all();
		$postos[0] = '';
		ksort($postos);
		
		$this->load->model('Postoinst_model');
        $postos_inst = $this->Postoinst_model->as_dropdown('posto_inst')->get_all();
		$postos_inst[0] = '';
		ksort($postos_inst);
		
		$this->load->model('Situacao_model');
        $situacoes = $this->Situacao_model->as_dropdown('situacao')->get_all();
		$situacoes[0] = '';
		ksort($situacoes);	
			
		$this->load->model('Saque_model');	
        $saques = $this->Saque_model->as_dropdown('grupo_de_saque')->get_all();
		$saques[0] = '';
		ksort($saques);

		$this->load->model('Banco_model');	
        $bancos = $this->Banco_model->as_dropdown('nome_instituicao')->get_all();
		$bancos[0] = '';
		sort($bancos);		

        $data = array(
            'button' => '<i class="fa fa-plus"></i> ' . $this->lang->line('app_create'),
            'action' => site_url('cadastros/create_action'),
			'cadastro_id' => set_value('cadastro_id'),
			'cad_ug' => set_value('cad_ug'),
            'nome' => set_value('nome'),
            'cpf' => set_value('cpf'),
            'posto_id' => set_value('posto_id'),
			'postos' => $postos,
            'situacao_id' => set_value('situacao_id'),
			'situacoes' => $situacoes,
            'instituidor' => set_value('instituidor'),
			'posto_instituidor_id' => set_value('posto_instituidor_id'),
			'postos_inst' => $postos_inst,
			'cpf_instituidor' => set_value('cpf_instituidor'),
            'nr' => set_value('nr'),
            'grupo_saque' => set_value('grupo_saque'),
			'saques' => $saques,
            'banco' => set_value('banco'),
			'bancos' => $bancos,
            'agencia' => set_value('agencia'),
            'conta_corrente' => set_value('conta_corrente'),
        );

        $data['view'] = 'cadastros/cadastros_form';
        $this->load->view('tema/topo', $data, false);

    }

    public function create_action()
    {
        if (!$this->permission->check($this->session->userdata('permissao'), 'aCadastro')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_add') . ' ' . $this->lang->line('cadastros'));
            redirect(base_url());
        }

        	$this->_rules();

        	if ($this->form_validation->run() == false) {
            	$this->create();
        	} else {
			
            	$data = array(
                	'cadastro_id' => $this->input->post('cadastro_id', true),
					'cad_ug' => $this->input->post('cad_ug', true),
                	'nome' => $this->input->post('nome', true),
                	'cpf' => $this->input->post('cpf', true),
                	'posto_id' => $this->input->post('posto_id', true),
                	'situacao_id' => $this->input->post('situacao_id', true),
                	'instituidor' => $this->input->post('instituidor', true),
                	'nr' => $this->input->post('nr', true),
                	'grupo_saque' => $this->input->post('grupo_saque', true),
                	'posto_instituidor_id' => $this->input->post('posto_instituidor_id', true),
                	'cpf_instituidor' => preg_replace("/\D+/", "",$this->input->post('cpf_instituidor', true)),
                	'banco' => $this->input->post('banco', true),
                	'agencia' => $this->input->post('agencia', true),
                	'conta_corrente' => $this->input->post('conta_corrente', true),			
            	);

            	$this->Cadastros_model->insert($data);
            	$this->session->set_flashdata('success', $this->lang->line('app_add_message'));
            	redirect(site_url('cadastros'));
        	}
    }

    public function update($id)
    {
        if (!is_numeric($id)) {
            $this->session->set_flashdata('error', $this->lang->line('app_not_found'));
            redirect('cadastros');
        }

        if (!$this->permission->check($this->session->userdata('permissao'), 'eCadastro')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_edit') . ' ' . $this->lang->line('cadastros'));
            redirect(base_url());
        }
		
		$this->load->model('Posto_model');
        $postos = $this->Posto_model->as_dropdown('posto')->get_all();
		$postos[0] = '';
		ksort($postos);
		
		$this->load->model('Postoinst_model');
        $postos_inst = $this->Postoinst_model->as_dropdown('posto_inst')->get_all();
		$postos_inst[0] = '';
		ksort($postos_inst);
		
		$this->load->model('Situacao_model');
        $situacoes = $this->Situacao_model->as_dropdown('situacao')->get_all();
		$situacoes[0] = '';
		ksort($situacoes);	
			
		$this->load->model('Saque_model');	
        $saques = $this->Saque_model->as_dropdown('grupo_de_saque')->get_all();
		$saques[0] = '';
		ksort($saques);

		$this->load->model('Banco_model');	
        $bancos = $this->Banco_model->as_dropdown('nome_instituicao')->get_all();
		$bancos[0] = '';
		ksort($bancos);		


        $row = $this->Cadastros_model->get($id);

        if ($row) {
            $data = array(
                'button' => '<i class="fa fa-edit"></i> ' . $this->lang->line('app_edit'),
                'action' => site_url('cadastros/update_action'),
				'cadastro_id' => set_value('cadastro_id', $row->cadastro_id),
				'cad_ug' => set_value('cad_ug', $row->cad_ug),
           	 	'nome' => set_value('nome', $row->nome),
            	'cpf' => set_value('cpf', $row->cpf),
            	'posto_id' => set_value('posto_id', $row->posto_id),
				'postos' => $postos,
            	'situacao_id' => set_value('situacao_id', $row->situacao_id),
				'situacoes' => $situacoes,
            	'instituidor' => set_value('instituidor', $row->instituidor),
            	'nr' => set_value('nr', $row->nr),
            	'grupo_saque' => set_value('grupo_saque', $row->grupo_saque),
				'saques' => $saques,
            	'posto_instituidor_id' => set_value('posto_instituidor_id', $row->posto_instituidor_id),
				'postos_inst' => $postos_inst,
            	'cpf_instituidor' => set_value('cpf_instituidor', $row->cpf_instituidor),
            	'banco' => set_value('banco', $row->banco),
				'bancos' => $bancos,
            	'agencia' => set_value('agencia', $row->agencia),
            	'conta_corrente' => set_value('conta_corrente', $row->conta_corrente),	
            );
            $data['view'] = 'cadastros/cadastros_form';
            $this->load->view('tema/topo', $data, false);

        } else {
            $this->session->set_flashdata('error', $this->lang->line('app_not_found'));
            redirect(site_url('cadastros'));
        }
    }

    public function update_action()
    {
        if (!$this->permission->check($this->session->userdata('permissao'), 'eCadastro')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_edit') . ' ' . $this->lang->line('cadastros'));
            redirect(base_url());
        }
        	$this->_rulesupdate();

        	if ($this->form_validation->run() == false) {
            	$this->update($this->input->post('cadastro_id', true));
        	} else {
            	$data = array(
					'cad_ug' => $this->input->post('cad_ug', true),
                	'nome' => $this->input->post('nome', true),
                	'cpf' => preg_replace("/\D+/", "",$this->input->post('cpf', true)),
                	'posto_id' => $this->input->post('posto_id', true),
                	'situacao_id' => $this->input->post('situacao_id', true),
                	'instituidor' => $this->input->post('instituidor', true),
                	'nr' => $this->input->post('nr', true),
                	'grupo_saque' => $this->input->post('grupo_saque', true),
                	'posto_instituidor_id' => $this->input->post('posto_instituidor_id', true),
                	'cpf_instituidor' => preg_replace("/\D+/", "",$this->input->post('cpf_instituidor', true)),
                	'banco' => $this->input->post('banco', true),
                	'agencia' => $this->input->post('agencia', true),
                	'conta_corrente' => $this->input->post('conta_corrente', true),	
            	);

            	$this->Cadastros_model->update($data, $this->input->post('cadastro_id', true));
            	$this->session->set_flashdata('success', $this->lang->line('app_edit_message'));
            	redirect(site_url('cadastros'));
        	}		
    }

    public function delete($cadastro_id)
    {
        if (!is_numeric($cadastro_id)) {
            $this->session->set_flashdata('error', $this->lang->line('app_not_found'));
            redirect('cadastros');
        }

        if (!$this->permission->check($this->session->userdata('permissao'), 'dCadastro')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_delete') . ' ' . $this->lang->line('cadastros'));
            redirect(base_url());
        }

        $row = $this->Cadastros_model->get($cadastro_id);
        $ajax = $this->input->get('ajax');
        

        if ($row) {


            if ($this->Cadastros_model->delete($cadastro_id)) {

                if ($ajax) {
                    echo json_encode(array('result' => true, 'message' => $this->lang->line('app_delete_message')));die();
                }
                $this->session->set_flashdata('success', $this->lang->line('app_delete_message'));
                redirect(site_url('cadastros'));
            } else {

                if ($ajax) {
                    echo json_encode(array('result' => false, 'message' => $this->lang->line('app_error')));die();
                }

                $this->session->set_flashdata('error', $this->lang->line('app_error'));
                redirect(site_url('cadastros'));
            }

        } else {

            if ($ajax) {
                echo json_encode(array('result' => false, 'message' => $this->lang->line('app_not_found')));die();
            }
            $this->session->set_flashdata('error', $this->lang->line('app_not_found'));
            redirect(site_url('cadastros'));
        }

    }

    public function delete_many()
    {

        if (!$this->permission->check($this->session->userdata('permissao'), 'dCadastro')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_delete') . ' ' . $this->lang->line('cadastros'));
            redirect(base_url());
        }

        $items = $this->input->post('item_id[]');

        if ($items) {

            $verify = implode('', $items);
            if (is_numeric($verify)) {

                $this->Cadastros_model->delete_linked($items);

                $result = $this->Cadastros_model->delete_many($items);
                if ($result) {
                    echo json_encode(array('result' => true, 'message' => $this->lang->line('app_delete_message_many')));die();
                } else {
                    echo json_encode(array('result' => false, 'message' => $this->lang->line('app_error')));die();
                }

            } else {
                echo json_encode(array('result' => false, 'message' => $this->lang->line('app_data_not_supported')));die();
            }
        }

        echo json_encode(array('result' => false, 'message' => $this->lang->line('app_empty_data')));die();

    }

    public function _rules()
    {
        $this->form_validation->set_rules('nome', '<b>' . $this->lang->line('nome') . '</b>', 'trim|required');
		$this->form_validation->set_rules('cpf', '<b>' . $this->lang->line('cpf') . '</b>', 'trim|required|is_unique[tb_cadastro.cpf]|callback_valid_cpf');		
        $this->form_validation->set_rules('posto_id', '<b>' . $this->lang->line('posto') . '</b>', 'trim|required');		
        $this->form_validation->set_rules('instituidor', '<b>' . $this->lang->line('instituidor') . '</b>', 'trim');
        $this->form_validation->set_rules('nr', '<b>' . $this->lang->line('saram') . '</b>', 'trim');
        $this->form_validation->set_rules('cpf_instituidor', '<b>' . $this->lang->line('cpf') . '</b>', 'trim|valid_cpf');
        $this->form_validation->set_rules('banco', '<b>' . $this->lang->line('banco') . '</b>', 'trim');
        $this->form_validation->set_rules('agencia', '<b>' . $this->lang->line('agencia') . '</b>', 'trim');
        $this->form_validation->set_rules('conta_corrente', '<b>' . $this->lang->line('conta') . '</b>', 'trim');
        $this->form_validation->set_rules('cadastro_id', 'cadastro_id', 'trim');

        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
	
	public function _rulesupdate()
    {
        $this->form_validation->set_rules('nome', '<b>' . $this->lang->line('nome') . '</b>', 'trim|required');
		$this->form_validation->set_rules('cpf', '<b>' . $this->lang->line('cpf') . '</b>', 'trim|required|callback_valid_cpf');		
        $this->form_validation->set_rules('posto_id', '<b>' . $this->lang->line('posto') . '</b>', 'trim|required');		
        $this->form_validation->set_rules('instituidor', '<b>' . $this->lang->line('instituidor') . '</b>', 'trim');
        $this->form_validation->set_rules('nr', '<b>' . $this->lang->line('saram') . '</b>', 'trim');
        $this->form_validation->set_rules('cpf_instituidor', '<b>' . $this->lang->line('cpf') . '</b>', 'trim|valid_cpf');
        $this->form_validation->set_rules('banco', '<b>' . $this->lang->line('banco') . '</b>', 'trim');
        $this->form_validation->set_rules('agencia', '<b>' . $this->lang->line('agencia') . '</b>', 'trim');
        $this->form_validation->set_rules('conta_corrente', '<b>' . $this->lang->line('conta') . '</b>', 'trim');
        $this->form_validation->set_rules('cadastro_id', 'cadastro_id', 'trim');

        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
	
		/**
 	* Verifica se o CPF informado é válido
 	* @param     string
 	* @return     bool
 	*/
	public function valid_cpf($str)
	{
    	// Verifiva se o número digitado contém todos os digitos
    	$cpf = $str;
 
    	// Verifica se nenhuma das sequências abaixo foi digitada, caso seja, retorna falso
    	if (strlen($cpf) != 11 ||
        	$cpf == '00000000000' ||
        	$cpf == '11111111111' ||
        	$cpf == '22222222222' ||
        	$cpf == '33333333333' ||
        	$cpf == '44444444444' ||
        	$cpf == '55555555555' ||
       		$cpf == '66666666666' ||
        	$cpf == '77777777777' ||
        	$cpf == '88888888888' ||
        	$cpf == '99999999999') {
        	return FALSE;
    	} else {
        	// Calcula os números para verificar se o CPF é verdadeiro
        	for ($t = 9; $t < 11; $t++) {
            	for ($d = 0, $c = 0; $c < $t; $c++) {
                	$d += $cpf{$c} * (($t + 1) - $c);
            	}
 
            	$d = ((10 * $d) % 11) % 10;
            	if ($cpf{$c} != $d) {
                	return FALSE;
            	}
        	}
        	return TRUE;
    	}
	}
 
// --------------------------------------------------------------------	


    public function pesquisar() {
        if (!$this->permission->check($this->session->userdata('permissao'), 'vCadastro')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_view') . ' ' . $this->lang->line('cadastros'));
            redirect(base_url());
        }
        
        $termo = $this->input->get('termo');

        $data['cadastros'] = $this->Cadastros_model->pesquisar($termo);

        $data['view'] = 'cadastros/pesquisa';
        $this->load->view('tema/topo', $data);
      
    }

}

/* End of file Cadastros.php */
/* Location: ./application/controllers/Cadastros.php */
