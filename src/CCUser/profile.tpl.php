<h1>Användarprofil</h1>
<p>Här kan du se och ändra din profilinformation.</p>

<?php if($is_authenticated): ?>
  <p>Användaren är autentiserad.</p>
  <pre><?=print_r($user, true)?></pre>
<?php else: ?>
  <p>Användaren är okänd och inte autentiserad.</p>
<?php endif; ?>

