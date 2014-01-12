<h1>Innehåll</h1>
<p>Skapa, redigera och visa innehåll.</p>

<h2>Alla sidor</h2>
<?php if($pages != null):?>
  <ul>
  <?php foreach($pages as $val):?>
    <li>
    	(<?=esc($val['id'])?>) <?=esc($val['title'])?>, av <?=$val['owner']?> | <a class="smaller-text" href='<?=create_url("content/edit/{$val['id']}")?>'>redigera</a> | <a class="smaller-text" href='<?=create_url("page/view/{$val['id']}")?>'>visa</a>
    </li>
  <?php endforeach; ?>
  </ul>
<?php else:?>
  <p>Det finns inget innehåll.</p>
<?php endif;?>

<h2>Alla blogginlägg</h2>
<?php if($posts != null):?>
  <ul>
  <?php foreach($posts as $val):?>
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