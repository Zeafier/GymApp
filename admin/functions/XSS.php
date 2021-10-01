<?php

function clean($input) {
    // Trims whitespace from input
    $input = trim($input);
    // Removes slashes from input data
    $input = stripslashes($input);
    
  // Removes all the html tags from input data
    $input = strip_tags($input);
    // Escapes html characters from input data
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
  return $input;
}

?>