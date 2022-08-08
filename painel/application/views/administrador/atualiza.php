
<?php echo $this->load->helper('funcoes'); ?>
<div class="main-header">
    <h2>Atualização Cadastral</h2>
    <em>Atualize os cadastros da sua empresa nos campos abaixo</em>
</div>

<?php if($mensagem = $this->session->flashdata("sucesso")) { 	?>
<div class="alert alert-success bg-success text-center">
    <?php echo $mensagem; ?>
</div>
<?php } ?>

<?php if($mensagem = $this->session->flashdata("error")) { 	?>
<div class="alert alert-danger text-center">
    <?php echo $mensagem; ?>
</div>
<?php } ?>

<?php echo form_open_multipart( 'administrador/processa_atualiza', array('class' => 'form-horizontal label-left', 'role' => 'form') )?>

<hr class="inner-separator">
<?php if($cliente->check_pessoa_fisica == 't') { ?>
<div class="widget pessoa-fisica">
    <div class="widget-header">
        <h3><i class="fa fa-edit"></i> Dados Pessoa Física</h3>
    </div>
    <div class="widget-content">
        <div class="form-group">
            <label class="col-sm-2 control-label">* Nome</label>
            <div class="col-sm-10">
                <?php echo $cliente->nome ; ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Apelido</label>
            <div class="col-sm-10">
                <?php echo tracoVazio($cliente->apelido) ; ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">* Profissão</label>
            <div class="col-sm-10">
                <?php echo form_input(array('name' => 'profissao','class' => 'form-control' ,  'id' => 'profissao'), set_value('profissao', @$cliente->profissao )); ?>
                <?php echo form_error('profissao'); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">* RG</label>
            <div class="col-sm-10">
                <?php echo form_input(array('name' => 'rg','class' => 'form-control' ,  'id' => 'rg'), set_value('rg', @$cliente->rg )); ?>
                <?php echo form_error('rg'); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">* CPF</label>
            <div class="col-sm-10">
                <?php echo form_input(array('name' => 'cpf','class' => 'form-control' ,  'id' => 'cpf'), set_value('cpf', @$cliente->cpf )); ?>
                <?php echo form_error('cpf'); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Estado Civil</label>
            <div class="col-sm-10">
                <?php echo form_dropdown('estado_civil', array('' => 'Selecione uma opção', 1 => 'Casado', 2 => 'Solteiro'), set_value('estado_civil', @$cliente->estado_civil ) , 'class="multiselect"'); ?>
                <?php echo form_error('estado_civil'); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Nacionalidade</label>
            <div class="col-sm-10">
                <?php echo form_input(array('name' => 'nacionalidade_pf','class' => 'form-control' ,  'id' => 'nacionalidade_pf'), set_value('nacionalidade_pf', @$cliente->nacionalidade_pf )); ?>
                <?php echo form_error('nacionalidade_pf'); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">* E-mail</label>
            <div class="col-sm-10">
                <?php echo form_input(array('name' => 'email','class' => 'form-control' ,  'id' => 'email'), set_value('email', @$cliente->email )); ?>
                <?php echo form_error('email'); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">* DDD + Telefone</label>
            <div class="col-sm-10">
                <?php echo form_input(array('name' => 'telefone','class' => 'form-control' ,  'id' => 'telefone'), set_value('telefone', @$cliente->telefone )); ?>
                <?php echo form_error('telefone'); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">DDD + Celular</label>
            <div class="col-sm-10">
                <?php echo form_input(array('name' => 'celular','class' => 'form-control' ,  'id' => 'celular'), set_value('celular', @$cliente->celular )); ?>
                <?php echo form_error('celular'); ?>
            </div>
        </div>
    </div>
</div>
<?php } else { ?>
<div class="widget pessoa-juridica">
    <div class="widget-header">
        <h3><i class="fa fa-edit"></i> Dados Pessoa Jurídica</h3>
    </div>
    <div class="widget-content">
        <div class="form-group">
            <label for="phone" class="col-sm-2 control-label">* Razão Social</label>
            <div class="col-sm-10">
                <?php echo $cliente->razao; ?>
            </div>
        </div>
        <div class="form-group">
            <label for="phone-ex" class="col-sm-2 control-label">Nome Fantasia</label>
            <div class="col-sm-10">
                <?php echo form_input(array('name' => 'nome_fantasia','class' => 'form-control' ,  'id' => 'nome_fantasia'), set_value('nome_fantasia', @$cliente->nome_fantasia )); ?>
                <?php echo form_error('nome_fantasia'); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="tax-id" class="col-sm-2 control-label">
                Início das atividades
                <br/>
                <small>Exemplo: 03/04/2001 </small>
            </label>
            <div class="col-sm-10">
                <?php echo form_input(array('name' => 'atividade','class' => 'form-control datepicker' ,  'id' => 'atividade'), set_value('atividade', parseDate( @$cliente->atividade, 'mysql2date') )); ?>
                <?php echo form_error('atividade'); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="ssn" class="col-sm-2 control-label">* CNPJ</label>
            <div class="col-sm-10">
                <?php echo $cliente->cnpj ; ?>
            </div>
        </div>
        <div class="form-group">
            <label for="product-key" class="col-sm-2 control-label">* Inscrição Estadual</label>
            <div class="col-sm-10">
                <?php echo form_input(array('name' => 'inscricao','class' => 'form-control' ,  'id' => 'inscricao'), set_value('inscricao', @$cliente->inscricao )); ?>
                <?php echo form_error('inscricao'); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="product-key" class="col-sm-2 control-label">* E-mail Principal</label>
            <div class="col-sm-10">
                <?php echo form_input(array('name' => 'email_j','class' => 'form-control' ,  'id' => 'email_j'), set_value('email_j', @$cliente->email_j )); ?>
                <?php echo form_error('email_j'); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="product-key" class="col-sm-2 control-label">DDD + Telefone Principal</label>
            <div class="col-sm-10">
                <?php echo form_input(array('name' => 'telefone_principal','class' => 'form-control' ,  'id' => 'telefone_principal'), set_value('telefone_principal', @$cliente->telefone_principal )); ?>
                <?php echo form_error('telefone_principal'); ?>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<div class="widget">
    <div class="widget-header">
        <h3><i class="fa fa-edit"></i> Endereço</h3>
    </div>
    <div class="widget-content">

        <div class="form-group">
            <label for="phone" class="col-sm-2 control-label">* CEP</label>
            <div class="col-sm-10">
                <?php echo form_input(array('name' => 'cep','class' => 'form-control' ,  'id' => 'cep'), set_value('cep', @$cliente->cep )); ?>
                <?php echo form_error('cep'); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="phone-ex" class="col-sm-2 control-label">* Endereço</label>
            <div class="col-sm-10">
                <?php echo form_input(array('name' => 'logradouro','class' => 'form-control' ,  'id' => 'logradouro'), set_value('logradouro', @$cliente->logradouro )); ?>
                <?php echo form_error('logradouro'); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="tax-id" class="col-sm-2 control-label">* Número</label>
            <div class="col-sm-10">
                <?php echo form_input(array('name' => 'numero','class' => 'form-control' ,  'id' => 'numero'), set_value('numero', @$cliente->numero )); ?>
                <?php echo form_error('numero'); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="ssn" class="col-sm-2 control-label">* Bairro</label>
            <div class="col-sm-10">
                <?php echo form_input(array('name' => 'bairro','class' => 'form-control' ,  'id' => 'bairro'), set_value('bairro', @$cliente->bairro )); ?>
                <?php echo form_error('bairro'); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="product-key" class="col-sm-2 control-label">Complemento</label>
            <div class="col-sm-10">
                <?php echo form_input(array('name' => 'complemento','class' => 'form-control' ,  'id' => 'complemento'), set_value('complemento', @$cliente->complemento )); ?>
                <?php echo form_error('complemento'); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="product-key" class="col-sm-2 control-label">* Cidade</label>
            <div class="col-sm-10">
                <?php echo form_input(array('name' => 'cidade','class' => 'form-control' ,  'id' => 'cidade'), set_value('cidade', @$cliente->cidade )); ?>
                <?php echo form_error('cidade'); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="product-key" class="col-sm-2 control-label">* Estado</label>
            <div class="col-sm-10">
                <?php echo form_dropdown('estado', $estados, set_value('estado', @$cliente->estado ) , 'class="multiselect"'); ?>
                <?php echo form_error('estado'); ?>
            </div>
        </div>

        <div class="form-group">
            <label for="product-key" class="col-sm-2 control-label">Logo da Empresa</label>
            <div class="col-sm-4">
                <?php echo form_upload(array('name'=>'imagem'), set_value('imagem'))?>
                <?php echo form_error('imagem'); ?>
                <BR>
                <div class="alert alert-info">
                    Dimensão Máxima: 200 x 200<br>
                    Tamanho Máximo: 2 MB<br>
                    Extensões Permitidas: PNG, JPG, GIF<br>
                    De preferência enviar com fundo transparente
                </div>
            </div>
            <div class="col-sm-5">
                <?php if(!empty($cliente->id_pessoa) && file_exists(BASEPATH . '../recursos/imagens/logos/thumb'.$cliente->id_pessoa.'.png')){ echo '<img src="../recursos/imagens/logos/thumb'.$cliente->id_pessoa.'.png">'; } ?>

            </div>
        </div>
    </div>
</div>

<div class="widget pessoa-juridica">
    <div class="widget-header">
        <h3><i class="fa fa-edit"></i>Contato</h3>
    </div>
    <div class="widget-content">
        <div class="form-group">
            <label for="phone" class="col-sm-2 control-label">Nome do Responsável</label>
            <div class="col-sm-10">
                <?php echo form_input(array('name' => 'responsavel','class' => 'form-control' ,  'id' => 'responsavel'), set_value('responsavel', @$cliente->responsavel )); ?>
                <?php echo form_error('responsavel'); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="phone-ex" class="col-sm-2 control-label">Email do Responsável</label>
            <div class="col-sm-10">
                <?php echo form_input(array('name' => 'email_responsavel','class' => 'form-control' ,  'id' => 'email_responsavel'), set_value('email_responsavel', @$cliente->email_responsavel )); ?>
                <?php echo form_error('email_responsavel'); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="tax-id" class="col-sm-2 control-label">RG do Responsável</label>
            <div class="col-sm-10">
                <?php echo form_input(array('name' => 'rgContato','class' => 'form-control' ,  'id' => 'rgContato'), set_value('rgContato', @$cliente->rgContato )); ?>
                <?php echo form_error('rgContato'); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="ssn" class="col-sm-2 control-label">CPF do Resposável</label>
            <div class="col-sm-10">
                <?php echo form_input(array('name' => 'cpfContato','class' => 'form-control' ,  'id' => 'cpfContato'), set_value('cpfContato', @$cliente->cpfContato )); ?>
                <?php echo form_error('cpfContato'); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="product-key" class="col-sm-2 control-label">Nacionalidade</label>
            <div class="col-sm-10">
                <?php echo form_input(array('name' => 'nacionalidade','class' => 'form-control' ,  'id' => 'nacionalidade'), set_value('nacionalidade', @$cliente->nacionalidade )); ?>
                <?php echo form_error('nacionalidade'); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="product-key" class="col-sm-2 control-label">Estado Civil</label>
            <div class="col-sm-10">
                <?php echo form_input(array('name' => 'civil','class' => 'form-control' ,  'id' => 'civil'), set_value('civil', @$cliente->civil )); ?>
                <?php echo form_error('civil'); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="product-key" class="col-sm-2 control-label">DDD + Telefone</label>
            <div class="col-sm-10">
                <?php echo form_input(array('name' => 'telefoneContato','class' => 'form-control' ,  'id' => 'telefoneContato'), set_value('telefoneContato', @$cliente->telefoneContato )); ?>
                <?php echo form_error('telefoneContato'); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="product-key" class="col-sm-2 control-label">DDD + Celular</label>
            <div class="col-sm-10">
                <?php echo form_input(array('name' => 'celularContato','class' => 'form-control' ,  'id' => 'celularContato'), set_value('celularContato', @$cliente->celularContato )); ?>
                <?php echo form_error('celularContato'); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="product-key" class="col-sm-2 control-label">CEP</label>
            <div class="col-sm-10">
                <?php echo form_input(array('name' => 'cepContato','class' => 'form-control' ,  'id' => 'cepContato'), set_value('cepContato', @$cliente->cepContato )); ?>
                <?php echo form_error('cepContato'); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="product-key" class="col-sm-2 control-label">Endereço</label>
            <div class="col-sm-10">
                <?php echo form_input(array('name' => 'logradouroContato','class' => 'form-control' ,  'id' => 'logradouroContato'), set_value('logradouroContato', @$cliente->logradouroContato )); ?>
                <?php echo form_error('logradouroContato'); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="product-key" class="col-sm-2 control-label">Número</label>
            <div class="col-sm-10">
                <?php echo form_input(array('name' => 'numeroContato','class' => 'form-control' ,  'id' => 'numeroContato'), set_value('numeroContato', @$cliente->numeroContato )); ?>
                <?php echo form_error('numeroContato'); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="product-key" class="col-sm-2 control-label">Bairro</label>
            <div class="col-sm-10">
                <?php echo form_input(array('name' => 'bairroContato','class' => 'form-control' ,  'id' => 'bairroContato'), set_value('bairroContato', @$cliente->bairroContato )); ?>
                <?php echo form_error('bairroContato'); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="product-key" class="col-sm-2 control-label">Complemento</label>
            <div class="col-sm-10">
                <?php echo form_input(array('name' => 'complementoContato','class' => 'form-control' ,  'id' => 'complementoContato'), set_value('complementoContato', @$cliente->complementoContato )); ?>
                <?php echo form_error('complementoContato'); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="product-key" class="col-sm-2 control-label">Cidade</label>
            <div class="col-sm-10">
                <?php echo form_input(array('name' => 'cidadeContato','class' => 'form-control' ,  'id' => 'cidadeContato'), set_value('cidadeContato', @$cliente->cidadeContato )); ?>
                <?php echo form_error('cidadeContato'); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="product-key" class="col-sm-2 control-label">Estado</label>
            <div class="col-sm-10">
                <?php echo form_dropdown('estadoContato', $estados, set_value('estadoContato', @$cliente->estadoContato ) , 'class="multiselect"'); ?>
                <?php echo form_error('estadoContato'); ?>
            </div>
        </div>
    </div>
</div>

<?php echo form_hidden('check_pessoa_fisica', $cliente->check_pessoa_fisica ); ?>

<button class="btn btn-primary" type="submit">Salvar</button>
<BR><BR>
<div class="alert alert-info">
    Para outras informações entre em contato com a ControlWork
</div>

<?php echo form_close()?>