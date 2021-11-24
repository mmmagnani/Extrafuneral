<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-title">
                <h4>
                    <?= $button ?>
                        <?= ucfirst($this->lang->line('amparos')); ?>
                </h4>
                <hr>
            </div>
            <div class="card-body">
                <div class="basic-form">
                    <form action="<?= $action; ?>" method="post">

                        <div class="row">

                            <div class="form-group col-md-12 col-sm-12">
                                <label for="desc_amparo">
                                    <?= ucfirst($this->lang->line('desc_amparo')) ?>
                                </label>
                                <input type="text" class="form-control" name="desc_amparo" id="desc_amparo" value="<?= $desc_amparo; ?>" />
                                <?= form_error('desc_amparo') ?>
                            </div>
                        </div>
                            
                            
                        <input type="hidden" name="id_amparo" value="<?= $id_amparo; ?>" />
                        <button type="submit" class="btn btn-info">
                            <?= $button ?>
                        </button>
                        <a href="<?= site_url('amparos') ?>" class="btn btn-dark">
                            <i class="fa fa-reply"></i>
                            <?= $this->lang->line('app_cancel'); ?>
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
