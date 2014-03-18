<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Silex · Silexframework</title>
	{* CSS *}
	{if !empty($style.css_files)}
		{foreach $style.css_files as $css_file}
			<link rel="stylesheet" type="text/css" href="{$style.relative_path}{$css_file}">
		{/foreach}
	{/if}

	{* JS *}
	{if !empty($style.js_files)}
		{foreach $style.js_files as $js_file}
			<script type="text/javascript" src="{$style.relative_path}{$js_file}"></script>
		{/foreach}
	{/if}
</head>
<body>
	{include file=$page.template}
</body>
</html>
