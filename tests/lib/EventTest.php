<?php
/**
 * @author    Janek Ostendorf (ozzy) <ozzy2345de@gmail.com>
 * @copyright Copyright (c) 2013 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */
 
class EventTest extends PHPUnit_Framework_TestCase {

	/**
	 * @var ReflectionClass
	 */
	protected static $reflectionClass = null;

	protected function getReflectionObject() {
		if(self::$reflectionClass === null) {
			self::$reflectionClass = new ReflectionClass('Event');
		}
		return self::$reflectionClass;
	}

	public function testEventFiresRightMethod() {
		$mock = $this->getMock('EventTest', ['fooBar']);
		$mock->expects($this->once())
		     ->method('fooBar')
		     ->with($this->equalTo(1337));

		// Create a listener
		Event::listen('test.hook.1', [$this, 'fooBar']);
		Event::fire('test.hook.1');
	}

	public function fooBar() {
		return 1337;
	}

}
