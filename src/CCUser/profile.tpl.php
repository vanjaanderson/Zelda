<h1>Användarprofil</h1>
<p>Här kan du se och ändra din profilinformation.</p>

<?php if($is_authenticated): ?>
  <?=$profile_form?>
  <p>Din profil skapades <?=$user['created']?> och är senast uppdaterad <?=$user['updated']?>.</p>
  <p>Du är medlem i <?=count($user['groups'])?> grupp/grupper:</p>
  <ul>
	  <?php foreach($user['groups'] as $group): ?>
	    <li><?=$group['name']?>
	  <?php endforeach; ?>
  </ul>
<?php else: ?>
  <p>Användaren är okänd och inte autentiserad.</p>
<?php endif; ?>