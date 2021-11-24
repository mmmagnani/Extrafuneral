<?php
$dados = urlencode(serialize($data));
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-title">
                Relatório de Pagamentos por Folha Extraordinária
              <hr>
            </div>
            <div class="card-body">
			    <div class="col-lg-12 col-md-12 col-sm-12">			
				    <a href="<?= site_url('relatorios/printRelatorio?datafim='.$datafim); ?>" target="_blank" class="btn btn-primary">
                    <?= $this->lang->line('app_print'); ?> <?= ucfirst($this->lang->line('report')) ?>
					</a>
				    <a href="<?= site_url('relatorios/printResumo?dados='.$dados); ?>" target="_blank" class="btn btn-secondary">
					<?= $this->lang->line('app_print'); ?> <?= ucfirst($this->lang->line('resumo')) ?>
					</a>						 
                    <a href="<?= site_url('fedd') ?>" class="btn btn-dark">
                    <i class="fa fa-reply"></i>
                    <?= $this->lang->line('app_cancel'); ?>
					</a>
			    </div>
            </div>
        </div>
    </div>
</div>