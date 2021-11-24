<?php if (!defined('BASEPATH')) { exit('No direct script access allowed'); }
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Recife');


    /**
     * author: Marcelo Magnani 
     * email: marcelommagnani@uol.com.br
     * 
     */
	 
class Fes extends CI_Controller
{
	 
    public function __construct()
    {
        parent::__construct();

        if ((!session_id()) || (!$this->session->userdata('logado'))) {
            redirect('fedd/login');
        }

        $this->load->model('Fes_model');
        $this->load->library('form_validation');
		$this->load->library('clsTexto');
		$this->load->library('PHPJasperXML');
		$this->load->helper('formater');
    }

    public function index()
    {
        if (!$this->permission->check($this->session->userdata('permissao'), 'vFe')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_view') . ' ' . $this->lang->line('fes'));
            redirect(base_url());
        }

        $data['view'] = 'fes/fes_list';
        $this->load->view('tema/topo', $data, false);
    }

    public function datatable()
    {

        if (!$this->permission->check($this->session->userdata('permissao'), 'vFe')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_view') . ' ' . $this->lang->line('fes'));
            redirect(base_url());
        }

        $this->load->model('Fes_model');
        $result_data = $this->Fes_model->get_datatables();
        $data = array();

        foreach ($result_data as $row) {
            $line = array();
			if ($this->permission->check($this->session->userdata('permissao'), 'dFe')) {
              $line[] = '<input type="checkbox" class="remove" name="item_id[]" value="'.$row->registro_id.'">';
			} else {
			  $line[] = "";
			}
			$line[] = $row->registro_id;
            $line[] = formatar('cpf', $row->cpf);
			$line[] = $row->nr_cautela;
			$line[] = $row->tipo;
			$line[] = number_format($row->valor, 2, ",", ".");
			if ($this->permission->check($this->session->userdata('permissao'), 'dFe')) {
            	$line[] = '<a href="' . site_url('fes/read/' . $row->registro_id) . '" class="btn btn-dark" title="' . $this->lang->line('app_view') . '"><i class="fa fa-eye"></i> </a>
                       <a href="' . site_url('fes/update/' . $row->registro_id) . '" class="btn btn-info" title="' . $this->lang->line('app_edit') . '"><i class="fa fa-edit"></i></a>
                       <a href="' . site_url('fes/delete/' . $row->registro_id) . '" class="btn btn-danger delete" title="' . $this->lang->line('app_delete') . '"><i class="fa fa-window-close"></i></a>';
			} else {
				$line[] = '<a href="' . site_url('fes/read/' . $row->registro_id) . '" class="btn btn-dark" title="' . $this->lang->line('app_view') . '"><i class="fa fa-eye"></i> </a>
                       <a href="' . site_url('fes/update/' . $row->registro_id) . '" class="btn btn-info" title="' . $this->lang->line('app_edit') . '"><i class="fa fa-edit"></i></a>';
			}
            $data[] = $line;
        }

        $output = array(
            'draw' => intval($this->input->post('draw')),
            'recordsTotal' => $this->Fes_model->get_all_data(),
            'recordsFiltered' => $this->Fes_model->get_filtered_data(),
            'data' => $data,
        );
        echo json_encode($output);
    }

