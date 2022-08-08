<?php echo $this->load->helper('funcoes'); ?>
<?php echo $this->load->helper('date'); ?>
					<!-- content-wrapper -->
					<div class="col-md-10 content-wrapper">
						<!-- main -->
						<div class="content">
							<div class="main-header">
                                <div class="row">
                                    <div class="col-md-5">
                                        <h2>RESUMO DE CRÉDITOS</h2>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="top-content">
                                            <ul class="list-inline mini-stat">
                                                <li>
                                                    <h5>Contratos Disponíveis
                                                        <span class="stat-value stat-color-orange"><i class="fa fa-plus-circle"></i> <?php echo($empresa->contratos_disponiveis - $credito_mes->total); ?></span>
                                                    </h5>
<!--                                                    <span id="mini-bar-chart1" class="mini-bar-chart"></span>-->
                                                </li>
                                                <li>
                                                    <h5>Usuários Disponíveis
                                                        <span class="stat-value stat-color-blue"><i class="fa fa-plus-circle"></i> <?php echo($empresa->usuarios_disponiveis - $credito_usuarios->total); ?> </span>
                                                    </h5>
<!--                                                    <span id="mini-bar-chart2" class="mini-bar-chart"></span>-->
                                                </li>
                                                <li>
                                                    <h5>Tipos de Contrato Disponíveis
                                                        <span class="stat-value stat-color-seagreen"><i class="fa fa-plus-circle"></i> <?php echo($empresa->tipo_contrato_disponivel - $credito_tipos_contratos->total); ?></span>
                                                    </h5>
<!--                                                    <span id="mini-bar-chart3" class="mini-bar-chart"></span>-->
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
							</div>

                            <div class="main-content">
                            <div class="row">
                                <div class="col-md-11">
                                    <!-- WIDGET NO HEADER -->
                                    <div class="widget widget-hide-header">
                                        <div class="widget-header hide">
                                            <h3>Sumário</h3>
                                        </div>
                                        <div class="widget-content">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="easy-pie-chart green" data-percent="<?php echo (($credito_mes->total / $empresa->contratos_disponiveis) * 100 )?>">
                                                        <span class="percent"><?php echo (($credito_mes->total / $empresa->contratos_disponiveis) * 100 )?></span>
                                                    </div>
                                                    <p class="text-center">Contratos Utilizados</p>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="easy-pie-chart red" data-percent="<?php echo(($credito_usuarios->total / $empresa->usuarios_disponiveis) * 100 ); ?>">
                                                        <span class="percent"><?php echo(($credito_usuarios->total / $empresa->usuarios_disponiveis) * 100 ); ?></span>
                                                    </div>
                                                    <p class="text-center">Usuários Utilizados</p>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="easy-pie-chart yellow" data-percent="<?php echo(($credito_tipos_contratos->total / $empresa->tipo_contrato_disponivel) * 100 ); ?>">
                                                        <span class="percent"><?php echo(($credito_tipos_contratos->total / $empresa->tipo_contrato_disponivel) * 100 ); ?></span>
                                                    </div>
                                                    <p class="text-center">Tipo de Contrato Utilizados</p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- WIDGET NO HEADER -->
                                </div>
                            </div>

                            <!-- WIDGET MAIN CHART WITH TABBED CONTENT -->

                            <!-- END WIDGET MAIN CHART WITH TABBED CONTENT -->

                            <div class="row">
                                <div class="col-md-6">
                                    <h3>Plano Atual</h3>
                                    <ul class="nav nav-pills nav-stacked nav-categories">
                                        <li><a href="#">Máximo de contratos permitidos por mês <span class="badge pull-right"><?php echo($empresa->contratos_disponiveis); ?></span></a></li>
                                        <li><a href="#">Máximo de usuários permitidos <span class="badge pull-right"><?php echo($empresa->usuarios_disponiveis); ?></span></a></li>
                                        <li><a href="#">Máximo de Tipos de Contrato <span class="badge pull-right"><?php echo($empresa->tipo_contrato_disponivel); ?></span></a></li>
                                        <li><a href="#">Permissão de Emissão de Boletos<span class="badge pull-right"><?php echo(converteSimNao($empresa->tem_boletos)); ?></span></a></li>
                                        <li><a href="#">Permissão de Gestão de Cobrança<span class="badge pull-right"><?php echo(converteSimNao($empresa->tem_gestao)); ?></span></a></li>
                                    </ul>
<!--                                    <div class="ticket-box">-->
<!--                                        <a href="#" class="btn btn-primary">Upgrade</a>-->
<!--                                    </div>-->

                                </div>

                            <div class="col-md-6">
                                <!-- WIDGET TABLE -->
                                <BR>
                                <div class="widget widget-table">
                                    <div class="widget-header">
                                        <h3><i class="fa fa-bar-chart-o fw"></i>  Contratos por Mês</h3>
                                        <div class="btn-group widget-header-toolbar">
                                            <a href="#" title="Focus" class="btn-borderless btn-focus"><i class="fa fa-eye"></i></a>
                                            <a href="#" title="Expand/Collapse" class="btn-borderless btn-toggle-expand"><i class="fa fa-chevron-up"></i></a>
                                            <a href="#" title="Remove" class="btn-borderless btn-remove"><i class="fa fa-times"></i></a>
                                        </div>
                                    </div>
                                    <div class="widget-content">
                                        <table id="visit-stat-table" class="table table-sorting table-striped table-hover datatable" cellpadding="0" cellspacing="0" width="100%">
                                            <thead>
                                            <tr>
                                                <th>Mês</th>
                                                <th>Utilizados</th>
                                                <th>Limite</th>
                                                <th>Saldo</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php if(!empty($creditos)) foreach( $creditos as $credito ) { ?>
                                            <tr>
                                                <td><?php echo(parseDate($credito->meses,'2date')); ?></td>
                                                <td><?php echo($credito->total); ?></td>
                                                <td><?php echo($empresa->contratos_disponiveis); ?></td>
                                                <td><?php echo($empresa->contratos_disponiveis - $credito->total); ?></td>
                                            </tr>
                                            <?php } ?>


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>




                            <!-- WIDGET TICKET TABLE -->

                            <!-- END WIDGET TICKET TABLE -->

                            </div>
							<!-- /main-content -->
						</div>
						<!-- /main -->
					</div>
					<!-- /content-wrapper -->
<link href="<?php echo base_url('recursos/assets/css/chart.css'); ?>" rel="stylesheet" type="text/css">
<!--<script type="text/javascript" src="--><?php //echo base_url('recursos/assets/js/bootstrap.min.js'); ?><!--"></script>-->
<!--<script type="text/javascript" src="--><?php //echo base_url('recursos/assets/js/bootstrap-switch.min.js'); ?><!--"></script>-->
                        <script>
                            jQuery.noConflict();
                        </script>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/jquery-ui-1.10.4.custom.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/modernizr.js'); ?>"></script>

<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/custom-form.js'); ?>"></script>

<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/king-common.js'); ?>"></script>

<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/function-form.js'); ?>"></script>

<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/jQAllRangeSliders-min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/bootstrap-colorpicker.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/jquery.simplecolorpicker.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/bootstrap.touchspin.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/daterangepicker.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/moment.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/king-elements.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/stat/jquery.easypiechart.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/raphael-2.1.0.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/stat/flot/jquery.flot.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/stat/flot/jquery.flot.resize.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/stat/flot/jquery.flot.time.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/stat/flot/jquery.flot.pie.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/stat/flot/jquery.flot.tooltip.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/jquery.sparkline.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/king-chart-stat.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/king-components.js'); ?>"></script>
