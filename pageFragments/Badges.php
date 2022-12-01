<table border="1">
	<thead>
		<tr>
			<th>Badge</th>
			<th>Concorrente</th>
		</tr>
	</thead>
<tbody>
	<?php foreach(select(["Utilizador","MaiorSeqDeCincos"],"EstatisticasUtilizadores", "ORDER BY MaiorSeqDeCincos DESC LIMIT 1") as $row) : extract($row); ?>
		<tr>
			<td>Maior Sequência de 5's</td>
			<td><?=$Utilizador?></td>
		</tr>
	<?php endforeach;?>
	<?php foreach(select(["Utilizador","MaiorSeqDeTendenciaCorreta"],"EstatisticasUtilizadores", "ORDER BY MaiorSeqDeTendenciaCorreta DESC LIMIT 1") as $row) : extract($row); ?>
		<tr>
			<td>Maior Sequência de Tendência Correta</td>
			<td><?=$Utilizador?></td>
		</tr>
	<?php endforeach;?>
	<?php foreach(select(["Utilizador","MaiorContribuinteDeResultados"],"EstatisticasUtilizadores", "ORDER BY MaiorContribuinteDeResultados DESC LIMIT 1") as $row) : extract($row); ?>
		<tr>
			<td>Maior Contribuinte de Resultados</td>
			<td><?=$Utilizador?></td>
		</tr>
	<?php endforeach;?>
</tbody>
</table>