    public function read($id)
    {
	    $this->load->model('Banco_model');
		
        if (!is_numeric($id)) {
            $this->session->set_flashdata('error', $this->lang->line('app_not_found'));
            redirect('fes');
        }

        if (!$this->permission->check($this->session->userdata('permissao'), 'vFe')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_view') . ' ' . $this->lang->line('fes'));
            redirect(base_url());
        }

        $row = $this->Fes_model->with('cadastro')->with('tipo')->with('saque')->get($id);
        if ($row) {
		  
		  $row2 = $this->Banco_model->get($row->cadastro->banco);
            $data = array(
                'registro_id' => $row->registro_id,
				'reg_ug' => $row->reg_ug,
                'cpf' => $row->cpf,
				'nome' => $row->cadastro->nome,
				'banco' => $row->cadastro->banco,
				'agencia' => $row->cadastro->agencia,
				'conta_corrente' => $row->cadastro->conta_corrente,
                'numero_ob' => $row->numero_ob,
                'data_ob' => ($row->data_ob)?date('d/m/Y', strtotime($row->data_ob)):"",
                'valor' => number_format($row->valor, 2, ',', '.'),
                'resgatado' => ($row->resgatado == 'Y')?$this->lang->line('app_yes'):$this->lang->line('app_no'),
                'tipo_id' => $row->tipo_id,
                'ano' => $row->ano,
                'observacao' => $row->observacao,
                'nr_cautela' => $row->nr_cautela,
                'emissao' => date('d/m/Y', strtotime($row->emissao)),	
				'grupo_saque' => $row->grupo_saque,
				'registro_fe' => ($row->registro_fe == 'Y')?$this->lang->line('app_yes'):$this->lang->line('app_no'),
				'justificativa_reg_fe' => $row->justificativa_reg_fe,
				'amparo_id' => $row->amparo_id,
				'mes_resgate' => formatar('mes', $row->mes_resgate),
				'bol_conce' => $row->bol_conce,
				'num_msg_siafi_aut' => $row->num_msg_siafi_aut,
				'num_msg_siafi_sol' => $row->num_msg_siafi_sol,			
            );
			if($row2) {
			    $data['banco_c'] = $row2->codigo_comp;
				$data['banco_n'] = $row2->nome_instituicao;
			} else {
			     $data['banco_c'] = "";
				 $data['banco_n'] = "";
		    }
			if(!is_null($row->tipo_id)){
				$data['tipo'] = $row->tipo->Tipo;
			} else {
				$data['tipo'] = "";
			}			
			if(!is_null($row->grupo_saque)){
				$data['grupo_de_saque'] = $row->saque->grupo_de_saque;
			} else {
				$data['grupo_de_saque'] = "";
			}			
            $data['view'] = 'fes/fes_read';
            $this->load->view('tema/topo', $data, false);
        } else {
            $this->session->set_flashdata('error', $this->lang->line('app_not_found'));
            redirect(site_url('fes'));
        }
    }

    public function create()
    {
        if (!$this->permission->check($this->session->userdata('permissao'), 'aFe')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_add') . ' ' . $this->lang->line('fes'));
            redirect(base_url());
        }
		
		$this->load->model('Numerador_model');
		$newCautela = $this->Numerador_model->get_new_numCautela(1);
		
		$this->load->model('Tipo_model');
		$where = 'tb_tipo.isFe = "1" AND tb_tipo.active = "1"';
        $tipos = $this->Tipo_model->as_dropdown('Tipo')->get_all($where);
		$tipos[''] = '';
		ksort($tipos);
		
		$this->load->model('Meses_model');
        $meses = $this->Meses_model->as_dropdown('nome_mes')->get_all();
		$meses[0] = 'Sem Resgate';
		ksort($meses);	
		
		$this->load->model('Opcoes_model');	
        $opcoes = $this->Opcoes_model->as_dropdown('desc_opcao')->get_all();
		$opcoes[''] = '';
		ksort($opcoes);				
			
		$this->load->model('Saque_model');	
        $saques = $this->Saque_model->as_dropdown('grupo_de_saque')->get_all(NULL);
		$saques[''] = '';
		ksort($saques);
	

        $data = array(
            'button' => '<i class="fa fa-plus"></i> ' . $this->lang->line('app_create'),
            'action' => site_url('fes/create_action'),
			'registro_id' => set_value('registro_id'),
			'reg_ug' => set_value('reg_ug'),
            'cpf' => set_value('cpf'),
            'numero_ob' => set_value('numero_ob'),
            'data_ob' => set_value('data_ob'),
			'valor' => set_value('valor'),
            'mes_resgate' => set_value('mes_resgate'),
			'meses' => $meses,
			'resgatado' => set_value('resgatado'),
			'resgate' => $opcoes,
			'tipo_id' => set_value('tipo_id'),
			'tipo' => $tipos,
            'grupo_saque' => set_value('grupo_saque'),
			'saques' => $saques,
			'observacao' => set_value('observacao'),
			'nr_cautela' => $newCautela,
			'bol_conce' => set_value('bol_conce'),
			'emissao' => set_value('emissao'),
			'num_msg_siafi_aut' => set_value('num_msg_siafi_aut'),
			'num_msg_siafi_sol' => set_value('num_msg_siafi_sol'),
			'registro_fe' => set_value('registro_fe'),
			'registro' => $opcoes,
			'justificativa_reg_fe' => set_value('justificativa_reg_fe'),

			);

        $data['view'] = 'fes/fes_form';
        $this->load->view('tema/topo', $data, false);

    }

