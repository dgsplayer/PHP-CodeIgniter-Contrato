<html>
<style>
    body{
        font-size: 13px !important;
    }
    table{
        font-size: 13px !important;
    }
</style>
<body>


<?php echo $this->load->helper('date'); ?>
<div class="main-header">


</div>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="main-content">
                <!-- NAV TABS -->
                <div class="row">
                    <div class="col-md-8">
                        <div class="user-info-right">
                            <div class="basic-info">
                                <h4><i class="fa fa-square"></i> <ins>Detalhes do chamado</ins></h4>
                                <p class="data-row">
                                    <span class="data-name"><strong>Chamado número:</strong></span>
                                    <span class="data-value"><?php echo($dados->id); ?></span>
                                </p>
                                <p class="data-row">
                                    <span class="data-name"><strong>Título:</strong></span>
                                    <span class="data-value"><?php echo($dados->titulo); ?></span>
                                </p>
                                <p class="data-row">
                                    <span class="data-name"><strong>Tipo:</strong></span>
                                    <span class="data-value"><?php echo($dados->tipo); ?></span>
                                </p>
                                <p class="data-row">
                                    <span class="data-name"><strong>Prioridade:</strong></span>
                                    <span class="data-value"><?php echo($dados->prioridade); ?></span>
                                </p>
                                <p class="data-row">
                                    <span class="data-name"><strong>Observação:</strong></span>
                                    <span class="data-value"><?php echo(@$motivos[$dados->id_motivo]); ?></span>
                                </p>
                                <p class="data-row">
                                    <span class="data-name"><strong>Área responsável:</strong></span>
                                    <span class="data-value"><?php echo(@$areas[$dados->id_area]); ?></span>
                                </p>
                                <p class="data-row">
                                    <span class="data-name"><strong>Data de criação:</strong></span>
                                    <span class="data-value"><?php echo(parseDate($dados->data_cadastro,'date3')); ?></span>
                                </p>
                                <p class="data-row">
                                    <span class="data-name"><strong>Data de previsão:</strong></span>
                                    <span class="data-value"><?php echo(parseDate($dados->data_previsao,'date3')); ?></span>
                                </p>
                                <p class="data-row">
                                    <span class="data-name"><strong>Data de conclusão:</strong></span>
                                    <span class="data-value"><?php echo(str_replace('//','-',parseDate($dados->data_conclusao,'date3'))); ?></span>
                                </p>
                                <p class="data-row">
                                    <span class="data-name"><strong>Percentual de conclusão:</strong></span>
                                    <span class="data-value"><?php echo($dados->percentual); ?> %:</strong></span>

                                </p>
                                <p class="data-row">
                                    <span class="data-name"><strong>Criado por:</strong></span>
                                    <span class="data-value"><?php echo(@$admin[$dados->id_usuario]); ?></span>
                                </p>
                                <p class="data-row">
                                    <span class="data-name"><strong>Status atual:</strong></span>
                                    <span class="data-value"><?php echo(@$status[@$last[$dados->id]]); ?></span>
                                </p>
                            </div>
                        </div>
                        <BR><BR>
                        <h4><i class="fa fa-square"></i> <ins>Fluxo do chamado</ins></h4>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-sorting table-striped table-hover datatable" cellpadding="0" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th style="width: 150px">Data</th>
                                        <th style="width: 200px">Status</th>
                                        <th style="width: 200px">Usuário</th>
                                        <th>Observação</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(!empty($rows)) foreach( $rows as $row ) { ?>
                                        <tr>
                                            <td><?php echo  parseDate($row['data'],'date3'); ?></td>
                                            <td><?php echo  @$status[$row['id_status']]; ?></td>
                                            <td><?php echo  @$admin[$row['id_usuario']]; ?></td>
                                            <td><?php echo  tracoVazio(@$row['descricao']); ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <BR><BR>
                        <h4><i class="fa fa-square"></i> <ins>Ocorrências do chamado</ins></h4>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-sorting table-striped table-hover datatable" cellpadding="0" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th style="width: 150px">Data</th>
                                        <th style="width: 200px">Usuário</th>
                                        <th>Descrição</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(!empty($dadosOcorrencia)) foreach( $dadosOcorrencia as $row ) { ?>
                                        <tr>
                                            <td><?php echo  parseDate($row['data'],'date3'); ?></td>
                                            <td><?php echo  @$admin[$row['id_usuario']]; ?></td>
                                            <td><?php echo  tracoVazio(@$row['descricao']); ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

</body>
</html>