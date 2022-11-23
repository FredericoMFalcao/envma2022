<form action="" method="POST">
<?php foreach(select(["NomeLongo","FraseEpica"], "Utilizadores","WHERE Utilizador = '$currentUser' LIMIT 1") as $row): extract($row); ?>
	Frase Épica:
	<input type="hidden" name="_table"     value="Utilizadores">
	<input type="text"   name="NomeLongo"  value="<?=$NomeLongo?>">
	<input type="text"   name="FraseEpica" value="<?=$FraseEpica?>">
	<input type="submit">
<?php endforeach; ?>
</form>