    public function create_action()
    {
        if (!$this->permission->check($this->session->userdata('permissao'), 'aFe')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_add') . ' ' . $this->lang->line('fes'));
            redirect(base_url());
        }

        	$this->_rules();

        	if ($this->form_validation->run() == false) {
            	$this->create();
        	} else {
				if(empty($this->input->post('resgatado'))) {
					$resgatado = 'N';
				} else {
					$resgatado = $this->input->post('resgatado');
				}
				if(empty($this->input->post('registro_fe'))) {
					$registro_fe = 'N';
				} else {
					$registro_fe = $this->input->post('registro_fe');
				}
				$data_ob = $this->input->post('data_ob');
				if(!empty($this->input->post('data_ob'))) {
					try
            		{
                		$data_ob = explode('/', $data_ob);
                		$data_ob = $data_ob[2] . '-' . $data_ob[1] . '-' . $data_ob[0];

            		}
            		catch (exception $e)
            		{
                		$data_ob = date('Y-m-d');
            		}		
				} else {
					$data_ob = NULL;
				}
				
				$emissao = $this->input->post('emissao');
				if(!empty($this->input->post('emissao'))) {
					try
            		{
                		$emissao = explode('/', $emissao);
                		$emissao = $emissao[2] . '-' . $emissao[1] . '-' . $emissao[0];

            		}
            		catch (exception $e)
            		{
                		$emissao = date('Y-m-d');
            		}		
				} else {
					$emissao = NULL;
				}
				if(empty(trim($this->input->post('numero_ob')))) {
					$numero_ob = NULL;
				} else {
					$numero_ob = trim($this->input->post('numero_ob', true));
				}
				
			
            	$data = array(
                	'registro_id' => $this->input->post('registro_id', true),
					'reg_ug' => $this->input->post('reg_ug', true),
					'ano' => $this->input->post('ano', true),
					'nr_cautela' => $this->input->post('nr_cautela', true),
                	'cpf' => preg_replace("/\D+/", "", $this->input->post('cpf', true)),
                	'numero_ob' => $numero_ob,
                	'data_ob' => $data_ob,
                	'valor' => str_replace(',','.', str_replace('.','',$this->input->post('valor', true))),
                	'mes_resgate' => $this->input->post('mes_resgate', true),
                	'resgatado' => $resgatado,
                	'tipo_id' => $this->input->post('tipo_id', true),
                	'grupo_saque' => $this->input->post('grupo_saque', true),
                	'observacao' => $this->input->post('observacao', true),
                	'bol_conce' => $this->input->post('bol_conce', true),
                	'emissao' => $emissao,
					'num_msg_siafi_aut' => trim($this->input->post('num_msg_siafi_aut', true)),
					'num_msg_siafi_sol' => trim($this->input->post('num_msg_siafi_sol', true)),
					'registro_fe' => $registro_fe,
					'justificativa_reg_fe' => $this->input->post('justificativa_reg_fe', true),			
            	);

            	$this->Fes_model->insert($data);
            	$this->session->set_flashdata('success', $this->lang->line('app_add_message'));
            	redirect(site_url('fes'));
        	}
    }

