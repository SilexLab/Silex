Silex Coding Style
==================

Throughout all our projects we aim to use one unified coding style for best readability and transferability. You can see the coding style clarified by examples below.

## PHP (and JavaScript)

**PSR**  
We adopted the coding standard recommendations [PSR-1](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md), [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md) and [PSR-4](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md).  

**PSR differences**  
We are using ```else if``` instead of ```elseif``` because it is the default for most c-languages.


#### Example

```php
<?php
namespace silex\namespace;

use silex\namespace\subnamespace\Class;

class ExampleClass implements FooInterface
{
	const RANDOM_CONSTANT = 42;

	protected $fooVar = 0;
	protected $array = [];
	protected $fooBool = false;

	// Abbreviations keep the case of the first letter throughout the whole abbreviation
	protected $htmlUsesHTTP;

	public function makeItWork($iAmAnArgument)
	{
		// Hey, do something pretty
		if ($this->fooBool) {
			$this->array['herp_derp'] .= $fooVar++;
		}

		return $fooVar;
	}

	public static function staticMethod($value)
	{
		if ($value <= 4) {
			return true;
		} else {
			return false;
		}
	}
	
	public function isFoo($echo = false)
	{
		if (!$echo)
			return $this->fooBool;
		echo 'It is ' . ($this->fooBool ? 'Foo' : 'Bar');
	}
	
	public function getArray()
	{
		return $this->array;
	}

}

```

## HTML / TPL

Indent with tabs and keep everything lower case!
For classes and IDs, multiple-word identifiers are separated by hyphens.
Template variable names are separated by underscores.  

#### Example 

```html
<div class="i-am-a-class">
	<span id="hurr">{$variable_with_underscores}</span>
	<br>
	{if $var_name > 10}
		<div class="useless">{$var.array_key}</div>
	{/if}
</div>
```

## CSS
IDs, classes and fairly everything else is lower case. Descendants may be indented.
Multiple-word identifiers are separated by hyphens (classes, ids).  

#### Example

```css
.i-am-a-class {
	position: absolute;
	top: 0;
}

	.i-am-a-class #hurr {
		height: 20px;
		background: #fff;
		padding: 10px 5px;
	}

	.i-am-a-class .useless {
		display: none;
	}
#i-am-an-id {
	content: "Hi";
}
```
