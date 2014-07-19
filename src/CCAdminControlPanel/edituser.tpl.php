<h1>Redigera användare <?=$edituser['name']?></h1>

<?php if($is_authenticated && $user['hasRoleAdmin']): ?>
<p>Visa och uppdatera användarprofiler.</p>
  <?=$profile_form?>
  <?php else: ?>
  <p>Du har inte behörighet att vara här.</p>
<?php endif; ?>