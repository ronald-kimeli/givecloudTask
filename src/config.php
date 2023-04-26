<?php
$servername = "localhost";
$username = "linuxhint";
$password = "new_password";
$dbname = "givecloud";


$Token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiY2U3YzhjNWExMGI3ODBlY2U5MTQwZGM3ZTVmMzI3Njg5NjcyZjU0ZWFmMzdmNWZkNmJhNTFjYzVhYWE1MTU1ZjYzYzdkZGI2MjA3Y2YxODQiLCJpYXQiOjE2ODAzNDYxNjQuMzgyMDc2LCJuYmYiOjE2ODAzNDYxNjQuMzgyMDgxLCJleHAiOjE3MTE5Njg1NjQuMzcwNjk1LCJzdWIiOiIyIiwic2NvcGVzIjpbXX0.l4ZG2zgqoVEaeCh3a7uhDRbs_PqQz54MrLwg_iwUUQX_-7FsSwM0T70soPGjMwywZSqH95vC9iKiJsrruJ8pkqxBzYRwdErz4Ib7Dd_x9G6Raqfovz7mr8cUU_9Ej7wBPOXumKBO3RdeUgu91ThxRZa-SHmOTXLpPniAb6T3wW1bknxASbYZsKdgdWMuF9rF_gDUOzhNTNVnGWbgXQJXnWm63V-48jrU91kYRWcFRiSD_lnysNW2PM_HqgOnk-Hf3Fx_931WrgqNMp-vLysb5qYSnwAx7XKMwlguwOSPdFnu-OPNvzqlRJs9bf7Z7vTkbC1oKMz_BUtCOngnq_j75HRVR75AQsXN4XKLNKznpL2Ch45D03pB-ppLsInwkzc4Jd_xaWkw8R5PJBwFG6-ngLOU0JgZBot__eoTcyAseEppPeBX8TpQ9wO94VgmS07HBxPavR5Yg4Ct98OjbreFNJo5rO8mkZYwE86McWcV5WaHBcDPBLxc-r7_z0pXEFNYoDrBGg28FRESuQIMABSt0Xo-an36d4EZe8OXEAZ0XZAiDp0dVTKzNXh7R4J7mjphScfr_qtqWkntNfJyRTsmVJ1e7H2Y1PvyWEpHaHO8W-lp3k0JmRhHz9x1llA5ycdrjVPo530_t0o9hTKUZAijAIpAUxljNWoyftYBiiY5kYY";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
  // echo 'Connected Successfully!';
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}