<?php echo $this->load->helper('date'); ?>
<div class="main-header">
    <div class="col-md-5">
        <h2>Cadastro do Serviço</h2>
        <em>Aqui crie um modelo padrão dos serviços</em>
    </div>
    <div class="col-md-7">
        <div class="top-content">
            <ul class="list-inline quick-access">
                <li>
                    <a href="<?php echo base_url('configuracao/lista_servico'); ?>">
                        <div class="quick-access-item bg-color-yellow">
                            <i class="fa fa-clipboard"></i>
                            <h5>Lista de serviços</h5>
                            <em>Clique aqui para listar serviços</em>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<?php echo form_open( 'configuracao/processa_cadastro_servico', array('class' => 'form-horizontal label-left', 'role' => 'form') )?>

	<hr class="inner-separator">

	<div class="widget pessoa-fisica">
		<div class="widget-content">
				<div class="form-group">
					<label class="col-sm-2 control-label">Título</label>
					<div class="col-sm-10">
						<?php echo form_input(array('name' => 'titulo', 'placeholder' => 'Insira um título para o modelo' , 'class' => 'form-control'), set_value('titulo', @$servicos->titulo ),'autofocus'); ?>
						<?php echo form_error('titulo'); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Serviços</label>
					<div class="col-sm-10">
                        <textarea class="form-control" name="descricao" rows="6" id="descricao" placeholder="Cadastre a descrição do serviço aqui"><?php echo set_value('descricao', @$servicos->descricao); ?></textarea>
                        <BR>
					</div>
				</div>
		</div>
	</div>

	<?php echo form_hidden('id', @$servicos->id ); ?>

	<button class="btn btn-primary" type="submit">Salvar</button>

<?php echo form_close()?>

<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/tinymce/tinymce.min.js'); ?>"></script>
<script language="JavaScript" xmlns="http://www.w3.org/1999/html">
    $(document).ready(function(){
        tinymce.init({
            selector: "textarea",
            language : 'pt_BR',
            plugins: [
                "advlist autolink lists link image charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste textcolor "
            ],
            theme_advanced_font_sizes: "10px,12px,13px,14px,16px,18px,20px",
            font_size_style_values: "12px,13px,14px,16px,18px,20px",
            style_formats: [
                {title: 'Adicionar Classe Parte II', selector: 'tr', classes: 'contrato_color_parte' },
                {title: 'Adicionar Classe Clausulas', selector: 'tr', classes: 'contrato_color_clausula' }
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | forecolor backcolor | sizeselect | fontselect | fontsizeselect"
        });


    });
</script>