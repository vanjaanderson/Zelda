<h1>Installera moduler</h1>

<p><em>Följande moduler påverkades av installationen:</em></p>

<table>
<caption>Resultat av modulinstallation</caption>
	<thead>
	  <tr><th>Modul</th><th>Resultat</th></tr>
	</thead>
	<tbody>
		<?php foreach($modules as $module): ?>
		  <tr><td><?=$module['name']?></td><td><div class='<?=$module['result'][0]?>'><?=$module['result'][1]?></div></td></tr>
		<?php endforeach; ?>
	</tbody>
</table>