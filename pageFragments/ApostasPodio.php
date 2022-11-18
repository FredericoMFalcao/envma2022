<?php if ($campeonato["Estado"] == "EmPreparacao") : ?>

<?php $apostaActual = select(["PrimeiroClassificado","SegundoClassificado","TerceiroClassificado","QuartoClassificado","MelhorMarcador"],"ApostasPodio","WHERE Utilizador = '$currentUser'")[0]; ?>

<form action="/" method="POST">
	<input type="hidden" name="_table" value="ApostasPodio" />
    <br/>Primeiro Classificado: 
	<br/><select name="PrimeiroClassificado">
		<?php foreach(select(["NomeCurto","NomeLongo"],"Equipas") as $row): extract($row); ?>
			<option value="<?=$NomeCurto?>" <?=$NomeCurto==$apostaActual["PrimeiroClassificado"]?"selected":""?>><?=$NomeLongo?></option>
		<?php endforeach; ?>
	</select>
    <br/>Segundo Classificado: 
    <br/><select name="SegundoClassificado">
		<?php foreach(select(["NomeCurto","NomeLongo"],"Equipas") as $row): extract($row); ?>
			<option value="<?=$NomeCurto?>" <?=$NomeCurto==$apostaActual["SegundoClassificado"]?"selected":""?>><?=$NomeLongo?></option>
		<?php endforeach; ?>
	</select>
    <br/>Terceiro Classificado: 
    <br/><select name="TerceiroClassificado">
		<?php foreach(select(["NomeCurto","NomeLongo"],"Equipas") as $row): extract($row); ?>
			<option value="<?=$NomeCurto?>" <?=$NomeCurto==$apostaActual["TerceiroClassificado"]?"selected":""?>><?=$NomeLongo?></option>
		<?php endforeach; ?>
	</select>
    <br/>Quarto Classificado: 
    <br/><select name="QuartoClassificado">
		<?php foreach(select(["NomeCurto","NomeLongo"],"Equipas") as $row): extract($row); ?>
			<option value="<?=$NomeCurto?>" <?=$NomeCurto==$apostaActual["QuartoClassificado"]?"selected":""?>><?=$NomeLongo?></option>
		<?php endforeach; ?>
	</select>
    <br/>Melhor Marcador: 
	<br/><input type="text" name="MelhorMarcador" value="<?=$apostaActual["MelhorMarcador"]?>">
	
    <br/><input type="submit">
</form>

<?php endif; ?>

<?php if ($campeonato["Estado"] == "Iniciado") : ?>

<table>
	<thead>
		<tr>
			<th>Utilizador</th>
			<th>Primero Classificado</th>
			<th>Segundo Classificado</th>
			<th>Terceiro Classificado</th>
			<th>Quarto Classificado</th>
			<th>Melhor Marcador</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach(select(["Utilizador","PrimeiroClassificado","SegundoClassificado","TerceiroClassificado","QuartoClassificado","MelhorMarcador"],"ApostasPodio") as $row): extract($row); ?>
		<tr>
			<td><?=$Utilizador?></td>
			<td><?=$PrimeiroClassificado?></td>
			<td><?=$SegundoClassificado?></td>
			<td><?=$TerceiroClassificado?></td>
			<td><?=$QuartoClassificado?></td>
			<td><?=$MelhorMarcador?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>

<?php endif; ?>