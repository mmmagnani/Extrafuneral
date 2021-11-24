<?php
	$meses=array('', '01'=>'JANEIRO', '02'=>'FEVEREIRO', '03'=>'MARÇO', '04'=>'ABRIL', '05'=>'MAIO', '06'=>'JUNHO', '07'=>'JULHO', '08'=>'AGOSTO', '09'=>'SETEMBRO', '10'=>'OUTUBRO', '11'=>'NOVEMBRO', '12'=>'DEZEMBRO');
?>

<div class="row">

    <div class="col-lg-12 col-md-12 col-sm-12">

        <div class="card">
            <div class="card-title">
                Relatório de Pagamentos por Folha Extraordinária
			  <hr>
            </div>
            <div class="card-body">
                <div class="form-body">
                    <form id="rolform" action="<?= site_url('relatorios/prepare_print'); ?>" method="post" >
                    <div class="row">
                    	<div class="col-lg-12 col-md-12 col-sm-12">
                    		<label><b>Relatório do mês de <?= $meses[$datafim];?> de <?= $this->session->userdata('anofiscal'); ?></b></label>
      
                            <hr>
                        </div>
                    </div>
                    
                    
                    <div class="row"> 
						<div class="col-lg-6 col-md-6 col-sm-12">
							<div class="form-group">
								<label for="saldoconta">
									Saldo anterior da conta contábil 2.1.8.8.1.01.29
								</label>
								<input type="text" class="form-control money" name="saldoconta" id="saldoconta" value="" />
                                <?= form_error('saldoconta') ?>
							</div>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-12">
							<div class="form-group">
								<label for="suplementacao">
									Suplementação no mês
								</label>
								<input type="text" class="form-control money" name="suplementacao" id="suplementacao" value="" />
                                <?= form_error('suplementacao') ?>
							</div>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-12">
							<div class="form-group">
								<label for="devolve">
									Devolução no Mês
								</label>
								<input type="text" class="form-control money" name="devolve" id="devolve" value="" />
                                <?= form_error('devolve') ?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group">
								<label for="justificativas">
									Justificativas (FE com mais de 30 dias sem registro em contracheque)
								</label>
								<textarea class="form-control" style="resize:none" name="justificativas" id="justificativas" cols="50" rows="3"></textarea>
							</div>
						</div>
					</div>
                    <input type="hidden" name="datafim" id="datafim" value="<?= $datafim; ?>" />
					
					<div><p>&nbsp;</p></div>     
						<button type="submit" class="btn btn-info envia">
						  	<?= $this->lang->line('prepare'); ?> <?= $this->lang->line('to'); ?> <?= $this->lang->line('app_print'); ?>
                        </button> 
                        <a href="<?= site_url('fedd') ?>" class="btn btn-dark">
                            <i class="fa fa-reply"></i>
                            <?= $this->lang->line('app_cancel'); ?>
                        </a>
                    </form>
                </div>
            </div>
            <dir class="card-body">
            	<div class="card-content table-responsive">
                	<table id="table" class="table table-bordered" style="margin-bottom: 10px; width:100%">
                    
						<thead>
							<tr>

								<th>#</th>
								<th>
									REG
								</th>
								<th>
									<?= ucfirst($this->lang->line('numfe')) ?>
								</th>
								<th style="max-width:30%">
									<?= ucfirst($this->lang->line('nome')) ?>
								</th> 
                                <th>
                                	PST       
								<th>
									<?= ucfirst($this->lang->line('cpf')) ?>
								</th>                                                                        
								<th>
									<?= $this->lang->line('numero_ob') ?>
								</th>
                                <th>
                                	<?= $this->lang->line('data_ob') ?>
                                </th>
                                <th>
                                	<?= $this->lang->line('valor_r') ?>
                                </th>
                                <th>
                                	<?= $this->lang->line('tipo') ?>
                                </th>
                                
							</tr>
						</thead>

					</table>
            	</div>
            </div>
		</div>  
    </div>
</div>

<script src="<?= base_url('assets/js/lib/datatables/datatables.min.js'); ?>"></script>

<script type="text/javascript">  

	$(document).ready(function () {

		var datatable = $('#table').DataTable({
			"processing": true,
			"serverSide": true,
			"order": [],
			"ajax": {
				url: "<?= site_url('relatorios/datatable/'.$datafim); ?>",
				type: "POST",
			},
			"columnDefs": [
				{
					"targets": [],
					"orderable": false,
				},
			],
			"language": {
				"search": "<?= $this->lang->line('app_search'); ?>",
				"lengthMenu": "<?= $this->lang->line('app_per_page'); ?>",
				"zeroRecords": "<?= $this->lang->line('app_zero_records'); ?>",
				"info": "<?= $this->lang->line('app_showing'); ?>",
				"infoEmpty": "<?= $this->lang->line('app_empty'); ?>",
				"infoFiltered": "<?= $this->lang->line('app_filtered'); ?>",
				"sInfoThousands": ".",
				"oPaginate": {
					"sNext": "<?= $this->lang->line('app_next'); ?>",
					"sPrevious": "<?= $this->lang->line('app_previous'); ?>",
					"sFirst": "<?= $this->lang->line('app_first'); ?>",
					"sLast": "<?= $this->lang->line('app_last'); ?>"
				},
				"sLoadingRecords": "<?= $this->lang->line('app_loading'); ?>",
				"sProcessing": "<?= $this->lang->line('app_processing'); ?>",
			}
		});
	});
	
</script>