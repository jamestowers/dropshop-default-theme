<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
		<meta charset="utf-8">

		<?php // Google Chrome Frame for IE ?>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title><?php wp_title(''); ?></title>

		<?php // mobile meta (hooray!) ?>
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="350">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scallable=no, minimal-ui"/>

		<!-- APPLE TAGS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <!-- STANDARD META TAGS -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="favicon.png">

		<link href='http://fonts.googleapis.com/css?family=Open+Sans+Pro:300,400,700,400italic' rel='stylesheet' type='text/css'>

		<script src="/library/js/vendor/modernizr.custom.js"></script>

		<?php wp_head(); ?>

	</head>

	<body>

		<div id="wrapper" class="group">

			<header class="header group pad" role="banner">
				
				<a id="logo" href="<?php echo home_url(); ?>" rel="nofollow">
					<h1><?php bloginfo('name'); ?></h1>
				</a>

				<a href="#" id="menu-toggle"><span></span></a>

			</header>

			<nav role="navigation" id="main-nav">
				<?php dropshop_main_nav(); ?>
			</nav>

			<div id="content" class="">