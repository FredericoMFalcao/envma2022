<?php foreach(select(["JogoId","a.NomeLongo EquipaCasa","b.NomeLongo EquipaFora","GolosEqCasa","GolosEqFora"],"Jogos INNER JOIN Equipas a ON a.NomeCurto = EquipaCasa INNER JOIN Equipas b ON b.NomeCurto = EquipaFora  ORDER BY JogoId ASC") as $Jogo) : ?>
<table border="1">
	<thead>
		<tr>
			<th> <?=$Jogo["EquipaCasa"]?> vs. <?=$Jogo["EquipaFora"]?> </th>
			<th> <?=$Jogo["GolosEqCasa"]?> - <?=$Jogo["GolosEqFora"]?> </th>
		</tr>
	</thead>
	<tbody>
		<?php foreach(select([
			"a.Utilizador Utilizador",
			"a.GolosEqCasa ApostaGolosEqCasa",
			"a.GolosEqFora ApostaGolosEqFora",
			"b.Estado Estado",
			"b.GolosEqCasa ResultadoEqCasa",
			"b.GolosEqFora ResultadoEqFora",
			"b.EquipaCasa NomeEquipaCasa",
			"b.EquipaFora NomeEquipaFora"
		],"ApostasJogos a", "INNER JOIN Jogos b ON a.JogoId = b.JogoId AND a.JogoId = {$Jogo["JogoId"]} ORDER BY a.JogoId ASC") as $row) : extract($row); ?>
			<?php if ($Utilizador != $currentUser && $Estado == "ApostasAbertas") continue; ?>
			<tr>
				<td><?=$row["Utilizador"]?></td>
				<td>
				<?php if ($Estado == "ApostasAbertas") : ?>				
					<form action="/" method="POST">
						<select name="GolosEqCasa">
							<option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option>
						</select>
						<select name="GolosEqFora">
							<option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option>
						</select>
						<br/>Boost: <input type="checkbox" name="boost" <?=$Boost?"checked":""?> />
						<br/><input type="submit" />
					</form>
				<?php else : ?>
					<?=$ApostaGolosEqCasa?> - <?=$ApostaGolosEqFora?>
				<?php endif;?>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endforeach; ?>




