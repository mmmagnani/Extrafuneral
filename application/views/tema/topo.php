<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Sistema de de Folha Extraordinária e Funeral">
	<meta name="author" content="Magnani">
	<!-- Favicon icon -->
	<link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/images/favicon-16x16.png'); ?>">
	<title>FE/DD - Sistema de Folha Extraordinária e Funeral</title>
	<!-- Bootstrap Core CSS -->
	<link href="<?= base_url('assets/css/lib/bootstrap/bootstrap.min.css'); ?>" rel="stylesheet">
	<!-- Custom CSS -->
	<link href="<?= base_url('assets/css/helper.css'); ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/style.css'); ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/lib/toastr/toastr.min.css'); ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/lib/data-table/dataTables.bootstrap4.min.css'); ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/lib/datepicker/bootstrap-datepicker3.min.css'); ?>" rel="stylesheet">	
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:** -->
	<!--[if lt IE 9]>
		<script src="https:**oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https:**oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	<!-- Jquery -->
	<script src="<?= base_url('assets/js/lib/jquery/jquery.min.js'); ?>"></script>
	<script src="<?= base_url('assets/js/lib/toastr/toastr.min.js'); ?>"></script>
	<script src="<?= base_url('assets/js/lib/datepicker/bootstrap-datepicker.min.js'); ?>"></script>
	<script src="<?= base_url('assets/locales/bootstrap-datepicker.pt-BR.min.js' ); ?>" charset='UTF-8'></script>
    <script src="<?= base_url('assets/js/lib/jquery.mask/jquery.mask.min.js'); ?>"></script>
	<script src="<?= base_url('assets/js/tip-top.js'); ?>"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$(".cpf").mask("###.###.###-##");
			$(".nr").mask("######-#");
			$(".datepicker").mask("##/##/####");
			$('.money').mask('###.###.##0,00', {reverse: true});
		})
	</script>
</head>

