<?php
// Check if database file has content (is initialized) and re-direct.
if(file_exists('site/data/.ht.sqlite')) {
  $size = filesize("site/data/.ht.sqlite");
  if ($size > 0) {
    header("Location: my/page/");
  } else {
    header("Location: setup/");
  }
}

?>