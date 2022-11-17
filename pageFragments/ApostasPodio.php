<form action="/" method="POST">
	Primeiro Classificado: 
	<select>
		<?php foreach(select(["NomeCurto","NomeLongo"],"Equipas") as $row): extract($row); ?>
			<option value="<?=$NomeCurto?>"><?=$NomeLongo?></option>
		<?php endforeach; ?>
	</select>
	Segundo Classificado: 
	<select>
		<?php foreach(select(["NomeCurto","NomeLongo"],"Equipas") as $row): extract($row); ?>
			<option value="<?=$NomeCurto?>"><?=$NomeLongo?></option>
		<?php endforeach; ?>
	</select>
	Terceiro Classificado: 
	<select>
		<?php foreach(select(["NomeCurto","NomeLongo"],"Equipas") as $row): extract($row); ?>
			<option value="<?=$NomeCurto?>"><?=$NomeLongo?></option>
		<?php endforeach; ?>
	</select>
	Quarto Classificado: 
	<select>
		<?php foreach(select(["NomeCurto","NomeLongo"],"Equipas") as $row): extract($row); ?>
			<option value="<?=$NomeCurto?>"><?=$NomeLongo?></option>
		<?php endforeach; ?>
	</select>
	Melhor Marcador: <input type="text" name="MelhorMarcador">
	
	<input type="submit">
</form>
