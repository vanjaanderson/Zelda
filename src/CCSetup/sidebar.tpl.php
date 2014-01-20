<div id="sidebarbox" class="box">

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
  <h3>Om Zelda</h3>
  <p>Här syns administrationspanel när du är inloggad.</p>
  <p>Om det inte finns särskild sidovy, så visas alla controllers och metoder.</p>
<?php endif; ?>

</div>