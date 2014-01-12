<h1>Sidor</h1>
<p>Skapa, redigera och visa innehåll.</p>

<h2>Allt innehåll</h2>
<?php if($content != null):?>
  <ul>
  <?php foreach($content as $val):?>
    <li>
    	(<?=esc($val['id'])?>) <?=esc($val['title'])?>, av <?=$val['owner']?> | <a class="smaller-text" href='<?=create_url("content/edit/{$val['id']}")?>'>redigera</a> | <a class="smaller-text" href='<?=create_url("page/view/{$val['id']}")?>'>visa</a>
    </li>
  <?php endforeach; ?>
  </ul>
<?php else:?>
  <p>Det finns inget innehåll.</p>
<?php endif;?>

<h2>Aktiviteter</h2>
  <p class="smaller-text">
  	<a href='<?=create_url('page')?>'>visa sidor</a> | 
  	<a href='<?=create_url('blog')?>'>visa som blogg</a>
  </p>