<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-title">
				<?= $button ?>
                <?= ucfirst($this->lang->line('dd')); ?>
                <hr>
            </div>
            <div class="card-body">
                <div class="form-body">
                    <form action="<?= $action; ?>" method="post">
                   <div class="row">   
                     <div class="col-lg-3 col-md-3 col-sm-12">
                        <div class="form-group">
                            <label for="cpf">
                                <?= ucfirst($this->lang->line('cpf')) ?>
                            </label>
                            <input type="text" class="form-control cpf" name="cpf" id="cpf" value="<?= $cpf; ?>" />
                            <?= form_error('cpf') ?>
                        </div>
                     </div>
					 <?php 
					// Show IF Conditional region 
					if ($registro_id == "") { ?>
                     <div class="col-lg-9 col-md-9 col-sm-12">
                        <div class="form-group">
                            <label for="nome">
                                <?= ucfirst($this->lang->line('nome')) ?>
                            </label>
                            <input type="text" class="form-control" name="nome" id="nome" value="" readonly="readonly" />
                            <?= form_error('nome') ?>
                        </div>
                     </div>
                   </div>
				   <div class="row">
				     <div class="col-lg-6 col-md-6 col-sm-12">
                       <div class="form-group">
                            <label for="banco">
                                <?= ucfirst($this->lang->line('banco')) ?>
                            </label>
                            <input type="text" class="form-control" name="banco" id="banco" value="" readonly="readonly" />
                           <?= form_error('banco') ?>
                        </div>
                     </div>
                     <div class="col-lg-3 col-md-3 col-sm-12">
                        <div class="form-group">
                            <label for="agencia">
                                <?= ucfirst($this->lang->line('agencia')) ?>
                            </label>
                            <input type="text" class="form-control" name="agencia" id="agencia" value="" readonly="readonly" />
                            <?= form_error('agencia') ?>
                        </div>
                     </div>
                     <div class="col-lg-3 col-md-3 col-sm-12">
                        <div class="form-group">
                            <label for="conta_corrente">
                                <?= ucfirst($this->lang->line('conta')) ?>
                            </label>
                            <input type="text" class="form-control" name="conta_corrente" id="conta_corrente" value="" readonly="readonly" />
                            <?= form_error('conta_corrente') ?>
                        </div>
                     </div> 
				   <?php } ?>                                         
                   </div>                  
                   <div class="row">
                   	 <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="numero_ob">
                                <?= ucfirst($this->lang->line('numero_ob')) ?>
                            </label>
                            <input type="text" class="form-control" name="numero_ob" id="numero_ob" value="<?= $numero_ob; ?>" />
                            <?= form_error('numero_ob') ?>
                        </div>
                     </div>
                     <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="data_ob">
                                <?= ucfirst($this->lang->line('data_ob')) ?>
                            </label>
                            <div class="input-group">
                              <input type="text" class="form-control datepicker" name="data_ob" id="data_ob" value="<?= $data_ob; ?>" />
                              <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                              <?= form_error('data_ob') ?>
                            </div>
                        </div>
                     </div>
                     <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group">
                   	        <label for="valor">
                                <?= ucfirst($this->lang->line('valor_r')) ?>
                            </label>
                            <input type="text" class="form-control money" name="valor" id="valor" value="<?= $valor; ?>" />
                            <?= form_error('valor') ?>
                        </div>
                     </div>							
                   </div>
                   <div class="row">                     
					 <div class="col-lg-2 col-md-2 col-sm-12">
                        <div class="form-group">
                            <label for="resgatado">
                                <?= ucfirst($this->lang->line('resgatado')) ?>
                            </label>
                            <?= form_dropdown('resgatado', $resgate, $resgatado, array('class' => 'form-control')); ?>
                            <?= form_error('resgatado') ?>
                        </div>
                     </div>
                     <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="observacao">
                                <?= ucfirst($this->lang->line('observacao')) ?>
                            </label>
                            <textarea class="form-control" style="resize:none" name="observacao" id="observacao" cols="50" rows="1" ><?= $observacao; ?>
                            </textarea>
                                <?= form_error('observacao') ?>
                        </div>
                     </div>
                     <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="tipo_id">
                                <?= ucfirst($this->lang->line('tipo')) ?>
                            </label>
                            <?= form_dropdown('tipo_id', $tipo, $tipo_id, array('class' => 'form-control tip-top', 'title' => 'No caso do Servidor Civil, se o Funeral for custeado por terceiro, será Indenização de Despesas com Funeral.')); ?>
                            <?= form_error('tipo_id') ?>
                        </div>
                     </div> 
                   </div>
                   <div class="row">
                     <div class="col-lg-3 col-md-3 col-sm-12">
                        <div class="form-group">
                            <label for="posto_falecido_id">
                                <?= ucfirst($this->lang->line('posto_falecido')) ?>
                            </label>
                            <?= form_dropdown('posto_falecido_id', $postos, $posto_falecido_id, array('class' => 'form-control')); ?>
                            <?= form_error('posto_falecido_id') ?>
                        </div>
                     </div>                      
                     <div class="col-lg-9 col-md-9 col-sm-12">
                        <div class="form-group">
                            <label for="nome_falecido">
                                <?= ucfirst($this->lang->line('nome_falecido')) ?>
                            </label>
                            <input type="text" class="form-control" name="nome_falecido" id="nome_falecido" value="<?= $nome_falecido; ?>" />
                            <?= form_error('nome_falecido') ?>
                        </div>
                     </div>
                   </div>
                   <div class="row">
                     <div class="col-lg-3 col-md-3 col-sm-12">
                        <div class="form-group">
                            <label for="nr_falecido">
                                <?= ucfirst($this->lang->line('nr_falecido')) ?>
                            </label>
                            <input type="text" class="form-control nr" name="nr_falecido" id="nr_falecido" value="<?= $nr_falecido; ?>" />
                            <?= form_error('nr_falecido') ?>
                        </div>
                     </div>
                     <div class="col-lg-3 col-md-3 col-sm-12">
                        <div class="form-group">
                            <label for="cpf_falecido">
                                <?= ucfirst($this->lang->line('cpf_falecido')) ?>
                            </label>
                            <input type="text" class="form-control cpf" name="cpf_falecido" id="cpf_falecido" value="<?= $cpf_falecido; ?>" />
                            <?= form_error('cpf_falecido') ?>
                        </div>
                     </div>
                     <div class="col-lg-3 col-md-3 col-sm-12">
                        <div class="form-group">
                            <label for="data_falec">
                                <?= ucfirst($this->lang->line('data_falec')) ?>
                            </label>
                            <div class="input-group">
                              <input type="text" class="form-control datepicker" name="data_falec" id="data_falec" value="<?= $data_falec; ?>" />
                              <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                              <?= form_error('data_falec') ?>
                            </div>
                        </div>
                     </div>
                     <div class="col-lg-3 col-md-3 col-sm-12">
                        <div class="form-group">
                            <label for="num_cert_obito">
                                <?= ucfirst($this->lang->line('num_cert_obito')) ?>
                            </label>
                            <input type="text" class="form-control" name="num_cert_obito" id="num_cert_obito" value="<?= $num_cert_obito; ?>" />
                            <?= form_error('num_cert_obito') ?>
                        </div>
                     </div>
                   </div>
                   <div class="row">
                     <div class="col-lg-7 col-md-7 col-sm-12">
                        <div class="form-group">
                            <label for="parentesco">
                                <?= ucfirst($this->lang->line('parentesco')) ?>
                            </label>
                            <?= form_dropdown('parentesco', $parentescos, $parentesco, array('class' => 'form-control')); ?>
                            <?= form_error('parentesco') ?>
                        </div>
                     </div>
                     <div class="col-lg-2 col-md-2 col-sm-12">
                        <div class="form-group">
                            <label for="nr_cautela">
                                <?= ucfirst($this->lang->line('numdd')) ?>
                            </label>
                            <input type="text" class="form-control tip-top" title="ATENÇÃO: Numeração automática" name="nr_cautela" id="nr_cautela" value="<?= $nr_cautela; ?>" readonly="readonly" />
                            <?= form_error('nr_cautela') ?>
                        </div>
                     </div>
                     <div class="col-lg-3 col-md-3 col-sm-12">
                        <div class="form-group">
                            <label for="emissao">
                                <?= ucfirst($this->lang->line('emissao')) ?>
                            </label>
                            <div class="input-group">
                              <input type="text" class="form-control datepicker" name="emissao" id="emissao" value="<?= $emissao; ?>" />
                              <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                              <?= form_error('emissao') ?>
                            </div>
                        </div>
                     </div>
                   </div> 
                   <div class="row">
                     <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="amparo_id">
                                <?= ucfirst($this->lang->line('amparo')) ?>
                            </label>
                            <?= form_dropdown('amparo_id', $amparos, $amparo_id, array('class' => 'form-control tip-top', 'title' => 'Se for Militar, letra &quot;h&quot; inciso I do Art. 2º da MP nº 2.215-10 de 31/08/2001. Se for Servidor Civil, será Art. 226 da Lei 8.112 de 11 de Dezembro de 1990. Se for Indenização de Despesa com Funeral, será Art. 226 e 227 da Lei 8.112 de 11 de Dezembro de 1990.')); ?>
                            <?= form_error('amparo_id') ?>
                        </div>
                     </div> 
					 <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="grupo_saque">
                                <?= ucfirst($this->lang->line('grupo_saque')) ?>
                            </label>
                            <?= form_dropdown('grupo_saque', $saques, $grupo_saque, array('class' => 'form-control')); ?>
                            <?= form_error('grupo_saque') ?>
                        </div>
                     </div>   
					 <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="registro_fe">
                                <?= ucfirst($this->lang->line('registro_dd')) ?>
                            </label>
                            <?= form_dropdown('registro_fe', $registro, $registro_fe, array('class' => 'form-control')); ?>
                            <?= form_error('registro_fe') ?>
                        </div>
                     </div>
                   </div>
                   <div class="row">    
                     <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group">
                            <label for="justificativa_reg_fe">
                                <?= ucfirst($this->lang->line('justificativa_reg_dd')) ?>
                            </label>
                            <textarea class="form-control tip-top" style="resize:none" name="justificativa_reg_fe" id="justificativa_reg_fe" cols="50" rows="1" title="Caso seja possível registrar DD em contracheque, indicar o mês e ano do contracheque em que foi feito o registro." ><?= $justificativa_reg_fe; ?>
                            </textarea>
                                <?= form_error('justificativa_reg_fe') ?>
                        </div>
                     </div>                                                                           
                   </div>       
                        <input type="hidden" name="ano" value="<?= $this->session->userdata('anofiscal'); ?>" />
                        <input type="hidden" name="registro_id" value="<?= $registro_id; ?>" />
                        <input type="hidden" name="reg_ug" value="<?= $this->session->userdata('om_id'); ?>" />
                        <div><p>&nbsp;</p></div>
                        
                        <button type="submit" class="btn btn-info envia">
                            <?= $button ?>
                        </button> 
                        <a href="<?= site_url('dds') ?>" class="btn btn-dark">
                            <i class="fa fa-reply"></i>
                            <?= $this->lang->line('app_cancel'); ?>
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(function(){
		$("#cpf").blur(function(){
		var cpf = $("#cpf").val();
		cpf = cpf.replace(/[^\d]+/g,'');
		if(cpf!="") {
		$.post('<?= site_url('fes/getbeneficiado'); ?>', {cpf:cpf}, 
		function(retorno){
				$("#nome").val(retorno.nome);
				$("#banco").val(retorno.banco);
				$("#agencia").val(retorno.agencia);
				$("#conta_corrente").val(retorno.conta_corrente);
						}, 'json')} 
			});
	});
</script>

<script type="text/javascript">
$(document).ready(function(){

    $('.datepicker').datepicker({ 
		    format: "dd/mm/yyyy",
    		todayBtn: "linked",
			clearBtn: true,
    		language: "pt-BR",
    		autoclose: true,
    		todayHighlight: true
	});
   
});

</script>