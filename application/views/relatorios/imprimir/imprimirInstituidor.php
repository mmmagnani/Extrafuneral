  <head>
    <title>FE/DD - Sistema de Folha Extraordinária e Funeral</title>
    <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/fullcalendar.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/main.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/blue.css" class="skin-color" />
    <script type="text/javascript"  src="<?php echo base_url();?>assets/js/jquery-1.10.2.min.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
	table {
		border-collapse:collapse;
		border-spacing: 0;
		width: 100%;

	}
	th, td {
		
		padding:10px;
	}
	th{
		border-bottom:1px solid #ddd;
	}
	tr:nth-child(even) {
		background-color:#f2f2f2
	}
	</style>
    </head>
 
  <body style="background-color: transparent">




    
          <div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12">
                  <div class="card">
                      <div class="card-title">
                          <h3 style="text-align: center">Ministério da Defesa<br>Comando da Aeronáutica<br><?= $ug; ?></h3><br>
                      
                      </div>
                         
               
                      <div class="card-body">

                  <table class="table table-bordered">
                      <thead>
                          <tr>
                              <th style="font-size:  1.0em; padding: 5px;">Posto Inst</th>
                              <th style="font-size: 1.0em; padding: 5px;">Instituidor</th>
							  <th style="font-size: 1.0em; padding: 5px;">CPF Instituidor</th>
                              <th style="font-size: 1.0em; padding: 5px;">Instituído</th>
                              <th style="font-size: 1.0em; padding: 5px;">CPF Instituído</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php
                          foreach ($instituidor as $c) {
                             
                              echo '<tr>';
                              echo '<td>' . $c->posto_inst . '</td>';
                              echo '<td>' . $c->instituidor . '</td>';
							  echo '<td>' . $c->cpf_instituidor . '</td>';
							  echo '<td>' . $c->instituido . '</td>';
							  echo '<td>' . $c->cpf_instituido . '</td>';
                              echo '</tr>';
                          }
                          ?>
                      </tbody>
                  </table>
                  
                  </div>
                   
              </div>
                  <h5 style="text-align: right; border-top:1px solid #ddd; padding-top:10px">Data do Relatório: <?php echo date('d/m/Y');?></h5>

          </div>
     


      </div>



  </body>
</html>







