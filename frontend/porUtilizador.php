<?php require_once __DIR__."/../sys/db.php"; ?>
<?php require_once __DIR__."/pageFragments/pageHeader.php"; ?>
	
	<h1><?=$_GET["UtilizadorSigla"]?></h1>
	<table border="1">
		<thead>
			<tr>
				<th>Jogo</th>
				<th>Fase</th>
				<th>Resultado</th>
				<th>Aposta</th>
				<th>Pontos</th>
				<th>Data Aposta</th>
		</thead>
		<tbody>
			<?php foreach(select(["EqCasa","EqFora","Fase","ResultadoEqCasa","ResultadoEqFora","Pontos","DataHoraAposta","Boost","ApostaGolosEqCasa","ApostaGolosEqFora"],"vApostasJogos","WHERE UtilizadorSigla = '{$_GET['UtilizadorSigla']}'") as $row) :  extract($row);?>
				<tr>
					<td><?=$EqCasa?> - <?=$EqFora?> </td>
					<td><?=$Fase?></td>
					<td><?=$ResultadoEqCasa?> - <?=$ResultadoEqFora?></td>
					<td><?=$ApostaGolosEqCasa?> - <?=$ApostaGolosEqFora?> <?=($Boost == 1?"(b)":"")?></td>
					<td><?=$Pontos?></td>
					<td><?=$DataHoraAposta?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php require_once __DIR__."/pageFragments/pageFooter.php"; ?>