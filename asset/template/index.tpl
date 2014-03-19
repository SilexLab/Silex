<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Silex · Silexframework</title>
{foreach $style.css_files as $css_file}
	<link rel="stylesheet" type="text/css" href="{$style.url_path}{$css_file}">
{/foreach}
{foreach $style.js_files as $js_file}
	<script type="text/javascript" src="{$style.url_path}{$js_file}"></script>
{/foreach}
</head>
<body>
{include file=$page.template}
</body>
</html>