    public function update($id)
    {
        if (!is_numeric($id)) {
            $this->session->set_flashdata('error', $this->lang->line('app_not_found'));
            redirect('fes');
        }

        if (!$this->permission->check($this->session->userdata('permissao'), 'eFe')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_edit') . ' ' . $this->lang->line('fes'));
            redirect(base_url());
        }
		
		$this->load->model('Tipo_model');
		$where = 'tb_tipo.isFe = "1" AND tb_tipo.active = "1"';
        $tipos = $this->Tipo_model->as_dropdown('Tipo')->get_all($where);
		$tipos[''] = '';
		ksort($tipos);
		
		$this->load->model('Meses_model');
        $meses = $this->Meses_model->as_dropdown('nome_mes')->get_all();
		$meses[0] = '';
		ksort($meses);	
		
		$this->load->model('Opcoes_model');	
        $opcoes = $this->Opcoes_model->as_dropdown('desc_opcao')->get_all();
		$opcoes[''] = '';
		ksort($opcoes);				
			
		$this->load->model('Saque_model');	
        $saques = $this->Saque_model->as_dropdown('grupo_de_saque')->get_all(NULL);
		$saques[''] = '';
		ksort($saques);	


        $row = $this->Fes_model->get($id);

        if ($row) {
			
			$data_ob = $row->data_ob;
				if(!empty($row->data_ob)) {
					try
            		{
                		$data_ob = explode('-', $data_ob);
                		$data_ob = $data_ob[2] . '/' . $data_ob[1] . '/' . $data_ob[0];

            		}
            		catch (exception $e)
            		{
                		$data_ob = date('d/m/Y');
            		}		
				} else {
					$data_ob = NULL;
				}
				
				$emissao = $row->emissao;
				if(!empty($row->emissao)) {
					try
            		{
                		$emissao = explode('-', $emissao);
                		$emissao = $emissao[2] . '-' . $emissao[1] . '-' . $emissao[0];

            		}
            		catch (exception $e)
            		{
                		$emissao = date('d/m/Y');
            		}		
				} else {
					$emissao = NULL;
				}
			
			
            $data = array(
                'button' => '<i class="fa fa-edit"></i> ' . $this->lang->line('app_edit'),
                'action' => site_url('fes/update_action'),
				'registro_id' => set_value('registro_id', $row->registro_id),
				'reg_ug' => set_value('reg_ug', $row->reg_ug),
				'ano' => set_value('ano', $row->ano),
            	'cpf' => set_value('cpf', $row->cpf),
            	'numero_ob' => set_value('numero_ob', $row->numero_ob),
            	'data_ob' => set_value('data_ob', $data_ob),
				'valor' => set_value('valor', $row->valor),
            	'mes_resgate' => set_value('mes_resgate', $row->mes_resgate),
				'meses' => $meses,
				'resgatado' => set_value('resgatado', $row->resgatado),
				'resgate' => $opcoes,
				'tipo_id' => set_value('tipo_id', $row->tipo_id),
				'tipo' => $tipos,
            	'grupo_saque' => set_value('grupo_saque', $row->grupo_saque),
				'saques' => $saques,
				'observacao' => set_value('observacao', $row->observacao),
				'nr_cautela' => set_value('nr_cautela', $row->nr_cautela),
				'bol_conce' => set_value('bol_conce', $row->bol_conce),
				'emissao' => set_value('emissao', $emissao),
				'num_msg_siafi_aut' => set_value('num_msg_siafi_aut', $row->num_msg_siafi_aut),
				'num_msg_siafi_sol' => set_value('num_msg_siafi_sol', $row->num_msg_siafi_sol),
				'registro_fe' => set_value('registro_fe', $row->registro_fe),
				'registro' => $opcoes,
				'justificativa_reg_fe' => set_value('justificativa_reg_fe', $row->justificativa_reg_fe),	
            );
            $data['view'] = 'fes/fes_form';
            $this->load->view('tema/topo', $data, false);

        } else {
            $this->session->set_flashdata('error', $this->lang->line('app_not_found'));
            redirect(site_url('fes'));
        }
    }

