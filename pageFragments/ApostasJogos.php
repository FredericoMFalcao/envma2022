<table border="1">
	<thead>
		<tr>
			<th>Jogo</th>
			<th>Utilizador</th>
			<th>Aposta</th>
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
		],"ApostasJogos a", "INNER JOIN Jogos b ON a.JogoId = b.JogoId") as $row) : extract($row); ?>
			<?php if ($Utilizador != $currentUser && $Estado == "ApostasAbertas") continue; ?>
			<tr>
				<td>
					<?=$NomeEquipaCasa?> - <?=$NomeEquipaFora?>
					<?php if ($Estado == "Disputado") : ?>
						(<?=$ResultadoEqCasa?> - <?=$ResultadoEqFora?>)
					<?php endif;?>
				</td>
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
				<td><?=$row["GolosEqCasa"]?> - <?=$row["GolosEqFora"]?></td>				
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>