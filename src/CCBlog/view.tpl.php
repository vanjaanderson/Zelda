<h1>Inlägg</h1>
<p>Skapa, redigera och visa innehåll.</p>

<h2>Alla inlägg</h2>
<?php if($content != null):?>
  <ul>
  <?php foreach($content as $val):?>
    <li>
    	(<?=esc($val['id'])?>) <?=esc($val['title'])?>, av <?=$val['owner']?> | <a class='smaller-text' href='<?=create_url('content', 'create')?>'>Skapa ny sida</a> | <a class='smaller-text' href='<?=create_url("content/edit/{$content['id']}")?>'>Redigera denna sida</a> | <a class='smaller-text' href='<?=create_url("content/{$content['page']}")?>'>Visa alla sidor</a>
    </li>
  <?php endforeach; ?>
  </ul>
<?php else:?>
  <p>Det finns inget innehåll.</p>
<?php endif;?>