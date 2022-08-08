<?php echo $this->load->helper('date'); ?>
<?php echo $this->load->helper('funcoes'); ?>
<!--<head>-->
<!--    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">-->
<!--    <link rel="stylesheet" type="text/css" href="--><?php //echo base_url('/recursos/assets/css/pdf/bootstrap.css'); ?><!--" />-->
<!--    <link rel="stylesheet" type="text/css" href="--><?php //echo base_url('/recursos/assets/css/pdf/default.css'); ?><!--" />-->
<!--    <link rel="stylesheet" type="text/css" href="--><?php //echo base_url('/recursos/assets/css/pdf/default_pdf.css'); ?><!--" />-->
<!--    <style>-->
<!--        @page { margin: 0px;}-->
<!--        body { margin: 0px;}-->
<!--    </style>-->
<!--</head>-->


<?

//var_dump($resDesign);

$content .= "<style>
    .container  {background-color: #" . $resDesign['cor_fundo'] . ";}
    .contrato_color_topo {background-color: #" . $resDesign['cor_topo'] . ";color: #" . $resDesign['cor_topo_fonte'] . ";}
    .contrato_color_parte {background-color: #" . $resDesign['cor_quadro'] . ";color: #" . $resDesign['cor_quadro_fonte'] . ";}
    .contrato_color_clausula {background-color: #" . $resDesign['cor_clausula'] . ";color: #" . $resDesign['cor_clausula_fonte'] . ";}
</style>";



$content .= "<div class='container'>";
$content .= "<table  cellspacing='0' cellpadding='0' class='contrato_color_topo' style='width: 100%; text-align: center;' >
    <tbody>
    <tr>
        <td valign='top' ><p><b>INSTRUMENTO PARTICULAR </b></p>
            <p><b>DE CONTRATO DE PRESTAÇÃO DE SERVIÇOS</b></p>
            <p><b>N. " . $NumContrato . "</b></p></td>
    </tr>
    </tbody>
</table>
<table  cellspacing='0' cellpadding='0' style='width: 100%;'   class='contrato_color_parte' >
    <tbody>
    <tr>
        <td valign='top'  ><p><b>PARTE I - QUADRO RESUMO</b></p></td>
    </tr>
    </tbody>
</table>
<table  cellspacing='0' cellpadding='0' style='width: 100%;'  class='contrato_color_clausula'>
    <tbody>
    <tr>
        <td valign='top' ><p><b>ITEM 01 - QUALIFICAÇÃO DAS PARTES </b></p></td>
    </tr>
    </tbody>
</table>";

$content .= "<p style='text-align:justify;'><b>CONTRATANTES: </b>" ;
    if($resCli['tipo_pessoa'] == 'CLIENTE'){
    include "ver_contrato_descContratante.php";
    }
    if($resCli['tipo_pessoa'] == 'FORNECEDOR'){
    include "ver_contrato_descContratada.php";
    }
    $content .= "</p>" ;
$content .= "<p  style='text-align:justify;'>" ;
    $content .= "<b>CONTRATADA:  </b>" ;
    if($resCli['tipo_pessoa'] == 'CLIENTE'){
    include "ver_contrato_descContratada.php";
    }
    if($resCli['tipo_pessoa'] == 'FORNECEDOR'){
    include "ver_contrato_descContratante.php";
    }

    $content .= "</p>" ;
$content .= "<table  cellspacing='0' cellpadding='0' style='width: 100%;' class='contrato_color_clausula'>
    <tbody>
    <tr>
        <td valign='top' ><p><b>ITEM 02 - DO OBJETO</b></p></td>
    </tr>
    </tbody>
</table>";
$content .= "<p><b>" . $resCon['texto_base_objeto'] . "</b></p>";
$content .= "
<table  cellspacing='0' cellpadding='0' style='width: 100%;'  class='contrato_color_clausula'>
    <tbody>
    <tr>
        <td valign='top' ><p><b>ITEM 03 - DA FORMA E CONDIÇÕES DE PAGAMENTO</b></p></td>
    </tr>
    </tbody>
</table>";
if(empty($resCon['valor_total'])){
$content .= "<p><b>" .$resCon['desc_cobranca']. "</b></p>";
}else{
$content .= "
<p><b>VALOR TOTAL: R$ " .strtoupper($resCon['valor_total']). "</b></p>";
if ( $resCon['mensalidade'] == 't' ) {
$content .= "<p><b>(Este valor é mensal. Pagamento todo dia " . parseDate($resCon['diadomes'],'dia') . ")</b></p>";
}
if(!empty($resCon['forma'])){
    $content .= "<p><b>FORMA DE PAGAMENTO: " .strtoupper($resCon['forma']). "</b></p>";
}
if($resCon['forma'] == 'DEPÓSITO/TRANSFERÊNCIA'){
$content .= "<p><b>DADOS BANCÁRIOS ";
    if(!empty($resCon['deposito_banco'])) $content .= "BANCO " . strtoupper($resCon['deposito_banco']);
    if(!empty($resCon['deposito_agencia'])) $content .= "  AGÊNCIA: " . $resCon['deposito_agencia'];
    if(!empty($resCon['deposito_conta'])) $content .= "  CONTA: " . $resCon['deposito_conta'];
    $content .= "</b></p>";
}
if(!empty($resCon['descricao_forma_pagamento'])){
$content .= "<p><b>OBSERVAÇÃO: ";
    $content .= "" .$resCon['descricao_forma_pagamento']. "";
    $content .= "</b></p>";
}
if ( $resCon['entrada'] > 0 ) {
$content .= "<p><b>ENTRADA: R$ " .strtoupper($resCon['entrada']). "</b></p>";
if ( !empty($resCon['descricao_entrada'])) {
$content .= "<p><b>" .strtoupper($resCon['descricao_entrada']). "</b></p>";
}
}
if ( !empty($resCon['qtd_parcelas'])) {
$content .= "<p><b>QUANTIDADE DE PARCELAS: " .strtoupper($resCon['qtd_parcelas']). "</b></p>";
$content .= "<p><b>DATA DO INÍCIO DE PAGAMENTO E DEMAIS</b>: </p>
<table cellspacing='0' cellpadding='0'  width='100%' >
    <tr class='table-border'>
        <td class='table-border'><b>Parcela</b></td>
        <td class='table-border'><b>Valor</b></td>
        <td class='table-border'><b>Data do pagamento</b></td>
    </tr>";
    if(!empty($getID)){
    # CONSULTA AS PARCELAS
    $strParc = 'SELECT * FROM tb_contratos_parcelas WHERE id_contrato = ' . $getID . ' ;';
    $qryParc = mysql_query( $strParc ) or die ( mysql_error() . '<br>' . $strParc );
    $countParc = mysql_num_rows($qryParc);
    if($countParc > 0){
    while ($resParc = mysql_fetch_array($qryParc)){
    $content .= "<tr>
    <td class='table-border'>" .$resParc['num_parcela']. "º parcela </td>
    <td class='table-border'>R$ " .number_format($resParc['valor_parcela'],2,',','.'). "</td>
    <td class='table-border'>" .  parseDate($resParc['data_parcela'], 'date3') . "</td>
</tr>";
    }
    }
    }
    if(isset($_GET['idNew'])){
    foreach($resParcArray as $keyN => $resParcDat){
    $content .= "<tr>
    <td class='table-border'>" .$resParcNum[$keyN]. "º parcela </td>
    <td class='table-border'>R$ " .$resParcVal[$keyN]. "</td>
    <td class='table-border'>" . $resParcDat . "</td>
</tr>";
    }
    }
    }
    $content .= "</table>";

}
$content .= "<div id='contentprint' style='text-align:justify;width:100%'>";
    $content .= "<table  cellspacing='0' cellpadding='0' style='width: 100%;'  class='contrato_color_clausula'>
        <tbody>
        <tr>
            <td valign='top' ><p><b>ITEM 04 - PRAZO DE VIGÊNCIA </b></p></td>
        </tr>
        </tbody>
    </table>
    ";
    if ( ($resCon['dt_expiracao'] != '0000-00-00') && (!empty($resCon['dt_expiracao'])) ) {
    $content .= "<p><b>Este contrato vigorará até dia " .  parseDate($resCon['dt_expiracao'], 'date3') . "</b></p>";
    }else{
    $content .= "<p><b>Este contrato vigorará por tempo indeterminado</b></p>";
    }
    if ( !empty($resCon['descricao']) ) {
    $content .= "
    <table  cellspacing='0' cellpadding='0' style='width: 100%;' class='contrato_color_clausula'>
        <tbody>
        <tr>
            <td valign='top' ><p><b>ITEM 05 - DESCRIÇÃO DO CONTRATO </b></p></td>
        </tr>
        </tbody>
    </table>
    <b>" .  $resCon['descricao'] . "</b>";
    $content .= "</div>";
$content .= "<div id='contentprint' style='text-align:justify;width:100%'>";
    $content .= "
    <BR><table  cellspacing='0' cellpadding='0' style='width: 100%;'  class='contrato_color_clausula'>
        <tbody>
        <tr>
            <td valign='top' ><p><b>ITEM 06 - DA PENALIDADE </b></p></td>
        </tr>
</div>
</tbody>
</table>";
$content .= "<p><b>No caso de vencimento sem o efetivo pagamento serão acrescidos da multa de " .strtoupper($resCon['multa']). "%  e juros de 1%(um por cento) ao mês, sem prejuízo dos demais termos contidos nas cláusulas do contrato.</b></p>";
$content .= "<p><b>Por este instrumento particular, as partes qualificadas nos itens 01 do quadro resumo, tem entre si justo o presente Instrumento Particular de Contrato e Prestação de Serviços, que se regerá pelas cláusulas e condições a seguir expostas.</b></p>";
}else{
$content .= "
<table  cellspacing='0' cellpadding='0' style='width: 100%;'  class='contrato_color_clausula'>
    <tbody>
    <tr>
        <td valign='top' ><p><b>ITEM 05 - DA PENALIDADE </b></p></td>
    </tr>

    </tbody>
</table>";
$content .= "<p><b>No caso de vencimento sem o efetivo pagamento serão acrescidos da multa de " .strtoupper($resCon['multa']). "%  e juros de 1%(um por cento) ao mês, sem prejuízo dos demais termos contidos nas cláusulas do contrato.</b></p>";
$content .= "<p><b>Por este instrumento particular, as partes qualificadas nos itens 01 do quadro resumo, tem entre si justo o presente Instrumento Particular de Contrato, que se regerá pelas cláusulas e condições a seguir expostas.</b></p>";
}


$content .= "<p><b>" . $resCon['texto_base'] . "</b></p>";

if(!empty($resAdm['imagem_assinatura']))
$fim = "<img style='border: 0px;margin-bottom: -60px; width: 315px' src='upload_assinaturas/" . $resAdm['imagem_assinatura'] . "'>";
$fim .="<p><b>" . strtoupper($resAdm['razao']);
    if($resAdm['check_pessoa_fisica'] == 'f')
    $fim .="- CNPJ: " . $resAdm['cnpj']. "</b></p><br /><br />";
else{
if(!empty($resAdm['rgContato']))
$fim .="- RG: " . $resAdm['rgContato']. "";
if(!empty($resAdm['cpfContato']))
$fim .="- CPF: " . $resAdm['cpfContato']. "";
$fim .="</b></p><br /><br />";
}


$fim .= "%%SIGN%%";
$fim .="<p><b> " . strtoupper($resCli['nome']). " ";
    if(!empty($resCli['rg']))
    $fim .= " - RG: " . $resCli['rg'] ;
    if(!empty($resCli['cpf']))
    $fim .= " - CPF: " . $resCli['cpf'] ;
    if(!empty($resCli['cnpj']))
    $fim .= " - CNPJ: " . $resCli['cnpj'] ;
    $fim .= "</b></p><br /><br />";
if(!empty($resCon['id_pessoa_secundario'])){
$fim .= "
<p><b> " . strtoupper($resCliSec['nome']). " ";
    if(!empty($resCliSec['rg']))
    $fim .= " - RG: " . $resCliSec['rg'] ;
    if(!empty($resCliSec['cpf']))
    $fim .= " - CPF: " . $resCliSec['cpf'] ;
    if(!empty($resCliSec['cnpj']))
    $fim .= " - CNPJ: " . $resCliSec['cnpj'] ;
    $fim .= "</b></p><br /><br />";
}
$fim .= "
<p><b>Testemunhas:</b></p>
<table  width='100%' cellspacing='0' cellpadding='0' >
    <tbody>
    <tr>
        <td valign='top' >
            <p>&nbsp;</p>
            <p>1) _________________________________________________________________</p>
            <p>&nbsp;</p>
            <p>Nome:</p>
            <p>&nbsp;</p>
            <p>CPF/MF:</p>
            <p>&nbsp;</p>
        </td>
        <td valign='top' >
            <p>&nbsp;</p>
            <p>2) _________________________________________________________________</p>
            <p>&nbsp;</p>
            <p>Nome:</p>
            <p>&nbsp;</p>
            <p>CPF/MF:</p>
            <p>&nbsp;</p>
        </td>
    </tr>
    </tbody>
</table>

";

// ANEXO 1
if(!empty($resCon['anexo'])){
$fim .= "<div style='page-break-after: always;'></div>";
$fim .= "<div id='contentprint' style='text-align:justify;width:100%'>";
    $fim .= "<table  cellspacing='0' cellpadding='0' class='contrato_color_topo' style='width: 100%;' >
        <tbody>
        <tr>
            <td valign='top' align='center' ><p><b>DOCUMENTO " . $resAdm['anexo_titulo'] . " DO CONTRATO N. " . $resCon['cod_contrato'] . " </b></p></td>
        </tr>
        </tbody>
    </table>";
    $fim .= "<br /><br />";
    $fim .= utf8_encode(stripslashes($resCon['anexo'])) ;
    if(!empty($_POST['dataInicial'])){
    $_POST['dataInicial'] 			= parseDate( $_POST['dataInicial'],'date2mysql' );
    $_POST['dataInicial'] 			= parseDate( $_POST['dataInicial'],'extenso' );
    $fim .="<br /><p><b>" .$resAdm['cidade']. ", " . $_POST['dataInicial'] . ".</b></p>";
    }else{
    $fim .="<br /><p><b>" .$resAdm['cidade']. ", " . date('d') . " de " . RetornaMes(date('n')) . " de " . date('Y') . ".</b></p>";
    }
    if(!empty($resAdm['imagem_assinatura']))
    $fim .= "<img style='border: 0px;margin-bottom: -60px; width: 315px' src='upload_assinaturas/" . $resAdm['imagem_assinatura'] . "'>";
    $fim .="<p><b>" . strtoupper($resAdm['razao']);
        if($resAdm['check_pessoa_fisica'] == 'f')
        $fim .="- CNPJ: " . $resAdm['cnpj']. "</b></p><br /><br />";
    else{
    if(!empty($resAdm['rgContato']))
    $fim .="- RG: " . $resAdm['rgContato']. "";
    if(!empty($resAdm['cpfContato']))
    $fim .="- CPF: " . $resAdm['cpfContato']. "";
    $fim .="</b></p><br /><br />";
    }


    $fim .= "%%SIGN%%";
    $fim .="<p><b> " . strtoupper($resCli['nome']). " ";
        if(!empty($resCli['rg']))
        $fim .= " - RG: " . $resCli['rg'] ;
        if(!empty($resCli['cpf']))
        $fim .= " - CPF: " . $resCli['cpf'] ;
        if(!empty($resCli['cnpj']))
        $fim .= " - CNPJ: " . $resCli['cnpj'] ;
        $fim .= "</b></p><br /><br />";
    if(!empty($resCon['id_pessoa_secundario'])){
    $fim .= "
    <p><b> " . strtoupper($resCliSec['nome']). " ";
        if(!empty($resCliSec['rg']))
        $fim .= " - RG: " . $resCliSec['rg'] ;
        if(!empty($resCliSec['cpf']))
        $fim .= " - CPF: " . $resCliSec['cpf'] ;
        if(!empty($resCliSec['cnpj']))
        $fim .= " - CNPJ: " . $resCliSec['cnpj'] ;
        $fim .= "</b></p><br /><br />";
    }
    $fim .= "
    <p><b>Testemunhas:</b></p>
    <table  width='100%' cellspacing='0' cellpadding='0' >
        <tbody>
        <tr>
            <td valign='top' >
                <p>&nbsp;</p>
                <p>1) _________________________________________________________________</p>
                <p>&nbsp;</p>
                <p>Nome:</p>
                <p>&nbsp;</p>
                <p>CPF/MF:</p>
                <p>&nbsp;</p>
            </td>
            <td valign='top' >
                <p>&nbsp;</p>
                <p>2) _________________________________________________________________</p>
                <p>&nbsp;</p>
                <p>Nome:</p>
                <p>&nbsp;</p>
                <p>CPF/MF:</p>
                <p>&nbsp;</p>
            </td>
        </tr>
        </tbody>
    </table>
</div>";
}
// ANEXO 2
if(!empty($resCon['anexo2'])){
$fim .= "<div style='page-break-after: always;'></div>";
$fim .= "<div id='contentprint' style='text-align:justify;width:100%'>";
    $fim .= "<table  cellspacing='0' cellpadding='0' class='contrato_color_topo' style='width: 100%;' >
        <tbody>
        <tr>
            <td valign='top' align='center' ><p><b>DOCUMENTO " . $resAdm['anexo2_titulo'] . " DO CONTRATO N. " . $resCon['cod_contrato'] . " </b></p></td>
        </tr>
        </tbody>
    </table>";
    $fim .= "<br /><br />";
    $fim .= utf8_encode(stripslashes($resCon['anexo2'])) ;
    if(!empty($_POST['dataInicial'])){
    $_POST['dataInicial'] 			= parseDate( $_POST['dataInicial'],'date2mysql' );
    $_POST['dataInicial'] 			= parseDate( $_POST['dataInicial'],'extenso' );
    $fim .="<br /><p><b>" .$resAdm['cidade']. ", " . $_POST['dataInicial'] . ".</b></p>";
    }else{
    $fim .="<br /><p><b>" .$resAdm['cidade']. ", " . date('d') . " de " . RetornaMes(date('n')) . " de " . date('Y') . ".</b></p>";
    }
    if(!empty($resAdm['imagem_assinatura']))
    $fim .= "<img style='border: 0px;margin-bottom: -60px; width: 315px' src='upload_assinaturas/" . $resAdm['imagem_assinatura'] . "'>";
    $fim .="<p><b>" . strtoupper($resAdm['razao']);
        if($resAdm['check_pessoa_fisica'] == 'f')
        $fim .="- CNPJ: " . $resAdm['cnpj']. "</b></p><br /><br />";
    else{
    if(!empty($resAdm['rgContato']))
    $fim .="- RG: " . $resAdm['rgContato']. "";
    if(!empty($resAdm['cpfContato']))
    $fim .="- CPF: " . $resAdm['cpfContato']. "";
    $fim .="</b></p><br /><br />";
    }


    $fim .= "%%SIGN%%";
    $fim .="<p><b> " . strtoupper($resCli['nome']). " ";
        if(!empty($resCli['rg']))
        $fim .= " - RG: " . $resCli['rg'] ;
        if(!empty($resCli['cpf']))
        $fim .= " - CPF: " . $resCli['cpf'] ;
        if(!empty($resCli['cnpj']))
        $fim .= " - CNPJ: " . $resCli['cnpj'] ;
        $fim .= "</b></p><br /><br />";
    if(!empty($resCon['id_pessoa_secundario'])){
    $fim .= "
    <p><b> " . strtoupper($resCliSec['nome']). " ";
        if(!empty($resCliSec['rg']))
        $fim .= " - RG: " . $resCliSec['rg'] ;
        if(!empty($resCliSec['cpf']))
        $fim .= " - CPF: " . $resCliSec['cpf'] ;
        if(!empty($resCliSec['cnpj']))
        $fim .= " - CNPJ: " . $resCliSec['cnpj'] ;
        $fim .= "</b></p><br /><br />";
    }
    $fim .= "
    <p><b>Testemunhas:</b></p>
    <table  width='100%' cellspacing='0' cellpadding='0' >
        <tbody>
        <tr>
            <td valign='top' >
                <p>&nbsp;</p>
                <p>1) _________________________________________________________________</p>
                <p>&nbsp;</p>
                <p>Nome:</p>
                <p>&nbsp;</p>
                <p>CPF/MF:</p>
                <p>&nbsp;</p>
            </td>
            <td valign='top' >
                <p>&nbsp;</p>
                <p>2) _________________________________________________________________</p>
                <p>&nbsp;</p>
                <p>Nome:</p>
                <p>&nbsp;</p>
                <p>CPF/MF:</p>
                <p>&nbsp;</p>
            </td>
        </tr>
        </tbody>
    </table>
</div>";
}



echo $content;
