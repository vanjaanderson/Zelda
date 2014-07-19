<div id="sidebarbox">

  <?php if($is_authenticated): ?>
  <h3>Controllers och metoder</h3>

    <p>
    	Följande controller finns. Du aktiverar och/eller avaktiverar dem i  
    	<code>site/config.php</code>.
    </p>
   
    <?php foreach($controllers as $key => $val): ?>  
    <hr />

    <h4><a href='<?=create_url($key)?>'><?=$key?></a></h4>

    <?php if(!empty($val)): ?>
    <ul>
    <?php foreach($val as $method): ?>
      <li><a href='<?=create_url($key, $method)?>'><?=$method?></a></li> 
    <?php endforeach; ?>		
    </ul>
    <?php endif; ?> 
  <?php endforeach; ?>

  <?php else: ?>
    <h2 class="sidebarheader">Senaste inlägg</h2> 
    <?php foreach($contents as $val):?>
      <h4><?=esc($val['title'])?></h4>
      <p><?=substr($val['data'],0,85);?></p>
      <p class='smaller-text silent' style='text-align:right'><a href='<?=create_url("page/view/{$val['id']}")?>'>Läs mer</a></p>
      <hr />
    <?php endforeach; ?>

  <?php endif; ?>

</div>