    public function update_action()
    {
        if (!$this->permission->check($this->session->userdata('permissao'), 'eFe')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_edit') . ' ' . $this->lang->line('fes'));
            redirect(base_url());
        }
        	$this->_rules();

        	if ($this->form_validation->run() == false) {
            	$this->update($this->input->post('registro_id', true));
        	} else {
				$data_ob = $this->input->post('data_ob');
				if(!empty($this->input->post('data_ob'))) {
					try
            		{
                		$data_ob = explode('/', $data_ob);
                		$data_ob = $data_ob[2] . '-' . $data_ob[1] . '-' . $data_ob[0];

            		}
            		catch (exception $e)
            		{
                		$data_ob = date('Y-m-d');
            		}		
				} else {
					$data_ob = NULL;
				}
				
				$emissao = $this->input->post('emissao');
				if(!empty($this->input->post('emissao'))) {
					try
            		{
                		$emissao = explode('/', $emissao);
                		$emissao = $emissao[2] . '-' . $emissao[1] . '-' . $emissao[0];

            		}
            		catch (exception $e)
            		{
                		$emissao = date('Y-m-d');
            		}		
				} else {
					$emissao = NULL;
				}
				if(empty(trim($this->input->post('numero_ob')))) {
					$numero_ob = NULL;
				} else {
					$numero_ob = trim($this->input->post('numero_ob', true));
				}
				
            	$data = array(
					'reg_ug' => $this->input->post('reg_ug', true),
                	'cpf' => preg_replace("/\D+/", "", $this->input->post('cpf', true)),
                	'numero_ob' => $numero_ob,
                	'data_ob' => $data_ob,
					'ano' => $this->input->post('ano', true),
					'nr_cautela' => $this->input->post('nr_cautela', true),
                	'valor' => str_replace(',','.', str_replace('.','',$this->input->post('valor', true))),
                	'mes_resgate' => $this->input->post('mes_resgate', true),
                	'resgatado' => $this->input->post('resgatado', true),
                	'tipo_id' => $this->input->post('tipo_id', true),
                	'grupo_saque' => $this->input->post('grupo_saque', true),
                	'observacao' => $this->input->post('observacao', true),
                	'bol_conce' => trim($this->input->post('bol_conce', true)),
                	'emissao' => $emissao,
					'num_msg_siafi_aut' => trim($this->input->post('num_msg_siafi_aut', true)),
					'num_msg_siafi_sol' => trim($this->input->post('num_msg_siafi_sol', true)),
					'registro_fe' => $this->input->post('registro_fe', true),
					'justificativa_reg_fe' => $this->input->post('justificativa_reg_fe', true),
            	);

            	$this->Fes_model->update($data, $this->input->post('registro_id', true));
            	$this->session->set_flashdata('success', $this->lang->line('app_edit_message'));
            	redirect(site_url('fes'));
        	}		
    }

    public function delete($registro_id)
    {
        if (!is_numeric($registro_id)) {
            $this->session->set_flashdata('error', $this->lang->line('app_not_found'));
            redirect('fes');
        }

        if (!$this->permission->check($this->session->userdata('permissao'), 'dFe')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_delete') . ' ' . $this->lang->line('fes'));
            redirect(base_url());
        }

        $row = $this->Fes_model->get($registro_id);
        $ajax = $this->input->get('ajax');
        

        if ($row) {


            if ($this->Fes_model->delete($registro_id)) {

                if ($ajax) {
                    echo json_encode(array('result' => true, 'message' => $this->lang->line('app_delete_message')));die();
                }
                $this->session->set_flashdata('success', $this->lang->line('app_delete_message'));
                redirect(site_url('fes'));
            } else {

                if ($ajax) {
                    echo json_encode(array('result' => false, 'message' => $this->lang->line('app_error')));die();
                }

                $this->session->set_flashdata('error', $this->lang->line('app_error'));
                redirect(site_url('fes'));
            }

        } else {

            if ($ajax) {
                echo json_encode(array('result' => false, 'message' => $this->lang->line('app_not_found')));die();
            }
            $this->session->set_flashdata('error', $this->lang->line('app_not_found'));
            redirect(site_url('fes'));
        }

    }

