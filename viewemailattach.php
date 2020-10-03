<?php
ob_start();
require_once 'init.php';
// clear out the output buffer
while (ob_get_status())
{
    ob_end_clean();
}
header("Location: fileserver.php");

