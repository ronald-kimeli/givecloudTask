<?php
require_once('./src/config.php');
require_once('./src/functions.php');

backupDatabaseAllTables($servername, $username, $password, $dbname);

echo 'Exported Successfully';