    public function delete_many()
    {

        if (!$this->permission->check($this->session->userdata('permissao'), 'dFe')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_delete') . ' ' . $this->lang->line('fes'));
            redirect(base_url());
        }

        $items = $this->input->post('item_id[]');

        if ($items) {

            $verify = implode('', $items);
            if (is_numeric($verify)) {

                $result = $this->Fes_model->delete_many($items);
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
        $this->form_validation->set_rules('cpf', '<b>' . $this->lang->line('cpf') . '</b>', 'trim|required');
        $this->form_validation->set_rules('numero_ob', '<b>' . $this->lang->line('numero_ob') . '</b>', 'trim');			
        $this->form_validation->set_rules('valor', '<b>' . $this->lang->line('valor_r') . '</b>', 'trim');
        $this->form_validation->set_rules('grupo_saque', '<b>' . $this->lang->line('grupo_saque') . '</b>', 'trim|required');
        $this->form_validation->set_rules('tipo_id', '<b>' . $this->lang->line('tipo') . '</b>', 'trim|required');
        $this->form_validation->set_rules('emissao', '<b>' . $this->lang->line('emissao') . '</b>', 'trim|required');
        $this->form_validation->set_rules('registro_id', 'registro_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
	

    public function pesquisar() {
        if (!$this->permission->check($this->session->userdata('permissao'), 'vFe')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_view') . ' ' . $this->lang->line('fes'));
            redirect(base_url());
        }
        
        $termo = $this->input->get('termo');

        $data['registros'] = $this->Fes_model->pesquisar($termo);

        $data['view'] = 'fes/pesquisa';
        $this->load->view('tema/topo', $data);
      
    }
	
	function limpaCPF_CNPJ($valor)
	{
 		$valor = trim($valor);
 		$valor = str_replace(".", "", $valor);
 		$valor = str_replace(",", "", $valor);
 		$valor = str_replace("-", "", $valor);
 		$valor = str_replace("/", "", $valor);
 		return $valor;
	}
	
	public function getbeneficiado() 
	{
		$cpf = $this->input->post('cpf');
		$this->load->model('Cadastros_model');
		$this->load->model('Banco_model');
		$row = $this->Cadastros_model->busca_beneficiado($cpf);
		if($row){
			$nome = $row->nome;
			$row2 = $this->Banco_model->get_banco($row->banco);
			if($row2) {
			    $cod_comp = $row2->codigo_comp;
				$nome_inst = $row2->nome_instituicao;
				$banco = $cod_comp . ' - ' . $nome_inst;
			} else {
			     $cod_comp = "";
				 $nome_inst = "";
				 $banco = "";
		    }
			$agencia = $row->agencia;
			$conta_corrente = $row->conta_corrente;
		    echo json_encode(array("nome"=>$nome,"banco"=>$banco,"agencia"=>$agencia,"conta_corrente"=>$conta_corrente));
		} else {
			echo json_encode(array("nome"=>"","banco"=>"","agencia"=>"","conta_corrente"=>""));
		}
	}
	
	public function printCautela($id){
	
		if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rFe')){
           $this->session->set_flashdata('error','Voc� n�o tem permiss�o para gerar folha extraordin�ria.');
           redirect(base_url());
        }
		
		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		$xml =  simplexml_load_file (base_url("assets/reports/cautela_1_NEW.jrxml"));

		$this->load->model('Ug_model');
		$local = $this->Ug_model->get_ug()->local_ug;
		
		$this->load->model('Fes_model');
        $row = $this->Fes_model->get_one($id);

		if($row)
		{
			$valor = $row->valor;
			$valor = "R$".number_format($valor,2,',','.');
			$cautela = '"'.$row->nr_cautela.'"';
			$emissor = $this->session->userdata('nome');
			$emissao = formatar('data_extenso', $row->emissao);
			$extenso = utf8_encode(clsTexto::valorPorExtenso($valor, true, false));
			if((is_null($row->instituidor))||($row->instituidor=="")) {
				$alimentante = "";
			} else {
				$alimentante = utf8_encode('ALIMENTANTE/INSTITUIDOR:');
			}
			if(!is_null($row->numero_ob)) {
				$obfull = 'NÚMERO DA ORDEM BANCÁRIA: '.$row->numero_ob.'OB'.$row->ano.'   Data: '.date('d/m/Y',strtotime($row->data_ob));
			} else {
				$obfull = 'NÚMERO DA ORDEM BANCÁRIA:              OB                       Data:____/____/____';
			}
			$emissao_extenso = $local . " " . $emissao;
			$this->PHPJasperXML = new PHPJasperXML();
			$this->PHPJasperXML->debugsql=false;
			$this->PHPJasperXML->arrayParameter=array("extenso"=>$extenso, "emissor"=>$emissor, "cautela"=>$cautela, "alimentante" =>$alimentante, "obfull"=>$obfull, "emissao"=>$emissao_extenso);
			$this->PHPJasperXML->xml_dismantle($xml);

			$this->PHPJasperXML->transferDBtoArray($this->db->hostname,$this->db->username,$this->db->password,$this->db->database);
			$this->PHPJasperXML->outpage("I");    //page output method I:standard output  D:Download file
	
		} else {
			$this->session->set_flashdata('error', $this->lang->line('app_not_found'));
            redirect(site_url('fes'));
		}
	}
	
}

/* End of file Fes.php */
/* Location: ./application/controllers/Fes.php */
