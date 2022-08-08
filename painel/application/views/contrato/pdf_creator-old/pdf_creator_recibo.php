<?php echo $this->load->helper('date'); ?>
<?php echo $this->load->helper('funcoes'); ?>
<?

$content .= mostra_logo_documento();


$content .= "



<p><b>RECIBO DE PAGAMENTO</b></p>



<br />

<p><b>De: </b>" ;

include "ver_contrato_descContratada.php";



$content .= "<p><b>Para: </b>" ;



include "ver_contrato_descContratante.php";



$content .= "<p>

<p><b>DO OBJETO DO RECIBO:</b></p>



<p>Quitação da parcela nº " . $resParc['num_parcela'] . " no valor de R$ " . $resParc['valor_parcela'] . " do contrato código " . $resCon['cod_contrato'] . "</p>



<p><b>" .$resAdm['cidade']. ", " . date('d') . " de " . RetornaMes(date('n')) . " de " . date('Y') . " </b></p>";


if(!empty($resAdm['imagem_assinatura']))
    $content .= "<img style='border: 0px;margin-bottom: -80px; width: 315px' src='upload_assinaturas/" . $resAdm['imagem_assinatura'] . "'>";


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

echo $content;