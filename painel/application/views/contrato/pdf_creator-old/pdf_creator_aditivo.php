<?php echo $this->load->helper('date'); ?>
<?php echo $this->load->helper('funcoes'); ?>
<?
$user = $this->session->userdata('contrato_user');

if(file_exists("recursos/imagens/logos/thumb" . $user['id_pessoa'] . ".png")) {
    $content .= "<p style='text-align: center;'><img style='border: 0px; max-width: 160px; max-height: 92px;' src='recursos/imagens/logos/thumb" . $user['id_pessoa'] . ".png'></p>";
}

$content .= "<p style='text-align: center; font-size: 16px;'><b>ADITIVO PARA O ITEM " . $resAdt['valueAditivo'] . " DO CONTRATO Nº <ins>" . $resCon['cod_contrato'] . "</ins></b></p>";


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
<p><b><i>As partes acima qualificadas, tem entre si justo o aditivo, que se regerá pelas seguintes cláusulas e condições:</i></b></p>



<p><b>Cláusula 1ª. </b>O presente instrumento tem por objeto alterar e/ou incluir a disposição do<b><i> item " .$resAdt['valueAditivo']. "</i></b> do quadro resumo do contrato  acima numerado segundo formulado na cláusula baixo.</p>



<p><b>Cláusula 2ª. </b>

";



//AQUI VAI O TEXTO DA DESCRICAO DO ADICIONAL

$content .= $resAdt['texto'].'</p>';



$content .= "

<p><b>Cláusula 3ª. </b>As partes confirmam e ratificam as demais cláusulas, não novando o contrato em sua totalidade, somente os itens neste instrumento alterado e incluídos.</p>

<p><b>Cláusula 4ª. </b>Para dirimir quaisquer controversas oriundas deste contrato, as partes elegem o mesmo foro já definido no contrato acima numerado.</p>

<p>E por estarem, assim, justas e contratadas, assinam o presente em duas vias de igual teor e forma, juntamente com as testemunhas abaixo.</p>

<p><b>" .$resAdm['cidade']. ", ______ de __________________ de __________</b></p>

<p>&nbsp;</p>";


if(!empty($resAdm['imagem_assinatura'])){
    //$upload_assinatura = "<img style='border: 0px;margin-bottom: -60px; width: 315px' src='upload_assinaturas/" . $resCon['upload_assinatura'] . "'>";
    $content .= "<img style='border: 0px;margin-bottom: -60px; width: 315px' src='upload_assinaturas/" . $resAdm['imagem_assinatura'] . "'>";
}

$content .="<p>&nbsp;</p><p><b>" . strtoupper($resAdm['razao']);

if($resAdm['check_pessoa_fisica'] == 'f')
    $content .="- CNPJ: " . $resAdm['cnpj']. "</b></p><br /><br />";
else{
    if(!empty($resAdm['rgContato']))
        $content .="- RG: " . $resAdm['rgContato']. "";
    if(!empty($resAdm['cpfContato']))
        $content .="- CPF: " . $resAdm['cpfContato']. "";
    $content .="</b></p>";
}




if(!empty($resAdt['upload_assinado'])){
    //$upload_assinatura = "<img style='border: 0px;margin-bottom: -60px; width: 315px' src='upload_assinaturas/" . $resCon['upload_assinatura'] . "'>";
    $content .= "<img style='border: 0px;margin-bottom: -60px; width: 315px' src='upload_assinaturas/" . $resAdt['upload_assinado'] . "'>";
}

$content .="<p>&nbsp;</p><p>&nbsp;</p><p><b> " . strtoupper($resCli['nome']). " ";

if(!empty($resCli['rg']))
    $content .= " , RG: " . $resCli['rg'] ;

if(!empty($resCli['cpf']))
    $content .= " , CPF: " . $resCli['cpf'] ;

if(!empty($resCli['cnpj']))
    $content .= " , CNPJ: " . $resCli['cnpj'] ;


$content .= "</b></p>";

if(!empty($resCon['id_pessoa_secundario'])){

    $content .= "



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



<table border='1' width='100%' cellspacing='0' cellpadding='0' >

<tbody>

<tr>

<td valign='top' >

<p>&nbsp;</p>

<p>1) _______________________________________________________________</p>

<p>&nbsp;</p>

<p>Nome:</p>

<p>&nbsp;</p>

<p>CPF/MF:</p>

<p>&nbsp;</p>

</td>

<td valign='top' >

<p>&nbsp;</p>

<p>2) _______________________________________________________________</p>

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