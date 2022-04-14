<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('login_model');
		date_default_timezone_set('Asia/Jakarta');
		$this->load->library('user_agent');
	}

	public function index()
	{
		//$data['user'] = isset($_POST['username']) ? $_POST['username'] : '';
		$this->load->view('v_login3');
	}

	public function auth()
	{
		$db = $this->load->database('default', TRUE);
		//$db2 = $this->load->database('db2', TRUE);
		$username = htmlspecialchars($this->input->post('username', TRUE), ENT_QUOTES);
		//$password = $this->input->post('password');
		$password = htmlspecialchars($this->input->post('password', TRUE), ENT_QUOTES);
		//$password_hash = md5($password);

		$t = $password;
		$c = strlen($t);
		$teksjadi = '';

		for ($x = 0; $x <= strlen($t) - 1; $x++) {
			$hr = ord($t[$x]);
			//$hr = $t[$x];
			$teksjadi = $teksjadi . sprintf("%03d", $hr + $c * 1);
			//$teksjadi = $teksjadi . $hr;
			$c = $c - 1;
		}

		$t = $teksjadi;
		$teksjadi = '';
		$x = 0;
		while ($x < strlen($t)) {

			$teksjadi = $teksjadi . chr(intval(substr($t, $x, 3)));
			$x = $x + 3;
		}

		$password_hash = $teksjadi;

		$tgl = date('Y-m-d H:i:s');
		$waktu = date('H:i:s');
		$browser = $this->agent->browser() . ' ' . $this->agent->version();
		$os = $this->agent->platform();
		$ip = $this->input->ip_address();
		$noid = date('ymdHis') . preg_replace("/[^0-9]/", "", $ip);
		$cek_user = $this->login_model->cek_user($username, $password_hash);

		if ($cek_user->num_rows() > 0) {
			$data = $cek_user->row_array();
			$userid = $data['NoUser'];
			$username = $data['NmUser'];
			$nama = $data['NmUser'];
			//$akses = $data['akses'];
			//$token = $data['Token'];
			//$akses = $data['Nama'];
			$cek_user_registrasi = $this->login_model->cek_user_registrasi($userid, $username);
			$this->session->set_userdata('masuk', TRUE);
			//$this->session->set_userdata('akses', $akses);
			$this->session->set_userdata('ses_token', $noid);
			$this->session->set_userdata('ses_username', $username);
			$this->session->set_userdata('ses_userid', $userid);
			$this->session->set_userdata('ses_nama', $nama);
			$data = array(
				'NoId'			  => $noid,
				'NmUser'    	  => $username,
				'Tanggal' 		  => $tgl,
				'Jam'			  => $waktu,
				'Keterangan'      => $browser,
				'NmKomputer'      => $os,
				'TCPIP'           => $ip,
			);

			if ($cek_user_registrasi->num_rows() > 0) {
				if ($db <> '') {
					$db->insert('audit_login_user', $data);
					$this->login_model->entry_token($noid, $username, $password_hash);
					echo $this->session->set_flashdata('msg', 'Selamat Datang, ' . $nama . ' ;)');
					redirect('dashboard/', 'refresh');
				} else {
					echo "tidak ada database";
				}
			} else {
				$url = base_url();
				echo $this->session->set_flashdata('msg', 'Silahkan Hubungi Estoh Software! User: ' . $username . ' Tidak Terdaftar :(');
				redirect($url);
			}
		} else {
			$url = base_url();
			echo $this->session->set_flashdata('msg', 'Username atau Password salah! :(');
			redirect($url);
		}
	}
	public function auth_ex()
	{
		$db = $this->load->database('default', TRUE);
		//$db2 = $this->load->database('db2', TRUE);
		$username = htmlspecialchars($this->input->get('username', TRUE), ENT_QUOTES);
		//$password = $this->input->post('password');
		$password = htmlspecialchars($this->input->get('password', TRUE), ENT_QUOTES);
		//$password_hash = md5($password);

		$t = $password;
		$c = strlen($t);
		$teksjadi = '';

		for ($x = 0; $x <= strlen($t) - 1; $x++) {
			$hr = ord($t[$x]);
			//$hr = $t[$x];
			$teksjadi = $teksjadi . sprintf("%03d", $hr + $c * 1);
			//$teksjadi = $teksjadi . $hr;
			$c = $c - 1;
		}

		$t = $teksjadi;
		$teksjadi = '';
		$x = 0;
		while ($x < strlen($t)) {

			$teksjadi = $teksjadi . chr(intval(substr($t, $x, 3)));
			$x = $x + 3;
		}

		$password_hash = $teksjadi;

		$tgl = date('Y-m-d H:i:s');
		$waktu = date('H:i:s');
		$browser = $this->agent->browser() . ' ' . $this->agent->version();
		$os = $this->agent->platform();
		$ip = $this->input->ip_address();
		$noid = date('ymdHis') . preg_replace("/[^0-9]/", "", $ip);
		$cek_user = $this->login_model->cek_user($username, $password_hash);

		if ($cek_user->num_rows() > 0) {
			$data = $cek_user->row_array();
			$username = $data['NmUser'];
			$userid = $data['NoUser'];
			$nama = $data['NmUser'];
			//$akses = $data['akses'];
			$akses = $data['Nama'];
			$cek_user_registrasi = $this->login_model->cek_user_registrasi($userid, $username);

			$this->session->set_userdata('masuk', TRUE);
			$this->session->set_userdata('akses', $akses);
			$this->session->set_userdata('ses_username', $username);
			$this->session->set_userdata('ses_userid', $userid);
			$this->session->set_userdata('ses_nama', $nama);
			$data = array(
				'NoId'			  => $noid,
				'NmUser'    	  => $username,
				'Tanggal' 		  => $tgl,
				'Jam'			  => $waktu,
				'Keterangan'      => $browser,
				'NmKomputer'      => $os,
				'TCPIP'           => $ip,
			);
			if ($cek_user_registrasi->num_rows() > 0) {
				if ($db <> '') {
					$db->insert('audit_login_user', $data);
					$this->login_model->entry_token($noid, $username, $password_hash);
					echo $this->session->set_flashdata('msg', 'Selamat Datang, ' . $nama . ' ;)');
					redirect('dashboard/', 'refresh');
				} else {
					echo "tidak ada database";
				}
			} else {
				$url = base_url();
				echo $this->session->set_flashdata('msg', 'Silahkan Hubungi Estoh Software! :(');
				redirect($url);
			}
		} else {
			$url = base_url();
			echo $this->session->set_flashdata('msg', 'Username atau Password salah! :(');
			redirect($url);
		}
	}

	/* =========================== function untuk ambil tabel setingjual system ====================== */


	public function update_password()
	{
		$username   = $this->session->userdata('ses_username');
		$passlama   = htmlspecialchars($this->input->post('passlama', TRUE), ENT_QUOTES);
		$passbaru   = htmlspecialchars($this->input->post('passbaru', TRUE), ENT_QUOTES);
		$ulangipass = htmlspecialchars($this->input->post('ulangipass', TRUE), ENT_QUOTES);

		/* =================================== proses cek password lama ======================== */
		$t = $passlama;
		$c = strlen($t);
		$teksjadi = '';

		for ($x = 0; $x <= strlen($t) - 1; $x++) {
			$hr = ord($t[$x]);
			//$hr = $t[$x];
			$teksjadi = $teksjadi . sprintf("%03d", $hr + $c * 1);
			//$teksjadi = $teksjadi . $hr;
			$c = $c - 1;
		}

		$t = $teksjadi;
		$teksjadi = '';
		$x = 0;
		while ($x < strlen($t)) {

			$teksjadi = $teksjadi . chr(intval(substr($t, $x, 3)));
			$x = $x + 3;
		}
		$password_hash = $teksjadi;
		$cek_user = $this->login_model->cek_user($username, $password_hash);
		$x = $cek_user->row_array();
		$user = $x['NmUser'];
		//$pass = $x['Pasword'];
		/* =============================================== end password lama ==================================== */

		$uri = base_url('dashboard/gantipassword/');

		/* =================================== proses konvert input pass baru ke database ======================== */
		$t = $passbaru;
		$c = strlen($t);
		$teksjadi = '';

		for ($x = 0; $x <= strlen($t) - 1; $x++) {
			$hr = ord($t[$x]);
			$teksjadi = $teksjadi . sprintf("%03d", $hr + $c * 1);
			$c = $c - 1;
		}

		$t = $teksjadi;
		$teksjadi = '';
		$x = 0;
		while ($x < strlen($t)) {

			$teksjadi = $teksjadi . chr(intval(substr($t, $x, 3)));
			$x = $x + 3;
		}
		$password_baru = strtoupper($teksjadi);
		/* ================================ end password baru ========================================== */

		if ($user == '') {
			echo $this->session->set_flashdata('error', 'password lama salah :(');
			header("Location: " . $uri, TRUE, $http_response_code);
		} else if ($passbaru == '') {
			echo $this->session->set_flashdata('error', 'Password Baru  tidak boleh kosong :(');
			header("Location: " . $uri, TRUE, $http_response_code);
		} else if ($passbaru <> $ulangipass) {
			echo $this->session->set_flashdata('error', 'Password Baru tidak sama dengan ulangi password baru :(');
			header("Location: " . $uri, TRUE, $http_response_code);
		} else {
			$this->login_model->update_password($username, $password_baru);
			echo $this->session->set_flashdata('error', 'ganti password sukses :(');
			header("Location: " . $uri, TRUE, $http_response_code);
		}
	}
	public function cek_session()
	{
		$username = $this->session->userdata('ses_username');
		$session = $this->session->userdata('ses_token');
		$cek = $this->login_model->cek_session($username)->row_array();
		$token = $cek['device_id'];

		if ($token != $session) {
			$data['output'] = 'logout';
		} else {
			$data['output'] = 'login';
		}
		echo json_encode($data);
	}
	public function logout()
	{
		$this->session->sess_destroy();
		$url = base_url();
		redirect($url);
	}
}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */