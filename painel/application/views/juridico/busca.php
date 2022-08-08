<div class="main-header">
    <h2>Busca Avançada</h2>
    <em>Realize sua busca nos processos</em>
</div>

<?php echo form_open( 'juridico/processa_busca' , array('class' => 'form-horizontal label-left', 'role' => 'form') ); ?>
<div class="row">
<div class="col-md-6">
    <div class="widget">
        <div class="widget-header">
            <h3><i class="fa fa-edit"></i> Critérios de Seleção</h3>
        </div>
        <div class="widget-content">
            <div class="form-group">
                <label class="col-sm-3 control-label">Número do processo</label>
                <div class="col-sm-9">
                    <?php echo form_input(array('name' => 'num_processo', 'class' => 'form-control', 'placeholder' => 'Pesquise por número de processo'), set_value('num_processo'),'autofocus'); ?>
                    <?php echo form_error('num_processo'); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Cliente</label>
                <div class="col-sm-9">
                    <?php echo form_input(array('name' => 'nome','class' => 'form-control', 'placeholder' => 'Pesquise por nome do cliente'), set_value('nome_cliente')); ?>
                    <?php echo form_error('nome_cliente'); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">CPF/CNPJ</label>
                <div class="col-sm-6">
                    <?php echo form_input(array('name' => 'cpf_cnpj','class' => 'form-control', 'placeholder' => 'Pesquise por CPF ou CNPJ do cliente'), set_value('cpf_cnpj')); ?>
                    <?php echo form_error('cpf_cnpj'); ?>
                </div>
                <div class="col-sm-3" style="margin-top: 10px; margin-left: -20px">
                    <small>* Incluir pontos e traços</small>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Vara e fórum</label>
                <div class="col-sm-9">
                    <?php echo form_input(array('name' => 'vara','class' => 'form-control', 'placeholder' => 'Pesquise por vara ou fórum'), set_value('vara')); ?>
                    <?php echo form_error('vara'); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Parte adversas</label>
                <div class="col-sm-9">
                    <?php echo form_input(array('name' => 'parte_adversa','class' => 'form-control', 'placeholder' => 'Pesquise por nome da parte adversa'), set_value('parte_adversa')); ?>
                    <?php echo form_error('parte_adversa'); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Número contrato de honorários</label>
                <div class="col-sm-9">
                    <?php echo form_input(array('name' => 'contrato','class' => 'form-control', 'placeholder' => 'Pesquise pelo código do contrato'), set_value('contrato')); ?>
                    <?php echo form_error('contrato'); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Número da pasta</label>
                <div class="col-sm-9">
                    <?php echo form_input(array('name' => 'num_pasta','class' => 'form-control', 'placeholder' => 'Pesquise por número da pasta'), set_value('num_pasta')); ?>
                    <?php echo form_error('num_pasta'); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Data de publicação</label>
                <div class="col-sm-6">
                    <?php echo form_input(array('name' => 'publicacao','class' => 'form-control datepicker', 'placeholder' => 'Pesquise por data de publicação'), set_value('publicacao')); ?>
                    <?php echo form_error('publicacao'); ?>
                </div>
            </div>
        </div>
    </div>

    <button class="btn btn-success" type="submit">Consultar</button>
</div>


</div>



<?php echo form_close(); ?>