<!DOCTYPE html>
<html lang="{$lang.id-short}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="Content-Language" content="{$lang.id-short}">
	<meta name="viewport" content="initial-scale=1, minimum-scale=1, width=device-width, height=device-height, user-scalable=no">
{*	<link rel="search" type="application/opensearchdescription+xml" href="/opensearch.xml" title="Silex"> *}
	<title>{$page.title} · Silex Framework</title>
	<link rel="icon" type="image/png" sizes="16x16" href="{$url.asset}images/favicon-small.png">
	<link rel="icon" type="image/png" sizes="32x32 64x64" href="{$url.asset}images/favicon.png">
	<link rel="icon" type="image/svg+xml" sizes="any" href="{$url.asset}images/favicon.svg">
{* Description *}
	<meta name="application-name" content="Silexlab">
	<meta name="author" content="Patrick Kleinschmidt">
	<meta name="author" content="Janek Ostendorf">
	<meta name="description" content="Silex the lightweight, fast, extensible, modular and open source PHP framework to build your webapps.">
	<meta name="keywords" content="silex, program, html, php, free, open, open source">
	<meta property="og:url" content="https://silexlab.org">
	<meta property="og:site_name" content="Silexlab">
	<meta property="og:title" content="Silex Framework">
	<meta property="og:description" content="Silex the lightweight, fast, extensible, modular and open source PHP framework to build your webapps.">
	<meta property="og:image" content="{$url.asset}images/logo.png">
	<meta property="og:image:type" content="image/png">
	<meta property="og:image:width" content="1200">
	<meta property="og:image:height" content="455">
	<meta property="og:image" content="{$url.asset}images/logo.svg">
	<meta property="og:image:type" content="image/svg+xml">{*
	<meta property="twitter:card" content="summary">
	<meta property="twitter:site" content="@SilexLab">
	<meta property="twitter:title" content="Silex Lab">
	<meta property="twitter:description" content="Silex the lightweight, fast, extensible, modular and open source PHP framework to build your webapps.">
	<meta property="twitter:image" content="{$url.asset}images/logo.png"> *}
{* Desktop apps
	<meta name="msapplication-TileImage" content="/windows-tile.png">
	<meta name="msapplication-TileColor" content="#ffffff">
	<link rel="fluid-icon" href="https://silexlab.org/fluidicon.png" title="Silex">
	<link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-114.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-144.png">
	<link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144.png">
*}
{* Cascading Style Sheets *}
{foreach $style.css_files as $css_file}
	<link rel="stylesheet" type="text/css" {if $css_file.media}media="{$css_file.media}" {/if}href="{$style.url_path}{$css_file.file}">
{/foreach}
{* Javascripts *}
	<script type="text/javascript">var baseURL = '{$url.base}';</script>
{foreach $style.js_files as $js_file}
	<script type="text/javascript" src="{$style.url_path}{$js_file}"></script>
{/foreach}
	<script type="text/javascript">
{foreach $style.css_async as $css_file}
loadCSS('{$style.url_path}{$css_file.file}');
{/foreach}
	</script>
</head>
<body>
{include file=$page.body}
{* No body and html endtag
index.php will set that stuff
</body>
</html>
*}
