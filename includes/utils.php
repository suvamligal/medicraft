<?php

function email_exists($email)
{
    global $dbconnection;
    $result = $dbconnection->query("select email from users where email='$email'");
    if ($result->num_rows > 0) {
        return true;
    }
    return false;
}

function truncate($text, $limit=10, $ellipsis = '...') {
  
    return substr($text,0,60)."...";
}