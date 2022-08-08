<div class="content">
    <div class="row">
        <div class="main-header">
            <div class="col-md-5">
                <h2><?php echo (!empty($submenu)) ?  $submenu : $menu;?></h2>
                <em>Escolha o cliente</em>
            </div>
            <div class="col-md-7">
                <div class="top-content">
                    <ul class="list-inline quick-access">
                        <li>
                            <a href="<?php echo base_url('orcamento/'); ?>">
                                <div class="quick-access-item bg-color-yellow">
                                    <i class="fa fa-clipboard"></i>
                                    <h5>Listar Propostas</h5>
                                    <em>Lista de registros propostas</em>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="main-content">
        <?php echo form_open( '/orcamento/pre_processa_orcamento', array('class' => 'form-horizontal label-left', 'role' => 'form') ); //'target' => '_blank',?>
        <div class="row">
            <div class="col-md-12">
                <div class="widget">
                    <div class="widget-header">
                        <h3><i class="fa fa-edit"></i> Escolha o Cliente</h3>
                    </div>
                    <div class="widget-content">
                        <div class="form-group">
                            <div class="col-sm-11">
                                <!-- <?php echo form_error('cliente'); ?> -->
                                <?php if(count($cliente) < 1){ ?>
                        <div class="alert alert-warning">Necessário cadastrar um <? echo ($this->uri->segment(3))?> completo antes de prosseguir. Faça este cadastro no menu ao lado.</div>
                    <?  } else { ?>
                        <?php echo form_dropdown('id_pessoa', $cliente, set_value('cliente', @$cliente->nome ) , 'class="form-control"'); ?>
                        <?php echo form_error('id_pessoa'); ?>


                        
                        <a class="btn btn-link btn-xs" href="<?php echo base_url('cliente/index/add'); ?>" type="button" id="dropdown_secundario_button"><i class="fa fa-plus-square"></i> Criar um novo cliente</a>
                    <?  } ?>

                                <!-- <?php echo form_input(array('name'=>'cliente', 'autocomplete'=>'off',  'placeholder'=>'Digite o nome ou apelido do cliente e selecione', 'id' => 'typeahead', 'class' => 'form-control'), set_value('cliente',@$nome))?>
                                <input type="hidden" id='IdControl' name='id_pessoa' value="<?php echo(@$id_pessoa);?>" > -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="submit" name="botao_gravar" class="btn btn-primary" id="grava" style="margin: 0 auto;" value="Avançar" >
        <?php echo form_close(); ?>
    </div>
</div>
<!--</div>-->
<script type="text/javascript" src="<?php echo (base_url(). '/recursos/assets/js/king-components.js'); ?>"></script>
<script type="text/javascript" src="<?php echo (base_url(). '/recursos/assets/js/jquery.masked-input.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo (base_url(). '/recursos/assets/js/contratonet.js'); ?>"></script>
<script type="text/javascript" src="<?php echo (base_url(). '/recursos/assets/js/bootstrap3-typeahead.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo (base_url(). '/recursos/assets/js/typeaheadHzi.js'); ?>"></script>
<script>
    $(document).ready(function(){
        $('#typeahead').focus();
    });
</script>