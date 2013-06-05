<?php
/**
 * @author    Janek Ostendorf (ozzy) <ozzy2345de@gmail.com>
 * @copyright Copyright (c) 2013 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

/**
 * Something bad happened
 */
class CoreException extends LoggedException implements IPrintableException {
	/**
	 * @param string    $message     Error message
	 * @param int       $code        Error code
	 * @param string    $description Error description
	 * @param Exception $previous    Repacked exception
	 */
	public function __construct($message = '', $code = 0, $description = '', Exception $previous = null) {
		parent::__construct((string)$message, (int)$code, $previous);
		$this->description = $description;
	}

	/**
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Remove delicate information from stack trace
	 * @see Exception::getTraceAsString()
	 * @return string
	 */
	public function __getTraceAsString() {
		$e = ($this->getPrevious() ? : $this);
		$string = preg_replace('/Database->__construct\(.*\)/', 'Database->__construct(...)', $e->getTraceAsString());
		$string = preg_replace('/mysqli->mysqli\(.*\)/', 'mysqli->mysqli(...)', $string);
		return $string;
	}

	/**
	 * Print this exception
	 * @return void
	 */
	public function show() {
		// Try to log this shit
		$id = $this->logError();

		/* Print HTML */
		@header('HTTP/1.1 503 Service Unavailable');
		$e = ($this->getPrevious() ? : $this);
		?>

		<!DOCTYPE html>
		<html>
			<head>
				<title>Fatal error: <?= StringUtil::encodeHtml($this->_getMessage()) ?></title>
				<meta charset='utf-8'>
			</head>
			<body>
				<div class="coreException">
					<h1>Fatal error: <?= StringUtil::encodeHtml($this->_getMessage()) ?></h1>
					<?php if(Silex::isDebug()): ?>
						<div>
							<p><?= $this->getDescription() ?></p>

							<h2>Information</h2>

							<p>
								<strong>ID:</strong> <code><?= $id ?></code><br>
								<strong>Error message:</strong> <?= StringUtil::encodeHtml($this->_getMessage()) ?>
								<br>
								<strong>Error code:</strong> <?= intval($e->getCode()) ?>
								<br>
								<?= $this->information ?>
								<strong>File:</strong> <?= StringUtil::encodeHtml($e->getFile().':'.$e->getLine()) ?><br>
								<strong>Time:</strong> <?= gmdate('r'); ?><br>
								<strong>Request:</strong> <?= isset($_SERVER['REQUEST_URI']) ? StringUtil::encodeHtml($_SERVER['REQUEST_URI']) : '' ?><br>
								<strong>Referer:</strong> <?= isset($_SERVER['HTTP_REFERER']) ? StringUtil::encodeHtml($_SERVER['HTTP_REFERER']) : '' ?><br>
							</p>

							<h2>Stacktrace</h2>
							<pre><?= StringUtil::encodeHtml($this->__getTraceAsString()) ?></pre>

						</div>
					<?php else: ?>
						<div>
							<h2>Information:</h2>

							<p>
								<b>ID:</b> <code><?php echo $id; ?></code><br>
								Send this ID to the administrator of this website to report this issue.
							</p>
						</div>
					<?php endif; ?>
				</div>
			</body>
		</html>
	<?php
	}
}
