<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-title">
                <form action="<?php echo current_url() ?>" class="form-group">

                    <div class="row form-group">
                        <div class="col col-md-12">
                            <div class="input-group">
                                <div class="input-group-btn">
                                    <button class="btn btn-primary">
                                        <i class="fa fa-search"></i> <?= $this->lang->line('app_search'); ?>
                                    </button>
                                </div>
                                <input type="text" class="form-control" name="termo" placeholder="<?= $this->lang->line('app_input_search'); ?>" />
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <p class="text-center lead"> <?= ucfirst($this->lang->line('cadastros')); ?></p>
                    <table class="table table-bordered ">
                        <thead>
                            <tr style="backgroud-color: #2D335B">
                                <th><?= ucfirst($this->lang->line('cpf')); ?></th>
                                <th><?= ucfirst($this->lang->line('nome')); ?></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if ($cadastros == null) {
                                    echo '<tr><td colspan="4">'.$this->lang->line('app_not_found').'</td></tr>';
                                }
                                foreach ($cadastros as $r) {
                                    echo '<tr>';
                                    echo '<td>' . formatar('cpf', $r->cpf) . '</td>';
									echo '<td>' . $r->nome . '</td>';
                                
                                    echo '<td>';
									
									if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vCadastro')) {
                                        echo '<a href="' . site_url('cadastros/read/'). $r->cadastro_id . '" class="btn btn-dark" title="'.$this->lang->line('app_view').'"><i class="fa fa-eye"></i></a>';
                                    }

                                    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eCadastro')) {
                                        echo ' <a href="' . site_url('cadastros/update/'). $r->cadastro_id . '" class="btn btn-info" title="'.$this->lang->line('app_edit').'"><i class="fa fa-edit"></i></a>';
                                    }
                                
                                    echo '</td>';
                                    echo '</tr>';
                                }?>
                        </tbody>
                    </table>
                </div>
                <hr>
				
                <div class="card-body">
                <div class="table-responsive">
                    <p class="text-center lead"> <?= ucfirst($this->lang->line('fes')); ?></p>
                    <table class="table table-bordered ">
                        <thead>
                            <tr style="backgroud-color: #2D335B">
                                <th><?= ucfirst($this->lang->line('cpf')); ?></th>
                                <th><?= ucfirst($this->lang->line('numfe')); ?></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if ($fes == null) {
                                    echo '<tr><td colspan="4">'.$this->lang->line('app_not_found').'</td></tr>';
                                }
                                foreach ($fes as $r) {
                                    echo '<tr>';
                                    echo '<td>' . formatar('cpf', $r->cpf) . '</td>';
									echo '<td>' . $r->nr_cautela . '</td>';
                                
                                    echo '<td>';
									
									if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vFe')) {
                                        echo '<a href="' . site_url('fes/read/'). $r->registro_id . '" class="btn btn-dark" title="'.$this->lang->line('app_view').'"><i class="fa fa-eye"></i></a>';
                                    }

                                    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eFe')) {
                                        echo ' <a href="' . site_url('fes/update/'). $r->registro_id . '" class="btn btn-info" title="'.$this->lang->line('app_edit').'"><i class="fa fa-edit"></i></a>';
                                    }
                                
                                    echo '</td>';
                                    echo '</tr>';
                                }?>
                        </tbody>
                    </table>
                </div>
                <hr>
                
				<div class="card-body">
                <div class="table-responsive">
                    <p class="text-center lead"> <?= ucfirst($this->lang->line('dds')); ?></p>
                    <table class="table table-bordered ">
                        <thead>
                            <tr style="backgroud-color: #2D335B">
                                <th><?= ucfirst($this->lang->line('cpf')); ?></th>
                                <th><?= ucfirst($this->lang->line('numdd')); ?></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if ($dds == null) {
                                    echo '<tr><td colspan="4">'.$this->lang->line('app_not_found').'</td></tr>';
                                }
                                foreach ($dds as $r) {
                                    echo '<tr>';
                                    echo '<td>' . formatar('cpf', $r->cpf) . '</td>';
									echo '<td>' . $r->nr_cautela . '</td>';
                                
                                    echo '<td>';
									
									if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vDd')) {
                                        echo '<a href="' . site_url('dds/read/'). $r->registro_id . '" class="btn btn-dark" title="'.$this->lang->line('app_view').'"><i class="fa fa-eye"></i></a>';
                                    }

                                    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eDd')) {
                                        echo ' <a href="' . site_url('dds/update/'). $r->registro_id . '" class="btn btn-info" title="'.$this->lang->line('app_edit').'"><i class="fa fa-edit"></i></a>';
                                    }
                                
                                    echo '</td>';
                                    echo '</tr>';
                                }?>
                        </tbody>
                    </table>
                </div>
                <hr>
			</div>
        </div> 
	</div>
</div>
