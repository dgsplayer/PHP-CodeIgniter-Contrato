<div class="main-header">
    <h2>Jurídico - Cadastros Gerais</h2>
    <em>Todos os cadastros do Módulo Jurídico estão descritos abaixo</em>
</div>
<div class="content">
<div class="main-content">
<div class="row">

<div class="col-sm-6">
<!--PETIÇÕES-->
<?php echo form_open( 'juridico/processa_peticao' , array('class' => 'form-horizontal label-left', 'role' => 'form') ); ?>

    <div class="widget">
        <div class="widget-header">
            <h3><i class="fa fa-edit"></i> Petições</h3>
        </div>
        <div class="widget-content">
            <?php if($mensagem = $this->session->flashdata("sucessoPeticao")) { 	?>
                <div class="alert alert-success bg-success text-center">
                    <?php echo $mensagem; ?>
                </div>
            <?php } ?>
            <div class="form-group">
                <div class="col-sm-10">
                    <?php echo form_input(array('name' => 'peticao', 'placeholder'=>'Nome da nova petição', 'class' => 'form-control' ,  'id' => 'peticao'), set_value('peticao', @$processo->peticao )); ?>
                    <?php echo form_error('peticao'); ?>
                </div>
                <div class="col-sm-2">
                    <button class="btn btn-success" type="submit">Gravar</button>
                </div>
            </div>

            <table class="table table-sorting table-striped table-hover datatable" cellpadding="0" cellspacing="0">
                <thead>
                <tr>
                    <th>Petição</th>
                    <th>#</th>
                </tr>
                </thead>
                <tbody>
                <?php if(isset($listas_peticoes) && count($listas_peticoes)) { ?>
                    <?php foreach( $listas_peticoes as $lista ) { ?>
                        <tr>
                            <td><?php echo $lista->peticao; ?></td>
                            <td><a href="<?php echo base_url('juridico/delete_peticao/' . $lista->id ); ?>" class="btn btn-danger btn-sm" onclick="return ask_delete();"><i class="fa fa-trash-o"></i> Excluir</a></td>
                        </tr>
                    <?php } ?>
                <?php }  ?>
                </tbody>
            </table>
        </div>
    </div>

<?php echo form_close(); ?>




<!--SITUAÇÕES-->
<?php echo form_open( 'juridico/processa_situacao' , array('class' => 'form-horizontal label-left', 'role' => 'form') ); ?>

    <div class="widget">

        <div class="widget-header">
            <h3><i class="fa fa-edit"></i> Situações</h3>
        </div>
        <div class="widget-content">
            <?php if($mensagem = $this->session->flashdata("sucessoSituacao")) { 	?>
                <div class="alert alert-success bg-success text-center">
                    <?php echo $mensagem; ?>
                </div>
            <?php } ?>
            <div class="form-group">
                <div class="col-sm-10">
                    <?php echo form_input(array('name' => 'situacao', 'placeholder'=>'Nome da nova situação', 'class' => 'form-control' ,  'id' => 'situacao'), set_value('situacao', @$processo->situacao )); ?>
                    <?php echo form_error('situacao'); ?>
                </div>
                <div class="col-sm-2">
                    <button class="btn btn-success" type="submit">Gravar</button>
                </div>
            </div>

            <table class="table table-sorting table-striped table-hover datatable" cellpadding="0" cellspacing="0">
                <thead>
                <tr>
                    <th>Situação</th>
                    <th>#</th>
                </tr>
                </thead>
                <tbody>
                <?php if(isset($listas_situacoes) && count($listas_situacoes)) { ?>
                    <?php foreach( $listas_situacoes as $lista ) { ?>
                        <tr>
                            <td><?php echo $lista->situacao; ?></td>
                            <td><a href="<?php echo base_url('juridico/delete_situacao/' . $lista->id ); ?>" class="btn btn-danger btn-sm" onclick="return ask_delete();"><i class="fa fa-trash-o"></i> Excluir</a></td>
                        </tr>
                    <?php } ?>
                <?php }  ?>
                </tbody>
            </table>
        </div>
    </div>

<?php echo form_close(); ?>
</div>


