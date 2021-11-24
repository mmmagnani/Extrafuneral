<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-title">
                <h4>
                    <?= $button ?>
                        <?= ucfirst($this->lang->line('permissao')); ?>
                </h4>
                <hr>
            </div>
            <div class="card-body">
                <div class="basic-form">
                    <form action="<?= $action; ?>" method="post">

                        <div class="row">

                            <div class="form-group col-md-8 col-sm-12">
                                <label for="nome">
                                    <?= ucfirst($this->lang->line('perm_name')) ?>
                                </label>
                                <input type="text" class="form-control" name="nome" id="nome" value="<?= $nome; ?>" />
                                <?= form_error('nome') ?>
                            </div>

                            <div class="form-group col-md-4 col-sm-12">
                                <label for="situacao">
                                    <?= ucfirst($this->lang->line('perm_status')) ?>
                                </label>
                                <?=  form_dropdown('situacao', array('1' => $this->lang->line('app_active'), '0' => $this->lang->line('app_inactive')), $situacao, array('class' => 'form-control') ); ?> 
                                <?= form_error('situacao') ?>
                            </div>
                        </div>

                        <div class="form-group">

                            <table class="table table-bordered">
                                <thead>
               
                                    <tr>
                                        <th>
                                            <label>
                                                <input name="" type="checkbox" value="1" id="marcarTodos" />
                                                <span class="lbl"> <?= $this->lang->line('app_check_all'); ?></span>
                                            </label>
                                        </th>
                                        <th><?= strtoupper($this->lang->line('app_view')); ?></th>
                                        <th><?= strtoupper($this->lang->line('app_create')); ?></th>
                                        <th><?= strtoupper($this->lang->line('app_edit')); ?></th>
                                        <th><?= strtoupper($this->lang->line('app_delete')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
									<tr>
                                        <td>
                                                <?= ucfirst($this->lang->line('cadastro')); ?>
                                        </td>
                                        <td>
                                                <input <?= isset($permissoes['vCadastro']) == '1'? 'checked' : '' ?> name="vCadastro" class="marcar" type="checkbox" value="1" />
                                        </td>
                                        <td>
                                                <input <?= isset($permissoes['aCadastro']) == '1' ? 'checked' : '' ?> name="aCadastro" class="marcar" type="checkbox" value="1" />
                                        </td>
                                        <td>
                                                <input <?= isset($permissoes['eCadastro']) =='1'? 'checked' : '' ?> name="eCadastro" class="marcar" type="checkbox" value="1" />
                                        </td>
                                        <td>
                                                <input <?= isset($permissoes['dCadastro']) == '1'? 'checked' : '' ?> name="dCadastro" class="marcar" type="checkbox" value="1" />
                                        </td>
                                    </tr>
									
                                    <tr>
                                        <td>
                                                <?= ucfirst($this->lang->line('fe')); ?>
                                        </td>
                                        <td>
                                                <input <?= isset($permissoes['vFe']) == '1'? 'checked' : '' ?> name="vFe" class="marcar" type="checkbox" value="1" />
                                        </td>
                                        <td>
                                                <input <?= isset($permissoes['aFe']) == '1' ? 'checked' : '' ?> name="aFe" class="marcar" type="checkbox" value="1" />
                                        </td>
                                        <td>
                                                <input <?= isset($permissoes['eFe']) =='1'? 'checked' : '' ?> name="eFe" class="marcar" type="checkbox" value="1" />
                                        </td>
                                        <td>
                                                <input <?= isset($permissoes['dFe']) == '1'? 'checked' : '' ?> name="dFe" class="marcar" type="checkbox" value="1" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                                <?= ucfirst($this->lang->line('dd')); ?>
                                        </td>
                                        <td>
                                                <input <?= isset($permissoes['vDd']) == '1'? 'checked' : '' ?> name="vDd" class="marcar" type="checkbox" value="1" />
                                        </td>
                                        <td>
                                                <input <?= isset($permissoes['aDd']) == '1' ? 'checked' : '' ?> name="aDd" class="marcar" type="checkbox" value="1" />
                                        </td>
                                        <td>
                                                <input <?= isset($permissoes['eDd']) =='1'? 'checked' : '' ?> name="eDd" class="marcar" type="checkbox" value="1" />
                                        </td>
                                        <td>
                                                <input <?= isset($permissoes['dDd']) == '1'? 'checked' : '' ?> name="dDd" class="marcar" type="checkbox" value="1" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center" colspan="4">
                                            <?= strtoupper($this->lang->line('reports')); ?>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                                <input <?= isset($permissoes[ 'rFe']) == '1' ? 'checked' : '' ?> name="rFe" class="marcar" type="checkbox" value="1" />
                                                <?= ucfirst($this->lang->line('report')) ?> <?= ucfirst($this->lang->line('fe')); ?>
                                        </td>
										<td>
                                                <input <?= isset($permissoes[ 'relFe']) == '1' ? 'checked' : '' ?> name="relFe" class="marcar" type="checkbox" value="1" />
                                                <?= ucfirst($this->lang->line('rol')) ?> <?= $this->lang->line('of') ?> <?= ucfirst($this->lang->line('payments')) ?> <?= $this->lang->line('by') ?> <?= ucfirst($this->lang->line('fe')); ?>
                                        </td>
                                        <td>
                                                <input <?= isset($permissoes[ 'rDd']) == '1' ? 'checked' : '' ?> name="rDd" class="marcar" type="checkbox" value="1" />
                                                <?= ucfirst($this->lang->line('report')) ?> <?= ucfirst($this->lang->line('dd')); ?>
                                        </td>
                                        <td>
                                                <input <?= isset($permissoes[ 'reIn']) == '1' ? 'checked' : '' ?> name="reIn" class="marcar" type="checkbox" value="1" />
                                                <?= ucfirst($this->lang->line('report')) ?> <?= ucfirst($this->lang->line('inst_instituido')); ?>
                                        </td>

                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center" colspan="4">
                                            <?= strtoupper($this->lang->line('app_configs')); ?>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>

                                        <td>
                                                <input <?= isset($permissoes[ 'cUsuario']) == '1' ? 'checked' : '' ?> name="cUsuario" class="marcar" type="checkbox" value="1" />
                                                <?= ucfirst($this->lang->line('app_config')); ?> <?= ucfirst($this->lang->line('user')); ?>
                                        </td>
                                        <td>
                                                <input <?= isset($permissoes[ 'cGestores']) == '1' ? 'checked' : '' ?> name="cGestores" class="marcar" type="checkbox" value="1" />
                                                <?= ucfirst($this->lang->line('app_config')); ?> <?= ucfirst($this->lang->line('gestores')); ?>
                                        </td>
                                        <td>
                                                <input <?= isset($permissoes[ 'cBancos']) == '1' ? 'checked' : '' ?> name="cBancos" class="marcar" type="checkbox" value="1" />
                                                <?= ucfirst($this->lang->line('app_config')); ?> <?= ucfirst($this->lang->line('bancos')); ?>
                                        </td>
                                        <td>
                                                <input <?= isset($permissoes[ 'cUg']) == '1' ? 'checked' : '' ?> name="cUg" class="marcar" type="checkbox" value="1" />
                                                <?= ucfirst($this->lang->line('app_config')); ?> <?= ucfirst($this->lang->line('ug')); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                                <input <?= isset($permissoes[ 'cAmparos']) == '1' ? 'checked' : '' ?> name="cAmparos" class="marcar" type="checkbox" value="1" />
                                                <?= ucfirst($this->lang->line('app_config')); ?> <?= ucfirst($this->lang->line('amparos')); ?>
                                        </td>
                                        <td>
                                                <input <?= isset($permissoes[ 'cTipos']) == '1' ? 'checked' : '' ?> name="cTipos" class="marcar" type="checkbox" value="1" />
                                                <?= ucfirst($this->lang->line('app_config')); ?> <?= ucfirst($this->lang->line('tipos')); ?>
                                        </td>                                        
                                        <td>
                                                <input <?= isset($permissoes[ 'cParentescos']) == '1' ? 'checked' : '' ?> name="cParentescos" class="marcar" type="checkbox" value="1" />
                                                <?= ucfirst($this->lang->line('app_config')); ?> <?= ucfirst($this->lang->line('parentescos')); ?>
                                        </td>
                                        <td>
                                                <input <?= isset($permissoes[ 'cPermissao']) == '1' ? 'checked' : '' ?> name="cPermissao" class="marcar" type="checkbox" value="1" />
                                                <?= ucfirst($this->lang->line('app_config')); ?> <?= ucfirst($this->lang->line('permissao')); ?>
                                        </td>
								    </tr>
								    <tr>
                                        <td>
                                                <input <?= isset($permissoes[ 'cBackup']) == '1' ? 'checked' : '' ?> name="cBackup" class="marcar" type="checkbox" value="1" />
                                                <?= ucfirst($this->lang->line('app_backup')); ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>

                        <input type="hidden" name="IdPermissao" value="<?= $IdPermissao; ?>" />
                        <button type="submit" class="btn btn-info">
                            <?= $button ?>
                        </button>
                        <a href="<?= site_url('permissoes') ?>" class="btn btn-dark">
                            <i class="fa fa-reply"></i>
                            <?= $this->lang->line('app_cancel'); ?>
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function(){

        $("#marcarTodos").change(function () {
            $("input:checkbox").prop('checked', $(this).prop("checked"));
        });

    });
</script>