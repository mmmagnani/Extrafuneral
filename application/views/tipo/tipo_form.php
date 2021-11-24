<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-title">
                <h4>
                    <?= $button ?>
                        <?= ucfirst($this->lang->line('tipo')); ?>
                </h4>
                <hr>
            </div>
            <div class="card-body">
                <div class="basic-form">
                    <form action="<?= $action; ?>" method="post">

                        <div class="row">

                            <div class="form-group col-md-12 col-sm-12">
                                <label for="Tipo">
                                    <?= ucfirst($this->lang->line('Tipo')) ?>
                                </label>
                                <input type="text" class="form-control" name="Tipo" id="Tipo" value="<?= $Tipo; ?>" />
                                <?= form_error('Tipo') ?>
                            </div>
                            
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="isFe">
                                    <?= ucfirst($this->lang->line('isFe')) ?>
                                </label>
                                <?=  form_dropdown('isFe', array('1' => $this->lang->line('app_yes'), '0' => $this->lang->line('app_no')), $isFe, array('class' => 'form-control') ); ?> 
                                <?= form_error('isFe') ?>
                            </div>

                            <div class="form-group col-md-6 col-sm-12">
                                <label for="active">
                                    <?= ucfirst($this->lang->line('situacao')) ?>
                                </label>
                                <?=  form_dropdown('active', array('1' => $this->lang->line('app_active'), '0' => $this->lang->line('app_inactive')), $active, array('class' => 'form-control') ); ?> 
                                <?= form_error('active') ?>
                            </div>
                        </div>


                        <input type="hidden" name="id_tipo" value="<?= $id_tipo; ?>" />
                        <button type="submit" class="btn btn-info">
                            <?= $button ?>
                        </button>
                        <a href="<?= site_url('tipos') ?>" class="btn btn-dark">
                            <i class="fa fa-reply"></i>
                            <?= $this->lang->line('app_cancel'); ?>
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
