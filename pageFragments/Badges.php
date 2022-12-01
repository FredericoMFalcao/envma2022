<table border="1">
	<thead>
		<tr>
			<th>Badge</th>
			<th>Concorrente</th>
		</tr>
	</thead>
<tbody>
	<?php foreach(select(["b.NomeLongo Utilizador","MaiorSeqDeCincos"],"EstatisticasUtilizadores a", "INNER JOIN Utilizadores b ON a.Utilizador = b.Utilizador ORDER BY MaiorSeqDeCincos DESC LIMIT 1") as $row) : extract($row); ?>
		<tr>
			<td>Maior Sequência de 5's</td>
			<td><?=$Utilizador?></td>
		</tr>
	<?php endforeach;?>
	<?php foreach(select(["b.NomeLongo Utilizador","MaiorSeqDeTendenciaCorreta"],"EstatisticasUtilizadores a", "INNER JOIN Utilizadores b ON a.Utilizador = b.Utilizador ORDER BY MaiorSeqDeTendenciaCorreta DESC LIMIT 1") as $row) : extract($row); ?>
		<tr>
			<td>Maior Sequência de Tendência Correta</td>
			<td><?=$Utilizador?></td>
		</tr>
	<?php endforeach;?>
	<?php foreach(select(["b.NomeLongo Utilizador","a.MaiorContribuinteDeResultados"],"EstatisticasUtilizadores a", "INNER JOIN Utilizadores b ON a.Utilizador = b.Utilizador ORDER BY a.MaiorContribuinteDeResultados DESC LIMIT 1") as $row) : extract($row); ?>
		<tr>
			<td>Maior Contribuinte de Resultados</td>
			<td><?=$Utilizador?></td>
		</tr>
	<?php endforeach;?>
</tbody>
</table>