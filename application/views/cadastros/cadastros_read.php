<div class="col-lg-12 col-md-12 col-sm-12">
	<div class="card">
		<div class="card-title">
			<h4>
				<i class="fa fa-eye"></i>
				<?= $this->lang->line('app_view').' '.ucfirst($this->lang->line('cadastro')); ?>
			</h4>
		</div>
		<div class="card-body">

			<div class="vtabs">
				<ul class="nav nav-tabs tabs-vertical" role="tablist">
					<li class="nav-item"> <a class="nav-link active show" data-toggle="tab" href="#info" role="tab" aria-selected="true"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Dados Cadastrais</span> </a> </li>
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
									<?= ucfirst($this->lang->line('posto')) ?>
								</td>
								<td class="text-left">
									<?= $posto; ?>
								</td>
							</tr>
							<tr>
								<td>
									<?= ucfirst($this->lang->line('situacao')) ?>
								</td>
								<td class="text-left">
									<?= $situacao; ?>
								</td>
							</tr>
							<tr>
								<td>
									<?= ucfirst($this->lang->line('saram')) ?>
								</td>
								<td class="text-left">
									<?= $nr; ?>
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
									<?= ucfirst($this->lang->line('instituidor')) ?>
								</td>
								<td class="text-left">
									<?= $instituidor; ?>
								</td>
							</tr> 
							<tr>
								<td>
									<?= ucfirst($this->lang->line('posto')) ?>
								</td>
								<td class="text-left">
									<?= $posto_instituidor; ?>
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
									<?= $banco_c; ?>
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
			<a href="<?= site_url('cadastros/create') ?>" class="btn btn-success">
				<i class="fa fa-plus"></i>
				<?= $this->lang->line('app_create'); ?>
			</a>
			<a href="<?= site_url('cadastros/update/'.$cadastro_id) ?>" class="btn btn-info">
				<i class="fa fa-edit"></i>
				<?= $this->lang->line('app_edit'); ?>
			</a>
			<a href="<?= site_url('cadastros') ?>" class="btn btn-dark">
				<i class="fa fa-reply"></i>
				<?= $this->lang->line('app_back'); ?>
			</a>

		</div>
	</div>
</div>


                             

