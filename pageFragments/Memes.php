	Faz upload do teu meme pessoal aqui:
	<form action="/" method="POST" enctype="multipart/form-data">
		<br/><input type="file" name="meme" id="meme">
		<br/><input type="submit">
	</form>

	<?php foreach(select(["UtilizadorNomeCurto"], "Ranking","LIMIT 1 ORDER BY Pontos DESC") as $row): extract($row); ?>
		<img src="/uploads/<?=$Utilizador?>.jpg" width="400" />
	<?php endforeach; ?>

	<?php foreach(select(["UtilizadorNomeCurto"], "Ranking","LIMIT 1 ORDER BY Pontos ASC") as $row): extract($row); ?>
		<img src="/uploads/<?=$Utilizador?>.jpg" width="400" />
	<?php endforeach; ?>

	<?php foreach(select(["UtilizadorNomeCurto"], "Ranking","LIMIT 1 ORDER BY RAND() ASC") as $row): extract($row); ?>
		<img src="/uploads/<?=$Utilizador?>.jpg" width="400" />
	<?php endforeach; ?>
