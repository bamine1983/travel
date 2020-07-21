<?php

echo "Update...";

$connection = ssh2_connect('188.165.171.1', 22);
ssh2_auth_password($connection, 'preprod', 'UPyzhOuN#b}A');

$stream = ssh2_exec($connection, 'rm -rf test.php');

echo "Output: " . stream_get_contents($stream);
echo "Error: " . stream_get_contents($errorStream);
echo "Update réussi";

?>