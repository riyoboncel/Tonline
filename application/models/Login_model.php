<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_model extends CI_Model
{
	// db2 digunakan untuk mengakses database ke-2
	private $db;

	public function __construct()
	{
		//parent::__construct();
		$this->db = $this->load->database('db2', TRUE);
	}
	public function cek_user($username, $password_hash)
	{
		return $this->db->select('*')
			->where('NmUser', $username)
			//->where('SalesJual','1')
			->where('Pasword', $password_hash)
			->get('systemuser');
		$this->db->limit(1);
	}
	public function cek_user_registrasi($userid, $username)
	{
		return $this->db->select('*')
			//->where('device_id', $userid)
			->where('device_name', $username)
			->get('list');
		//$this->db->limit(1);
	}
	public function entry_token($noid, $username, $password_hash)
	{
		//return $this->db->query("UPDATE systemuser SET Token = '$noid' WHERE nmuser = '$username' AND pasword = '$password_hash' ");
		return $this->db->query("UPDATE list SET device_id = '$noid' WHERE device_name = '$username' ");
	}

	public function cek_session($username)
	{
		//return $this->db->query("SELECT * FROM systemuser WHERE nmuser = '$username' LIMIT 1 ");
		return $this->db->query("SELECT * FROM list WHERE device_name = '$username' LIMIT 1 ");
	}

	public function lokasiawal($id_user)
	{
		return $this->db->select('*')
			->where('NoUser', $id_user)
			->get('systemuser');
		$this->db->limit(1);
	}

	public function seting()
	{
		return $this->db->select('*')
			->get('seting');
	}

	public function sistemuser($username)
	{
		return $this->db->select('*')
			->where('NmUser', $username)
			->get('systemuser');
		//$this->db->limit(1);
	}
	public function systemuser($id_user)
	{
		return $this->db->select('*')
			->where('NoUser', $id_user)
			->get('systemuser');
	}

	public function update_password($username, $password_baru)
	{
		$this->db->query("UPDATE systemuser set Pasword = '$password_baru' WHERE NmUser = '$username' ");
	}

	/* =========================== function untuk ambil tabel setingjual system ====================== */
	public function setingjual()
	{
		return $this->db->select('*')
			->get('setingjual');
	}
}

/* End of file Login_model.php */
/* Location: ./application/models/Login_model.php */