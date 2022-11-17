<form action="/" method="POST">
    <br/>Primeiro Classificado: 
	<br/><select>
		<?php foreach(select(["NomeCurto","NomeLongo"],"Equipas") as $row): extract($row); ?>
			<option value="<?=$NomeCurto?>"><?=$NomeLongo?></option>
		<?php endforeach; ?>
	</select>
    <br/>Segundo Classificado: 
    <br/><select>
		<?php foreach(select(["NomeCurto","NomeLongo"],"Equipas") as $row): extract($row); ?>
			<option value="<?=$NomeCurto?>"><?=$NomeLongo?></option>
		<?php endforeach; ?>
	</select>
    <br/>Terceiro Classificado: 
    <br/><select>
		<?php foreach(select(["NomeCurto","NomeLongo"],"Equipas") as $row): extract($row); ?>
			<option value="<?=$NomeCurto?>"><?=$NomeLongo?></option>
		<?php endforeach; ?>
	</select>
    <br/>Quarto Classificado: 
    <br/><select>
		<?php foreach(select(["NomeCurto","NomeLongo"],"Equipas") as $row): extract($row); ?>
			<option value="<?=$NomeCurto?>"><?=$NomeLongo?></option>
		<?php endforeach; ?>
	</select>
    <br/>Melhor Marcador: 
	<br/><input type="text" name="MelhorMarcador">
	
    <br/><input type="submit">
</form>
