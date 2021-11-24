<?php if (!defined('BASEPATH')) { exit('No direct script access allowed'); }


    /**
     * author: Marcelo Magnani 
     * email: marcelommagnani@uol.com.br
     * 
     */
	 
class Dds extends CI_Controller
{
	 
    public function __construct()
    {
        parent::__construct();

        if ((!session_id()) || (!$this->session->userdata('logado'))) {
            redirect('fedd/login');
        }

        $this->load->model('Dds_model');
        $this->load->library('form_validation');
		$this->load->helper('formater');
    }

    public function index()
    {
        if (!$this->permission->check($this->session->userdata('permissao'), 'vDd')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_view') . ' ' . $this->lang->line('dds'));
            redirect(base_url());
        }

        $data['view'] = 'dds/dds_list';
        $this->load->view('tema/topo', $data, false);
    }

    public function datatable()
    {

        if (!$this->permission->check($this->session->userdata('permissao'), 'vDd')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_view') . ' ' . $this->lang->line('dds'));
            redirect(base_url());
        }

        $this->load->model('Dds_model');
        $result_data = $this->Dds_model->get_datatables();
        $data = array();

        foreach ($result_data as $row) {
            $line = array();
			if ($this->permission->check($this->session->userdata('permissao'), 'dDd')) {
              $line[] = '<input type="checkbox" class="remove" name="item_id[]" value="'.$row->registro_id.'">';
			} else {
			  $line[] = "";
			}
			$line[] = $row->registro_id;
            $line[] = formatar('cpf', $row->cpf);
			$line[] = $row->nr_cautela;
			$line[] = $row->tipo;
			$line[] = number_format($row->valor, 2, ",", ".");
			if ($this->permission->check($this->session->userdata('permissao'), 'dDd')) {
            	$line[] = '<a href="' . site_url('dds/read/' . $row->registro_id) . '" class="btn btn-dark" title="' . $this->lang->line('app_view') . '"><i class="fa fa-eye"></i> </a>
                       <a href="' . site_url('dds/update/' . $row->registro_id) . '" class="btn btn-info" title="' . $this->lang->line('app_edit') . '"><i class="fa fa-edit"></i></a>
                       <a href="' . site_url('dds/delete/' . $row->registro_id) . '" class="btn btn-danger delete" title="' . $this->lang->line('app_delete') . '"><i class="fa fa-window-close"></i></a>';
			} else {
				$line[] = '<a href="' . site_url('dds/read/' . $row->registro_id) . '" class="btn btn-dark" title="' . $this->lang->line('app_view') . '"><i class="fa fa-eye"></i> </a>
                       <a href="' . site_url('dds/update/' . $row->registro_id) . '" class="btn btn-info" title="' . $this->lang->line('app_edit') . '"><i class="fa fa-edit"></i></a>';
			}
            $data[] = $line;
        }

        $output = array(
            'draw' => intval($this->input->post('draw')),
            'recordsTotal' => $this->Dds_model->get_all_data(),
            'recordsFiltered' => $this->Dds_model->get_filtered_data(),
            'data' => $data,
        );
        echo json_encode($output);
    }

