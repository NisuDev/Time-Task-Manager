<?php

unset($_SESSION);

session_destroy();

echo 'CERRADA';

exit();

?>