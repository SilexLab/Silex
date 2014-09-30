Silex Coding Style
==================

Throughout all our projects we aim to use one unified coding style for best readability and transferability. You can see the coding style clarified by examples below.

## PHP (and JavaScript)

Pure PHP-scripts starts with the __<?php__ tag in line 1 but never closing it at the end.
This prevents an inadvertent output of whitespaces.

**Indentation and Brace Style**  
The brace style follows the 1TBS, the one true brace style. Tabulators are used to indent subordinated code.

**Spacing**  
Between the function- or statement names and their brackets there are no spaces.
Operators (except "++", "--", "::", "->" or ".") have spaces before and after.

**Naming**  
All variable, function- and method names are lowerCamelCase, meaning the first letter is always lower case. Classes, including interfaces, are named using UpperCamelCase, capitalising the first letter. Interface's names are prepended with an `I` (capital i).
However, keys of arrays are named lower case and by using underscores `_`.
Constants are named all upper case and using underscores, e.g. `DEBUG_CONSTANT`.

#### Example

```php
<?php

class ExampleClass implements IFooInterface {
	const RANDOM_CONSTANT = 42;

	protected $fooVar = 0;
	protected $array = [];
	protected $fooBool = false;

	// Abbreviations keep the case of the first letter throughout the whole abbreviation
	protected $htmlUsesHTTP;

	public function makeItWork($iAmAnArgument) {
		// Hey, do something pretty
		if ($this->fooBool) {
			$this->array['herp_derp'] .= $fooVar++;
		}

		return $fooVar;
	}

	public static function staticMethod($value) {
		if ($value <= 4) {
			return true;
		} else {
			return false;
		}
	}
	
	public function isFoo() {
		return $this->fooBool;
	}
	
	public function getArray() {
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
