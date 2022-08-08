<?php echo $this->load->helper('funcoes'); ?>
<div class="content">
    <?php if ($this->uri->segment(1) === "chamados") { ?>
    <div class="row">
        <div class="main-header">
            <div class="col-md-8">
                <table>
                    <tr>
                        <td><img src="<?php echo (base_url(). '/recursos/img/red.png'); ?>" border="0" width="14">&nbsp;</td>
                        <td><span style="text-align: left">Em atraso</span></td>
                    </tr>
                    <tr>
                        <td><img src="<?php echo (base_url(). '/recursos/img/yellow.png'); ?>" border="0" width="15">&nbsp;</td>
                        <td>Prazo de 0 a 3 dias</td>
                    </tr>
                    <tr>
                        <td><img src="<?php echo (base_url(). '/recursos/img/green.png'); ?>" border="0" width="15">&nbsp;</td>
                        <td>Prazo acima de 3 dias</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="span4">
                        <?php if(!empty($areas)) foreach($areas as $key => $linha){ ?>
                            <a style="padding: 7px; margin-bottom: 5px" href="/painel/chamados/index/<?=$linha->id_area?>" class="btn <?php echo ($id_area == $linha->id_area) ? 'btn-success' : '' ;?>">Pendências de <?=$linha->area?></a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <BR><BR>
    <?php } ?>
    <em>
        <script type="text/javascript">
            var d=new Date()
            var weekday=new Array("Domingo","Segunda","Ter&ccedil;a","Quarta","Quinta","Sexta","S&aacute;bado")
            var monthname=new Array("Janeiro","Fevereiro","Mar&ccedil;o","Abril","Mar&ccedil;o","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro")
            document.write(weekday[d.getDay()] + ", ")
            document.write(d.getDate() + " de ")
            document.write(monthname[d.getMonth()] + " de ")
            document.write(d.getFullYear())

        </script>

    </em>


    <div>
        <?php echo $output; ?>
    </div>


</div>
