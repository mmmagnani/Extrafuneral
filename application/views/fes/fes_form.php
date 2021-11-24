<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-title">
				<?= $button ?>
                <?= ucfirst($this->lang->line('fe')); ?>
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
                   </div>
                   <div class="row">
				   <?php } ?>
                   	 <div class="col-lg-3 col-md-3 col-sm-12">
                        <div class="form-group">
                            <label for="numero_ob">
                                <?= ucfirst($this->lang->line('numero_ob')) ?>
                            </label>
                            <input type="text" class="form-control" name="numero_ob" id="numero_ob" value="<?= $numero_ob; ?>" />
                            <?= form_error('numero_ob') ?>
                        </div>
                     </div>
                     <div class="col-lg-3 col-md-3 col-sm-12">
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
                     <div class="col-lg-3 col-md-3 col-sm-12">
                        <div class="form-group">
                   	        <label for="valor">
                                <?= ucfirst($this->lang->line('valor_r')) ?>
                            </label>
                            <input type="text" class="form-control money" name="valor" id="valor" value="<?= $valor; ?>" />
                            <?= form_error('valor') ?>
                        </div>
                     </div>							
                     <div class="col-lg-3 col-md-3 col-sm-12">
                        <div class="form-group">
                            <label for="mes_resgate">
                                <?= ucfirst($this->lang->line('mes_resgate')) ?>
                            </label>
                            <?= form_dropdown('mes_resgate', $meses, $mes_resgate, array('class' => 'form-control')); ?>
                            <?= form_error('mes_resgate') ?>
                        </div>
                     </div>
                     <div class="col-lg-2 col-md-2 col-sm-12">
                        <div class="form-group">
                            <label for="resgatado">
                                <?= ucfirst($this->lang->line('resgatado')) ?>
                            </label>
                            <?= form_dropdown('resgatado', $resgate, $resgatado, array('class' => 'form-control')); ?>
                            <?= form_error('resgatado') ?>
                        </div>
                     </div>
                     <div class="col-lg-7 col-md-7 col-sm-12">
                        <div class="form-group">
                            <label for="tipo_id">
                                <?= ucfirst($this->lang->line('tipo')) ?>
                            </label>
                            <?= form_dropdown('tipo_id', $tipo, $tipo_id, array('class' => 'form-control')); ?>
                            <?= form_error('tipo_id') ?>
                        </div>
                     </div> 
                   </div>
                   <div class="row">                                            
                     <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group">
                            <label for="observacao">
                                <?= ucfirst($this->lang->line('additional_informations')) ?>
                            </label>
                            <?php if($observacao) { ?>
                            <textarea class="form-control" style="resize:none" name="observacao" id="observacao" cols="50" rows="3" ><?= $observacao; ?></textarea>
                            <?php } else { ?>
                            <textarea class="form-control" style="resize:none" name="observacao" id="observacao" cols="50" rows="3" ></textarea>
                            <?php } ?>
                            
                                <?= form_error('observacao') ?>
                        </div>
                     </div>
                   </div>
                   <div class="row">
                     <div class="col-lg-2 col-md-2 col-sm-12">
                        <div class="form-group">
                            <label for="nr_cautela">
                                <?= ucfirst($this->lang->line('numfe')) ?>
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
                     <div class="col-lg-3 col-md-3 col-sm-12">
                        <div class="form-group">
                            <label for="bol_conce">
                                <?= ucfirst($this->lang->line('bol_conce')) ?>
                            </label>
                            <input type="text" class="form-control" name="bol_conce" id="bol_conce" value="<?= $bol_conce; ?>" />
                                <?= form_error('bol_conce') ?>
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
                   </div>
                   <div class="row">
			         <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="registro_fe">
                                <?= ucfirst($this->lang->line('registro_fe')) ?>
                            </label>
                            <?= form_dropdown('registro_fe', $registro, $registro_fe, array('class' => 'form-control')); ?>
                            <?= form_error('registro_fe') ?>
                        </div>
                     </div>    
                     <div class="col-lg-8 col-md-8 col-sm-12">
                        <div class="form-group">
                            <label for="justificativa_reg_fe">
                                <?= ucfirst($this->lang->line('justificativa_reg_fe')) ?>
                            </label>
                            <?php if($justificativa_reg_fe) { ?>
                            <textarea class="form-control tip-top" style="resize:none" name="justificativa_reg_fe" id="justificativa_reg_fe" cols="50" rows="3" title="JUSTIFICAR: caso seja possível registar FE em contracheque, indicar o mês e ano do contracheque em que foi feito o registro. Caso negativo, deverá ser encaminhada cópia da respectiva FE à SDPP, juntamente com a relação de pagamento por FE no mês considerado, conforme Anexo B da presente orientação." ><?= $justificativa_reg_fe; ?></textarea>
                            <?php } else { ?>
                            <textarea class="form-control tip-top" style="resize:none" name="justificativa_reg_fe" id="justificativa_reg_fe" cols="50" rows="3" title="JUSTIFICAR: caso seja possível registar FE em contracheque, indicar o mês e ano do contracheque em que foi feito o registro. Caso negativo, deverá ser encaminhada cópia da respectiva FE à SDPP, juntamente com a relação de pagamento por FE no mês considerado, conforme Anexo B da presente orientação." ></textarea>
                            <?php } ?>
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
                        <a href="<?= site_url('fes') ?>" class="btn btn-dark">
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