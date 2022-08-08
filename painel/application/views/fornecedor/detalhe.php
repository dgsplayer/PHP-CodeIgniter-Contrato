<?php echo $this->load->helper('date'); ?>
<?php echo $this->load->helper('funcoes'); ?>
<div class="main-heade">
    <h2>Informações Gerais do Fornecedor</h2>
</div>
<BR>



<div class="widget-content">
<div class="main-content">
<!-- NAV TABS -->


<div class="row">
<div class="col-md-6">
<div class="user-info-right">
    <div class="basic-info">
        <h3><i class="fa fa-square"></i> Dados do Fornecedor</h3>
        <p class="data-row">
            <span class="data-name">Nome / Razão Social</span>
            <span class="data-value"><?php echo($cliente->nome) ?></span>
        </p>
        <p class="data-row">
            <span class="data-name">Telefones</span>
            <span class="data-value"><?php echo(@$cliente->telefone) ?>&nbsp;&nbsp;<?php echo(@$cliente->telefone_principal) ?>&nbsp;&nbsp;<?php echo(@$cliente->celular) ?></span>
        </p>
        <?php if(!empty($cliente->logradouro)) { ?>
        <p class="data-row">
            <span class="data-name">Endereço</span>
            <span class="data-value"><?php echo(ucwords(@$cliente->logradouro . ', ' . @$cliente->numero. ' ' . @$cliente->complemento. ', ' . @$cliente->bairro. ' ' . @$cliente->cep. ' ' . @$cliente->cidade. ' - ' . @$cliente->estado))?></span>
        </p>
        <?php } ?>
        <p class="data-row">
            <span class="data-name">E-mail</span>
            <span class="data-value"><?php echo(@$cliente->email) ?>&nbsp;&nbsp;<?php echo(@$cliente->email_j) ?></span>
        </p>
        <p class="data-row">
            <span class="data-name">Conosco desde</span>
            <span class="data-value"><?php echo(parseDate($cliente->data_cad,'date3')) ?></span>
        </p>

        <?php if(!empty($cliente->nome_fantasia)) { ?>
        <p class="data-row">
            <span class="data-name">Nome Fantasia</span>
            <span class="data-value"><?php echo($cliente->nome_fantasia) ?></span>
        </p>
        <?php } ?>

        <?php if(!empty($cliente->apelido)) { ?>
        <p class="data-row">
            <span class="data-name">Apelido</span>
            <span class="data-value"><?php echo($cliente->apelido) ?></span>
        </p>
        <?php } ?>

        <?php if(!empty($cliente->atividade) && $cliente->atividade != '0000-00-00') { ?>
        <p class="data-row">
            <span class="data-name">Atividade</span>
            <span class="data-value"><?php echo($cliente->atividade) ?></span>
        </p>
        <?php } ?>
        <?php if(!empty($cliente->atividade_empresa)) { ?>
        <p class="data-row">
            <span class="data-name">Atividade da Empresa</span>
            <span class="data-value"><?php echo($cliente->atividade_empresa) ?></span>
        </p>
        <?php } ?>
        <?php if(!empty($cliente->profissao)) { ?>
        <p class="data-row">
            <span class="data-name">Profissão</span>
            <span class="data-value"><?php echo($cliente->profissao) ?></span>
        </p>
        <?php } ?>
        <?php if(!empty($cliente->estado_civil)) { ?>
        <p class="data-row">
            <span class="data-name">Estado Civil</span>
            <span class="data-value"><?php echo($cliente->estado_civil) ?></span>
        </p>
        <?php } ?>
        <?php if(!empty($cliente->nacionalidade_pf)) { ?>
        <p class="data-row">
            <span class="data-name">Nacionalidade</span>
            <span class="data-value"><?php echo($cliente->nacionalidade_pf) ?></span>
        </p>
        <?php } ?>
        <?php if(!empty($cliente->rg)) { ?>
        <p class="data-row">
            <span class="data-name">RG</span>
            <span class="data-value"><?php echo($cliente->rg) ?></span>
        </p>
        <?php } ?>
        <?php if(!empty($cliente->cpf)) { ?>
        <p class="data-row">
            <span class="data-name">CPF</span>
            <span class="data-value"><?php echo($cliente->cpf) ?></span>
        </p>
        <?php } ?>
        <?php if(!empty($cliente->cnpj)) { ?>
        <p class="data-row">
            <span class="data-name">CNPJ</span>
            <span class="data-value"><?php echo($cliente->cnpj) ?></span>
        </p>
        <?php } ?>
        <?php if(!empty($cliente->doc)) { ?>
        <p class="data-row">
            <span class="data-name">Outro Documento</span>
            <span class="data-value"><?php echo($cliente->doc) ?></span>
        </p>
        <?php } ?>

        <?php if(!empty($cliente->ccm)) { ?>
        <p class="data-row">
            <span class="data-name">CCM</span>
            <span class="data-value"><?php echo($cliente->ccm) ?></span>
        </p>
        <?php } ?>

        <?php if(!empty($cliente->inscricao)) { ?>
        <p class="data-row">
            <span class="data-name">Inscrição Estadual</span>
            <span class="data-value"><?php echo($cliente->inscricao) ?></span>
        </p>
        <?php } ?>
        <?php if(!empty($cliente->porte)) { ?>
        <p class="data-row">
            <span class="data-name">Porte</span>
            <span class="data-value"><?php echo($cliente->porte) ?></span>
        </p>
        <?php } ?>
        <?php if(!empty($cliente->natureza)) { ?>
        <p class="data-row">
            <span class="data-name">Natureza</span>
            <span class="data-value"><?php echo($cliente->natureza) ?></span>
        </p>
        <?php } ?>
        <?php if(!empty($cliente->socios)) { ?>
        <p class="data-row">
            <span class="data-name">Sócios</span>
            <span class="data-value"><?php echo($cliente->socios) ?></span>
        </p>
        <?php } ?>
        <?php if(!empty($cliente->funcionarios)) { ?>
        <p class="data-row">
            <span class="data-name">Funcionários</span>
            <span class="data-value"><?php echo($cliente->funcionarios) ?></span>
        </p>
        <?php } ?>

    </div>

    <?php if(!empty($cliente->responsavel)) { ?>

    <div class="contact_info">
        <h3><i class="fa fa-square"></i> Contato</h3>
        <p class="data-row">
            <span class="data-name">Responsável</span>
            <span class="data-value"><?php echo($cliente->responsavel) ?></span>
        </p>
        <?php if(!empty($cliente->cpfContato)) { ?>
        <p class="data-row">
            <span class="data-name">CPF</span>
            <span class="data-value"><?php echo($cliente->cpfContato) ?></span>
        </p>
        <?php } ?>
        <?php if(!empty($cliente->rgContato)) { ?>
        <p class="data-row">
            <span class="data-name">RG</span>
            <span class="data-value"><?php echo($cliente->rgContato) ?></span>
        </p>
        <?php } ?>
        <?php if(!empty($cliente->email_responsavel)) { ?>
        <p class="data-row">
            <span class="data-name">Email</span>
            <span class="data-value"><?php echo($cliente->email_responsavel) ?></span>
        </p>
        <?php } ?>
        <p class="data-row">
            <span class="data-name">Telefones</span>
            <span class="data-value"><?php echo(@$cliente->telefoneContato) ?>&nbsp;&nbsp;<?php echo(@$cliente->celularContato) ?></span>
        </p>
        <?php if(!empty($cliente->nacionalidade)) { ?>
        <p class="data-row">
            <span class="data-name">Nacionalidade</span>
            <span class="data-value"><?php echo($cliente->nacionalidade) ?></span>
        </p>
        <?php } ?>
        <?php if(!empty($cliente->civil)) { ?>
        <p class="data-row">
            <span class="data-name">Estado Civil</span>
            <span class="data-value"><?php echo($cliente->civil) ?></span>
        </p>
        <?php } ?>
        <?php if(!empty($cliente->cidadeContato)) { ?>
        <p class="data-row">
            <span class="data-name">Endereço</span>
            <span class="data-value"><?php echo(@$cliente->logradouroContato . ' ' . @$cliente->numeroContato. ' ' . @$cliente->complementoContato. ' ' . @$cliente->bairroContato. ' ' . @$cliente->cepContato. ' ' . @$cliente->cidadeContato. ' ' . @$cliente->estadoContato)?></span>
        </p>
        <?php } ?>

        <?php if(!empty($cliente->docContato)) { ?>
        <p class="data-row">
            <span class="data-name">Documento</span>
            <span class="data-value"><?php echo($cliente->docContato)?></span>
        </p>
        <?php } ?>
    </div>
    <?php } ?>
