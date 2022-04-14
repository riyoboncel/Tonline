<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rekap_jual extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        //validasi jika user belum login
        if ($this->session->userdata('masuk') != TRUE) {
            $url = base_url();
            redirect($url);
        }

        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('rekap_jual_model');
        $this->load->model('login_model');
        $this->load->helper('random');
    }
    public function index()
    {
        $username = $this->session->userdata('ses_username');
        $setting['user'] = $this->login_model->sistemuser($username)->row();
        $setting['seting'] = $this->login_model->seting()->row();

        $this->load->view('header', $setting);
        $this->load->view('rekap_penjualan/info.php');
        $this->load->view('footers');
    }

    public function rekap_penjualan_perbarang()
    {
        $data['judul'] = "Barang";
        $KodeData = substr($this->db->database, 0, 5);
        $jkode = strlen($KodeData) + 1; // jumlah karakter kode
        $tahunbulan   = $this->rekap_jual_model->schema($KodeData, $jkode)->result_array(); // hasilnya array tahunbulan (202201)
        $filter = $this->input->post('filter');
        $data['year'] = $this->rekap_jual_model->getTahunJual($KodeData, $jkode)->result_array();
        //$data['tahunx'] = $this->rekap_jual_model->getTahunJual()->result_array();
        $uri = base_url('rekap_jual/rekap_penjualan_perbarang/');
        if ($filter == "ok") {
            $tahun = $data['tahun'] = $this->input->post('tahun');
            $bulan = $data['bulan'] = $this->input->post('bulan');
            $cek = $this->rekap_jual_model->cek_tahun_bulan($KodeData, $tahun, $bulan, $jkode);

            if ($cek->num_rows() > 0) {
                $data['rekap'] = $this->rekap_jual_model->getDataRekapPerbarang($KodeData, $tahun, $bulan)->result();
            } else {
                echo $this->session->set_flashdata('error',  'Tahun atau Bulan Tidak Tersedia:(');
                header("Location: " . $uri, TRUE, $http_response_code = 0);
            }
        } else {
            $tahun = $data['tahun'] = date('Y');
            $bulan = $data['bulan'] = date('m');
            $data['rekap'] = $this->rekap_jual_model->getDataRekapPerbarang($KodeData, $tahun, $bulan)->result();
            //$data['diskon'] = $this->rekap_jual_model->getDiskon($KodeData, $tahun, $bulan)->result();
        }
        $data['aa'] = 0;
        $data['bb'] = 0;
        $data['cc'] = 0;
        $data['dd'] = 0;
        $data['ee'] = 0;
        $username = $this->session->userdata('ses_username');
        $setting['user'] = $this->login_model->sistemuser($username)->row();
        $setting['seting'] = $this->login_model->seting()->row();
        $this->load->view('header', $setting);
        $this->load->view('rekap_penjualan/rekap_perbarang', $data);
        $this->load->view('footers');
    }

    public function rekap_penjualan_percustomer()
    {
        $data['judul'] = "Customer";
        $KodeData = substr($this->db->database, 0, 5);
        $jkode = strlen($KodeData) + 1; // jumlah karakter kode
        $tahunbulan   = $this->rekap_jual_model->schema($KodeData, $jkode)->result_array(); // hasilnya array tahunbulan 
        $filter = $this->input->post('filter');
        $data['year'] = $this->rekap_jual_model->getTahunJual($KodeData, $jkode)->result_array();
        //$data['tahunx'] = $this->rekap_jual_model->getTahunJual()->result_array();
        $uri = base_url('rekap_jual/rekap_penjualan_percustomer/');
        if ($filter == "ok") {
            $tahun = $data['tahun'] = $this->input->post('tahun');
            $bulan = $data['bulan'] = $this->input->post('bulan');
            $cek = $this->rekap_jual_model->cek_tahun_bulan($KodeData, $tahun, $bulan, $jkode);

            if ($cek->num_rows() > 0) {
                $data['rekap'] = $this->rekap_jual_model->getDataRekapPercustomer($KodeData, $tahun, $bulan)->result();
            } else {
                echo $this->session->set_flashdata('error',  'Tahun atau Bulan Tidak Tersedia:(');
                header("Location: " . $uri, TRUE, $http_response_code = 0);
            }
        } else {
            $tahun = $data['tahun'] = date('Y');
            $bulan = $data['bulan'] = date('m');
            $data['rekap'] = $this->rekap_jual_model->getDataRekapPercustomer($KodeData, $tahun, $bulan)->result();
            //$data['diskon'] = $this->rekap_jual_model->getDiskon($KodeData, $tahun, $bulan)->result();
        }
        $data['aa'] = 0;
        $data['bb'] = 0;
        $data['cc'] = 0;
        $data['dd'] = 0;
        $data['ee'] = 0;
        $username = $this->session->userdata('ses_username');
        $setting['user'] = $this->login_model->sistemuser($username)->row();
        $setting['seting'] = $this->login_model->seting()->row();
        $this->load->view('header', $setting);
        $this->load->view('rekap_penjualan/rekap_percustomer', $data);
        $this->load->view('footers');
    }
    public function rekap_penjualan_pertanggal()
    {
        $data['judul'] = "Tanggal";
        $KodeData = substr($this->db->database, 0, 5);
        $jkode = strlen($KodeData) + 1; // jumlah karakter kode
        $filter = $this->input->post('filter');
        $data['year'] = $this->rekap_jual_model->getTahunJual($KodeData, $jkode)->result_array();

        $uri = base_url('rekap_jual/rekap_penjualan_pertanggal/');
        if ($filter == "ok") {
            $tahun = $data['tahun'] = $this->input->post('tahun');
            $bulan = $data['bulan'] = $this->input->post('bulan');
            $cek = $this->rekap_jual_model->cek_tahun_bulan($KodeData, $tahun, $bulan, $jkode);

            if ($cek->num_rows() > 0) {
                $data['rekap'] = $this->rekap_jual_model->getDataRekapPertanggal($KodeData, $tahun, $bulan)->result();
            } else {
                echo $this->session->set_flashdata('error',  'Tahun atau Bulan Tidak Tersedia:(');
                header("Location: " . $uri, TRUE, $http_response_code = 0);
            }
        } else {
            $tahun = $data['tahun'] = date('Y');
            $bulan = $data['bulan'] = date('m');
            $data['rekap'] = $this->rekap_jual_model->getDataRekapPertanggal($KodeData, $tahun, $bulan)->result();
        }
        $data['aa'] = 0;
        $data['bb'] = 0;
        $data['cc'] = 0;
        $data['dd'] = 0;
        $data['ee'] = 0;
        $username = $this->session->userdata('ses_username');
        $setting['user'] = $this->login_model->sistemuser($username)->row();
        $setting['seting'] = $this->login_model->seting()->row();
        $this->load->view('header', $setting);
        $this->load->view('rekap_penjualan/rekap_pertanggal', $data);
        $this->load->view('footers');
    }
}

/* End of file Laporan.php */
/* Location: ./application/controllers/Laporan.php */