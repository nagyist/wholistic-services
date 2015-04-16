<?php
namespace Testeleven\Schedule\Registry;

class Scheduled_Class_Registry {
	/**
	 * Array to store items
	 *
	 * @var array
	 */
	private $_objects = array();

	/**
	 * Stores the registry object
	 *
	 * @var Scheduled_Class_Registry
	 */
	private static $_instance = null;

	/**
	 * Get the instance
	 *
	 */
	public static function get_instance() {
		if (is_null(self::$_instance)) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Constructor
	 *
	 * @access private
	 */
	private function __construct() {}

	/**
	 * Set an item by given key and value
	 *
	 * @param string $key
	 * @param void $value
	 * @return void
	 */
	public function __set($key, $value) {
		$this->_objects[$key] = $value;
	}

	/**
	 * Get an item by key
	 *
	 * @param string $key Identifier for the registry item
	 *
	 * @return null
	 */
	public function __get($key) {
		if (isset($this->_objects[$key])) {
			$result = $this->_objects[$key];
		} else {
			$result = null;
		}
		return $result;
	}

	/**
	 * Check if an item with a given key exists
	 *
	 * @param string $key
	 *
	 * @return bool
	 */
	public function __isset($key) {
		return isset($this->_objects[$key]);
	}

	/**
	 * Delete an item with the given key
	 *
	 * @param string $key
	 * @return void
	 */
	public function __unset($key) {
		unset($this->_objects[$key]);
	}

	/**
	 * Make clone private, so noone can clone the instance
	 *
	 * @return void
	 */
	private function __clone() {}
}