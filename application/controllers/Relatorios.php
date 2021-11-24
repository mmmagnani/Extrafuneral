<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Relatorios extends CI_Controller{


    /**
     * author: Marcelo Magnani 
     * email: marcelommagnani@uol.com.br
     * 
     */
    
    public function __construct() {
        parent::__construct();
        if( (!session_id()) || (!$this->session->userdata('logado'))){
            redirect('fedd/login');
        }
        
        $this->load->model('Relatorios_model');
		$this->load->library('PHPJasperXML');
		$this->load->library('clsTexto.php');
		$this->load->library('form_validation');
		$this->load->helper('formater');

    }

    public function index() {
        header('Location: ./ Content-Type: text/html; charset=UTF-8');
		date_default_timezone_set('America/Recife');
    }

	public function rol_fe(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'relFe')){
           $this->session->set_flashdata('error','app_permission_report_fe');
           redirect(base_url());
        }

        $this->data['view'] = 'relatorios/rol_fe';
       	$this->load->view('tema/topo',$this->data);
    }
	
	public function datatable($id)
	{
		$datafim = $id;
		
		$this->load->model('Relatorios_model');
        $result_data = $this->Relatorios_model->get_datatables($datafim);
        $data = array();

        foreach ($result_data as $row) {
			
            $line = array();
			$line[] = $row->registro_id;
			$line[] = $row->desc_opcao;
			$line[] = $row->nr_cautela;
			$line[] = $row->nome;
			$line[] = $row->posto;
			$line[] = formatar('cpf', $row->cpf);
			$line[] = $row->OB;
			$line[] = date('d/m/Y', strtotime($row->data_ob));
			$line[] = $row->valor2;
			$line[] = $row->Tipo;			

            $data[] = $line;
        }

        $output = array(
            'draw' => intval($this->input->post('draw')),
            'recordsTotal' => $this->Relatorios_model->get_all_data(),
            'recordsFiltered' => $this->Relatorios_model->get_filtered_data($datafim),
            'data' => $data,
        );
		echo json_encode($output);       		
		
	}
	
	public function gera_rol()
	{
		if((($this->input->post('datafim')<6) && ($this->session->userdata('anofiscal')==2021)) || (($this->input->post('datafim')<13) && ($this->session->userdata('anofiscal')<2021))) {
			$this->session->set_flashdata('error','app_limit_report');
           redirect(base_url());
		}
		$datafim = $this->input->post('datafim');
		
		$this->data['datafim'] = $datafim;
        $this->data['view'] = 'relatorios/rol_fe2';
       	$this->load->view('tema/topo',$this->data);
	}	
	
	public function prepare_print()
	{
		if(!$this->permission->checkPermission($this->session->userdata('permissao'),'relFe')){
           $this->session->set_flashdata('error','app_permission_report_fe');
           redirect(base_url());
        }
		$this->_rules();
		
		if ($this->form_validation->run() == false) {
            $this->gera_rol();
        } else {
			$datafim = $this->input->post('datafim');
			$saldoconta = floatval(str_replace(',','.',str_replace('.','',$this->input->post('saldoconta')))); 
			$suplemento = floatval(str_replace(',','.',str_replace('.','',$this->input->post('suplementacao'))));
			$devolve = floatval(str_replace(',','.',str_replace('.','',$this->input->post('devolve'))));
			$justificativas = $this->input->post('justificativas')."\n";
			$datahoje = formatar("data_extenso", date("Y-m-d"));
			$anoatual = date('Y');
			$this->load->model('Relatorios_model');
			$local = $this->Relatorios_model->get_locale()->local_ug;
			$localdata = strtoupper($local). " " . strtoupper($datahoje);
			$total = floatval($this->Relatorios_model->get_total($datafim)->total);
			$stotal = $saldoconta+$suplemento-$devolve-$total;
        	$result_data = $this->Relatorios_model->get_summary($datafim);
			$data = array();
			$tiposfe = $this->Relatorios_model->TiposFe();
			$x = 0;	
			foreach ($tiposfe as $row2) {
				$x= $x+1;
				foreach ($result_data as $row) {											
					if($row->Tipo == $row2->Tipo){
						$texto = $row2->Tipo;
						$texto = substr($texto, 26);
						$data['motivo'.$x] = $texto;
				    	$data['stotais'.$x] = $row->subtotal;
						break;
					} else {						
						$texto = $row2->Tipo;
						$texto = substr($texto, 26);
						$data['motivo'.$x] = $texto;
				    	$data['stotais'.$x] = '0.00';
					}
				}
			}					
			$data['datafim'] = $datafim;
			$data['mesano'] = $mesano;
			$data['anoatual'] = $anoatual;
			$data['localdata'] = $localdata;
			$data['saldoconta'] = number_format($saldoconta,2,',','.');
			$data['suplemento'] = number_format($suplemento,2,',','.');
			$data['stotal'] = number_format($stotal,2,',','.');
			$data['total'] = number_format($total,2,',','.');
			$data['devolve'] = number_format($devolve,2,',','.');
			$data['justificativas'] = $justificativas;
			$this->data['datafim'] = $datafim;
			$this->data['data'] = $data;
        	$this->data['view'] = 'relatorios/print_rel';
       		$this->load->view('tema/topo',$this->data);
		}
	}
	
	public function _rules()
    {
        $this->form_validation->set_rules('saldoconta', '<b>' . $this->lang->line('saldo') . '</b>', 'trim|required|min_length[4]');
        $this->form_validation->set_rules('suplementacao', '<b>' . $this->lang->line('suplementacao') . '</b>', 'trim|required|min_length[4]');			
        $this->form_validation->set_rules('devolve', '<b>' . $this->lang->line('devolve') . '</b>', 'trim|required|min_length[4]');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
	
	public function printRelatorio()
	{
	
		if(!$this->permission->checkPermission($this->session->userdata('permissao'),'relFe')){
           $this->session->set_flashdata('error','app_permission_report_fe');
           redirect(base_url());
        }
		$meses=array('', '01'=>'JANEIRO', '02'=>'FEVEREIRO', '03'=>'MARÇO', '04'=>'ABRIL', '05'=>'MAIO', '06'=>'JUNHO', '07'=>'JULHO', '08'=>'AGOSTO', '09'=>'SETEMBRO', '10'=>'OUTUBRO', '11'=>'NOVEMBRO', '12'=>'DEZEMBRO');
		
		$mesano = $meses[$_GET['datafim']] . ' DE ' . $this->session->userdata('anofiscal');
		$data['datafim'] = $_GET['datafim'];
		$data['mesano'] = $mesano;

		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		$xml =  simplexml_load_file (base_url("assets/reports/relatoriofe.jrxml"));

			
			$this->PHPJasperXML = new PHPJasperXML();
			$this->PHPJasperXML->debugsql=false;
			$this->PHPJasperXML->arrayParameter = $data;
			$this->PHPJasperXML->xml_dismantle($xml);

			$this->PHPJasperXML->transferDBtoArray($this->db->hostname,$this->db->username,$this->db->password,$this->db->database);
			$this->PHPJasperXML->outpage("I", "Relatorio.pdf");    //page output method I:standard output  D:Download file
	
	}
	
	public function printResumo()
	{
		if(!$this->permission->checkPermission($this->session->userdata('permissao'),'relFe')){
           	$this->session->set_flashdata('error','app_permission_report_fe');
           	redirect(base_url());
        }
		
			error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
			$xml =  simplexml_load_file (base_url("assets/reports/resumo.jrxml"));
			
			$data = unserialize(stripslashes(urldecode($_GET['dados'])));

			$this->PHPJasperXML = new PHPJasperXML();
			$this->PHPJasperXML->debugsql=false;
			$this->PHPJasperXML->arrayParameter = $data;
			$this->PHPJasperXML->xml_dismantle($xml);

			$this->PHPJasperXML->transferDBtoArray($this->db->hostname,$this->db->username,$this->db->password,$this->db->database);
			$this->PHPJasperXML->outpage("I", "Resumo.pdf");    //page output method I:standard output  D:Download file	
	}
	
	public function instituidor()
	{

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'reIn')){
           $this->session->set_flashdata('error','app_permission_report_inst');
           redirect(base_url());
        }
		
        $this->data['view'] = 'relatorios/rel_instituidor';
       	$this->load->view('tema/topo',$this->data);
    }
	
	public function instituidorCustom()
	{
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'reIn')){
           $this->session->set_flashdata('error','app_permission_report_inst');
           redirect(base_url());
        }

        $order = $this->input->get('order');
		$this->load->model('Ug_model');
		$data['ug'] = $this->Ug_model->get_ug()->nome_ug;

        $data['instituidor'] = $this->Relatorios_model->instituidorCustom($order);

        $this->load->helper('mpdf');
        
        $html = $this->load->view('relatorios/imprimir/imprimirInstituidor', $data, true);
        pdf_create($html, 'relatorio_instituidor' . date('d/m/y'), TRUE);
    
    }
    
}