    public function read($id)
    {
	    $this->load->model('Banco_model');
		
        if (!is_numeric($id)) {
            $this->session->set_flashdata('error', $this->lang->line('app_not_found'));
            redirect('dds');
        }

        if (!$this->permission->check($this->session->userdata('permissao'), 'vDd')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_view') . ' ' . $this->lang->line('dds'));
            redirect(base_url());
        }

        $row = $this->Dds_model->with('cadastro')->with('tipo')->with('saque')->with('amparo')->with('posto')->with('parentesco')->get($id);
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
                'emissao' => ($row->emissao)?date('d/m/Y', strtotime($row->emissao)):"",	
				'grupo_saque' => $row->grupo_saque,
				'registro_fe' => ($row->registro_fe == 'Y')?$this->lang->line('app_yes'):$this->lang->line('app_no'),
				'justificativa_reg_fe' => $row->justificativa_reg_fe,
				'amparo_id' => $row->amparo_id,
				'posto_falecido_id' => $row->posto_falecido_id,
				'nome_falecido' => $row->nome_falecido,
				'nr_falecido' => $row->nr_falecido,
				'cpf_falecido' => $row->cpf_falecido,
				'data_falec' =>	($row->data_falec)?date('d/m/Y', strtotime($row->data_falec)):"",	
				'num_cert_obito' => $row->num_cert_obito,	
				'parentesco' => $row->parentesco,
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
			if(!is_null($row->amparo_id)){
				$data['amparo'] = $row->amparo->desc_amparo;
			} else {
				$data['amparo'] = "";
			}		
			if(!is_null($row->posto_falecido_id)){
				$data['posto_falecido'] = $row->posto->posto;
			} else {
				$data['posto_falecido'] = "";
			}	
			if(!is_null($row->parentesco)){
				$data['parentesco'] = $row->parentesco->parentesco;
			} else {
				$data['parentesco'] = "";
			}
            $data['view'] = 'dds/dds_read';
            $this->load->view('tema/topo', $data, false);
        } else {
            $this->session->set_flashdata('error', $this->lang->line('app_not_found'));
            redirect(site_url('dds'));
        }
    }

    public function create()
    {
        if (!$this->permission->check($this->session->userdata('permissao'), 'aDd')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_add') . ' ' . $this->lang->line('dds'));
            redirect(base_url());
        }
		
		$this->load->model('Numerador_model');
		$newCautela = $this->Numerador_model->get_new_numCautela(10);
		
		$this->load->model('Tipo_model');
		$where = 'tb_tipo.isFe = "0" AND tb_tipo.active = "1"';
        $tipos = $this->Tipo_model->as_dropdown('Tipo')->get_all($where);
		$tipos[''] = '';
		ksort($tipos);
		
		$this->load->model('Opcoes_model');	
        $opcoes = $this->Opcoes_model->as_dropdown('desc_opcao')->get_all();
		$opcoes[''] = '';
		ksort($opcoes);	
		
		$this->load->model('Posto_model');
        $postos = $this->Posto_model->as_dropdown('posto')->get_all();
		$postos[''] = '';
		ksort($postos);	
		
		$this->load->model('Amparo_model');
        $amparos = $this->Amparo_model->as_dropdown('desc_amparo')->get_all();
		$amparos[''] = '';
		ksort($amparos);	
		
		$this->load->model('Parentesco_model');	
        $parentescos = $this->Parentesco_model->as_dropdown('parentesco')->get_all();
		$parentescos[''] = '';
		ksort($parentescos);				
			
		$this->load->model('Saque_model');	
        $saques = $this->Saque_model->as_dropdown('grupo_de_saque')->get_all(NULL);
		$saques[''] = '';
		ksort($saques);
	

        $data = array(
            'button' => '<i class="fa fa-plus"></i> ' . $this->lang->line('app_create'),
            'action' => site_url('dds/create_action'),
			'registro_id' => set_value('registro_id'),
			'reg_ug' => set_value('reg_ug'),
			'ano' => set_value('ano'),
            'cpf' => set_value('cpf'),
            'numero_ob' => set_value('numero_ob'),
            'data_ob' => set_value('data_ob'),
			'valor' => set_value('valor'),
            'posto_falecido_id' => set_value('posto_falecido_id'),
			'postos' => $postos,
			'resgatado' => set_value('resgatado'),
			'resgate' => $opcoes,
			'tipo_id' => set_value('tipo_id'),
			'tipo' => $tipos,
            'grupo_saque' => set_value('grupo_saque'),
			'saques' => $saques,
			'observacao' => set_value('observacao'),
			'nr_cautela' => $newCautela,
			'nome_falecido' => set_value('nome_falecido'),
			'emissao' => set_value('emissao'),
			'nr_falecido' => set_value('nr_falecido'),
			'cpf_falecido' => set_value('cpf_falecido'),
			'data_falec' => set_value('data_falec'),
			'num_cert_obito' => set_value('num_cert_obito'),
			'parentesco' => set_value('parentesco'),
			'parentescos' => $parentescos,
			'amparo_id' => set_value('amparo_id'),
			'amparos' => $amparos,
			'registro_fe' => set_value('registro_fe'),
			'registro' => $opcoes,
			'justificativa_reg_fe' => set_value('justificativa_reg_fe'),

			);

        $data['view'] = 'dds/dds_form';
        $this->load->view('tema/topo', $data, false);

    }

    public function create_action()
    {
        if (!$this->permission->check($this->session->userdata('permissao'), 'aDd')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_add') . ' ' . $this->lang->line('dds'));
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
				
				$data_falec = $this->input->post('data_falec');
				if(!empty($this->input->post('data_falec'))) {
					try
            		{
                		$data_falec = explode('/', $data_falec);
                		$data_falec = $data_falec[2] . '-' . $data_falec[1] . '-' . $data_falec[0];

            		}
            		catch (exception $e)
            		{
                		$data_falec = date('Y-m-d');
            		}		
				} else {
					$data_falec = NULL;
				}

				if(empty(trim($this->input->post('numero_ob')))) {
					$numero_ob = NULL;
				} else {
					$numero_ob = trim($this->input->post('numero_ob', true));
				}
			
            	$data = array(
                	'registro_id' => $this->input->post('registro_id', true),
					'reg_ug' => $this->input->post('reg_ug', true),
                	'cpf' => preg_replace("/\D+/", "", $this->input->post('cpf', true)),
					'ano' => $this->input->post('ano', true),
                	'numero_ob' => $numero_ob,
                	'data_ob' => $data_ob,
                	'valor' => str_replace(',','.', str_replace('.','',$this->input->post('valor', true))),
                	'posto_falecido_id' => $this->input->post('posto_falecido_id', true),
                	'resgatado' => $resgatado,
                	'tipo_id' => $this->input->post('tipo_id', true),
                	'grupo_saque' => ($this->input->post('grupo_saque', true)),
                	'observacao' => $this->input->post('observacao', true),
					'cpf_falecido' => preg_replace("/\D+/", "", $this->input->post('cpf_falecido', true)),
                	'nome_falecido' => trim($this->input->post('nome_falecido', true)),
					'parentesco' => $this->input->post('parentesco', true),
					'nr_cautela' => $this->input->post('nr_cautela', true),
                	'emissao' => $emissao,
					'amparo_id' => $this->input->post('amparo_id', true),
					'nr_falecido' => $this->input->post('nr_falecido', true),
					'num_cert_obito' => trim($this->input->post('num_cert_obito', true)),
					'data_falec' => $data_falec,
					'registro_fe' => $registro_fe,
					'justificativa_reg_fe' => $this->input->post('justificativa_reg_fe', true),			
            	);

            	$this->Dds_model->insert($data);
            	$this->session->set_flashdata('success', $this->lang->line('app_add_message'));
            	redirect(site_url('dds'));
        	}
    }

    public function update($id)
    {
        if (!is_numeric($id)) {
            $this->session->set_flashdata('error', $this->lang->line('app_not_found'));
            redirect('dds');
        }

        if (!$this->permission->check($this->session->userdata('permissao'), 'eFe')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_edit') . ' ' . $this->lang->line('dds'));
            redirect(base_url());
        }
					
		$this->load->model('Tipo_model');
		$where = 'tb_tipo.isFe = "0" AND tb_tipo.active = "1"';
        $tipos = $this->Tipo_model->as_dropdown('Tipo')->get_all($where);
		$tipos[''] = '';
		ksort($tipos);
		
		$this->load->model('Opcoes_model');	
        $opcoes = $this->Opcoes_model->as_dropdown('desc_opcao')->get_all();
		$opcoes[''] = '';
		ksort($opcoes);	
		
		$this->load->model('Posto_model');
        $postos = $this->Posto_model->as_dropdown('posto')->get_all();
		$postos[''] = '';
		ksort($postos);	
		
		$this->load->model('Amparo_model');
        $amparos = $this->Amparo_model->as_dropdown('desc_amparo')->get_all();
		$amparos[''] = '';
		ksort($amparos);	
		
		$this->load->model('Parentesco_model');	
        $parentescos = $this->Parentesco_model->as_dropdown('parentesco')->get_all();
		$parentescos[''] = '';
		ksort($parentescos);				
			
		$this->load->model('Saque_model');	
        $saques = $this->Saque_model->as_dropdown('grupo_de_saque')->get_all(NULL);
		$saques[''] = '';
		ksort($saques);


        $row = $this->Dds_model->get($id);

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
                		$emissao = $emissao[2] . '/' . $emissao[1] . '/' . $emissao[0];

            		}
            		catch (exception $e)
            		{
                		$emissao = date('d/m/Y');
            		}		
				} else {
					$emissao = NULL;
				}
				
				$data_falec = $row->data_falec;
				if(!empty($row->data_falec)) {
					try
            		{
                		$data_falec = explode('-', $data_falec);
                		$data_falec = $data_falec[2] . '/' . $data_falec[1] . '/' . $data_falec[0];

            		}
            		catch (exception $e)
            		{
                		$data_falec = date('d/m/Y');
            		}		
				} else {
					$data_falec = NULL;
				}
			
			
            $data = array(
            	'button' => '<i class="fa fa-edit"></i> ' . $this->lang->line('app_edit'),
                'action' => site_url('dds/update_action'),
				'registro_id' => set_value('registro_id', $row->registro_id),
				'reg_ug' => set_value('reg_ug', $row->reg_ug),
            	'cpf' => set_value('cpf', $row->cpf),
				'ano' => set_value('ano', $row->ano),
            	'numero_ob' => set_value('numero_ob', $row->numero_ob),
            	'data_ob' => set_value('data_ob', $data_ob),
				'valor' => set_value('valor', $row->valor),
            	'posto_falecido_id' => set_value('posto_falecido_id', $row->posto_falecido_id),
				'postos' => $postos,
				'resgatado' => set_value('resgatado', $row->resgatado),
				'resgate' => $opcoes,
				'tipo_id' => set_value('tipo_id', $row->tipo_id),
				'tipo' => $tipos,
            	'grupo_saque' => set_value('grupo_saque', $row->grupo_saque),
				'saques' => $saques,
				'observacao' => set_value('observacao', $row->observacao),
				'nr_cautela' => set_value('nr_cautela', $row->nr_cautela),
				'nome_falecido' => set_value('nome_falecido', $row->nome_falecido),
				'emissao' => set_value('emissao', $emissao),
				'nr_falecido' => set_value('nr_falecido', $row->nr_falecido),
				'cpf_falecido' => set_value('cpf_falecido', $row->cpf_falecido),
				'data_falec' => set_value('data_falec', $data_falec),
				'num_cert_obito' => set_value('num_cert_obito', $row->num_cert_obito),
				'parentesco' => set_value('parentesco', $row->parentesco),
				'parentescos' => $parentescos,
				'amparo_id' => set_value('amparo_id', $row->amparo_id),
				'amparos' => $amparos,
				'registro_fe' => set_value('registro_fe', $row->registro_fe),
				'registro' => $opcoes,
				'justificativa_reg_fe' => set_value('justificativa_reg_fe', $row->justificativa_reg_fe),
	
            );
            $data['view'] = 'dds/dds_form';
            $this->load->view('tema/topo', $data, false);

        } else {
            $this->session->set_flashdata('error', $this->lang->line('app_not_found'));
            redirect(site_url('dds'));
        }
    }

    public function update_action()
    {
        if (!$this->permission->check($this->session->userdata('permissao'), 'eDd')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_edit') . ' ' . $this->lang->line('dds'));
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
				
				$data_falec = $this->input->post('data_falec');
				if(!empty($this->input->post('data_falec'))) {
					try
            		{
                		$data_falec = explode('/', $data_falec);
                		$data_falec = $data_falec[2] . '-' . $data_falec[1] . '-' . $data_falec[0];

            		}
            		catch (exception $e)
            		{
                		$data_falec = date('Y-m-d');
            		}		
				} else {
					$data_falec = NULL;
				}

				if(empty(trim($this->input->post('numero_ob')))) {
					$numero_ob = NULL;
				} else {
					$numero_ob = trim($this->input->post('numero_ob', true));
				}
			
            	$data = array(
                	'registro_id' => $this->input->post('registro_id', true),
					'reg_ug' => $this->input->post('reg_ug', true),
                	'cpf' => preg_replace("/\D+/", "", $this->input->post('cpf', true)),
					'ano' => $this->input->post('ano'),
                	'numero_ob' => $numero_ob,
                	'data_ob' => $data_ob,
                	'valor' => str_replace(',','.', str_replace('.','',$this->input->post('valor', true))),
                	'posto_falecido' => $this->input->post('posto_falecido', true),
                	'resgatado' => $this->input->post('resgatado', true),
                	'tipo_id' => $this->input->post('tipo_id', true),
                	'grupo_saque' => ($this->input->post('grupo_saque', true)),
                	'observacao' => $this->input->post('observacao', true),
					'cpf_falecido' => preg_replace("/\D+/", "", $this->input->post('cpf_falecido', true)),
                	'nome_falecido' => trim($this->input->post('nome_falecido', true)),
					'parentesco' => $this->input->post('parentesco', true),
					'nr_cautela' => $this->input->post('nr_cautela', true),
                	'emissao' => $emissao,
					'amparo_id' => $this->input->post('amparo_id', true),
					'nr_falecido' => $this->input->post('nr_falecido', true),
					'num_cert_obito' => trim($this->input->post('num_cert_obito', true)),
					'data_falec' => $data_falec,
					'registro_fe' => $this->input->post('registro_fe', true),
					'justificativa_reg_fe' => $this->input->post('justificativa_reg_fe', true),
            	);

            	$this->Dds_model->update($data, $this->input->post('registro_id', true));
            	$this->session->set_flashdata('success', $this->lang->line('app_edit_message'));
            	redirect(site_url('dds'));
        	}		
    }

    public function delete($registro_id)
    {
        if (!is_numeric($registro_id)) {
            $this->session->set_flashdata('error', $this->lang->line('app_not_found'));
            redirect('dds');
        }

        if (!$this->permission->check($this->session->userdata('permissao'), 'dDd')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_delete') . ' ' . $this->lang->line('dds'));
            redirect(base_url());
        }

        $row = $this->Dds_model->get($registro_id);
        $ajax = $this->input->get('ajax');
        

        if ($row) {


            if ($this->Dds_model->delete($registro_id)) {

                if ($ajax) {
                    echo json_encode(array('result' => true, 'message' => $this->lang->line('app_delete_message')));die();
                }
                $this->session->set_flashdata('success', $this->lang->line('app_delete_message'));
                redirect(site_url('dds'));
            } else {

                if ($ajax) {
                    echo json_encode(array('result' => false, 'message' => $this->lang->line('app_error')));die();
                }

                $this->session->set_flashdata('error', $this->lang->line('app_error'));
                redirect(site_url('dds'));
            }

        } else {

            if ($ajax) {
                echo json_encode(array('result' => false, 'message' => $this->lang->line('app_not_found')));die();
            }
            $this->session->set_flashdata('error', $this->lang->line('app_not_found'));
            redirect(site_url('dds'));
        }

    }

    public function delete_many()
    {

        if (!$this->permission->check($this->session->userdata('permissao'), 'dFe')) {
            $this->session->set_flashdata('error', $this->lang->line('app_permission_delete') . ' ' . $this->lang->line('dds'));
            redirect(base_url());
        }

        $items = $this->input->post('item_id[]');

        if ($items) {

            $verify = implode('', $items);
            if (is_numeric($verify)) {

                $result = $this->Dds_model->delete_many($items);
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
            $this->session->set_flashdata('error', $this->lang->line('app_permission_view') . ' ' . $this->lang->line('dds'));
            redirect(base_url());
        }
        
        $termo = $this->input->get('termo');

        $data['registros'] = $this->Dds_model->pesquisar($termo);

        $data['view'] = 'dds/pesquisa';
        $this->load->view('tema/topo', $data);
      
    }
	
	public function printDd($id){
	
		if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rDd')){
           $this->session->set_flashdata('error',$this->lang->line('app_permission_report'));
           redirect(base_url());
        }
		
		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		$xml =  simplexml_load_file (base_url("assets/reports/dd.jrxml"));
		
		$this->load->model('Ug_model');
		$local = $this->Ug_model->get_ug()->local_ug;		

		$this->load->model('Dds_model');
        $row = $this->Dds_model->get_one($id);

		if($row)
		{
			$valor = $row->valor;
			$valor = "R$".number_format($valor,2,',','.');
			$cautela = '"'.$row->nr_cautela.'"';
			$emissor = $this->session->userdata('nome');
			$extenso = utf8_encode(clsTexto::valorPorExtenso($valor, true, false));
			$emissao = formatar('data_extenso', $row->emissao);			
			if(!is_null($row->numero_ob)) {
				$obfull = 'NÚMERO DA ORDEM BANCÁRIA: '.$row->numero_ob.'OB'.$row->ano.'   Data: '.date('d/m/Y',strtotime($row->data_ob));
			} else {
				$obfull = 'NÚMERO DA ORDEM BANCÁRIA:              OB                       Data:____/____/____';
			}
			$emissao_extenso = $local . " " . $emissao;

			$this->PHPJasperXML = new PHPJasperXML();
			$this->PHPJasperXML->debugsql=false;
			$this->PHPJasperXML->arrayParameter=array("extenso"=>$extenso, "emissor"=>$emissor, "cautela"=>$cautela, "obfull"=>$obfull, "emissao"=>$emissao_extenso);
			$this->PHPJasperXML->xml_dismantle($xml);

			$this->PHPJasperXML->transferDBtoArray($this->db->hostname,$this->db->username,$this->db->password,$this->db->database);
			$this->PHPJasperXML->outpage("I");    //page output method I:standard output  D:Download file
	
		} else {
			$this->session->set_flashdata('error', $this->lang->line('app_not_found'));
            redirect(site_url('fes'));
		}
	}
}

/* End of file Dds.php */
/* Location: ./application/controllers/Dds.php */
