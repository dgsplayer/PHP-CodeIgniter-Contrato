    <div class="content">

        <div class="row">
            <div class="main-header">
                <div class="col-md-5">
                    <h2>Lista de Propostas</h2>
                    <em>Lista de todos os propostas cadastrados.</em>
                </div>
                <div class="col-md-7">
                    <div class="top-content">
                        <ul class="list-inline quick-access">
                            <li>
                                <a href="<?php echo base_url('orcamento/preCadastro'); ?>">
                                    <div class="quick-access-item bg-color-blue">
                                        <i class="fa fa-clipboard"></i>
                                        <h5>Cadastrar Proposta</h5>
                                        <em>Criar propostas</em>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="widget widget-table">
            <div class="widget-header">
                <h3><i class="fa fa-table"></i>Propostas</h3>
            </div>
            <div class="widget-content">
                <?php if($mensagem = $this->session->flashdata("sucesso")) { 	?>
                    <div class="alert alert-success bg-success text-center">
                        <?php echo $mensagem; ?>
                    </div>
                <?php } ?>
                <table class="table table-sorting table-striped table-hover datatable2" cellpadding="0" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Cód</th>
                        <th>Cliente</th>
                        <th>Modelo</th>
                        <th>Valor Total</th>
                        <th>Status</th>
                        <th>Enviado em</th>
                        <th>#</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($orcamentos) && count($orcamentos)) { ?>
                        <?php foreach( $orcamentos as $orcamento ) { ?>
                            <tr>
                                <td><?php echo $orcamento->id_orcamento; ?></td>
                                <td><?php echo $orcamento->nome_cliente; ?></td>
                                <td><?php echo $orcamento->titulo_modelo; ?></td>
                                <td>R$ <?php echo  $orcamento->valor_total; ?></td>
                                <td>
                                        <?php

                                        if ($orcamento->status == 'Aprovado')
                                            echo '<span style="color: #3b853b; font-weight: bold ">' . $orcamento->status . '</span>' ;
                                        else if ($orcamento->status == 'Visualizado')
                                                echo '<span style="color: #DD830E; font-weight: bold ">' . $orcamento->status . '</span>' ;
                                        else
                                            echo $orcamento->status ;

                                        ?>
                                </td>
                                <td><?php echo parseDate( @$last[$orcamento->id_orcamento] , 'date3');?></td>
                                <td>
                                    <a href="<?php echo base_url('orcamento/visualizar/' . $orcamento->id_orcamento) ; ?>" class="btn btn-custom-secondary btn-sm"><i class="fa fa-binoculars"></i> Detalhes</a>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php }  ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="<?php echo base_url('recursos/js/datatable/jquery.dataTables.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('recursos/js/datatable/jquery.dataTables.bootstrap.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('recursos/js/king-table.js'); ?>"></script>
    <script>

        $(document).ready(function(){


            if( $('.datatable2').length > 0 ) {

                $('.datatable2').dataTable({
                    "sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
//                "bPaginate": false,
                    "sPaginationType": "bootstrap",
                "aaSorting": [[ 0, "desc" ]],
                    "oLanguage": {
                        "sProcessing":   "Processando...",
                        "sLengthMenu":   "Mostrar _MENU_ registros",
                        "sZeroRecords":  "Não foram encontrados nenhum resultado",
                        "sInfo":         "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                        "sInfoEmpty":    "Mostrando de 0 até 0 de 0 registros",
                        "sInfoFiltered": "(filtrado de _MAX_ registros no total)",
                        "sInfoPostFix":  "",
                        "sSearch":       "Buscar:",
                        "sUrl":          "",
                        "oPaginate": {
                            "sFirst":    "Primeiro",
                            "sPrevious": "Anterior",
                            "sNext":     "Seguinte",
                            "sLast":     "Último"
                        }
                    }
                });
            }
        });
    </script>