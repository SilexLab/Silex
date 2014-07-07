<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>{$page.title} · Silexframework</title>
	<link rel="icon" type="image/png" sizes="16x16" href="{$style.url_path}images/favicon-small.png">
	<link rel="icon" type="image/png" sizes="32x32 64x64" href="{$style.url_path}images/favicon.png">
	<link rel="icon" type="image/svg+xml" sizes="any" href="{$style.url_path}images/favicon.svg">
{* Cascading Style Sheets *}
{foreach $style.css_files as $css_file}
	<link rel="stylesheet" type="text/css" href="{$style.url_path}{$css_file}">
{/foreach}
{* Javascripts *}
	<script type="text/javascript">var baseURL = '{$url.base}';</script>
{foreach $style.js_files as $js_file}
	<script type="text/javascript" src="{$style.url_path}{$js_file}"></script>
{/foreach}
	<script type="text/javascript">
{foreach $style.css_async as $css_file}
loadCSS('{$style.url_path}{$css_file}');
{/foreach}
	</script>
</head>
<body>
{include file=$page.base_tpl}
{if !$DEBUG}
</body>
</html>
{/if}
