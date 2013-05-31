<?php

require('../../../../wp-blog-header.php');

if (current_user_can( 'manage_options' )) {
	flushTerrificCache();
	header('Location: ' . $_SERVER['HTTP_REFERER']);
}

echo "Permission denied.";

?>