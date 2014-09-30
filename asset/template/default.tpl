{* Default Base Template *}
<header>
	<div class="container">
		<img id="silex-logo" src="{$url.asset}/images/logo-white.svg" alt="Silex">
		<nav class="main">
			<ul>
{foreach $nav.main as $entry}
				<li{($entry.active) ? ' class="active"' : ''}>
{if $entry.enabled}
					<a href="{$entry.link}">{$entry.title}</a>
{else}
					<a class="disabled">{$entry.title}</a>
{/if}
				</li>
{/foreach}
			</ul>
		</nav>
		{if isset($header)}{$header}{/if}
		{if isset($headline)}<h1>{$headline|lang}</h1>{/if}
	</div>
</header>
<div class="notification">
	<noscript>
		<div class="info">
			{'notification.javascript'|lang}
		</div>
	</noscript>
</div>
<section class="main-content">
{include file=$page.template}
</section>
<footer class="main">
	<div class="container">
		<div class="w-content">
			<div class="table">
				<div>
					{$style.title}<br>
					{$lang.name}
				</div>
				<div>You may should know, this site runs on Silex too.</div>
				<div>
					<p>IRC: <a href="http://chat.skyirc.net/?nick=silex_...&amp;channels=SilexLab&amp;prompt=1" target="_blank">#SilexLab</a> at <a href="http://skyirc.net/" target="_blank"><i class="i i-external-link-square"></i> SkyIrc</a></p>
		<p><a href="https://github.com/SilexLab/Silex"><i class="i i-github-alt" title="Github repository"></i></a> <a href="https://github.com/SilexLab/Silex/issues"><i class="i i-exclamation-circle" title="Issues"></i></a></p>
				</div>
			</div>
		</div>
	</div>
</footer>
