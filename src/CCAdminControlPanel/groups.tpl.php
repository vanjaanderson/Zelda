<h1>Hantera grupper</h1>
<p>Redigera befintlig eller skapa ny grupp.</p>

<?php if($is_authenticated && $user['hasRoleAdmin']): ?>
  <ul>
  <?php foreach($allgroups as $group): ?>
    <li><a href="<?=create_url('akp/groups/'.$group['id'])?>"><?=$group['name']?></a> (<?=$group['acronym']?>)
  <?php endforeach; ?>
  </ul>
<?php else: ?>
  <p>Du är inte behörig att vara här.</p>
<?php endif; ?>