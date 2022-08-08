<?php echo $this->load->helper('funcoes'); ?>
<div class="content">
    <div class="row">
        <div class="row bottom">
            <div class="col-md-12">
                <div class="widget">
                    <div class="widget-header">
                        <h3><i class="fa fa-check"></i> Critério de consulta dos chamados</h3>
                    </div>
                    <?php echo form_open("chamados/index/")?>
                    <div class="widget-content">
                        <div class="row ">
                            <div class="col-md-12">
                                <label>Filtrar por data de abertura</label><BR><BR>
                                <div class="col-md-2">
                                    <b>Data de início</b>
                                </div>
                                <div class="col-md-1">
                                    <select class="form-control" name='dia_ini' id='dia_ini'>
                                        <option value="" disabled selected>Dia</option>
                                        <?php
                                        for($i=1;$i<=31;$i++){
                                            ?>
                                            <option><?php echo $i?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control" name='mes_ini' id='mes_ini'>
                                        <option value="" disabled selected>Mês</option>
                                        <option value="1">Janeiro</option>
                                        <option value="2">Fevereiro</option>
                                        <option value="3">Março</option>
                                        <option value="4">Abril</option>
                                        <option value="5">Maio</option>
                                        <option value="6">Junho</option>
                                        <option value="7">Julho</option>
                                        <option value="8">Agosto</option>
                                        <option value="9">Setembro</option>
                                        <option value="10">Outubro</option>
                                        <option value="11">Novembro</option>
                                        <option value="12">Dezembro</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control small-date" name='ano_ini' id='ano_ini'>
                                        <option value="" disabled selected>Ano</option>
                                        <?php for($i=date("Y");$i>date("Y")-90;$i--){?>
                                            <option><?php echo $i?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <BR><BR><BR><BR><BR>

                            <div class="col-md-12">
                                <div class="col-md-2">
                                    <b>Data final</b>
                                </div>
                                <div class="col-md-1">
                                    <select class="form-control" name='dia_fim' id='dia_fim'>
                                        <option value="" disabled selected>Dia</option>
                                        <?php
                                        for($i=1;$i<=31;$i++){
                                            ?>
                                            <option><?php echo $i?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control" name='mes_fim' id='mes_fim'>
                                        <option value="" disabled selected>Mês</option>
                                        <option value="1">Janeiro</option>
                                        <option value="2">Fevereiro</option>
                                        <option value="3">Março</option>
                                        <option value="4">Abril</option>
                                        <option value="5">Maio</option>
                                        <option value="6">Junho</option>
                                        <option value="7">Julho</option>
                                        <option value="8">Agosto</option>
                                        <option value="9">Setembro</option>
                                        <option value="10">Outubro</option>
                                        <option value="11">Novembro</option>
                                        <option value="12">Dezembro</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control small-date" name='ano_fim' id='ano_fim'>
                                        <option value="" disabled selected>Ano</option>
                                        <?php for($i=date("Y");$i>date("Y")-90;$i--){?>
                                            <option><?php echo $i?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row bottom">
                        <div class="col-md-12">

                            <label><input type="radio" name="tipo" value="abertos"> Abertos</label><BR>
                            <label><input type="radio" name="tipo" value="fechados"> Fechados</label><BR>
                            <label><input checked type="radio" name="tipo" value="ambos"> Ambos</label>

                        </div>
                    </div>
                    <div class="row bottom">
                        <div class="col-md-12">
                            <input type="hidden" value="acao" name="cmd">
                            <button class="btn btn-success left" type="submit" id="botaoSubmit" >Buscar</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>

</div>
