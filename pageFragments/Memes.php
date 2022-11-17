	Faz upload do teu meme pessoal aqui:
	<form action="/" method="POST" enctype="multipart/form-data">
		<br/><input type="file" name="meme" id="meme">
		<br/><input type="submit">
	</form>

	<?php foreach(select(["NomeCurto"], "Utilizadores","LIMIT 3") as $row): extract($row); ?>
		<img src="/uploads/<?=$NomeCurto?>.jpg" width="400" />
	<?php endforeach; ?>

