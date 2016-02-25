<?php
class Dao_Impl {
	var $db;
	const SALT_VALUE = '|@ranranba';

	public function __construct() {
		$this->db = new ezSQL_mysql(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
		$this->db->query('set names utf8');
	}

	public static function validate_field_not_null($field) {
		return $field !== NULL;
	}

	public static function validate_field_not_empty($field) {
		return !empty($field);
	}

	public static function validate_field_max_length($field, $length) {
		return String_Util::strlen_utf8($field) > $length ? FALSE : TRUE;
	}

	public static function validate_mobile($field) {
		$p = '/^1[3458][0-9]{9}$/';
		return preg_match($p, $field);
	}

	public static function validate_id($id) {
		if (Validate_Util::my_is_int($id) && $id > 0) {
			return TRUE;
		}
		return FALSE;
	}
}
