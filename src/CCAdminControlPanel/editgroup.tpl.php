<h1>Redigera grupp <?=$editgroup['name']?></h1>

<?php if($is_authenticated && $user['hasRoleAdmin']): ?>
<p>Visa och uppdatera grupper.</p>
  <?=$group_form?>
  <?php else: ?>
  <p>Du har inte behörighet att vara här.</p>
<?php endif; ?>