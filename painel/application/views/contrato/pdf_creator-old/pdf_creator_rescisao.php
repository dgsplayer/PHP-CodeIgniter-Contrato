<?php echo $this->load->helper('date'); ?>
<?php echo $this->load->helper('funcoes'); ?>
<?

$content .= mostra_logo_documento();


$content .= "



    <p style='text-align: center; font-size: 16px;'><b>TERMO DE RESCISÃO CONTRATUAL DO CONTRATO CÓDIGO " . $resCon['cod_contrato'] . " </b></p>";




$content .= "<p><b>CONTRATANTES: " ;


if($resCli['tipo_pessoa'] == 'CLIENTE'){
    include "ver_contrato_descContratante.php";
}
if($resCli['tipo_pessoa'] == 'FORNECEDOR'){
    include "ver_contrato_descContratada.php";
}


$content .= "<br /><p>" ;
$content .= "<b>CONTRATADA:  " ;

if($resCli['tipo_pessoa'] == 'CLIENTE'){
    include "ver_contrato_descContratada.php";
}
if($resCli['tipo_pessoa'] == 'FORNECEDOR'){
    include "ver_contrato_descContratante.php";
}

$content .= "<p>Diante da comunicação do(s) CONTRATANTE(S) à CONTRATADA(S) da intenção de rescindir o contrato firmado e em completa obediência aos termos do contrato, serve este instrumento, para <b>RESCINDIR O CONTRATO Nº " . $resCon['cod_contrato'] . ".</b></p>



<p><b>DA MULTA</b></p>



<p>Em obediência aos termos do contrato, a(s) CONTRATANTE(S) pagará à CONTRATADA(S) a título de multa o valor de <span style='background-color: #E3E658;'>R$ " . (str_replace('.','',$resCon['valor_total']) / 100) * 2 . " </span>, dando a CONTRATADA(S) plena quitação, para nada mais ter a reclamar, de presente ou de futuro, sob tal título. </p>



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

if(!empty($resCli['rg']))
    $content .= " , RG: " . $resCli['rg'] ;

if(!empty($resCli['cpf']))
    $content .= " , CPF: " . $resCli['cpf'] ;

if(!empty($resCli['cnpj']))
    $content .= " , CNPJ: " . $resCli['cnpj'] ;


$content .= "</b></p>";



if(!empty($resCon['id_pessoa_secundario'])){

    $content .= "

					<p><b>_________________________________________ </b></p>

					<p><b>" .strtoupper($resCliSec['nome']). " ";

    if(!empty($resCliSec['rg']))
        $content .= " , RG: " . $resCliSec['rg'] ;

    if(!empty($resCliSec['cpf']))
        $content .= " , CPF: " . $resCliSec['cpf'] ;

    if(!empty($resCliSec['cnpj']))
        $content .= " , CNPJ: " . $resCliSec['cnpj'] ;

    $content .= "</b></p>";

}

$content .= "<br /><br />

<p><b>Testemunhas:</b></p>



<table border='1'width='100%' cellspacing='0' cellpadding='0' >

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