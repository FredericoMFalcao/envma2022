<?php require_once __DIR__."/sys/db.php"; ?>
<html>
<head>
	<title>ENVMA 2022</title>
</head>
<body>
	
	<h1>ENVMA 2022</h1>
	<h5>- <?=$currentUserData["NomeLongo"]?></h5>
	<ul>
		<li><a href="#ApostasPodio">Apostas Pódio</a></li>
		<li><a href="#ApostasJogos">Apostas Jogos</a> (<a href="#JogoHoje">Hoje</a>)</li>
		<li><a href="#Ranking">Ranking</a></li>
		<li><a href="#Badges">Badges</a></li>
	</ul>
	
	
	<h2 id="FraseEpica">Frase Épica</h2>
	<?php require __DIR__."/pageFragments/FraseEpica.php"; ?>
	
	<hr/>
	
	<h2 id="Memes">Memes</h2>
	<?php require __DIR__."/pageFragments/Memes.php"; ?>

	<hr/>
	
	<h2 id="ApostasPodio">Apostas Pódio</h2>
	<?php require __DIR__."/pageFragments/ApostasPodio.php"; ?>

	<hr/>
	
	<h2 id="ApostasJogos">Apostas Jogos</h2>
	<?php require __DIR__."/pageFragments/ApostasJogos.php"; ?>

	<hr/>
	
	<h2 id="Ranking">Ranking</h2>
	<?php require __DIR__."/pageFragments/Ranking.php"; ?>

	<h2 id="Badges">Badges</h2>
	<?php require __DIR__."/pageFragments/Badges.php"; ?>


	<h2 id="DadosPessoais">Dados Pessoais</h2>
	<?php require __DIR__."/pageFragments/DadosPessoais.php"; ?>
	
</body>
</html>