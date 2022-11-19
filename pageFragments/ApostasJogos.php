<?php foreach(select(["JogoId","a.NomeLongo EquipaCasa","b.NomeLongo EquipaFora","GolosEqCasa","GolosEqFora","DataHoraUTC","Estado","Fase"],
		"Jogos INNER JOIN Equipas a ON a.NomeCurto = EquipaCasa INNER JOIN Equipas b ON b.NomeCurto = EquipaFora  ORDER BY JogoId ASC"
			) as $Jogo) : ?>
<h3><?=$Jogo["EquipaCasa"]?> vs. <?=$Jogo["EquipaFora"]?> <?=$Jogo["Estado"]=="Disputado"?"(".$Jogo["GolosEqCasa"]." - ". $Jogo["GolosEqFora"].")":""?></h3>
<h5><?=$Jogo["DataHoraUTC"]?></h5>
<table border="1">
	<thead>
		<tr>
			<th>Aposta</th>
			<th>Concorrentes</th>
		</tr>
	</thead>
	<tbody>
		<?php if ($Jogo["Estado"] == "ApostasAbertas") : ?>
			<?php $aposta = select(["Boost","GolosEqCasa","GolosEqFora"],"ApostasJogos","WHERE Utilizador = '$currentUser' AND JogoId = {$Jogo["JogoId"]}")[0]; ?>
			<tr>
				<td colspan="2">
					<form action="/" method="POST">
						<input type="hidden" name="_table" value="ApostasJogos">
						<input type="hidden" name="_pk_JogoId" value="<?=$Jogo["JogoId"]?>">
						<input type="hidden" name="Fase"   value="<?=$Jogo["Fase"]?>">
						<select name="GolosEqCasa">
							<?=implode("",array_map(function($o){global $aposta;return "<option ".($aposta["GolosEqCasa"]==$o?"selected":"").">$o</option>";},range(0,9)))?>
						</select>
						<select name="GolosEqFora">
							<?=implode("",array_map(function($o){global $aposta;return "<option ".($aposta["GolosEqFora"]==$o?"selected":"").">$o</option>";},range(0,9)))?>
						</select>
						<br/>Boost: <input type="checkbox" name="boost" value="1" <?=$aposta["Boost"]?"checked":""?> />
						<br/><input type="submit" />
					</form>
				</td>
			</tr>
		<?php else : ?>
		<?php foreach(select([
			"GROUP_CONCAT(u.NomeLongo SEPARATOR '<br/>') Utilizador",
			"a.GolosEqCasa ApostaGolosEqCasa",
			"a.GolosEqFora ApostaGolosEqFora",
			"b.Estado Estado",
			"b.GolosEqCasa ResultadoEqCasa",
			"b.GolosEqFora ResultadoEqFora",
			"b.EquipaCasa NomeEquipaCasa",
			"b.EquipaFora NomeEquipaFora"
		],"ApostasJogos a", 
		 "INNER JOIN Jogos b ON a.JogoId = b.JogoId AND a.JogoId = {$Jogo["JogoId"]} "
		."INNER JOIN Utilizadores u ON a.Utilizador = u.Utilizador "
		."GROUP BY a.GolosEqCasa, a.GolosEqFora "
		."ORDER BY a.JogoId ASC"
		) as $row) : extract($row); ?>
			<?php if ($Utilizador != $currentUser && $Estado == "ApostasAbertas") continue; ?>
			<tr>
				<td><?=$ApostaGolosEqCasa?> - <?=$ApostaGolosEqFora?></td>
				<td><?=$row["Utilizador"]?></td>
			</tr>
		<?php endforeach; ?>
		<?php endif;?>
	</tbody>
</table>
<?php endforeach; ?>




