<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Grafik extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		//validasi jika user belum login
		if ($this->session->userdata('masuk') != TRUE) {
			$url = base_url();
			redirect($url);
		}

		/*
		if ($this->session->userdata('akses') != 'manager') {
			$url = base_url('dashboard/');
			redirect($url);
		}
		*/

		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('grafik_model');
		$this->load->model('kasir_model');
		$this->load->model('login_model');
	}

	public function stok_barang()
	{
		$data['report'] = $this->grafik_model->statistik_stok();
		$username = $this->session->userdata('ses_username');
		$setting['user'] = $this->login_model->sistemuser($username)->row();
		$setting['seting'] = $this->login_model->seting()->row();

		$this->load->view('header', $setting);
		$this->load->view('grafik/grafik_stok_barang', $data);
	}

	public function penjualan_bulanan()
	{
		$data['year'] = date('Y');
		$data['bulan'] = date('m');
		$data['tahun'] = $this->grafik_model->getTahunJual()->result_array();
		$username = $this->session->userdata('ses_username');
		$setting['user'] = $this->login_model->sistemuser($username)->row();
		$setting['seting'] = $this->login_model->seting()->row();

		$this->load->view('header', $setting);
		$this->load->view('grafik/pilih_bulan', $data);
	}

	public function profit_bulanan()
	{
		$data['year'] = date('Y');
		$data['bulan'] = date('m');
		$data['tahun'] = $this->grafik_model->getTahunJual()->result_array();
		$username = $this->session->userdata('ses_username');
		$setting['user'] = $this->login_model->sistemuser($username)->row();
		$setting['seting'] = $this->login_model->seting()->row();

		$this->load->view('header', $setting);
		$this->load->view('grafik/pilih_bulan_profit', $data);
		$this->load->view('footers');
	}

	public function grafik_penjualan_bulanan()
	{
		$kodedata = 'tusd_';
		$tahun = $this->input->post('tahun');
		$bulan = $this->input->post('bulan');
		$data['nama_bulan'] = array(
			'01' => 'Januari',
			'02' => 'Februari',
			'03' => 'Maret',
			'04' => 'April',
			'05' => 'Mei',
			'06' => 'Juni',
			'07' => 'Juli',
			'08' => 'Agustus',
			'09' => 'September',
			'10' => 'Oktober',
			'11' => 'November',
			'12' => 'Desember',
		);
		$data['report'] = $this->grafik_model->graf_penjualan_perbulan($kodedata, $tahun, $bulan);
		$data['bln'] = $bulan;
		$data['thn'] = $tahun;
		$username = $this->session->userdata('ses_username');
		$setting['user'] = $this->login_model->sistemuser($username)->row();
		$setting['seting'] = $this->login_model->seting()->row();

		$this->load->view('header', $setting);
		$this->load->view('grafik/grafik_penjualan_perbulan', $data);
		$this->load->view('footers');
	}

	public function grafik_profit_bulanan()
	{
		$kodedata = 'tusd_';
		$tahun = $this->input->post('tahun');
		$bulan = $this->input->post('bulan');
		$data['nama_bulan'] = array(
			'01' => 'Januari',
			'02' => 'Februari',
			'03' => 'Maret',
			'04' => 'April',
			'05' => 'Mei',
			'06' => 'Juni',
			'07' => 'Juli',
			'08' => 'Agustus',
			'09' => 'September',
			'10' => 'Oktober',
			'11' => 'November',
			'12' => 'Desember',
		);
		$data['report'] = $this->grafik_model->graf_profit_perbulan($kodedata, $tahun, $bulan);
		$data['diskon'] = $this->grafik_model->getDiskon($kodedata, $tahun, $bulan);
		$data['bln'] = $bulan;
		$data['thn'] = $tahun;
		$username = $this->session->userdata('ses_username');
		$setting['user'] = $this->login_model->sistemuser($username)->row();
		$setting['seting'] = $this->login_model->seting()->row();

		$this->load->view('header', $setting);
		$this->load->view('grafik/grafik_profit_perbulan', $data);
		$this->load->view('footers');
	}

	public function penjualan_tahun()
	{
		date_default_timezone_set('Asia/Jakarta');
		$data['year'] = date('Y');
		$data['tahun'] = $this->grafik_model->getTahunJual()->result_array();
		$username = $this->session->userdata('ses_username');
		$setting['user'] = $this->login_model->sistemuser($username)->row();
		$setting['seting'] = $this->login_model->seting()->row();

		$this->load->view('header', $setting);
		$this->load->view('grafik/pilih_tahun', $data);
		$this->load->view('footers');
	}

	public function grafik_penjualan_tahunan()
	{
		$kodedata = 'tusd_';
		$tahun = $this->input->post('tahun');
		$data['report'] = $this->grafik_model->graf_penjualan_pertahun($kodedata, $tahun);
		$data['thn'] = $tahun;
		$username = $this->session->userdata('ses_username');
		$setting['user'] = $this->login_model->sistemuser($username)->row();
		$setting['seting'] = $this->login_model->seting()->row();

		$this->load->view('header', $setting);
		$this->load->view('grafik/grafik_penjualan_pertahun', $data);
		$this->load->view('footers');
	}
}

/* End of file Grafik.php */
/* Location: ./application/controllers/Grafik.php */