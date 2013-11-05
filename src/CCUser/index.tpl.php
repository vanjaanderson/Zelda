<h1>Användarprofil</h1>
<ul>
  <li><a href='<?=create_url(null, 'init')?>'>Initiera databasen, skapa tabeller och skapa förinställd administrator</a>
  <li><a href='<?=create_url(null, 'login', 'root/root')?>'>Logga in som root/root (fungerar)</a>
    <li><a href='<?=create_url(null, 'login', 'doe/doe')?>'>Logga in som doe/doe (fungerar)</a>
  <li><a href='<?=create_url(null, 'login', 'root@dbwebb.se/root')?>'>Logga in som root@dbwebb.se/root (fungerar)</a>
  <li><a href='<?=create_url(null, 'login', 'admin/root')?>'>Logga in som admin/root (fungerar inte, användarnamnet är fel)</a>
  <li><a href='<?=create_url(null, 'login', 'root/admin')?>'>Logga in som root/admin (fungerar inte, lösenordet är fel)</a>
  <li><a href='<?=create_url(null, 'login', 'admin@dbwebb.se/root')?>'>Logga in som admin@dbwebb.se/root (fungerar inte, e-postadressen är fel)</a>
  <li><a href='<?=create_url(null, 'logout')?>'>Logga ut</a>
</ul>
<p>Information om aktuell användare.</p>

<?php if($is_authenticated): ?>
  <p>Användaren är autentiserad.</p>
  <pre><?=print_r($user, true)?></pre>
<?php else: ?>
  <p>Användaren är okänd och inte autentiserad.</p>
<?php endif; ?>