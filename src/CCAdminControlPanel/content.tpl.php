<h1>Hantera innehåll</h1>
<p>Controller för att hantera innehåll.</p>

<h2>Allt innehåll</h2>
<?php if($contents != null):?>
  <ul>
  <?php foreach($contents as $val):?>
    <li><?=$val['id']?>, <?=$val['title']?> by <?=$val['owner']?> <a href='<?=create_url("content/edit/{$val['id']}")?>'>edit</a> <a href='<?=create_url("page/view/{$val['id']}")?>'>view</a>
  <?php endforeach; ?>
  </ul>
<?php else:?>
  <p>No content exists.</p>
<?php endif;?>