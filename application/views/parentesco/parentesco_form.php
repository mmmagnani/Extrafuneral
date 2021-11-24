<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-title">
                <h4>
                    <?= $button ?>
                        <?= ucfirst($this->lang->line('parentescos')); ?>
                </h4>
                <hr>
            </div>
            <div class="card-body">
                <div class="basic-form">
                    <form action="<?= $action; ?>" method="post">

                        <div class="row">

                            <div class="form-group col-md-12 col-sm-12">
                                <label for="parentesco">
                                    <?= ucfirst($this->lang->line('tipo')) ?> <?= ucfirst($this->lang->line('parentesco')) ?>
                                </label>
                                <input type="text" class="form-control" name="parentesco" id="parentesco" value="<?= $parentesco; ?>" />
                                <?= form_error('parentesco') ?>
                            </div>
                        </div>
                            
                            
                        <input type="hidden" name="id_parentesco" value="<?= $id_parentesco; ?>" />
                        <button type="submit" class="btn btn-info">
                            <?= $button ?>
                        </button>
                        <a href="<?= site_url('parentescos') ?>" class="btn btn-dark">
                            <i class="fa fa-reply"></i>
                            <?= $this->lang->line('app_cancel'); ?>
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
