<h1>Innehållskontroller Index</h1>
<p>En kontroller för att administrera allt innehåll: lista, skapa, redigera, ta bort och visa innehåll.</p>

<h2>Allt innehåll</h2>
<?php if($contents != null):?>
  <ul>
  <?php foreach($contents as $val):?>
    <li><?=$val['id']?>, <?=$val['title']?>, av <?=$val['owner']?> <a href='<?=create_url("content/edit/{$val['id']}")?>'>redigera</a>
  <?php endforeach; ?>
  </ul>
<?php else:?>
  <p>Det finns inget innehåll.</p>
<?php endif;?>

<h2>Aktiviteter</h2>
<ul>
  <li><a href='<?=create_url('content/init')?>'>Initiera databasen och skapa demoinnehåll</a>
  <li><a href='<?=create_url('content/create')?>'>Skapa nytt innehåll</a>
</ul>