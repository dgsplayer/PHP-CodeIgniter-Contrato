<?php echo $this->load->helper('date'); ?>

    <div class="main-header">
        <div class="col-md-5">
            <h2>Cadastro de Cliente</h2>
            <em>Campos com dados do cliente</em>
        </div>
        <div class="col-md-7">
            <div class="top-content">
                <ul class="list-inline quick-access">
                    <li>
                        <a href="<?php echo base_url('cliente/'); ?>">
                            <div class="quick-access-item bg-color-yellow">
                                <i class="fa fa-clipboard"></i>
                                <h5>Lista de clientes</h5>
                                <em>Clique aqui para listar clientes</em>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

<?php echo form_open( 'cliente/processa_cadastro', array('class' => 'form-horizontal label-left', 'role' => 'form') )?>

    <div class="simple-radio simple-radio-inline radio-green">
        <?php echo form_radio(array('name'=> 'pessoa', 'value' => 'J', 'id' => 'tipo_pessoaj', 'class' => 'pessoa' , 'checked' => ( @$cliente->pessoa == 'J') ? TRUE : FALSE ) ); ?>
        <label for="tipo_pessoaj">Pessoa Jurídica</label>
        <?php echo form_radio(array('name'=> 'pessoa', 'value' => 'F', 'id' => 'tipo_pessoaf', 'class' => 'pessoa', 'checked' => ( @$cliente->pessoa == 'F' || !is_object(@$cliente) ) ? TRUE : FALSE ) ); ?>
        <label for="tipo_pessoaf">Pessoa Física</label>
    </div>

    <hr class="inner-separator">

    <div class="widget pessoa-fisica">
        <div class="widget-header">
            <h3><i class="fa fa-edit"></i> Dados Pessoa Física</h3>
        </div>
        <div class="widget-content">
            <div class="form-group">
                <label class="col-sm-2 control-label">* Nome</label>
                <div class="col-sm-10">
                    <?php echo form_input(array('name' => 'nome', 'maxlength' => '150', 'class' => 'form-control' ,  'id' => 'nome'), set_value('nome', @$cliente->nome )); ?>
                    <?php echo form_error('nome'); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Apelido</label>
                <div class="col-sm-10">
                    <?php echo form_input(array('name' => 'apelido','maxlength' => '150','class' => 'form-control' ,  'id' => 'apelido'), set_value('apelido', @$cliente->apelido )); ?>
                    <?php echo form_error('apelido'); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">* Profissão</label>
                <div class="col-sm-10">
                    <?php echo form_input(array('name' => 'profissao','maxlength' => '50','class' => 'form-control' ,  'id' => 'profissao'), set_value('profissao', @$cliente->profissao )); ?>
                    <?php echo form_error('profissao'); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">* RG</label>
                <div class="col-sm-10">
                    <?php echo form_input(array('name' => 'rg','maxlength' => '14','class' => 'form-control' ,  'id' => 'rg'), set_value('rg', @$cliente->rg )); ?>
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
                    <?php echo form_dropdown('estado_civil', array('' => 'Selecione uma opção', 1 => 'Casado', 2 => 'Solteiro', 3 => 'União estável', 4 => 'Separado judicial', 5 => 'Divorciado(a)', 6 => 'União de fato'), set_value('estado_civil', @$cliente->estado_civil ) , 'class="multiselect"'); ?>
                    <?php echo form_error('estado_civil'); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Nacionalidade</label>
                <div class="col-sm-10">
                    <?php echo form_input(array('name' => 'nacionalidade_pf','maxlength' => '50','class' => 'form-control' ,  'id' => 'nacionalidade_pf'), set_value('nacionalidade_pf', @$cliente->nacionalidade_pf )); ?>
                    <?php echo form_error('nacionalidade_pf'); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">* E-mail</label>
                <div class="col-sm-10">
                    <?php echo form_input(array('name' => 'email','maxlength' => '50','class' => 'form-control' ,  'id' => 'email'), set_value('email', @$cliente->email )); ?>
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

    <div class="widget pessoa-juridica">
        <div class="widget-header">
            <h3><i class="fa fa-edit"></i> Dados Pessoa Jurídica</h3>
        </div>
        <div class="widget-content">
            <div class="form-group">
                <label for="phone" class="col-sm-2 control-label">* RAZÃO SOCIAL</label>
                <div class="col-sm-10">
                    <?php echo form_input(array('name' => 'razao','maxlength' => '100','class' => 'form-control' ,  'id' => 'razao'), set_value('razao', @$cliente->razao )); ?>
                    <?php echo form_error('razao'); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="phone-ex" class="col-sm-2 control-label">NOME FANTASIA</label>
                <div class="col-sm-10">
                    <?php echo form_input(array('name' => 'nome_fantasia','maxlength' => '100','class' => 'form-control' ,  'id' => 'nome_fantasia'), set_value('nome_fantasia', @$cliente->nome_fantasia )); ?>
                    <?php echo form_error('nome_fantasia'); ?>
                </div>
            </div>
            <!--        <div class="form-group">-->
            <!--            <label for="tax-id" class="col-sm-2 control-label">-->
            <!--                Início das atividades-->
            <!--                <br/>-->
            <!--                <small>Exemplo: 03/04/2001 </small>-->
            <!--            </label>-->
            <!--            <div class="col-sm-10">-->
            <!--                --><?php //echo form_input(array('name' => 'atividade','class' => 'form-control datepicker' ,  'id' => 'atividade'), set_value('atividade', parseDate( @$cliente->atividade, 'mysql2date') )); ?>
            <!--                --><?php //echo form_error('atividade'); ?>
            <!--            </div>-->
            <!--        </div>-->
            <div class="form-group">
                <label for="ssn" class="col-sm-2 control-label">* CNPJ</label>
                <div class="col-sm-10">
                    <?php echo form_input(array('name' => 'cnpj','class' => 'form-control' ,  'id' => 'cnpj'), set_value('cnpj', @$cliente->cnpj )); ?>
                    <?php echo form_error('cnpj'); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="product-key" class="col-sm-2 control-label">* Inscrição Estadual</label>
                <div class="col-sm-10">
                    <?php echo form_input(array('name' => 'inscricao','maxlength' => '20','class' => 'form-control' ,  'id' => 'inscricao'), set_value('inscricao', @$cliente->inscricao )); ?>
                    <?php echo form_error('inscricao'); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="product-key" class="col-sm-2 control-label">CCM</label>
                <div class="col-sm-10">
                    <?php echo form_input(array('name' => 'ccm', 'maxlength' => '50', 'class' => 'form-control'), set_value('ccm', @$cliente->ccm )); ?>
                    <?php echo form_error('ccm'); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="product-key" class="col-sm-2 control-label">* E-mail Principal</label>
                <div class="col-sm-10">
                    <?php echo form_input(array('name' => 'email_j','maxlength' => '50','class' => 'form-control' ,  'id' => 'email_j'), set_value('email_j', @$cliente->email_j )); ?>
                    <?php echo form_error('email_j'); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="product-key" class="col-sm-2 control-label">* DDD + Telefone Principal</label>
                <div class="col-sm-10">
                    <?php echo form_input(array('name' => 'telefone_principal','class' => 'form-control' ,  'id' => 'telefone_principal'), set_value('telefone_principal', @$cliente->telefone_principal )); ?>
                    <?php echo form_error('telefone_principal'); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="product-key" class="col-sm-2 control-label">Outro Documento</label>
                <div class="col-sm-10">
                    <?php echo form_input(array('name' => 'doc','maxlength' => '50','class' => 'form-control'), set_value('doc', @$cliente->doc )); ?>
                    <?php echo form_error('doc'); ?>
                </div>
            </div>
        </div>
    </div>



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
                    <?php echo form_input(array('name' => 'logradouro','maxlength' => '255','class' => 'form-control' ,  'id' => 'logradouro'), set_value('logradouro', @$cliente->logradouro )); ?>
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
                    <?php echo form_input(array('name' => 'bairro','class' => 'form-control' , 'maxlength' => '50', 'id' => 'bairro'), set_value('bairro', @$cliente->bairro )); ?>
                    <?php echo form_error('bairro'); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="product-key" class="col-sm-2 control-label">Complemento</label>
                <div class="col-sm-10">
                    <?php echo form_input(array('name' => 'complemento','class' => 'form-control' , 'maxlength' => '50', 'id' => 'complemento'), set_value('complemento', @$cliente->complemento )); ?>
                    <?php echo form_error('complemento'); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="product-key" class="col-sm-2 control-label">* Cidade</label>
                <div class="col-sm-10">
                    <?php echo form_input(array('name' => 'cidade','class' => 'form-control' , 'maxlength' => '100', 'id' => 'cidade'), set_value('cidade', @$cliente->cidade )); ?>
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
                <label for="product-key" class="col-sm-2 control-label">Status</label>
                <div class="col-sm-10">
                    <?php echo form_dropdown('ativo', array(1 => 'Ativo', 2 => 'Inativo'), set_value('ativo', @$cliente->ativo ) , 'class="multiselect"'); ?>
                    <?php echo form_error('ativo'); ?>
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
                    <?php echo form_input(array('name' => 'responsavel','class' => 'form-control' , 'maxlength' => '100', 'id' => 'responsavel'), set_value('responsavel', @$cliente->responsavel )); ?>
                    <?php echo form_error('responsavel'); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="phone-ex" class="col-sm-2 control-label">Email do Responsável</label>
                <div class="col-sm-10">
                    <?php echo form_input(array('name' => 'email_responsavel','class' => 'form-control' , 'maxlength' => '50', 'id' => 'email_responsavel'), set_value('email_responsavel', @$cliente->email_responsavel )); ?>
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
                    <?php echo form_input(array('name' => 'nacionalidade','class' => 'form-control' ,  'maxlength' => '50', 'id' => 'nacionalidade'), set_value('nacionalidade', @$cliente->nacionalidade )); ?>
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
                    <?php echo form_input(array('name' => 'logradouroContato','class' => 'form-control' , 'maxlength' => '255', 'id' => 'logradouroContato'), set_value('logradouroContato', @$cliente->logradouroContato )); ?>
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
                    <?php echo form_input(array('name' => 'bairroContato','class' => 'form-control' , 'maxlength' => '50', 'id' => 'bairroContato'), set_value('bairroContato', @$cliente->bairroContato )); ?>
                    <?php echo form_error('bairroContato'); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="product-key" class="col-sm-2 control-label">Complemento</label>
                <div class="col-sm-10">
                    <?php echo form_input(array('name' => 'complementoContato','class' => 'form-control' , 'maxlength' => '50', 'id' => 'complementoContato'), set_value('complementoContato', @$cliente->complementoContato )); ?>
                    <?php echo form_error('complementoContato'); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="product-key" class="col-sm-2 control-label">Cidade</label>
                <div class="col-sm-10">
                    <?php echo form_input(array('name' => 'cidadeContato','class' => 'form-control' , 'maxlength' => '100', 'id' => 'cidadeContato'), set_value('cidadeContato', @$cliente->cidadeContato )); ?>
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

    <input type="hidden" value="<?php echo @$cliente->id_pessoa; ?>" name="id_pessoa">


    <button class="btn btn-primary" type="submit">Salvar</button>
    <!--<button class="btn btn-primary" type="submit">Salvar e Criar Contrato</button>-->

<?php echo form_close()?>