<!--VaraForum-->
<?php echo form_open( 'juridico/processa_forum' , array('class' => 'form-horizontal label-left', 'role' => 'form') ); ?>
<div class="col-sm-6">
    <div class="widget">

        <div class="widget-header">
            <h3><i class="fa fa-edit"></i> Vara / Fórum</h3>
        </div>
        <div class="widget-content">
            <?php if($mensagem = $this->session->flashdata("sucessoForum")) { 	?>
                <div class="alert alert-success bg-success text-center">
                    <?php echo $mensagem; ?>
                </div>
            <?php } ?>
            <div class="form-group">
                <div class="col-sm-10">
                    <?php echo form_input(array('name' => 'forum', 'placeholder'=>'Nome da nova vara/forum', 'class' => 'form-control' ,  'id' => 'forum'), set_value('forum', @$processo->forum )); ?>
                    <?php echo form_error('forum'); ?>
                </div>
                <div class="col-sm-2">
                    <button class="btn btn-success" type="submit">Gravar</button>
                </div>
            </div>

            <table class="table table-sorting table-striped table-hover datatable" cellpadding="0" cellspacing="0">
                <thead>
                <tr>
                    <th>Vara / Fórum</th>
                    <th>#</th>
                </tr>
                </thead>
                <tbody>
                <?php if(isset($listas_forum) && count($listas_forum)) { ?>
                    <?php foreach( $listas_forum as $lista ) { ?>
                        <tr>
                            <td><?php echo $lista->forum; ?></td>
                            <td><a href="<?php echo base_url('juridico/delete_forum/' . $lista->id ); ?>" class="btn btn-danger btn-sm" onclick="return ask_delete();"><i class="fa fa-trash-o"></i> Excluir</a></td>
                        </tr>
                    <?php } ?>
                <?php }  ?>
                </tbody>
            </table>
        </div>
    </div>

<?php echo form_close(); ?>

<!--Partes Adversas-->
<?php echo form_open( 'juridico/processa_adversas' , array('class' => 'form-horizontal label-left', 'role' => 'form') ); ?>

    <div class="widget">

        <div class="widget-header">
            <h3><i class="fa fa-edit"></i> Partes Adversas</h3>
        </div>
        <div class="widget-content">
            <?php if($mensagem = $this->session->flashdata("sucessoAdversas")) { 	?>
                <div class="alert alert-success bg-success text-center">
                    <?php echo $mensagem; ?>
                </div>
            <?php } ?>
            <div class="form-group">
                <div class="col-sm-12">
                    <?php echo form_input(array('name' => 'nome', 'placeholder'=>'Nome', 'class' => 'form-control'), set_value('nome', @$processo->nome )); ?>
                    <?php echo form_error('nome'); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-6">
                    <?php echo form_input(array('name' => 'cpf', 'placeholder'=>'CPF', 'class' => 'form-control', 'id'=>'cpf'), set_value('cpf', @$processo->cpf )); ?>
                    <?php echo form_error('cpf'); ?>
                </div>

                <div class="col-sm-6">
                    <?php echo form_input(array('name' => 'email', 'placeholder'=>'E-mail', 'class' => 'form-control'), set_value('email', @$processo->email )); ?>
                    <?php echo form_error('email'); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-6">
                    <?php echo form_input(array('name' => 'telefone', 'placeholder'=>'Telefone', 'class' => 'form-control', 'id'=>'telefone'), set_value('telefone', @$processo->telefone )); ?>
                    <?php echo form_error('telefone'); ?>
                </div>
                <div class="col-sm-6">
                    <?php echo form_input(array('name' => 'advogado', 'placeholder'=>'Advogado', 'class' => 'form-control'), set_value('advogado', @$processo->advogado )); ?>
                    <?php echo form_error('advogado'); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-2">
                    <button class="btn btn-success" type="submit">Gravar</button>
                </div>
            </div>
            <table class="table table-sorting table-striped table-hover datatable" cellpadding="0" cellspacing="0">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>E-Mail</th>
                    <th>Telefone</th>
                    <th>Advogado</th>
                    <th>#</th>
                </tr>
                </thead>
                <tbody>
                <?php if(isset($listas_adversas) && count($listas_adversas)) { ?>
                    <?php foreach( $listas_adversas as $lista ) { ?>
                        <tr>
                            <td><?php echo $lista->nome; ?></td>
                            <td><?php echo $lista->cpf; ?></td>
                            <td><?php echo $lista->email; ?></td>
                            <td><?php echo $lista->telefone; ?></td>
                            <td><?php echo $lista->advogado; ?></td>
                            <td><a href="<?php echo base_url('juridico/delete_adversa/' . $lista->id ); ?>" class="btn btn-danger btn-sm" onclick="return ask_delete();"><i class="fa fa-trash-o"></i> Excluir</a></td>
                        </tr>
                    <?php } ?>
                <?php }  ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php echo form_close(); ?>
</div>
</div>
</div>