<?php
/**
 * @author    Janek Ostendorf (ozzy) <ozzy2345de@gmail.com>
 * @copyright Copyright (c) 2013 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

class ConfigTest extends SilexDatabaseTestCase {

	/**
	 * Returns the test dataset.
	 * @return PHPUnit_Extensions_Database_DataSet_IDataSet
	 */
	protected function getDataSet() {
		$ds = new PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
		$ds->addTable('config');
		return $ds;
	}

	public function testProperFetching() {
		$startDS = new PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
		$startDS->addTable('config');

		// String
		$string = Silex::getConfig()->get('page.title');
		$this->assertInternalType('string', $string);
		// Int
		$int = Silex::getConfig()->get('session.cookie_time');
		$this->assertInternalType('int', $int);

		// No changes while just fetching
		$endDS = new PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
		$endDS->addTable('config');
		$this->assertDataSetsEqual($startDS, $endDS);
	}
}
