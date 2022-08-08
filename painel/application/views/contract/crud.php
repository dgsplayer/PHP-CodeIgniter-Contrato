<?php $this->load->helper('funcoes'); ?>
<style>
    .modal{
        z-index: 10000;
    }
</style>
<div class="main-header">
    <div class="col-md-5">
    
    </div>
    <div class="col-md-7">
        <div class="top-content">
            <ul class="list-inline quick-access">
                <li>
                    <a href="<?php echo site_url('contrato/cadastro/cliente'); ?>" >
                        <div class="quick-access-item bg-color-green">
                            <i class="fa fa-clipboard"></i>
                            <h5>Novo Contrato</h5>
                            <em>Clique aqui para cadastrar novo contrato</em>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div>
    <?php echo $output; ?>
</div>

<script type="text/javascript" src="<?php echo (base_url(). '/recursos/assets/js/jquery.meiomask.js'); ?>"></script>

<script>
    $(document).ready(function(){

        $("#field-cep" ).mask('99999-999');
        $("#field-cepContato" ).mask('99999-999');
        $("#field-cpf" ).mask('999.999.999-99');
        $("#field-cnpj" ).mask('99.999.999/9999-99');
        $("#field-numero" ).mask('9?9999');
        $("#field-numeroContato" ).mask('9?9999');

    $("#field-cep").change(function(){
        var cep = $("#field-cep").val();
        var cepEditado = cep.replace('-','');
        $.getJSON("http://cep.republicavirtual.com.br/web_cep.php?cep=" + cepEditado + "&formato=jsonp",
            function(data){
                $('#field-cidade').val(data.cidade);
                $('#field-bairro').val(data.bairro);
                $('#field-estado').val(data.uf.toLowerCase());
                $('#field-logradouro').val(data.logradouro);
            });
        });

        $("#field-cepContato").change(function(){
        var cepContato = $("#field-cepContato").val();
        var cepEditadoContato = cepContato.replace('-','');
        $.getJSON("http://cep.republicavirtual.com.br/web_cep.php?cep=" + cepEditadoContato + "&formato=jsonp",
            function(data){
                $('#field-cidadeContato').val(data.cidade);
                $('#field-bairroContato').val(data.bairro);
                $('#field-estadoContato').val(data.uf.toLowerCase());
                $('#field-logradouroContato').val(data.logradouro);
            });
        });
    });

</script>