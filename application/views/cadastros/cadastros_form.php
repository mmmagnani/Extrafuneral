<link href="<?= base_url('assets/css/lib/sweetalert/sweetalert.css'); ?>" rel="stylesheet">
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-title">
<?= $button ?>
                    <?= ucfirst($this->lang->line('cadastro')); ?>
              
                <hr>
            </div>
            <div class="card-body">
                <div class="form-body">
                    <form id="cadform" action="<?= $action; ?>" method="post">
                   <div class="row">
                     
                     <div class="col-lg-3 col-md-3 col-sm-12">
                        <div class="form-group">
                            <label for="cpf">
                                <?= ucfirst($this->lang->line('cpf')) ?>
                            </label>
							<?php
							// Show IF Conditional region 
							 if($cadastro_id == "") { ?>
                            <input type="text" class="form-control cpf" name="cpf" id="cpf" value="<?= $cpf; ?>"  />
							<?php } else { ?>
							<input type="text" class="form-control cpf" name="cpf" id="cpf" value="<?= $cpf; ?>" readonly="readonly"  />
							<?php } 
							// End conditional region
							?>
                            <?= form_error('cpf') ?>
                        </div>
                     </div>
                     <div class="col-lg-7 col-md-7 col-sm-12">
                        <div class="form-group">
                            <label for="nome">
                                <?= ucfirst($this->lang->line('nome')) ?>
                            </label>
                            <input type="text" class="form-control" name="nome" id="nome" onkeyup="this.value = this.value.toUpperCase()" value="<?= $nome; ?>" />
                            <?= form_error('nome') ?>
                        </div>
                     </div>
                     <div class="col-lg-2 col-md-2 col-sm-12">
                        <div class="form-group">
                            <label for="posto_id">
                                <?= ucfirst($this->lang->line('posto')) ?>
                            </label>
                            <?= form_dropdown('posto_id', $postos, $posto_id, array('class' => 'form-control')); ?>
                            <?= form_error('posto_id') ?>
                        </div>
                     </div>
                     
                  </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12">
                            	<div class="form-group">
                            	<label for="situacao_id">
                                	<?= ucfirst($this->lang->line('situacao')) ?>
                            	</label>
                            	<?= form_dropdown('situacao_id', $situacoes, $situacao_id, array('class' => 'form-control')); ?>
                            	<?= form_error('situacao_id') ?>
                        		</div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="nr">
                                        <?= ucfirst($this->lang->line('saram')) ?>
                                    </label>
                                    <input type="text" class="form-control nr" name="nr" id="nr" maxlength="7" value="<?= $nr; ?>" />
                                    <?= form_error('nr') ?>
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
                            <label for="banco">
                                	<?= ucfirst($this->lang->line('banco')) ?>
                            	</label>
                            	<?= form_dropdown('banco', $bancos, $banco, array('class' => 'form-control')); ?>
                            	<?= form_error('banco') ?>
                        </div>
                        </div>

                        
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="agencia">
                                        <?= ucfirst($this->lang->line('agencia')) ?>
                                    </label>
                                    <input type="text" class="form-control" name="agencia" id="agencia" value="<?= $agencia; ?>" />
                                    <?= form_error('agencia') ?>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="conta_corrente">
                                        <?= ucfirst($this->lang->line('conta')) ?>
                                    </label>
                                    <input type="text" class="form-control" name="conta_corrente" id="conta_corrente" value="<?= $conta_corrente; ?>" />
                                    <?= form_error('conta_corrente') ?>
                                </div>
                            </div>
                        </div>
						<fieldset>
                        <legend>Somente Pensionistas e Alimentando</legend>
                        <div class="row" style="background-color:#F00; color:#FFF">
                            
                            <div class="col-lg-7 col-md-7 col-sm-12">
                                <div class="form-group">
                                    <label for="instituidor">
                                        <?= ucfirst($this->lang->line('instituidor')) ?>
                                    </label>
                                    <input type="text" class="form-control" name="instituidor" id="instituidor" onkeyup="this.value = this.value.toUpperCase()" value="<?= $instituidor; ?>" />
                                    <?= form_error('instituidor') ?>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-12">
                        <div class="form-group">
                            <label for="posto_instituidor_id">
                                <?= ucfirst($this->lang->line('posto')) ?>
                            </label>
                            <?= form_dropdown('posto_instituidor_id', $postos_inst, $posto_instituidor_id, array('class' => 'form-control')); ?>
                            <?= form_error('posto_instituidor_id') ?>
                        </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="cpf_instituidor">
                                        <?= ucfirst($this->lang->line('cpf')) ?>
                                    </label>
                                    <input type="text" class="form-control cpf" name="cpf_instituidor" id="cpf_instituidor" value="<?= $cpf_instituidor; ?>" />
                                    <?= form_error('cpf_instituidor') ?>
                                </div>
                            </div>
                          </div>
                          </fieldset>
                        
                        <input type="hidden" name="cadastro_id" value="<?= $cadastro_id; ?>" />
                        <input type="hidden" name="cad_ug" value="<?= $this->session->userdata('om_id'); ?>" />
                        <div><p>&nbsp;</p></div>
                        
                        <button type="submit" class="btn btn-info envia">
                            <?= $button ?>
                        </button> 
                        <a href="<?= site_url('cadastros') ?>" class="btn btn-dark">
                            <i class="fa fa-reply"></i>
                            <?= $this->lang->line('app_cancel'); ?>
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/js/lib/sweetalert/sweetalert.min.js'); ?>"></script><script type="text/javascript">  
$(document).on('click', '.envia', function (event) {
	event.preventDefault();
	if(document.getElementById("instituidor").value==""){
			
			swal({
				title: "<?= $this->lang->line('app_attention'); ?>",
				text: "<?= $this->lang->line('app_confirm_not_instituidor'); ?>",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "<?= $this->lang->line('app_yes'); ?>",
				cancelButtonText: "<?= $this->lang->line('app_cancel'); ?>",
				showLoaderOnConfirm: true,
				closeOnConfirm: true
			},
			function(isConfirm) {
			    var cpf = $("#cpf").val();
				if (isConfirm) {					  
					  $("#cpf").val(cpf.replace(/[^\d]+/g,''));
					  document.getElementById('cadform').submit()
				}
			
			});
			
	} else {
			document.getElementById('cadform').submit();
	}
});
</script>