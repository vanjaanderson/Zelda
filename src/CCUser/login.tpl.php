<h1>Logga in</h1>
<p>Här skulle det vara ett login-formulär. Men tills vidare kan du logga in med dessa länkar.</p>
<ul>
  <li><a href='<?=create_url('user/login/doe/doe')?>'>Logga in som doe/doe (fungerar)</a>
  <li><a href='<?=create_url('user/login/root/root')?>'>Logga in som root/root (fungerar)</a>
  <li><a href='<?=create_url('user/login/root@dbwebb.se/root')?>'>Logga in som root@dbwebb.se/root (fungerar)</a>
  <li><a href='<?=create_url('user/login/admin/root')?>'>Logga in som admin/root (fungerar ej, felaktigt användarnamn)</a>
  <li><a href='<?=create_url('user/login/root/admin')?>'>Logga in som root/admin (fungerar ej, felaktigt lösenord)</a>
  <li><a href='<?=create_url('user/login/admin@dbwebb.se/root')?>'>Logga in som admin@dbwebb.se/root (fungerar ej, felaktig e-postadress)</a>
</ul>


