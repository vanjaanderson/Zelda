<h1>Innehåll</h1>
<p>Skapa, redigera och visa innehåll.</p>

<h2>Allt innehåll</h2>
<?php if($contents != null):?>
  <ul>
  <?php foreach($contents as $val):?>
    <li><?=$val['id']?>, <?=esc($val['title'])?>, av <?=$val['owner']?> <a href='<?=create_url("content/edit/{$val['id']}")?>'>redigera</a> <a href='<?=create_url("page/view/{$val['id']}")?>'>visa</a>
  <?php endforeach; ?>
  </ul>
<?php else:?>
  <p>Det finns inget innehåll.</p>
<?php endif;?>

<h2>Aktiviteter</h2>
<ul>
  <li><a href='<?=create_url('content/init')?>'>Initiera databasen och skapa demoinnehåll</a>
  <li><a href='<?=create_url('content/create')?>'>Skapa nytt innehåll</a>
  <li><a href='<?=create_url('blog')?>'>Visa som blogg</a>
</ul>