<body class="fix-header fix-sidebar">
	<!-- Preloader - style you can find in spinners.css -->
	<div class="preloader">
		<svg class="circular" viewBox="25 25 50 50">
			<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
	</div>
	<!-- Main wrapper  -->
	<div id="main-wrapper">
		<!-- header header  -->
		<div class="header">
			<nav class="navbar top-navbar navbar-expand-md navbar-light">
				<!-- Logo -->
				<div class="navbar-header">
					<a class="navbar-brand" href="<?= base_url() ?> ">
						<!-- Logo icon -->
						<b>
							<img style="max-height: 24px; max-width: 60px" src="<?= base_url('assets/images/logo.png'); ?>" class="dark-logo img-responsive" />
						</b>
						<!--End Logo icon -->
						<!-- Logo text -->
						<span>
							<img style="max-height: 24px; max-width: 120px" src="<?= base_url('assets/images/logo-text.png'); ?>" alt="MapOS" class="dark-logo img-responsive"
							/>
						</span>
					</a>
				</div>
				<!-- End Logo -->
				<div class="navbar-collapse">
					<!-- toggle and nav items -->
					<ul class="navbar-nav mr-auto mt-md-0">
						<!-- This is  -->
						<li class="nav-item">
							<a class="nav-link nav-toggler hidden-md-up text-muted  " href="javascript:void(0)">
								<i class="mdi mdi-menu"></i>
							</a>
						</li>
						<li class="nav-item m-l-10">
							<a class="nav-link sidebartoggler hidden-sm-down text-muted  " href="javascript:void(0)">
								<i class="ti-menu"></i>
							</a>
						</li>
						<!-- Messages -->
						<li class="nav-item dropdown mega-dropdown">
							<a class="nav-link dropdown-toggle text-muted  " href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fa fa-th-large"></i>
							</a>
							<div class="dropdown-menu animated zoomIn">
								<ul class="mega-dropdown-menu row">


									<li class="col-lg-2 m-b-30">
										<h4 class="m-b-20">ACESSO RÁPIDO</h4>
										<ul>
											<li>
												<a href="<?= site_url('cadastros/create') ?>" class="btn btn-primary col-12"><i class="fa fa-plus"></i> Beneficiário</a>
											</li>
											<li>
												<a href="<?= site_url('fes/create') ?>" class="btn btn-primary col-12">Cadastrar FE</a>
											</li>
											<li>
												<a href="<?= site_url('dds/create') ?>" class="btn btn-primary col-12">Cadastrar DD</a>
											</li>

										</ul>
									</li>
									<li class="col-lg-3 col-xlg-3 m-b-30">
										<h4 class="m-b-20">Beneficiários</h4>

										<form class="app-search" action="<?= site_url('cadastros/pesquisar'); ?>" method="GET" >
											<div class="form-group">
												<input type="text" class="form-control" name="termo" id="" placeholder="Digite o nome ou o CPF"> </div>
											<button type="submit" class="btn btn-info">Pesquisar Beneficiários</button>
										</form>

									</li>
									<li class="col-lg-3 col-xlg-3 m-b-30">
										<h4 class="m-b-20">FE</h4>

										<form class="app-search" action="<?= site_url('fes/pesquisar'); ?>" method="GET" >
											<div class="form-group">
												<input type="text" class="form-control" name="termo" id="" placeholder="Digite o CPF ou Nº da FE"> </div>
											<button type="submit" class="btn btn-info">Pesquisar FE</button>
										</form>
									</li>
									<li class="col-lg-3 col-xlg-3 m-b-30">
										<h4 class="m-b-20">DD</h4>

										<form class="app-search" action="<?= site_url('dds/pesquisar'); ?>" method="GET" >
											<div class="form-group">
												<input type="text" class="form-control" name="termo" id="" placeholder="Digite o CPF ou Nº da DD"> </div>
											<button type="submit" class="btn btn-info">Pesquisar DD</button>
										</form>
									</li>
								</ul>
							</div>
						</li>
						<!-- End Messages -->
					</ul>
					<!-- User profile and search -->
					<ul class="navbar-nav my-lg-0">

						<!-- Search -->
						<li class="nav-item hidden-sm-down search-box">
							<a class="nav-link hidden-sm-down text-muted  " href="javascript:void(0)">
								<i class="ti-search"></i>
							</a>
							<form class="app-search" action="<?= site_url('fedd/pesquisar'); ?>" method="GET" >
								<input type="text" name="termo" class="form-control" placeholder="Pesquise aqui">
								<a class="srh-btn">
									<i class="ti-close"></i>
								</a>
							</form>
						</li>

						<!-- Profile -->
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle text-muted  " href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<img src="<?= base_url('assets/images/user.png'); ?>" alt="user" class="profile-pic" />
							</a>
							<div class="dropdown-menu dropdown-menu-right animated zoomIn">
								<ul class="dropdown-user">
									<li>
										<a href="<?= site_url('fedd/conta'); ?>">
											<i class="ti-user"></i> Perfil</a>
									</li>
									<li>
										<a href="<?= site_url('fedd/sair'); ?>">
											<i class="fa fa-power-off"></i> Sair do Sistema</a>
									</li>
								</ul>
							</div>
						</li>
					</ul>
				</div>
			</nav>
		</div>
		<!-- End header header -->
		<!-- Left Sidebar  -->
		<div class="left-sidebar">
			<!-- Sidebar scroll-->
			<div class="scroll-sidebar">
				<!-- Sidebar navigation-->
				<nav class="sidebar-nav">
					<ul id="sidebarnav">
						<li class="nav-devider"></li>

						<li class="nav-label">Menu</li>

						<li>
							<a href="<?= site_url() ?>" aria-expanded="false">
								<i class="fa fa-tachometer-alt"></i>
								<span class="hide-menu">Painel</span>
							</a>
						</li>
						<li>
							<a href="<?= site_url('cadastros') ?>" aria-expanded="false">
								<i class="fa fa-users"></i>
								<span class="hide-menu">Beneficiários</span>
							</a>
						</li>
						<li>
							<a href="<?= site_url('fes') ?>" aria-expanded="false">
								<i class="fa fa-dollar-sign"></i>
								<span class="hide-menu">FE</span>
							</a>
						</li>
						<li>
							<a href="<?= site_url('dds') ?>" aria-expanded="false">
								<i class="fa fa-cross"></i>
								<span class="hide-menu">DD</span>
							</a>
						</li>
						<li>
							<a class="has-arrow  " href="#" aria-expanded="false">
								<i class="fa fa-scroll"></i>
								<span class="hide-menu">Relatórios</span>
							</a>
							<ul aria-expanded="false" class="collapse">
								<li>
									<a href="<?= site_url('relatorios/rol_fe'); ?>">Pagamentos por FE</a>
								</li>
                                <li>
									<a href="<?= site_url('relatorios/instituidor'); ?>">Instituidor/Instituído</a>
								</li>
							</ul>
						</li>

						<li>
							<a class="has-arrow  " href="#" aria-expanded="false">
								<i class="fa fa-cogs"></i>
								<span class="hide-menu">Configurações</span>
							</a>
							<ul aria-expanded="false" class="collapse">
								<li>
									<a href="<?= site_url('usuarios'); ?>">Usuários</a>
								</li>
                                
                                <li>
									<a href="<?= site_url('bancos'); ?>">Bancos</a>
								</li>								

								<li>
									<a href="<?= site_url('amparos'); ?>">Amparos</a>
								</li>
								
                                <li>
									<a href="<?= site_url('tipos'); ?>">Motivos</a>
								</li>								
                                
                                <li>
									<a href="<?= site_url('parentescos'); ?>">Parentescos</a>
								</li>
                                
                                <li>
									<a href="<?= site_url('ug'); ?>">OM</a>
								</li>
                                
                                <li>
									<a href="<?= site_url('gestores'); ?>">Gestores</a>
								</li>
                                
								<li>
									<a href="<?= site_url('permissoes'); ?>">Permissões</a>
								</li>
								<li>
									<a href="<?= site_url('fedd/backup'); ?>">Backup</a>
								</li>
			
							</ul>
						</li>

					</ul>
				</nav>
				<!-- End Sidebar navigation -->
			</div>
			<!-- End Sidebar scroll-->
		</div>
		<!-- End Left Sidebar  -->
		<!-- Page wrapper  -->
		<div class="page-wrapper">
			<!-- Bread crumb -->
			<div class="row page-titles">
				<div class="col-md-5 align-self-center">
					<h3 class="text-primary">
					<?php if(($this->uri->segment(1) != null)&&($this->uri->segment(1)!= 'fedd'))
					{ 
						echo ucfirst($this->uri->segment(1));
					} 
					else if($this->uri->segment(2) != null) 
					{ 
						echo ucfirst($this->uri->segment(2));
					} 
					else 
					{
					?>
                    Painel
					<?php 
					} 
					?></h3>
				</div>
				<div class="col-md-7 align-self-center">
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<a href="javascript:void(0)">Home</a>						</li>
                        
    					<li class="breadcrumb-item"> <a href="<?= base_url()?>" title="Painel de Controle" class="tip-bottom"> Painel</a></li> 
	                    <?php
		if (($this->uri->segment(1) != null)&&($this->uri->segment(1)!= 'fedd')){ 
	?>
                      <li class="breadcrumb-item active"><a href="<?= base_url() . 'index.php/' . $this->uri->segment(1) ?>" class="tip-bottom" title="<?= ucfirst($this->uri->segment(1));?>"><?= ucfirst($this->uri->segment(1)); ?></a></li>
   	<?php
		}
		if ($this->uri->segment(2) != null){
	?>
    					<li class="breadcrumb-item active"><a href="<?= base_url() . 'index.php/' . $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/' . $this->uri->segment(3) ?>" class="current tip-bottom" title="<?= ucfirst($this->uri->segment(2)); ?>"><?= ucfirst($this->uri->segment(2));?></a></li>
    <?php
		}
	?>
					</ol>
			  </div>
			</div>
			<!-- End Bread crumb -->
			<!-- Container fluid  -->
			<div class="container-fluid">
				<!-- Start Page Content -->
				<div class="row">
					<div class="col-12">					
						<?php if(isset($view)){echo $this->load->view($view, null, true);}?>
					</div>
				</div>
				<!-- End PAge Content -->
			</div>
			<!-- End Container fluid  -->
			<!-- footer -->
			<footer class="footer text-center fixed-bottom" style="margin: 0">
				
				&copy; FE/DD - Versão: <?= $this->config->item('app_version'); ?>
			</footer>

			<!-- End footer -->
		</div>
		<!-- End Page wrapper  -->
	</div>
	<!-- End Wrapper -->
	
	<!-- Bootstrap tether Core JavaScript -->
	<script src="<?= base_url('assets/js/lib/bootstrap/js/popper.min.js'); ?>"></script>
	<script src="<?= base_url('assets/js/lib/bootstrap/js/bootstrap.min.js'); ?>"></script>
	<!-- slimscrollbar scrollbar JavaScript -->
	<script src="<?= base_url('assets/js/jquery.slimscroll.js'); ?>"></script>
	<!--Menu sidebar -->
	<script src="<?= base_url('assets/js/sidebarmenu.js'); ?>"></script>
	<!--stickey kit -->
	<script src="<?= base_url('assets/js/lib/sticky-kit-master/dist/sticky-kit.min.js'); ?>"></script>
	<!--Custom JavaScript -->
	<script src="<?= base_url('assets/js/scripts.js'); ?>"></script>

	<script type="text/javascript">  
		$(document).ready(function () {
			
			<?php if($this->session->flashdata('success') != null){ ?>
		
				toastr.success('<?= $this->session->flashdata('success');?>','Atenção',{
					timeOut: 8000,
					"closeButton": true,
					"newestOnTop": true,
					"progressBar": true,
					"positionClass": "toast-top-right",
					"onclick": null,
				});

			<?php } ?>

			<?php if($this->session->flashdata('error') != null){?>
		
				toastr.error('<?= $this->session->flashdata('error');?>','Atenção',{
					timeOut: 8000,
					"closeButton": true,
					"newestOnTop": true,
					"progressBar": true,
					"positionClass": "toast-top-right",
					"onclick": null,
				});

			<?php } ?>

		});  
	</script>

</body>

</html>