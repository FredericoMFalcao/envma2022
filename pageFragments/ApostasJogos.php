<table>
	<thead>
		<tr>
			<th>Jogo</th>
			<th>Aposta</th>
			<th>Resultado</th>
			<th>Utilizador</th>			
		</tr>
	</thead>
	<tbody>
		<?php foreach(select(["Utilizador","GolosEqCasa","GolosEqFora"],"ApostasJogos") as $row) : extract($row); ?>
			<tr>
				<td><?=$JogoId?></td>
				<td><?=$GolosEqFora?> - <?=$GolosEqFora?></td>
				<td><?=$Utilizador?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>