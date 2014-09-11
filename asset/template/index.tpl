<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="Content-Language" content="en">
	<meta name="viewport" content="initial-scale=1, minimum-scale=1, width=device-width, height=device-height, user-scalable=no">
{*	<link rel="search" type="application/opensearchdescription+xml" href="/opensearch.xml" title="Silex"> *}
	<title>{$page.title} · Silex Framework</title>
	<link rel="icon" type="image/png" sizes="16x16" href="{$style.url_path}images/favicon-small.png">
	<link rel="icon" type="image/png" sizes="32x32 64x64" href="{$style.url_path}images/favicon.png">
	<link rel="icon" type="image/svg+xml" sizes="any" href="{$style.url_path}images/favicon.svg">
{* Description *}
	<meta name="application-name" content="Silexlab">
	<meta name="author" content="Patrick Kleinschmidt">
	<meta name="description" content="The Silex Framework.">
	<meta name="keywords" content="silex, program, html, php, free, open, open source">
	<meta property="og:url" content="https://silexlab.org">
	<meta property="og:site_name" content="Silexlab">
	<meta property="og:title" content="Silex Framework">
	<meta property="og:description" content="The Silex Framework.">
	<!-- <meta property="og:image" content="/asset/images/logo.png">
	<meta property="og:image:type" content="image/png">
	<meta property="og:image:width" content="1200">
	<meta property="og:image:height" content="455">
	<meta property="og:image" content="/asset/images/logo.svg">
	<meta property="og:image:type" content="image/svg+xml"> -->
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
{include file=$page.base_tpl}
{if !$DEBUG}
</body>
</html>
{/if}
