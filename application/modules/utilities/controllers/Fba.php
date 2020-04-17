<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fba extends Admin_Controller {

	public function index()
	{
		$dir_list = ['media', 'content/language', 'content/themes'];
		if (!empty($_GET['dir']) && in_array($_GET['dir'], $dir_list)) {
			$dir = $_GET['dir'];
		} else {
			$dir = 'content/themes';
		}

		// Load class fba_lib.php
		$this->load->library('fba_lib');
		$this->fba_lib->set_path($dir);

		// Scan direktori
		if(isset($_POST['path'])) {
			// Jalankan fungsi scan->('SUB DIR NAME')
			$res = $this->fba_lib->scan($_POST['path']);

			json_output($res);
		} else if(!empty($_POST['file'])) { // Read file

			// Jalankan fungsi scan->('SUB DIR NAME')
			$res = $this->fba_lib->read($_POST['file']);

			// Output isi file
			json_output($res);
		} else if(!empty($_POST['wfile']) && !empty($_POST['content'])) {

			//phai full quyen
			if (!$this->acl->check_acl()) {
				json_output(['status' => 'error', 'msg' => lang('error_permission_execute')]);
			}

			$res = $this->fba_lib->write($_POST['wfile'], $_POST['content']);

			// Output isi file
			json_output($res);
		}
	}
}
