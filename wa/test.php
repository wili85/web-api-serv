<?php
/*
$hash = '$2y$10$GarvLsiaTekLEFI8dCxuru5bWy6npHUQyiDyJFg/uKuxEwsp4R6fm';

if (password_verify('43431943', $hash)) {
    echo 'ok';
} else {
    echo 'no';
}
*/

include_once 'api.php';
$api = new Api();

$api->testftp();

?>