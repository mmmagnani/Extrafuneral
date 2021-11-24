<div class="row">

    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vCadastro')){ ?>
    <div class="col-md-8 col-sm-6">
        <a href="<?= site_url('cadastros') ; ?>">
            <div class="card p-30">
                <div class="media">
                    <div class="media-left meida media-middle">
                        <span>
                            <i class="fa fa-users f-s-40 color-primary"></i>
                        </span>
                    </div>
                    <div class="media-body media-text-right">
                        <p class="m-b-0">CADASTRO DE BENEFICIÁRIO</p>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <?php } ?>
    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vFe')){ ?>

    <div class="col-md-8 col-sm-6">
        <a href="<?= site_url('fes') ; ?>">
            <div class="card p-30">
                <div class="media">
                    <div class="media-left meida media-middle">
                        <span>
                            <i class="fa fa-dollar-sign f-s-40 color-success"></i>
                        </span>
                    </div>
                    <div class="media-body media-text-right">
                        <p class="m-b-0">CADASTRO DE ADIANTAMENTOS E EMISSÃO DE FOLHA EXTRAORDINÁRIA</p>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <?php } ?>
    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vDd')){ ?>

    <div class="col-md-8 col-sm-6">
        <a href="<?= site_url('dds') ; ?>">
            <div class="card p-30">
                <div class="media">
                    <div class="media-left meida media-middle">
                        <span>
                            <i class="fa fa-cross f-s-40 color-warning"></i>
                        </span>
                    </div>
                    <div class="media-body media-text-right">
                        <p class="m-b-0">CADASTRO DE DESPESAS COM FUNERAL E EMISSÃO DE DOCUMENTO DE DESPESAS</p>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <?php } ?>

</div>
