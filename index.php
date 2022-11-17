<?php require_once __DIR__."/sys/db.php"; ?>
<html>
<head>
	<title>ENVMA 2022</title>
</head>
<body>
	
	<h1>ENVMA 2022</h1>
	<?php foreach(select(["FraseEpica"], "Utilizadores","LIMIT 1") as $row): extract($row); ?>
		<img src="/uploads/<?=$NomeCurto?>.jpg" width="200" />
	<?php endforeach; ?>
	
	<hr/>
	
	<h2>Memes</h2>

	<?php foreach(select(["NomeCurto"], "Ranking","LIMIT 3") as $row): extract($row); ?>
		<img src="/uploads/<?=$NomeCurto?>.jpg" width="200" />
	<?php endforeach; ?>

	<hr/>
	
	<h2>Apostas Pódio</h2>
	
	<hr/>
	
	<h2>Apostas Jogos</h2>

	<hr/>
	
	<h2>Ranking</h2>
	
</body>
</html>