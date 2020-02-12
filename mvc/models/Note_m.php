<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Note_m extends MY_Model {

	protected $_table_name = 'note';
	protected $_primary_key = 'id';
	protected $_primary_filter = 'intval';
	protected $_order_by = "id asc";

	public function __construct() {
		parent::__construct();
	}

	public function get_note($array=NULL, $signal=FALSE) {
		$query = parent::get($array, $signal);
		return $query;
	}

	public function get_single_note($array) {
		$query = parent::get_single($array);
		return $query;
	}

	public function get_order_by_note($array=NULL) {
		$query = parent::get_order_by($array);
		return $query;
	}

	public function insert_note($array) {
		$error = parent::insert($array);
		return TRUE;
	}

	public function update_note($data, $id = NULL) {
		parent::update($data, $id);
		return $id;
	}

	public function delete_note($id){
		parent::delete($id);
	}
}

/* End of file note_m.php */
/* Location: .//D/xampp/htdocs/school/mvc/models/exam_m.php */
