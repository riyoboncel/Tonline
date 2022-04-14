<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		//validasi jika user belum login
		if ($this->session->userdata('masuk') != TRUE) {
			$url = base_url();
			redirect($url);
		}
		$this->load->model('dashboard_model');
		$this->load->model('login_model');
		$this->load->model('barang_model');
		$this->load->helper('random');
	}

	public function index()
	{
		//echo $this->db->database; untuk mengambil nama database
		$tanggal = date('Y-m-d');
		$username = $this->session->userdata('ses_username');

		//$setting['token'] = $this->session->userdata('ses_token');
		$setting['user'] = $this->login_model->sistemuser($username)->row();
		$setting['seting'] = $this->login_model->seting()->row();
		$setting['tbrg'] = $this->barang_model->totalbarang()->row();
		$setting['tcust'] = $this->barang_model->totalcustomer()->row();
		$setting['total'] = $this->dashboard_model->total_penjualan_user($tanggal, $username)->row();
		$this->load->view('header', $setting);
		$this->load->view('dashboard', $setting);
		$this->load->view('footers');
	}

	public function gantipassword()
	{
		$username = $this->session->userdata('ses_username');
		$setting['user'] = $this->login_model->sistemuser($username)->row();
		$setting['seting'] = $this->login_model->seting()->row();
		$this->load->view('header', $setting);
		$this->load->view('gantipassword', $setting);
		$this->load->view('footers');
	}
}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */