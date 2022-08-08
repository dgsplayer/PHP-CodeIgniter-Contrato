<?php echo $this->load->helper('funcoes'); ?>
<?php echo $this->load->helper('date'); ?>
					<!-- content-wrapper -->
					<div class="col-md-10 content-wrapper">
						<!-- main -->
						<div class="content">
							<div class="main-header">
                                <h2>SUPORTE</h2>
								<em>informações gerais</em>
							</div>

							<div class="main-content">
								<!-- NAV TABS -->
								<!-- <ul class="nav nav-tabs">
									<li class="active"><a href="#profile-tab" data-toggle="tab"><i class="fa fa-user"></i> Minha Empresa</a></li>
								</ul> -->
								<!-- END NAV TABS -->
								<div class="tab-content profile-page">
									<!-- PROFILE TAB CONTENT -->
									<div class="tab-pane profile active" id="profile-tab">
										<div class="row">
											<div class="col-md-12">
												<div class="user-info-right">

                                                <div class="contact_info">
														<h3><i class="fa fa-square"></i> ContratoNET</h3>

                                                        <p class="data-row">
                                                            <span class="data-name">Nome da Empresa</span>
                                                            <span class="data-value"><?php echo($contratonet->nome) ?></span>
                                                        </p>
                                                        <p class="data-row">
                                                            <span class="data-name">Telefones</span>
                                                            <span class="data-value"><a href="tel:<?=(@$contratonet->celular ? @$contratonet->celular : @$contratonet->telefone)?>"><?php echo(@$contratonet->telefone) ?>&nbsp;&nbsp;<?php echo(@$contratonet->telefone_principal) ?>&nbsp;&nbsp;<?php echo(@$contratonet->celular) ?></a></span>
                                                        </p>
                                                        <p class="data-row">
                                                            <span class="data-name">Endereço</span>
                                                            <span class="data-value"><?php echo(@$contratonet->logradouro . ' ' . @$contratonet->numero. ' ' . @$contratonet->complemento. ' ' . @$contratonet->bairro. ' ' . @$contratonet->cep. ' ' . @$contratonet->cidade. ' ' . @$contratonet->estado)?></span>
                                                        </p>
                                                        <p class="data-row">
                                                            <span class="data-name">E-mail</span>
                                                            <span class="data-value"><a href="mailto:<?=(@$contratonet->email ? @$contratonet->email : @$contratonet->email_j)?>"><?php echo(@$contratonet->email) ?>&nbsp;&nbsp;<?php echo(@$contratonet->email_j) ?></a></span>
                                                        </p>
                                                       
													</div>

													<div class="basic-info">
														<h3><i class="fa fa-square"></i> Minha Empresa</h3>
                                                        <p class="data-row">
                                                            <span class="data-name">Nome da Empresa</span>
                                                            <span class="data-value"><?php echo($empresa->nome) ?></span>
                                                        </p>
                                                        <p class="data-row">
                                                            <span class="data-name">Telefones</span>
                                                            <span class="data-value"><?php echo(@$empresa->telefone) ?>&nbsp;&nbsp;<?php echo(@$empresa->telefone_principal) ?>&nbsp;&nbsp;<?php echo(@$empresa->celular) ?></span>
                                                        </p>
                                                        <p class="data-row">
                                                            <span class="data-name">Endereço</span>
                                                            <span class="data-value"><?php echo(@$empresa->logradouro . ' ' . @$empresa->numero. ' ' . @$empresa->complemento. ' ' . @$empresa->bairro. ' ' . @$empresa->cep. ' ' . @$empresa->cidade. ' ' . @$empresa->estado)?></span>
                                                        </p>
                                                        <p class="data-row">
                                                            <span class="data-name">E-mail</span>
                                                            <span class="data-value"><?php echo(@$empresa->email) ?>&nbsp;&nbsp;<?php echo(@$empresa->email_j) ?></span>
                                                        </p>
                                                        <p class="data-row">
                                                            <span class="data-name">Conosco desde</span>
                                                            <span class="data-value"><?php echo(parseDate($empresa->data_cad,'date3')) ?></span>
                                                        </p>
                                                        <?php if(!empty($empresa->nome_fantasia)) { ?>
                                                            <p class="data-row">
                                                                <span class="data-name">Nome Fantasia</span>
                                                                <span class="data-value"><?php echo($empresa->nome_fantasia) ?></span>
                                                            </p>
                                                        <?php } ?>

                                                        <?php if(!empty($empresa->atividade) && $empresa->atividade != '0000-00-00') { ?>
                                                        <p class="data-row">
                                                            <span class="data-name">Atividade</span>
                                                            <span class="data-value"><?php echo($empresa->atividade) ?></span>
                                                        </p>
                                                        <?php } ?>
                                                        <?php if(!empty($empresa->atividade_empresa)) { ?>
                                                        <p class="data-row">
                                                            <span class="data-name">Atividade da Empresa</span>
                                                            <span class="data-value"><?php echo($empresa->atividade_empresa) ?></span>
                                                        </p>
                                                        <?php } ?>
                                                        <?php if(!empty($empresa->profissao)) { ?>
                                                        <p class="data-row">
                                                            <span class="data-name">Profissão</span>
                                                            <span class="data-value"><?php echo($empresa->profissao) ?></span>
                                                        </p>
                                                        <?php } ?>
                                                        <?php if(!empty($empresa->estado_civil)) { ?>
                                                        <p class="data-row">
                                                            <span class="data-name">Estado Civil</span>
                                                            <span class="data-value"><?php echo($empresa->estado_civil) ?></span>
                                                        </p>
                                                        <?php } ?>
                                                        <?php if(!empty($empresa->nacionalidade_pf)) { ?>
                                                        <p class="data-row">
                                                            <span class="data-name">Nacionalidade</span>
                                                            <span class="data-value"><?php echo($empresa->nacionalidade_pf) ?></span>
                                                        </p>
                                                        <?php } ?>
                                                        <?php if(!empty($empresa->rg)) { ?>
                                                        <p class="data-row">
                                                            <span class="data-name">RG</span>
                                                            <span class="data-value"><?php echo($empresa->rg) ?></span>
                                                        </p>
                                                        <?php } ?>
                                                        <?php if(!empty($empresa->cpf)) { ?>
                                                        <p class="data-row">
                                                            <span class="data-name">CPF</span>
                                                            <span class="data-value"><?php echo($empresa->cpf) ?></span>
                                                        </p>
                                                        <?php } ?>
                                                        <?php if(!empty($empresa->cnpj)) { ?>
                                                        <p class="data-row">
                                                            <span class="data-name">CNPJ</span>
                                                            <span class="data-value"><?php echo($empresa->cnpj) ?></span>
                                                        </p>
                                                        <?php } ?>
                                                        <?php if(!empty($empresa->doc)) { ?>
                                                        <p class="data-row">
                                                            <span class="data-name">Documento</span>
                                                            <span class="data-value"><?php echo($empresa->doc) ?></span>
                                                        </p>
                                                        <?php } ?>

                                                        <?php if(!empty($empresa->inscricao)) { ?>
                                                        <p class="data-row">
                                                            <span class="data-name">Inscrição Estadual</span>
                                                            <span class="data-value"><?php echo($empresa->inscricao) ?></span>
                                                        </p>
                                                        <?php } ?>
                                                        <?php if(!empty($empresa->porte)) { ?>
                                                        <p class="data-row">
                                                            <span class="data-name">Porte</span>
                                                            <span class="data-value"><?php echo($empresa->porte) ?></span>
                                                        </p>
                                                        <?php } ?>
                                                        <?php if(!empty($empresa->natureza)) { ?>
                                                        <p class="data-row">
                                                            <span class="data-name">Natureza</span>
                                                            <span class="data-value"><?php echo($empresa->natureza) ?></span>
                                                        </p>
                                                        <?php } ?>
                                                        <?php if(!empty($empresa->socios)) { ?>
                                                        <p class="data-row">
                                                            <span class="data-name">Sócios</span>
                                                            <span class="data-value"><?php echo($empresa->socios) ?></span>
                                                        </p>
                                                        <?php } ?>
                                                        <?php if(!empty($empresa->funcionarios)) { ?>
                                                        <p class="data-row">
                                                            <span class="data-name">Funcionários</span>
                                                            <span class="data-value"><?php echo($empresa->funcionarios) ?></span>
                                                        </p>
                                                        <?php } ?>

													</div>

                                                    <?php if(!empty($empresa->responsavel)) { ?>

													<div class="contact_info">
														<h3><i class="fa fa-square"></i> Contato</h3>

                                                        <p class="data-row">
                                                            <span class="data-name">Responsável</span>
                                                            <span class="data-value"><?php echo($empresa->responsavel) ?></span>
                                                        </p>

                                                        <?php if(!empty($empresa->cpfContato)) { ?>
                                                        <p class="data-row">
                                                            <span class="data-name">CPF</span>
                                                            <span class="data-value"><?php echo($empresa->cpfContato) ?></span>
                                                        </p>
                                                        <?php } ?>

                                                        <?php if(!empty($empresa->rgContato)) { ?>
                                                        <p class="data-row">
                                                            <span class="data-name">RG</span>
                                                            <span class="data-value"><?php echo($empresa->rgContato) ?></span>
                                                        </p>
                                                        <?php } ?>

                                                        <?php if(!empty($empresa->email_responsavel)) { ?>
                                                        <p class="data-row">
                                                            <span class="data-name">Email</span>
                                                            <span class="data-value"><?php echo($empresa->email_responsavel) ?></span>
                                                        </p>
                                                        <?php } ?>
                                                        <p class="data-row">
                                                            <span class="data-name">Telefones</span>
                                                            <span class="data-value"><?php echo(@$empresa->telefoneContato) ?>&nbsp;&nbsp;<?php echo(@$empresa->celularContato) ?></span>
                                                        </p>
                                                        <?php if(!empty($empresa->nacionalidade)) { ?>
                                                        <p class="data-row">
                                                            <span class="data-name">Nacionalidade</span>
                                                            <span class="data-value"><?php echo($empresa->nacionalidade) ?></span>
                                                        </p>
                                                        <?php } ?>
                                                        <?php if(!empty($empresa->civil)) { ?>
                                                        <p class="data-row">
                                                            <span class="data-name">Estado Civil</span>
                                                            <span class="data-value"><?php echo($empresa->civil) ?></span>
                                                        </p>
                                                        <?php } ?>
                                                        <?php if(!empty($empresa->cidadeContato)) { ?>
                                                        <p class="data-row">
                                                            <span class="data-name">Endereço</span>
                                                            <span class="data-value"><?php echo(@$empresa->logradouroContato . ' ' . @$empresa->numeroContato. ' ' . @$empresa->complementoContato. ' ' . @$empresa->bairroContato. ' ' . @$empresa->cepContato. ' ' . @$empresa->cidadeContato. ' ' . @$empresa->estadoContato)?></span>
                                                        </p>
                                                        <?php } ?>

                                                        <?php if(!empty($empresa->docContato)) { ?>
                                                        <p class="data-row">
                                                            <span class="data-name">Documento</span>
                                                            <span class="data-value"><?php echo($empresa->docContato)?></span>
                                                        </p>
                                                        <?php } ?>
													</div>


                                                    <?php } ?>
 

<div class="contact_info">
    <h3><i class="fa fa-square"></i> Meus Dados</h3>

    <p class="data-row">
        <span class="data-name">Nome</span>
        <span class="data-value"><?php echo($usuario->nome_usuario) ?></span>
    </p>

    <?php if(!empty($usuario->celular)) { ?>
    <p class="data-row">
        <span class="data-name">Celular</span>
        <span class="data-value"><?php echo($usuario->celular) ?></span>
    </p>
    <?php } ?>

    <?php if(!empty($usuario->email)) { ?>
    <p class="data-row">
        <span class="data-name">E-mail</span>
        <span class="data-value"><?php echo($usuario->email) ?></span>
    </p>
    <?php } ?>
 
</div>
 
												</div>
											</div>
										</div>
									</div>
								</div>

							</div>
							<!-- /main-content -->
						</div>
						<!-- /main -->
					</div>
					<!-- /content-wrapper -->