</div>
<BR>
<div class="row">
    <div class="col-md-4">
        <a href="<?php echo base_url('fornecedor/cadastro/' . $cliente->id_pessoa ); ?>" class="btn btn-info btn-block"><i class="fa fa-edit"></i> Editar</a>
    </div>
    <?php if($cliente->ativo == '1') { ?>
    <div class="col-md-4">
        <a href="<?php echo base_url('fornecedor/delete/' . $cliente->id_pessoa ); ?>"  onclick="return ask_delete();" class="btn btn-danger btn-block"><i class="fa fa-ban"></i> Excluir</a>
    </div>
    <?php } ?>
</div>
</div>
<div class="col-md-6">
    <div class="user-info-left">
        <div class="contact">
            <?php if($mensagem = $this->session->flashdata("sucesso")) { 	?>
            <div class="alert alert-success bg-success text-center">
                <?php echo $mensagem; ?>
            </div>
            <?php } ?>
            <h3><i class="fa fa-square"></i> Histórico do Fornecedor</h3>
            <BR>
            <?php echo form_open( 'fornecedor/detalhe/' . $cliente->id_pessoa, array('class' => 'form-horizontal label-left', 'role' => 'form') )?>
            <div class="row">
                <div class="col-md-9">

                    <textarea maxlength="400" class="form-control" name="descricao" rows="1" placeholder="Descreva uma observação sobre este fornecedor"></textarea>
                    <?php echo form_error('descricao'); ?>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-success" type="submit">Gravar</button>
                </div>
            </div>
            <?php echo form_hidden('id_pessoa', @$cliente->id_pessoa ); ?>
            <?php echo form_close()?>
            <BR>
            <div class="row">
                <table class="table table-sorting table-striped table-hover datatable" cellpadding="0" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Criador</th>
                        <th>Data</th>
                        <th>Descrição</th>
                        <th>#</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($historicos) && count($historicos)) { ?>
                        <?php foreach( $historicos as $historico ) { ?>
                        <tr>
                            <td><?php echo $historico->admin; ?></td>
                            <td><?php echo parseDate($historico->data_cad, 'both'); ?></td>
                            <td><?php echo $historico->descricao; ?></td>
                            <td>
                                <a href="<?php echo base_url('fornecedor/delete_historico/' . $historico->id ); ?>">Remover</a>
                            </td>
                        </tr>
                            <?php } ?>
                        <?php } else { ?>
                    <tr>
                        <td colspan="6" class="text-center"> Sem informação cadastrada.</td>
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

<!-- /main-content -->
</div>
<!-- /main -->

<!-- /content-wrapper -->