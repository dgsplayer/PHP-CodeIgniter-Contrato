<html>
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
	<link rel='stylesheet' type='text/css' href='css/bootstrap.css' />
	<link rel='stylesheet' href='css/default.css' type='text/css' />
	<link rel='stylesheet' href='css/default_pdf.css' type='text/css' />
	<style>
		@page { margin: 0px; }
		body { margin: 0px; }
	</style>
</head>
<body id='tudo'>
	<div id='contentprint' style='text-align:justify;'>";

<?php if(file_exists("imagens/logos/thumb" . $resCon['id_pessoa_pai'] . ".png")) { ?>
	<img style='border: 0px; max-width: 160px; max-height: 92px;' src='imagens/logos/thumb<?php echo $resCon['id_pessoa_pai']; ?>.png'>
<?php } ?>
	<p><b>RECIBO DE PAGAMENTO</b></p>
	<br />
	<p><b>De: </b>
	<?php include "ver_contrato_descContratada.php"; ?>
	<p><b>Para: </b>
	<?php include "ver_contrato_descContratante.php"; ?>
	<p>
	<p><b>DO OBJETO DO RECIBO:</b></p>
	<p>Quitação da parcela nº " . $resParc['num_parcela'] . " no valor de R$ " . $resParc['valor_parcela'] . " do contrato código " . $resCon['cod_contrato'] . "</p>
	<p><b>" .$resAdm['cidade']. ", " . date('d') . " de " . RetornaMes(date('n')) . " de " . date('Y') . " </b></p>";
	<?php if(!empty($resAdm['imagem_assinatura'])) { ?>
		<img style="border: 0px;margin-bottom: -80px; width: 315px" src='upload_assinaturas/<?php echo $resAdm['imagem_assinatura'];?>'>
	<?php } ?>
	<p>&nbsp;</p><p><b><?php echo strtoupper($resAdm['razao']); ?>

	<?php if($resAdm['check_pessoa_fisica'] == 'f') { ?>
    	- CNPJ: <?php echo $resAdm['cnpj']; ?></b></p><br /><br />
	<?php } else { ?>
	    <?php if(!empty($resAdm['rgContato'])) { ?>
	        - RG: <?php echo $resAdm['rgContato'];?>
	    <?php } ?>
	    <?php if(!empty($resAdm['cpfContato'])) { ?>
	        - CPF: <?php echo $resAdm['cpfContato'];?>
		<?php } ?>
	    </b></p><br /><br />
	<?php } ?>
</body>
</html>