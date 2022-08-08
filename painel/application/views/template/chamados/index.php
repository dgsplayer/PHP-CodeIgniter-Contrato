<style>
a{
    color: #000;
}
</style>
<div class="content">
    <div class="main-header">
        <div class="row">
            <div class="col-md-6">
                <h2>Lista de Chamados</h2>
            </div>
            <!--            <em>Lista de todos os propostas cadastrados.</em>-->
<!--            <div class="col-md-3">-->
<!--                <table>-->
<!--                    <tr>-->
<!--                        <td><img src="--><?php //echo (base_url(). '/recursos/img/red.png'); ?><!--" border="0" width="14">&nbsp;</td>-->
<!--                        <td><span style="text-align: left">Em atraso</span></td>-->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <td><img src="--><?php //echo (base_url(). '/recursos/img/yellow.png'); ?><!--" border="0" width="15">&nbsp;</td>-->
<!--                        <td>Prazo de 0 a 3 dias</td>-->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <td><img src="--><?php //echo (base_url(). '/recursos/img/green.png'); ?><!--" border="0" width="15">&nbsp;</td>-->
<!--                        <td>Prazo acima de 3 dias</td>-->
<!--                    </tr>-->
<!--                </table>-->
<!--            </div>-->
<!--            <div class="col-md-3">-->
<!--                <div class="top-content">-->
<!--                    <ul class="list-inline quick-access">-->
<!--                        <li>-->
<!--                            <a href="--><?php //echo base_url('chamados_crud/index/add'); ?><!--" class="">-->
<!--                                <div class="quick-access-item bg-color-green">-->
<!--                                    <i class="fa fa-clipboard"></i>-->
<!--                                    <h5>Novo Chamado</h5>-->
<!--                                    <em>Clique aqui para cadastrar novo chamado</em>-->
<!--                                </div>-->
<!--                            </a>-->
<!--                        </li>-->
<!--                    </ul>-->
<!--                </div>-->
<!--            </div>-->
        </div>
    </div>
<!--    <div class="alert alert-info text-center">-->
<!--        Melhorias temporariamente desconsideradas-->
<!--    </div>-->
    <div class="widget widget-table">
        <div class="widget-header">
            <h3><i class="fa fa-table"></i>Chamados</h3>
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
<!--                    <th>Prazo</th>-->
                    <th>Cód</th>
                    <th>Título</th>
                    <th>Área</th>
                    <th>Responsável</th>
                    <th>Status</th>
                    <th>Criado em</th>
                    <th>#</th>
                </tr>
                </thead>
                <tbody>
                <?php if(isset($dados) && count($dados)) { ?>
                    <?php foreach( $dados as $dado ) { ?>
                        <tr>
<!--                            <td>--><?php //echo prazo_dias_callback($dado); ?><!--</td>-->
                            <td><a href="<?php echo base_url('chamados/detalhe/' . $dado->id_chamado) ; ?>"><?php echo $dado->id_chamado; ?></a></td>
                            <td><a href="<?php echo base_url('chamados/detalhe/' . $dado->id_chamado) ; ?>"><?php echo $dado->titulo; ?></a></td>
                            <td><a href="<?php echo base_url('chamados/detalhe/' . $dado->id_chamado) ; ?>"><?php echo @$area[$dado->id_area]; ?></a></td>
                            <td><a href="<?php echo base_url('chamados/detalhe/' . $dado->id_chamado) ; ?>"><?php echo  @$admin[$dado->id_responsavel]; ?></a></td>
                            <td><a href="<?php echo base_url('chamados/detalhe/' . $dado->id_chamado) ; ?>"><?php echo  @$status[$dado->id_status]; ?></a></td>
                            <td><a href="<?php echo base_url('chamados/detalhe/' . $dado->id_chamado) ; ?>"><?php echo parseDate( $dado->data_abertura , 'date3');?></a></td>
                            <td>
                                <a href="<?php echo base_url('chamados/detalhe/' . $dado->id_chamado) ; ?>" class="btn btn-custom-secondary btn-sm"><i class="fa fa-binoculars"></i> Detalhes</a>
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

<?php

function prazo_dias_callback($row){

    date_default_timezone_set('America/Sao_Paulo');

    $date_conclusao = new DateTime($row->data_conclusao);
    $date_previsao  = new DateTime($row->data_previsao_conclusao);
    $date_previsao_analise  = new DateTime($row->data_previsao_analise);
    $date_now       = new DateTime(date('Y-m-d'));

    $interval = $date_conclusao->diff($date_previsao);
    $interval = $interval->format('%R%a dias ');

    $interval_abertas = $date_now->diff($date_previsao);
    $interval_abertas = $interval_abertas->format('%R%a dias ');

    $interval_abertas_analise = $date_now->diff($date_previsao_analise);
    $interval_abertas_analise = $interval_abertas_analise->format('%R%a dias ');

    if($row->id_status == 7 ) {
        if($interval < 0  ) {
            $return = '<img src="' . base_url() . '/recursos/img/red.png" border="0" width="16"> Concluído';
        }
        if ($interval >= 0 && $interval <= 3 ){
            $return = '<img src="' . base_url() . '/recursos/img/green.png" border="0" width="16"> Concluído';
        }
        if($interval > 3  ) {
            $return = '<img src="' . base_url() . '/recursos/img/green.png" border="0" width="16"> Concluído';
        }
    }else{
        if(!empty($row->data_previsao_conclusao)){
            if($interval_abertas < 0  ) {
                $return = '<img src="' . base_url() . '/recursos/img/red.png" border="0" width="16">';
            }
            if ($interval_abertas >= 0 && $interval_abertas <= 3 ){
                $return = '<img src="' . base_url() . '/recursos/img/yellow.png" border="0" width="16">';
            }
            if($interval_abertas > 3  ) {
                $return = '<img src="' . base_url() . '/recursos/img/green.png" border="0" width="16">';
            }
        }else{
            if($interval_abertas_analise < 0  ) {
                $return = '<img src="' . base_url() . '/recursos/img/red.png" border="0" width="16">';
            }
            if ($interval_abertas_analise >= 0 && $interval_abertas_analise <= 3 ){
                $return = '<img src="' . base_url() . '/recursos/img/yellow.png" border="0" width="16">';
            }
            if($interval_abertas_analise > 3  ) {
                $return = '<img src="' . base_url() . '/recursos/img/green.png" border="0" width="16">';
            }
        }
    }

    return $return;
}
?>
