<form action="/" method="POST">
	<input type="hidden" name="_table" value="ApostasPodio" />
    <br/>Primeiro Classificado: 
	<br/><select name="PrimeiroClassificado">
		<?php foreach(select(["NomeCurto","NomeLongo"],"Equipas") as $row): extract($row); ?>
			<option value="<?=$NomeCurto?>"><?=$NomeLongo?></option>
		<?php endforeach; ?>
	</select>
    <br/>Segundo Classificado: 
    <br/><select name="SegundoClassificado">
		<?php foreach(select(["NomeCurto","NomeLongo"],"Equipas") as $row): extract($row); ?>
			<option value="<?=$NomeCurto?>"><?=$NomeLongo?></option>
		<?php endforeach; ?>
	</select>
    <br/>Terceiro Classificado: 
    <br/><select name="TerceiroClassificado">
		<?php foreach(select(["NomeCurto","NomeLongo"],"Equipas") as $row): extract($row); ?>
			<option value="<?=$NomeCurto?>"><?=$NomeLongo?></option>
		<?php endforeach; ?>
	</select>
    <br/>Quarto Classificado: 
    <br/><select name="QuartoClassificado">
		<?php foreach(select(["NomeCurto","NomeLongo"],"Equipas") as $row): extract($row); ?>
			<option value="<?=$NomeCurto?>"><?=$NomeLongo?></option>
		<?php endforeach; ?>
	</select>
    <br/>Melhor Marcador: 
	<br/><input type="text" name="MelhorMarcador">
	
    <br/><input type="submit">
</form>
