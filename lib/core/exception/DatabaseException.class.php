<?php
/**
 * @author    Janek Ostendorf (ozzy) <ozzy2345de@gmail.com>
 * @copyright Copyright (c) 2013 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

/**
 * Database errors
 */
class DatabaseException extends CoreException {

	protected $errorNumber = 0;
	protected $errorDesc = '';
	protected $sqlVersion = '';

	/**
	 * @var Database
	 */
	protected $db = null;

	/**
	 * @var string
	 */
	protected $dbType = '';

	/**
	 * @var PreparedStatement
	 */
	protected $preparedStatement = null;

	/**
	 * @param string            $message
	 * @param Database          $db
	 * @param PreparedStatement $preparedStatement
	 */
	public function __construct($message, Database $db, PreparedStatement $preparedStatement = null) {
		$this->db = $db;
		$this->preparedStatement = $preparedStatement;
		$this->dbType = $this->db->getType();

		// Prefer statement's errors
		if($this->preparedStatement !== null && $this->preparedStatement->getErrorNumber()) {
			$this->errorNumber = $this->preparedStatement->getErrorNumber();
			$this->errorDesc = $this->preparedStatement->getErrorDesc();
		} else {
			$this->errorNumber = $this->db->getErrorNumber();
			$this->errorDesc = $this->db->getErrorDesc();
		}

		parent::__construct($message, intval($this->errorNumber));
	}

	/**
	 * @return string
	 */
	public function getDbType() {
		return $this->dbType;
	}

	/**
	 * @return int
	 */
	public function getErrorNumber() {
		return $this->errorNumber;
	}

	/**
	 * return string
	 */
	public function getSqlVersion() {
		if($this->sqlVersion === '') {
			try {
				$this->sqlVersion = $this->db->getVersion();
			} catch(DatabaseException $e) {
				$this->sqlVersion = 'unknown';
			}
		}
		return $this->sqlVersion;
	}

	/**
	 * Show SQL error
	 */
	public function show() {
		// Put it into the information var
		$this->information .= '<strong>SQL type:</strong> '.StringUtil::encodeHtml($this->dbType).'<br />'.NL;
		$this->information .= '<strong>SQL error number:</strong> '.StringUtil::encodeHtml($this->errorNumber).'<br />'.NL;
		$this->information .= '<strong>SQL error message:</strong> '.StringUtil::encodeHtml($this->errorDesc).'<br />'.NL;
		$this->information .= '<strong>SQL version:</strong> '.StringUtil::encodeHtml($this->getSqlVersion()).'<br />'.NL;

		// Do we have some additional query stuff?
		if($this->preparedStatement !== null) {
			$this->information .= '<strong>SQL query:</strong> '.StringUtil::encodeHtml($this->preparedStatement->getQuery()).'<br />'.NL;

			// Parameters?
			$parameters = $this->preparedStatement->getParameters();
			if(!empty($parameters)) {
				foreach($parameters as $key => $value) {
					$this->information .= '<strong>SQL parameter '.$key.':</strong> '.StringUtil::encodeHtml($value).'<br />'.NL;
				}
			}
		}
		parent::show();
	}
}
