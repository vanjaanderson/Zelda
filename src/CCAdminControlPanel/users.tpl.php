<h1>Hantera användare</h1>
<p>Visa och uppdatera användarprofiler.</p>

<?php if($is_authenticated && $user['hasRoleAdmin']): ?>
  <ul>
  <?php foreach($allusers as $user): ?>
    <li><a href="<?=create_url('akp/users/'.$user['id'])?>"><?=$user['name']?></a> (<?=$user['acronym']?>)
  <?php endforeach; ?>
  </ul>
<?php else: ?>
  <p>Du är inte behörig att vara här.</p>
<?php endif; ?>