<h1>Innehåll</h1>
<p>Skapa, redigera och visa innehåll.</p>

<h2>Allt innehåll</h2>
<?php if($contents != null):?>
  <ul>
  <?php foreach($contents as $val):?>
    <p class="smaller-text">
    	<?=$val['id']?>, <?=esc($val['title'])?>, av <?=$val['owner']?> | <a href='<?=create_url("content/edit/{$val['id']}")?>'>redigera</a> | <a href='<?=create_url("page/view/{$val['id']}")?>'>visa</a>
    </p>
  <?php endforeach; ?>
  </ul>
<?php else:?>
  <p>Det finns inget innehåll.</p>
<?php endif;?>

<h2>Aktiviteter</h2>
  <p class="smaller-text">
  	<a href='<?=create_url('content/create')?>'>skapa nytt innehåll</a> | 
  	<a href='<?=create_url('blog')?>'>visa som blogg</a>
  </p>