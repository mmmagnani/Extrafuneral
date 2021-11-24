<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-title">
                <h4>
                    <?= $button ?>
                        <?= ucfirst($this->lang->line('gestores')); ?>
                </h4>
                <hr>
            </div>
            <div class="card-body">
                <div class="basic-form">
                    <form action="<?= $action; ?>" method="post">
				    <?php 
					// Show IF Conditional region 
					if ($id_gestores == "") { ?>
                        <div class="row">

                            <div class="form-group col-md-8 col-sm-12">
                                <label for="gestores_ug">
                                   <?= ucfirst($this->lang->line('sigla_ug')) ?>
                                </label>
                                <?= form_dropdown('gestores_ug', $sigla_ug, $gestores_ug, array('class' => 'form-control')); ?>
                                <?= form_error('gestores_ug') ?>
                            </div>
                        </div>
                        <?php } else { ?>
                        	<input type="hidden" name="gestores_ug" value="<?= $gestores_ug; ?>" />  
                        <?php } ?>
                        <div class="row">
                            <div class="form-group col-md-8 col-sm-12">
                                <label class="radio-inline" for="ordenador">
                            		<input type="radio" name="checkBoxCargo" id="s" value="0" <?= ($checkBoxCargo == "0") ? "checked" : null; ?> /> <?= ucfirst($this->lang->line('od_extenso')) ?></label>                   
                         		<label class="radio-inline offset-1">
                            		<input type="radio" name="checkBoxCargo" id="c" value="1" <?= ($checkBoxCargo == "1") ? "checked" : null; ?> /> <?= ucfirst($this->lang->line('ad_extenso')) ?></label>      

                                <input type="text" class="form-control" name="ordenador" id="ordenador" value="<?= $ordenador; ?>" />
                                <?= form_error('ordenador') ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-8 col-sm-12">
                            	<label class="radio-inline" for="agente">
                            		<input type="radio" name="checkBoxDelegado" id="a" value="0" <?= ($checkBoxDelegado == "0") ? "checked" : null; ?> /> <?= ucfirst($this->lang->line('agente')) ?></label>                   
                         		<label class="radio-inline offset-1">
                            		<input type="radio" name="checkBoxDelegado" id="d" value="1" <?= ($checkBoxDelegado == "1") ? "checked" : null; ?> /> <?= ucfirst($this->lang->line('delegado')) ?></label>      

                                <input type="text" class="form-control" name="agente" id="agente" value="<?= $agente; ?>" />
                                <?= form_error('agente') ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-8 col-sm-12">
                                <label for="financas">
                                   <?= ucfirst($this->lang->line('financas')) ?>
                                </label>
                                <input type="text" class="form-control" name="financas" id="financas" value="<?= $financas; ?>" />
                                <?= form_error('financas') ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-8 col-sm-12">
                                <label for="contabilidade">
                                   <?= ucfirst($this->lang->line('contabilidade')) ?>
                                </label>
                                <input type="text" class="form-control" name="contabilidade" id="contabilidade" value="<?= $contabilidade; ?>" />
                                <?= form_error('contabilidade') ?>
                            </div>
                        </div>
                            
                        <input type="hidden" name="id_gestores" value="<?= $id_gestores; ?>" />
                        <button type="submit" class="btn btn-info">
                            <?= $button ?>
                        </button>
                        <a href="<?= site_url('gestores') ?>" class="btn btn-dark">
                            <i class="fa fa-reply"></i>
                            <?= $this->lang->line('app_cancel'); ?>
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
