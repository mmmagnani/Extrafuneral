<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-title">
                <h4>
                    <?= $button ?>
                        <?= ucfirst($this->lang->line('user')); ?>
                </h4>
                <hr>
            </div>
            <div class="card-body">
                <div class="basic-form">
                    <form action="<?= $action; ?>" method="post">
                        <div class="form-group">
                            <label for="usu_nome">
                                <?= ucfirst($this->lang->line('user_name')) ?>
                            </label>
                            <input type="text" class="form-control" name="usu_nome" id="usu_nome" value="<?= $usu_nome; ?>" />
                            <?= form_error('usu_nome') ?>
                        </div>

                        <div class="form-group">
                            <label for="usu_email">
                                <?= ucfirst($this->lang->line('user_email')) ?>
                            </label>
                            <input type="text" class="form-control" name="usu_email" id="usu_email" value="<?= $usu_email; ?>" />
                            <?= form_error('usu_email') ?>
                        </div>
                        <div class="form-group">
                            <label for="usu_senha">
                                <?= ucfirst($this->lang->line('user_password')) ?>
                            </label>
                            <input type="password" class="form-control" name="usu_senha" id="usu_senha" value="<?= $usu_senha; ?>" placeholder="<?= $this->uri->segment(2) == 'update' ? $this->lang->line('user_change_password') : ''; ?>" />
                            <?= form_error('usu_senha') ?>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="usu_active">
                                        <?= ucfirst($this->lang->line('user_status')) ?>
                                    </label>
                                    <?php 
                                        $options = array(
                                            '1' => $this->lang->line('app_active'),
                                            '0' => $this->lang->line('app_inactive')
                                        );
                                        echo form_dropdown('usu_active', $options, $usu_active, array('class' => 'form-control'));
                                        echo form_error('usu_active');

                                    ?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                              <div class="form-group">
                                    <label for="permissao_id">
                                        <?= ucfirst($this->lang->line('user_group')) ?>
                                    </label>
                                    <?= form_dropdown('permissao_id', $permissoes, $permissao_id, array('class' => 'form-control')); ?>
                                  <?= form_error('permissao_id') ?>
                                </div>
                            </div>
                        </div>
						<input type="hidden" name="usu_ug" value="<?= $usu_ug; ?>" />
                        <input type="hidden" name="usu_id" value="<?= $usu_id; ?>" />
                        <button type="submit" class="btn btn-info">
                            <?= $button ?>
                        </button>
                        <a href="<?= site_url('usuarios') ?>" class="btn btn-dark">
                            <i class="fa fa-reply"></i>
                            <?= $this->lang->line('app_cancel'); ?>
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>