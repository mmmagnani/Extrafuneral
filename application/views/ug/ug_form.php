<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-title">
                <h4>
                    <?= $button ?>
                        <?= ucfirst($this->lang->line('ug')); ?>
                </h4>
                <hr>
            </div>
            <div class="card-body">
                <div class="basic-form">
                    <form action="<?= $action; ?>" method="post">

                        <div class="row">

                            <div class="form-group col-md-4 col-sm-12">
                                <label for="sigla_ug">
                                   <?= ucfirst($this->lang->line('sigla_ug')) ?>
                                </label>
                                <input type="text" class="form-control" name="sigla_ug" id="sigla_ug" value="<?= $sigla_ug; ?>" />
                                <?= form_error('sigla_ug') ?>
                            </div>
                            <div class="form-group col-md-4 col-sm-12">
                                <label for="nome_ug">
                                   <?= ucfirst($this->lang->line('ug')) ?>
                                </label>
                                <input type="text" class="form-control" name="nome_ug" id="nome_ug" value="<?= $nome_ug; ?>" />
                                <?= form_error('nome_ug') ?>
                            </div>
                            <div class="form-group col-md-4 col-sm-12">
                                <label for="cod_ug">
                                   <?= ucfirst($this->lang->line('cod_ug')) ?>
                                </label>
                                <input type="text" class="form-control" name="cod_ug" id="cod_ug" value="<?= $cod_ug; ?>" />
                                <?= form_error('cod_ug') ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12 col-sm-12">
                                <label for="local_ug">
                                   <?= ucfirst($this->lang->line('local')) ?>
                                </label>
                                <input type="text" class="form-control" name="local_ug" id="local_ug" value="<?= $local_ug; ?>" />
                                <?= form_error('local_ug') ?>
                            </div>
                        </div>
                            
                        <input type="hidden" name="id_ug" value="<?= $id_ug; ?>" />
                        <button type="submit" class="btn btn-info">
                            <?= $button ?>
                        </button>
                        <a href="<?= site_url('ug') ?>" class="btn btn-dark">
                            <i class="fa fa-reply"></i>
                            <?= $this->lang->line('app_cancel'); ?>
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
