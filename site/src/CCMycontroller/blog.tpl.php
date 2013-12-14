<h1>Blogg</h1>
<p><em>Här är alla mina blogginlägg:</em></p>

<?php if($contents != null):?>
  <?php foreach($contents as $val):?>
    <h2><?=esc($val['title'])?></h2>
    <p class='smaller-text'><em>Publicerat den <?=$val['created']?> av <?=$val['owner']?></em></p>
    <p><?=filter_data($val['data'], $val['filter'])?></p>
    <p class='smaller-text silent'><a href='<?=create_url("content/edit/{$val['id']}")?>'>ändra</a></p>
  <?php endforeach; ?>
<?php else:?>
  <p>Det finns inga inlägg.</p>
<?php endif;?>

