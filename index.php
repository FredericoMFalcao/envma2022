<?php require_once __DIR__."/sys/db.php"; ?>
<html>
<head>
	<title>ENVMA 2022</title>
</head>
<body>
	
	<h1>ENVMA 2022</h1>
	
	<table>
		<tbody>
	<?php foreach(select(["NomeCurto", "NomeLongo"], "Utilizadores") as $row): extract($row); ?>
	<tr>
		<td><?=$NomeCurto?></td><td><?=$NomeLongo?></td>
	</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
	<hr/>
	
	<h2>Memes</h2>

	<hr/>
	
	<h2>Apostas Pódio</h2>
	
	<hr/>
	
	<h2>Apostas Jogos</h2>

	<hr/>
	
	<h2>Ranking</h2>
	
</body>
</html>