<?php echo $this->load->helper('date'); ?>
<?php echo $this->load->helper('funcoes'); ?>
<?

$content .= mostra_logo_documento();

$content .= "

<p>&nbsp;</p>

<p align=\"center\"><strong>NOTIFICA&Ccedil;&Atilde;O EXTRAJUDICIAL </strong></p>

<p align=\"center\"><strong>DE COBRAN&Ccedil;A</strong></p>

<p>&nbsp;</p>



<p>&nbsp;</p>

<p><b>CREDORA:</b> ";

include "ver_contrato_descContratada.php";


$content .= "<p>&nbsp;</p>

<p><b>DEVEDORA:</b> ";



include "ver_contrato_descContratante.php";



$dataHoje   = date('Y-m-d');

$dataExpira = date($resParc['data_parcela']);



$today 				= strtotime($dataHoje);

$expiration_date 	= strtotime($dataExpira);



if($expiration_date < $today ){


    $valorAtualizado    =   retornaCalculoAtraso($resParc['valor_parcela'], $resCon['multa'], 1);

}else{



    $valorAtualizado    =  $resParc['valor_parcela'] ;





}

//echo '     -'.$resParc['valor_parcela'] . '-'.  $resCon['multa'];

$content .= "



<table cellspacing=\"0\" cellpadding=\"0\" align=\"left\">

<tbody>

<tr>

<td width=\"3\" height=\"13\">&nbsp;</td>

</tr>

<tr>



<td>&nbsp;</td>

</tr>

</tbody>

</table>



<p>Considerando que consta em nossos cadastros, d&eacute;bito decorrente do n&atilde;o pagamento da parcela n&ordm; <strong>" . $resParc['num_parcela'] . "</strong> do <strong>CONTRATO</strong> código <strong>" . $resCon['cod_contrato'] . "</strong> que atualmente quantifica o valor de R$ <strong> " . $valorAtualizado . ";</strong></p>

<p>&nbsp;</p>

<p>A NOTIFICANTE notifica a NOTIFICADA, para que entre em contato conosco, nos n&uacute;meros de telefones <strong>" .$resAdm['telefone']. " " .$resAdm['celular']. "</strong>, ou e-mail <strong>" .$resAdm['email']. "</strong> em hor&aacute;rio comercial, em at&eacute; <strong><span style=\"text-decoration: underline;\">quarenta e oito horas</span></strong>, a contar do recebimento desta, para que juntos possamos realizar acordo evitando futuras medidas judiciais.</p>

<p>&nbsp;</p>

<p>Caso sua situa&ccedil;&atilde;o esteja regularizada, desconsidere esta notifica&ccedil;&atilde;o.</p>

<p>&nbsp;</p>

<p>Cordialmente,</p>

<p>&nbsp;</p>

<p><strong>" . strtoupper($resAdm['razao']). "</strong></p>

<p><strong>Departamento de Cobran&ccedil;a</strong></p>

<p><b>" .$resAdm['cidade']. ", " . date('d') . " de " . RetornaMes(date('n')) . " de " . date('Y') . ".</b></p>





";


echo $content;



