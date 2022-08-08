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


//$user = $this->session->userdata('contrato_user');
//if(file_exists("recursos/imagens/logos/thumb" . $user['id_pessoa'] . ".png")) {
//    $content .= "<p style='text-align: center;'><img style='border: 0px; max-width: 160px; max-height: 92px;' src='recursos/imagens/logos/thumb" . $user['id_pessoa'] . ".png'></p>";
//}

$content .= mostra_logo_documento();
$content .= "<p style='text-align: center; font-size: 16px;'><b>TERMO DE DISTRATO CONTRATUAL DO CONTRATO Nº " . $resCon['cod_contrato'] . " </b></p>";


$content .= "<p><b>CONTRATANTE(S): " ;


if($resCli['tipo_pessoa'] == 'CLIENTE'){
    include "ver_contrato_descContratante.php";
}
if($resCli['tipo_pessoa'] == 'FORNECEDOR'){
    include "ver_contrato_descContratada.php";
}


$content .= "<br /><p>" ;
$content .= "<b>CONTRATADA(S):  " ;

if($resCli['tipo_pessoa'] == 'CLIENTE'){
    include "ver_contrato_descContratada.php";
}
if($resCli['tipo_pessoa'] == 'FORNECEDOR'){
    include "ver_contrato_descContratante.php";
}


$content .= "

<p>Diante da intenção das partes<a name='_GoBack'></a> de distratar, fica o contrato em epígrafe resilido, dando as partes plena quitação, para nada mais ter a reclamar, de presente ou de futuro, sob tal título. </p>



<p>E por estarem as partes assim justas e acertadas, assinam o presente, em duas (02) vias, de igual teor e forma, na presença das testemunhas retro, para que surta seus legais e jurídicos efeitos.</p>



<p>E firmam o presente instrumento</p>



<p><b>" .$resAdm['cidade']. ", ______ de __________________ de __________</b></p>

<p>&nbsp;</p>

<p><b>________________________________________________ </b></p>";


$content .="<p><b>" . strtoupper($resAdm['razao']);

if($resAdm['check_pessoa_fisica'] == 'f')
    $content .="- CNPJ: " . $resAdm['cnpj']. "</b></p><br /><br />";
else{
    if(!empty($resAdm['rgContato']))
        $content .="- RG: " . $resAdm['rgContato']. "";
    if(!empty($resAdm['cpfContato']))
        $content .="- CPF: " . $resAdm['cpfContato']. "";
    $content .="</b></p><br /><br />";
}





$content .="

<p>&nbsp;</p>


<p><b>________________________________________________ </b></p>



<p><b> " . strtoupper($resCli['nome']). " ";



if(!empty($resCon['id_pessoa_secundario'])){

    $content .= "

					<p><b>_______________________________ </b></p>

					" .strtoupper($resCliSec['nome']). " ";

}



$content .= "<br /><br />

<p><b>Testemunhas:</b></p>



<table border='1' width='100%' cellspacing='0' cellpadding='0' >

<tbody>

<tr>

<td valign='top' >

<p>&nbsp;</p>

<p>1) ____________________________________________________________</p>

<p>&nbsp;</p>

<p>Nome:</p>

<p>&nbsp;</p>

<p>CPF/MF:</p>

<p>&nbsp;</p>

</td>

<td valign='top' >

<p>&nbsp;</p>

<p>2) ____________________________________________________________</p>

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
echo $content;