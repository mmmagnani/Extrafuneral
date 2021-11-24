<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-title">
                Relatório de Pagamentos por Folha Extraordinária
              <hr>
            </div>
              <div class="card-body">
			    <div class="form-body">
			      <form id="monthform" method="post" action="<?= site_url('relatorios/gera_rol'); ?>">
				    <div class="col-lg-3 col-md-3 col-sm-12">
					  <label for="datafim">
                        Selecione o mês do relatório
                      </label>
               	      <select class="form-control" name="datafim" id="datafim">
		    		    <option value="01">Janeiro</option>
		    		    <option value="02">Fevereiro</option>
		    		    <option value="03">Março</option>
		    		    <option value="04">Abril</option>
		    		    <option value="05">Maio</option>
		    		    <option value="06">Junho</option>
		   		 	    <option value="07">Julho</option>
		    		    <option value="08">Agosto</option>
		    		    <option value="09">Setembro</option>
		    		    <option value="10">Outubro</option>
		    		    <option value="11">Novembro</option>
		    		    <option value="12">Dezembro</option>
               	      </select>
			        </div>
					<div><p>&nbsp;</p></div>
					<button type="submit" class="btn btn-info envia">
                      Gerar Relatório
                    </button> 
                    <a href="<?= site_url('fedd') ?>" class="btn btn-dark">
                      <i class="fa fa-reply"></i>
                      <?= $this->lang->line('app_cancel'); ?>
                    </a>
			      </form>
			    </div>
              </div>
        </div>
    </div>
</div>