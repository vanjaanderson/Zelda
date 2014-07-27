<h1>Sidor<span class='headerlink'></h1>
<p>Skapa, redigera och visa innehåll.</p>

<h2>Alla sidor</h2>
<?php if($content != null):?>
  <ul>
  <?php foreach($content as $val):?>
    <li>
    	(<?=esc($val['id'])?>) <?=esc($val['title'])?>, av <?=$val['owner']?> | <a href='<?=create_url("content/edit/{$val['id']}")?>'>Redigera</a> | <a href='<?=create_url("page/view/{$val['id']}")?>'>Visa</a>
    </li>
  <?php endforeach; ?>
  </ul>
<?php else:?>
  <p>Det finns inget innehåll.</p>
<?php endif;?>