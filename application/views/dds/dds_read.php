<div class="col-lg-12 col-md-12 col-sm-12">
	<div class="card">
		<div class="card-title">
			<h4>
				<i class="fa fa-eye"></i>
				<?= $this->lang->line('app_view').' '.ucfirst($this->lang->line('dd')); ?>
			</h4>
		</div>
		<div class="card-body">

			<div class="vtabs">
				<ul class="nav nav-tabs tabs-vertical" role="tablist">
					<li class="nav-item"> <a class="nav-link active show" data-toggle="tab" href="#info" role="tab" aria-selected="true"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Dados DD</span> </a> </li>
					<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#banco" role="tab" aria-selected="false"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Dados Bancários</span></a> </li>
				</ul>
				<!-- Tab panes -->
				<div class="tab-content col-12">
					<div class="tab-pane active show" id="info" role="tabpanel">
						<table class="table table-bordered table-striped">
							<tr>
								<td style="width: 30%">
									<?= ucfirst($this->lang->line('cpf')) ?>
								</td>
								<td class="text-left">
									<?= formatar('cpf',$cpf); ?>
								</td>
							</tr>
							<tr>
								<td>
									<?= ucfirst($this->lang->line('nome')) ?>
								</td>
								<td class="text-left">
									<?= $nome; ?>
								</td>
							</tr>
							<tr>
								<td>
									<?= ucfirst($this->lang->line('numero_ob')) ?>
								</td>
								<td class="text-left">
									<?= $numero_ob; ?>
								</td>
							</tr> 
							<tr>
								<td>
									<?= ucfirst($this->lang->line('data_ob')) ?>
								</td>
								<td class="text-left">
									<?= $data_ob; ?>
								</td>
							</tr>  
							<tr>
								<td>
									<?= ucfirst($this->lang->line('valor_r')) ?>
								</td>
								<td class="text-left">
									<?= $valor; ?>
								</td>
							</tr>  
							<tr>
								<td>
									<?= ucfirst($this->lang->line('resgatado')) ?>
								</td>
								<td class="text-left">
									<?= $resgatado; ?>
								</td>
							</tr> 							<tr>
								<td>
									<?= ucfirst($this->lang->line('observacao')) ?>
								</td>
								<td class="text-left">
									<?= $observacao; ?>
								</td>
							</tr> 							<tr>
								<td>
									<?= ucfirst($this->lang->line('tipo')) ?>
								</td>
								<td class="text-left">
									<?= $tipo; ?>
								</td>
							</tr> 							<tr>
								<td>
									<?= ucfirst($this->lang->line('posto_falecido')) ?>
								</td>
								<td class="text-left">
									<?= $posto_falecido; ?>
								</td>
							</tr> 							<tr>
								<td>
									<?= ucfirst($this->lang->line('nome_falecido')) ?>
								</td>
								<td class="text-left">
									<?= $nome_falecido; ?>
								</td>
							</tr> 							<tr>
								<td>
									<?= ucfirst($this->lang->line('nr_falecido')) ?>
								</td>
								<td class="text-left">
									<?= $nr_falecido; ?>
								</td>
							</tr> 							<tr>
								<td>
									<?= ucfirst($this->lang->line('cpf_falecido')) ?>
								</td>
								<td class="text-left">
									<?= formatar('cpf',$cpf_falecido); ?>
								</td>
							</tr> 							<tr>
								<td>
									<?= ucfirst($this->lang->line('data_falec')) ?>
								</td>
								<td class="text-left">
									<?= $data_falec; ?>
								</td>
							</tr> 							<tr>
								<td>
									<?= ucfirst($this->lang->line('num_cert_obito')) ?>
								</td>
								<td class="text-left">
									<?= $num_cert_obito; ?>
								</td>
							</tr>
							<tr>
								<td>
									<?= ucfirst($this->lang->line('parentesco')) ?>
								</td>
								<td class="text-left">
									<?= $parentesco; ?>
								</td>
							</tr>    
                            <tr>
								<td>
									<?= ucfirst($this->lang->line('numdd')) ?>
								</td>
								<td class="text-left">
									<?= $nr_cautela; ?>
								</td>
							</tr>  
                            <tr>
								<td>
									<?= ucfirst($this->lang->line('emissao')) ?>
								</td>
								<td class="text-left">
									<?= $emissao; ?>
								</td>
							</tr>
                            <tr>
								<td>
									<?= ucfirst($this->lang->line('amparo')) ?>
								</td>
								<td class="text-left">
									<?= $amparo; ?>
								</td>
							</tr>     
                            <tr>
								<td>
									<?= ucfirst($this->lang->line('grupo_saque')) ?>
								</td>
								<td class="text-left">
									<?= $grupo_de_saque; ?>
								</td>
							</tr>                     
                            <tr>
								<td>
									<?= ucfirst($this->lang->line('registro_dd')) ?>
								</td>
								<td class="text-left">
									<?= $registro_fe; ?>
								</td>
							</tr> 							<tr>
								<td>
									<?= ucfirst($this->lang->line('justificativa_reg_dd')) ?>
								</td>
								<td class="text-left">
									<?= $justificativa_reg_fe; ?>
								</td>
							</tr>                                                                                                           
						</table>
					</div>
					<div class="tab-pane" id="banco" role="tabpanel">
						<table class="table table-bordered table-striped">
							<tr>
								<td style="width: 30%">
									<?= ucfirst($this->lang->line('banco')) ?>
								</td>
								<td class="text-left">
									<?= $banco_c; ?> - <?= $banco_n; ?>
								</td>
							</tr>
							<tr>
								<td>
									<?= ucfirst($this->lang->line('agencia')) ?>
								</td>
								<td class="text-left">
									<?= $agencia; ?>
								</td>
							</tr>
							<tr>
								<td>
									<?= ucfirst($this->lang->line('conta')) ?>
								</td>
								<td class="text-left">
									<?= $conta_corrente; ?>
								</td>
							</tr>
						</table>	
					</div>
				</div>
			</div>


			<hr>
			<a href="<?= site_url('dds/create') ?>" class="btn btn-success">
				<i class="fa fa-plus"></i>
				<?= $this->lang->line('app_create'); ?>
			</a>
			<a href="<?= site_url('dds/update/'.$registro_id) ?>" class="btn btn-info">
				<i class="fa fa-edit"></i>
				<?= $this->lang->line('app_edit'); ?>
			</a>
			<a href="<?= site_url('dds') ?>" class="btn btn-dark">
				<i class="fa fa-reply"></i>
				<?= $this->lang->line('app_back'); ?>
			</a>
			<?php if($resgatado=='Não') { ?>
			<a style="margin-left:20px" href="<?= site_url('dds/printDd/'.$registro_id) ?>" target="_blank" class="btn btn-primary">
				<i class="fa fa-print"></i>
				<?= $this->lang->line('app_print'); ?>
			</a>
			<?php } ?>

		</div>
	</div>
</div>


                             

