<?php
/**
 * @author    Patrick Kleinschmidt (NoxNebula) <noxifoxi@gmail.com>
 * @copyright Copyright (c) 2013 SilexLab
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

class SessionDatabaseHandler implements SessionHandlerInterface {
	private $db = null;
	private $table = '';

	public function __construct(Database $db, $table) {
		$this->db = $db;
		$this->table = $table;
	}

	public function open($save_path, $session_id) {
		return true;
	}

	public function close() {
		return true;
	}

	public function read($session_id) {
		$s = $this->db->prepare('SELECT * FROM `'.$this->table.'` WHERE `id` = :id LIMIT 1');
		$s->execute([':id' => $session_id]);
		$result = $s->fetchObject();
		if($result)
			return $result->session_value;
		return '';
	}

	public function write($session_id, $session_data) {
		$s = $this->db->prepare('SELECT COUNT(*) FROM `'.$this->table.'` WHERE `id` = :id');
		$s->execute([':id' => $session_id]);
		if($s->fetchArray()['COUNT(*)'] == 0) {
			$s = $this->db->prepare('INSERT INTO `'.$this->table.'` (`id`, `session_value`, `last_activity_time`) VALUES (:id, :value, :time)');
			return (bool)$s->execute([':id' => $session_id, ':value' => $session_data, ':time' => time()]);
		}

		$s = $this->db->prepare('UPDATE `'.$this->table.'` SET `session_value` = :value, `last_activity_time` = :time WHERE `id` = :id');
		return (bool)$s->execute([':id' => $session_id, ':value' => $session_data, ':time' => time()]);
	}

	public function destroy($session_id) {
		$s = $this->db->prepare('DELETE FROM `'.$this->table.'` WHERE `id` = :id');
		return (bool)$s->execute([':id' => $session_id]);
	}

	public function gc($maxlifetime) {
		$s = $this->db->prepare('DELETE FROM `'.$this->table.'` WHERE `last_activity_time` < :time');
		return (bool)$s->execute([':time' => time() - $maxlifetime]);
	}
}
