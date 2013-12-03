<h1>Teman</h1>
<p>Här kan du testa och utveckla teman.<p>
<p>Nuvarande tema är: <?=$theme_name?></p>

<ul>
<?php foreach($methods as $val): ?>
  <li><a href='<?=create_url($val)?>'><?=$val?></a></li>
<?php endforeach; ?>
</ul>