<div class="main-header">
    <h2>Alteração do Design do Contrato</h2>
    <!--	<em>Campos com dados do orçamento</em>-->
</div>
<?php if ($this->session->flashdata("sucesso")) {
    $user = $this->session->userdata('contrato_user');
    echo "<script language=\"javascript\" type=\"text/javascript\">window.open('http://contratonet.com.br/contract_key/download/download_modelo/" . base64_encode($user['id_pessoa']) . "');</script>";
    echo ('<div class="alert alert-success">' . $this->session->flashdata("sucesso") . '</div>');
} ?>

<!-- <?php if ($this->session->flashdata("error")) {
            echo ('<div class="alert alert-danger">' . $this->session->flashdata("error") . '</div>');
        } ?> -->


<div class="main-content">
    <div class="row">
        <div class="col-md-10">
            <?php echo form_open_multipart('/configuracao/processa_headers', array('role' => 'form')); ?>
            <div class="widget">
                <div class="widget-header">
                    <h3>Topo do Contrato (INSTRUMENTO PARTICULAR DE CONTRATO DE PRESTAÇÃO DE SERVIÇOS)</h3>
                </div>
                <div class="widget-content">
                    <div class="row">
                        <div class="col-md-6">
                            <p>Escolha a cor do fundo: </p>
                            <div id="cor_topo" class="input-group colorpicker-component colorpicker-element">
                                <input class="form-control" id="cor_topo_id" name="cor_topo" type="text" value="#<?php echo (@$resDesign->cor_topo); ?>">
                                <span class="input-group-addon">
                                    <i style="background-color: #<?php echo (@$resDesign->cor_topo); ?>;"></i>
                                </span>
                            </div>
                            <?php echo form_error('cor_topo'); ?>
                        </div>
                        <div class="col-md-6">
                            <p>Escolha a cor da fonte: </p>
                            <div id="cor_topo_fonte" class="input-group colorpicker-component colorpicker-element">
                                <input class="form-control" id="cor_topo_fonte_id" name="cor_topo_fonte" type="text" value="#<?php echo (@$resDesign->cor_topo_fonte); ?>">
                                <span class="input-group-addon">
                                    <i style="background-color: #<?php echo (@$resDesign->cor_topo_fonte); ?>;"></i>
                                </span>
                            </div>
                            <?php echo form_error('cor_topo_fonte'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="widget">
                <div class="widget-header">
                    <h3>Partes do Contrato (Parte II e Parte II)</h3>
                </div>
                <div class="widget-content">
                    <div class="row">
                        <div class="col-md-6">
                            <p>Escolha a cor do fundo: </p>
                            <div id="cor_quadro" class="input-group colorpicker-component colorpicker-element">
                                <input class="form-control" id="cor_quadro_id" name="cor_quadro" type="text" value="#<?php echo (@$resDesign->cor_quadro); ?>">
                                <span class="input-group-addon">
                                    <i style="background-color: #<?php echo (@$resDesign->cor_quadro); ?>;"></i>
                                </span>
                            </div>
                            <?php echo form_error('cor_quadro'); ?>
                        </div>
                        <div class="col-md-6">
                            <p>Escolha a cor do fonte: </p>
                            <div id="cor_quadro_fonte" class="input-group colorpicker-component colorpicker-element">
                                <input class="form-control" id="cor_quadro_fonte_id" name="cor_quadro_fonte" type="text" value="#<?php echo (@$resDesign->cor_quadro_fonte); ?>">
                                <span class="input-group-addon">
                                    <i style="background-color: #<?php echo (@$resDesign->cor_quadro_fonte); ?>;"></i>
                                </span>
                            </div>
                            <?php echo form_error('cor_quadro_fonte'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="widget">
                <div class="widget-header">
                    <h3>Cláusulas do Contrato</h3>
                </div>
                <div class="widget-content">
                    <div class="row">
                        <div class="col-md-6">
                            <p>Escolha a cor do fundo: </p>
                            <div id="cor_clausula" class="input-group colorpicker-component colorpicker-element">
                                <input class="form-control" id="cor_clausula_id" name="cor_clausula" type="text" value="#<?php echo (@$resDesign->cor_clausula); ?>">
                                <span class="input-group-addon">
                                    <i style="background-color: #<?php echo (@$resDesign->cor_clausula); ?>;"></i>
                                </span>
                            </div>
                            <?php echo form_error('cor_clausula'); ?>
                        </div>
                        <div class="col-md-6">
                            <p>Escolha a cor da fonte: </p>
                            <div id="cor_clausula_fonte" class="input-group colorpicker-component colorpicker-element">
                                <input class="form-control" id="cor_clausula_fonte_id" name="cor_clausula_fonte" type="text" value="#<?php echo (@$resDesign->cor_clausula_fonte); ?>">
                                <span class="input-group-addon">
                                    <i style="background-color: #<?php echo (@$resDesign->cor_clausula_fonte); ?>;"></i>
                                </span>
                            </div>
                            <?php echo form_error('cor_clausula_fonte'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="widget">
                <div class="widget-header">
                    <h3>Cor Geral do Fundo do Contrato</h3>
                </div>
                <div class="widget-content">
                    <div class="row">
                        <div class="col-md-6">
                            <p>Escolha a cor do fundo do contrato (Não recomendável alterar): </p>
                            <div id="cor_fundo" class="input-group colorpicker-component colorpicker-element">
                                <input class="form-control" id="cor_fundo_id" name="cor_fundo" type="text" value="#<?php echo (@$resDesign->cor_fundo); ?>">
                                <span class="input-group-addon">
                                    <i style="background-color: #<?php echo (@$resDesign->cor_fundo); ?>;"></i>
                                </span>
                            </div>
                            <?php echo form_error('cor_fundo'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="widget">
                <div class="widget-header">
                    <h3>Cabeçalho e Rodapé do Contrato</h3>
                </div>
                <div class="widget-content">
                    <div class="alert alert-info">
                        <div class="row">

                            <div class="col-md-12">

                                <p>Logomarca do cabeçalho</p>

                                <label class="col-sm-3 control-label">Escolha a nova imagem (PNG ou JPG) Dimensão:1024x768 Tamanho máximo: 2MB</label>
                                <div class="col-sm-8">
                                    <input type="file" name="file">
                                </div>
                                
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-12">
                                <div class="col-sm-8">
                                    <img src="http://www.contratonet.com.br/painel/recursos/logomarcas/<?php echo (@$resDesign->file); ?>" alt="" style="max-height: 100;"/>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p>Cabeçalho</p>
                            <textarea name="header" class="form-control myTextEditor" rows="7"><?php echo (@$resDesign->header); ?></textarea>
                            <br>
                            <p>Rodapé</p>
                            <textarea name="footer" class="form-control myTextEditor2" rows="7"><?php echo (@$resDesign->footer); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <BR>
            <input type="submit" name="botao_gravar" class="btn btn-default" style="margin: 0 auto;" value="Voltar ao Padrão">
            <BR><BR>
            <input type="submit" name="botao_gravar" class="btn btn-success" style="margin: 0 auto;" value="Gravar e ver modelo">
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/bootstrap-colorpicker.min.js'); ?>"></script>

<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/tinymce/tinymce.min.js'); ?>"></script>
<script language="JavaScript" xmlns="http://www.w3.org/1999/html">
    $(document).ready(function() {
        //        $('#cor_topo').colorpicker();
        $('#cor_topo').colorpicker().on('changeColor', function(ev) {
            bodyStyle.backgroundColor = ev.color.toHex();
        });
        $('#cor_topo_fonte').colorpicker();
        $('#cor_quadro').colorpicker();
        $('#cor_quadro_fonte').colorpicker();
        $('#cor_clausula').colorpicker();
        $('#cor_clausula_fonte').colorpicker();
        $('#cor_fundo').colorpicker();

        //        $('#originais').click(function(){
        //            $('#cor_topo_id').val('#333333');
        //            $('#cor_topo_fonte_id').val('#ffffff');
        //            $('#cor_quadro_id').val('#ffffff');
        //            $('#cor_quadro_fonte_id').val('#000000');
        //            $('#cor_clausula_id').val('#dddddd');
        //            $('#cor_clausula_fonte_id').val('#000000');
        //            $('#cor_fundo_id').val('#ffffff');
        //        });

        tinymce.init({
            selector: "textarea",
            language: 'pt_BR',
            plugins: [
                "advlist autolink lists link image charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste textcolor "
            ],
            style_formats: [{
                    title: 'Adicionar Classe Parte II',
                    selector: 'tr',
                    classes: 'contrato_color_parte'
                },
                {
                    title: 'Adicionar Classe Clausulas',
                    selector: 'tr',
                    classes: 'contrato_color_clausula'
                }
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | forecolor backcolor"
        });


    });
</script>