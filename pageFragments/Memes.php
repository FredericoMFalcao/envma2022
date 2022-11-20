	Faz upload do teu meme pessoal aqui:
	<form action="/" method="POST" enctype="multipart/form-data">
		<br/><input type="file" name="meme" id="meme">
		<br/><input type="submit">
	</form>

	<?php foreach(select(["UtilizadorNomeCurto"], "Ranking","ORDER BY Pontos DESC, Utilizador DESC LIMIT 1") as $row): extract($row); ?>
		<img src="/uploads/<?=$UtilizadorNomeCurto?>.jpg" width="400" />
	<?php endforeach; ?>

	<?php foreach(select(["UtilizadorNomeCurto"], "Ranking","ORDER BY Pontos ASC, Utilizador DESC LIMIT 1") as $row): extract($row); ?>
		<img src="/uploads/<?=$UtilizadorNomeCurto?>.jpg" width="400" />
	<?php endforeach; ?>

	<?php foreach(select(["UtilizadorNomeCurto"], "Ranking"," ORDER BY RAND() ASC LIMIT 1") as $row): extract($row); ?>
		<img src="/uploads/<?=$UtilizadorNomeCurto?>.jpg" width="400" />
	<?php endforeach; ?>
