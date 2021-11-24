<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-title">
                <h4>
                    <?= $button ?>
                        <?= ucfirst($this->lang->line('banco')); ?>
                </h4>
                <hr>
            </div>
            <div class="card-body">
                <div class="basic-form">
                    <form action="<?= $action; ?>" method="post">

                        <div class="row">

                            <div class="form-group col-md-4 col-sm-12">
                                <label for="codigo_comp">
                                    <?= ucfirst($this->lang->line('codigo_comp')) ?>
                                </label>
                                <input type="text" class="form-control" name="codigo_comp" id="codigo_comp" value="<?= $codigo_comp; ?>" />
                                <?= form_error('codigo_comp') ?>
                            </div>
                            
                            <div class="form-group col-md-4 col-sm-12">
                                <label for="nome_instituicao">
                                    <?= ucfirst($this->lang->line('nome_instituicao')) ?>
                                </label>
                                <input type="text" class="form-control" name="nome_instituicao" id="nome_instituicao" value="<?= $nome_instituicao; ?>" />
                                <?= form_error('nome_instituicao') ?>
                            </div>

                            <div class="form-group col-md-4 col-sm-12">
                                <label for="ativo">
                                    <?= ucfirst($this->lang->line('situacao')) ?>
                                </label>
                                <?=  form_dropdown('ativo', array('1' => $this->lang->line('app_active'), '0' => $this->lang->line('app_inactive')), $ativo, array('class' => 'form-control') ); ?> 
                                <?= form_error('ativo') ?>
                            </div>
                        </div>


                        <input type="hidden" name="banco_id" value="<?= $banco_id; ?>" />
                        <button type="submit" class="btn btn-info">
                            <?= $button ?>
                        </button>
                        <a href="<?= site_url('bancos') ?>" class="btn btn-dark">
                            <i class="fa fa-reply"></i>
                            <?= $this->lang->line('app_cancel'); ?>
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
