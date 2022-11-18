<?php require_once __DIR__."/sys/db.php"; ?>
<html>
<head>
	<title>ENVMA 2022</title>
</head>
<body>
	
	<h1>ENVMA 2022</h1>
	<?php require __DIR__."/pageFragments/FraseEpica.php"; ?>
	
	<hr/>
	
	<h2>Memes</h2>
	<?php require __DIR__."/pageFragments/Memes.php"; ?>

	<hr/>
	
	<h2>Apostas Pódio</h2>
	<?php require __DIR__."/pageFragments/ApostasPodio.php"; ?>

	<hr/>
	
	<h2>Apostas Jogos</h2>
	<?php require __DIR__."/pageFragments/ApostasJogos.php"; ?>

	<hr/>
	
	<h2>Ranking</h2>
	<?php require __DIR__."/pageFragments/Ranking.php"; ?>
	
</body>
</html>