<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">

        <div class="card">
            <div class="card-title">
                Relatório Instituidor/Instituído
			  <hr>
            </div>
            <div class="card-body">
                <div class="form-body">
                    <form target="_blank" action="<?php echo base_url()?>index.php/relatorios/instituidorCustom" method="get">
                     <div class="row">   
                     	<div class="col-lg-4 col-md-4 col-sm-12">
                        	<div class="form-group">
                            	<label for="order">
                                	<?= ucfirst($this->lang->line('order_by')) ?>
                            	</label>
                            	<select class="form-control" name="order" id="order" />
                                    <option value="instituidor">Alfabética por nome do instituidor</option>
                                	<option value="instituido">Alfabética por nome do instituído</option>
                                    <option value="cpf_instituidor">Por CPF do instituidor</option> 
                                    <option value="cpf_instituido">Por CPF do instituído</option>                      
                                </select>
                           	</div>
                     	</div>
                    </div>
                    <div class="$row">
                        <label for="">.</label>
                        <button class="btn btn-inverse"><i class="fa fa-print"></i> <?= $this->lang->line('app_print'); ?></button>
                    </div>
                    </form>
                </div>
                .
            </div>
        </div>
    </div>
</div>