<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Juridico busca</title>
</head>
<body>
<form action="" method="post">
	<input type="text" size="100" name="dePesquisaNuUnificado" />
	<button type="submit">pesquisar</button>
</form>
<p>Número teste : 0117674-18.2008.8.26.0002</p>
<p>Um exemplo de consulta do juridico. Obs: Esse exemplo é apenas o mecanismo para consulta, se a consulta estaver correta, vamos planejar como vai funcionar no nosso sistema.</p>
<div>
	<?php echo @$html->find('table',4); ?>
</div>
</body>
</html>