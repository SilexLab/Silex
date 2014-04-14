<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>{$page.title} · Silexframework</title>
	<link rel="icon" type="image/png" sizes="16x16" href="{$style.url_path}images/favicon-small.png">
	<link rel="icon" type="image/png" sizes="32x32 64x64" href="{$style.url_path}images/favicon.png">
	<link rel="icon" type="image/svg+xml" sizes="any" href="{$style.url_path}images/favicon.svg">
{foreach $style.css_files as $css_file}
	<link rel="stylesheet" type="text/css" href="{$style.url_path}{$css_file}">
{/foreach}
{foreach $style.js_files as $js_file}
	<script type="text/javascript" src="{$style.url_path}{$js_file}"></script>
{/foreach}
</head>
<body>
<header>
	<div class="w-size">
		<div class="w-content-h">
			<div class="content-box">
				<a href="{$url.base}"><img src="{$style.url_path}images/logo-single.svg" alt="Silex logo" title="Silex" id="page-logo"></a>
			</div>
			<div class="content-box">
				<nav class="main">
					<ul>
{foreach $nav.main as $entry}
						<li{($entry.active) ? ' class="active"' : ''}>
							<a href="{$entry.link}">{$entry.title}</a>
						</li>
{/foreach}
					</ul>
				</nav>
			</div>
			<div class="content-box right">
				<nav class="user">
					<ul>
						<li><a href="/search" title="{'general.search'|lang}" id="user-search"><img src="{$style.url_path}images/icon-magnifying-glass-b.svg" alt="{'general.search'|lang}" class="search"></a></li>
						<li><a href="/login" title="{'general.login'|lang}" id="user-login"><img src="{$style.url_path}images/icon-logout-b.svg" alt="{'general.login'|lang}" class="loginout"></a></li>
						<li><a href="/user/{$user.name}">{$user.name}</a></li>
						<li class="avatar"><a href="/user/{$user.name}"><img src="{$style.url_path}images/icon-user-b.svg" alt="avatar" class="avatar"></a></li>
					</ul>
				</nav>
			</div>
		</div>
	</div>
</header>
<section id="user-panel">
	<div class="w-size">
		<div class="w-content">
			User Panel
		</div>
	</div>
</section>
<section class="content-container">
	<div class="notification">
		<noscript>
			<div class="info">
				{'notification.javascript'|lang}
			</div>
		</noscript>
	</div>
	<div class="w-size">
		<div class="w-content">
			<nav class="breadcrumbs">
{foreach $nav.crumbs as $entry}
				<a href="{$entry.link}" class="crust"><span class="crumb">{$entry.title}</span></a>
{/foreach}
			</nav>
		</div>
		<div class="w-content">
{include file=$page.template}
		</div>
		<div class="w-content">
			<nav class="breadcrumbs">
{foreach $nav.crumbs as $entry}
				<a href="{$entry.link}" class="crust"><span class="crumb">{$entry.title}</span></a>
{/foreach}
			</nav>
		</div>
	</div>
</section>
<footer class="main">
	<div class="w-size">
		<div class="w-content">
			<div class="table">
				<div>Flex column 1</div>
				<div>Flex column 2</div>
				<div>Flex column 3</div>
			</div>
			{$style.title}<br>
			{$lang.name}
		</div>
	</div>
</footer>
</body>
</html>
