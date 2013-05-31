<!DOCTYPE html>
<html>
	<head>
		<meta charset="<?php bloginfo('charset'); ?>" />
		<meta name="viewport" content="width=device-width" />
		<title><?php bloginfo('name'); ?><?php wp_title( '|', true, 'right' ); ?></title>
		<?php wp_head(); ?>
	</head>
	<body>
		<div class="wrapper">
			<?php module('Header') ?>
			<div class="contentwrapper">