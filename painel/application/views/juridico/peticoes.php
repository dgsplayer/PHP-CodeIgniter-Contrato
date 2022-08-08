<?php echo $this->load->helper('date'); ?>
<div class="main-header">
    <h2>Banco de Petições</h2>
    <em>Informações das petições</em>
</div>

<?php if($mensagem = $this->session->flashdata("sucesso")) { 	?>
    <div class="alert alert-success bg-success text-center">
        <?php echo $mensagem; ?>
    </div>
<?php } ?>

<?php echo form_open_multipart( 'juridico/processa_peticoes' , array('class' => 'form-horizontal label-left form-group', 'role' => 'form') ); ?>

<div class="widget pessoa-fisica">
    <div class="widget-header">
        <h3><i class="fa fa-edit"></i>Petições</h3>
    </div>
    <div class="widget-content">
        <div class="form-group">
            <label class="col-sm-2 control-label">Tipo de petição</label>
            <div class="col-sm-3">
                <?php echo form_dropdown('id_peticao', $peticoes , set_value('id_peticao', @$cliente->id_peticao ) , 'class="form-control"'); ?>
                <?php echo form_error('id_peticao'); ?>
            </div>
            <div class="col-sm-7"></div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Arquivo (Formato)</label>
            <div class="col-sm-10">
                <?php echo form_upload(array('name' => 'anexo',  'id' => 'anexoPeticao')); ?>
                <?php echo form_error('anexo'); ?>
            </div>
        </div>
    </div>
</div>

<?php //echo form_hidden('id', @$orcamento->id_orcamento ); ?>

<button class="btn btn-success" type="submit">Gravar</button>

<?php echo form_close(); ?>

<div class="widget widget-table">
    <div class="widget-header">
        <h3><i class="fa fa-table"></i>Lista de petições</h3>
    </div>
    <div class="widget-content">
        <table class="table table-sorting table-striped table-hover datatable" cellpadding="0" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Data</th>
                <th>Petição</th>
                <th>Anexo</th>
                <th>#</th>
            </tr>
            </thead>
            <tbody>
            <?php if(isset($lista_peticoes) && count($lista_peticoes)) { ?>
                <?php foreach( $lista_peticoes as $peticao ) { ?>
                    <tr>
                        <td><?php echo parseDate( $peticao->data , 'date3'); ?></td>
                        <td><?php echo $peticao->peticao; ?></td>
                        <td>
                            <a class="btn btn-primary" href="<?php echo base_url('upload/upload_juridico/'. $peticao->anexo);?>">Arquivo</a>
                        </td>
                        <td>
                            <a href="<?php echo base_url('juridico/delete_banco_peticao/' . $peticao->id ); ?>" onclick="return ask_delete();" class="btn btn-danger">
                                <i class="fa fa-trash fa-2"></i> Excluir
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="3" class="text-center"> Sem informação cadastrada.</td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>