<?php

// The thread-local PCRE cache is limited to 1024 entries, but entries are
// reference counted to ensure that code such as this won't segfault.

function replace($i, $m,$lim) {
  if ($i < $lim) {
    preg_replace_callback("/.|$i/",
      function ($m) use ($i,$lim) {
        replace($i+1, $m,$lim);
      },
      'x');
  }
  return '';
}
replace(0, 0, 1100);
echo "OK\n";
