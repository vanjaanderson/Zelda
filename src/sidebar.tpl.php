<div id="sidebarbox">

  <?php if($is_authenticated): ?>
    <h2 class="sidebarheader">Adminis&shy;tra&shy;tions&shy;panel</h2>
    <ul class='adminul'>
      <li><a href='<?=create_url('akp/create')?>'>Skapa användare</a></li>
      <li><a href='<?=create_url('akp/users')?>'>Hantera användare</a></li>
    <!--  <li><a href='<?=create_url('akp/edituser')?>'>Redigera användare</a></li> -->
    </ul>
    <ul class='adminul'>
      <li><a href='<?=create_url('akp/creategroup')?>'>Skapa grupp</a></li>
      <li><a href='<?=create_url('akp/groups')?>'>Hantera grupper</a></li>
    <!--  <li><a href='<?=create_url('akp/editgroup')?>'>Redigera grupper</a></li> -->
    </ul>
    <ul class='adminul'>
      <li><a href='<?=create_url('content/create')?>'>Skapa innehåll</a></li>
      <li><a href='<?=create_url('content/managecontents')?>'>Hantera innehåll</a></li>
    </ul>

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