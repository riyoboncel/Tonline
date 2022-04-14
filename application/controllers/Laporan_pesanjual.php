<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_pesanjual extends CI_Controller
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
        $this->load->model('laporan_pesanjual_model');
        $this->load->model('login_model');
        $this->load->helper('random');
    }

    public function index()
    {
    }
    public function laporan_daftar_pesanjual()
    {
        $data['tampilpesanjual'] = $this->laporan_pesanjual_model->tampilpesanjual();
        $data['no'] = 1;

        $username = $this->session->userdata('ses_username');
        $setting['user'] = $this->login_model->sistemuser($username)->row();
        $setting['seting'] = $this->login_model->seting()->row();

        $this->load->view('header', $setting);
        $this->load->view('laporan_pesanjual/tampil-pesanjual', $data);
        $this->load->view('footers');
    }
    public function detail_daftar_pesanjual()
    {
        $nofaktur = urldecode($this->uri->segment(3));
        $data['detailpesanjual'] = $this->laporan_pesanjual_model->detaildaftarpesanjual($nofaktur);
        $data['no'] = 1;
        $data['faktur'] = $this->laporan_pesanjual_model->detaildaftarpesanjual($nofaktur)->row();
        $data['subtotal'] = 0;

        $username = $this->session->userdata('ses_username');
        $setting['user'] = $this->login_model->sistemuser($username)->row();
        $setting['seting'] = $this->login_model->seting()->row();

        $this->load->view('header', $setting);
        $this->load->view('laporan_pesanjual/detail-daftar-pesanjual', $data);
        $this->load->view('footers');
    }



    public function lap_jumlah_pesanjual()
    {
        $kodedata = substr($this->db->database, 0, 5);
        $tanggal = date('Y-m-d');
        $tahun = date('Y');
        $bulan = date('m');
        $data['jumlahpesan'] = $this->laporan_pesanjual_model->lapjumlahpesanjual($kodedata, $tahun, $bulan);

        $username = $this->session->userdata('ses_username');
        $setting['user'] = $this->login_model->sistemuser($username)->row();
        $setting['seting'] = $this->login_model->seting()->row();

        $this->load->view('header', $setting);
        $this->load->view('laporan_pesanjual/lap-jumlah-pesanjual');
        $this->load->view('footers');
    }
    public function lap_total_pesanjual()
    {
    }
    public function rekap_pesanjual_percustomer()
    {
    }




    public function penjualan_transaksi()
    {
        //$KodeData = 'tusd_';
        $tanggal = date('Y-m-d');
        $filter = $this->input->get('filter');
        $a = $this->input->get('a'); //tanggal awal
        $b = $this->input->get('b'); //bulan awal
        $c = $this->input->get('c'); //tahun awal

        $d = $this->input->get('d'); //tanggal akhir
        $e = $this->input->get('e'); //bulan akhir
        $f = $this->input->get('f'); //tahun akhir
        $tgl_awal = $c . "-" . $b . "-" . $a;
        $tgl_akhir = $f . "-" . $e . "-" . $d;
        $data['tgl'] = date('d');
        $data['bln'] = date('m');
        $data['thn'] = date('Y');
        $data['no'] = 1;
        $data['subtot'] = 0;
        $data['diskon'] = 0;
        $data['grandtot'] = 0;
        $data['cash'] = 0;
        $data['debet'] = 0;
        $data['tanggal'] = $tanggal;
        $data['awal'] = $tgl_awal;
        $data['akhir'] = $tgl_akhir;
        $data['filter'] = $filter;
        $username = $this->session->userdata('ses_username');
        $setting['user'] = $this->login_model->sistemuser($username)->row();
        $seting['seting'] = $this->login_model->seting()->row();

        if ($filter == "ok") {
            $data['penjualan'] = $this->laporan_pesanjual_model->getDataPenjualanTransaksiFilter($tgl_awal, $tgl_akhir);
        } else {
            $data['penjualan'] = $this->laporan_pesanjual_model->getDataPenjualanTransaksi($tanggal);
        }
        $this->load->view('header', $seting);
        $this->load->view('laporan/penjualan/penjualan_transaksi', $data);
        $this->load->view('footer');
    }

    public function penjualan_barang()
    {
        $KodeData = 'tusd_';
        //$kode = substr($this->db->database, 0, 5);
        $tanggal = date('Y-m-d');
        $filter = $this->input->get('filter');
        $a = $this->input->get('a'); //tanggal awal
        $b = $this->input->get('b'); //bulan awal
        $c = $this->input->get('c'); //tahun awal

        $d = $this->input->get('d'); //tanggal akhir
        $e = $this->input->get('e'); //bulan akhir
        $f = $this->input->get('f'); //tahun akhir
        $tgl_awal = $c . "-" . $b . "-" . $a;
        $tgl_akhir = $f . "-" . $e . "-" . $d;
        // tambahan
        $bawal = $b;
        $bakhir = $e;
        $tawal = $c;
        $takhir = $f;


        $data['tgl'] = date('d');
        $data['bln'] = date('m');
        $data['thn'] = date('Y');
        $data['no'] = 1;
        $data['tot'] = 0;
        $data['tanggal'] = $tanggal;
        $data['awal'] = $tgl_awal;
        $data['akhir'] = $tgl_akhir;
        $data['filter'] = $filter;

        if ($filter == "ok") {
            $data['penjualan'] = $this->laporan_pesanjual_model->getDataPenjualanBarangFilter($tawal, $takhir, $bawal, $bakhir, $KodeData);
        } else {
            $data['penjualan'] = $this->laporan_pesanjual_model->getDataPenjualanBarang($tanggal);
        }
        $username = $this->session->userdata('ses_username');
        $setting['user'] = $this->login_model->sistemuser($username)->row();
        $setting['seting'] = $this->login_model->seting()->row();

        $this->load->view('header', $setting);
        $this->load->view('laporan/penjualan/penjualan_barang', $data);
        $this->load->view('footer');
    }

    public function profit()
    {
        $tanggal = date('Y-m-d');
        $filter = $this->input->get('filter');
        $startdate = $this->input->get('startdate'); //tahun bulan tanggal awal
        $enddate = $this->input->get('enddate'); //tahun bulan tanggal akhir

        if ($filter == "ok") {
            if ($startdate == "" or $enddate == "") {
                $data['no'] = 1;
                $data['noo'] = 1;
                $data['tot_item'] = 0;
                $data['tot_modal'] = 0;
                $data['tot_pendapatan'] = 0;
                $data['tot_profit'] = 0;
                $data['totbiaya'] = 0;
                $data['tanggal'] = $tanggal;
                $data['awal'] = $startdate;
                $data['akhir'] = $enddate;
                $data['filter'] = $filter;
                $data['profit'] = $this->laporan_pesanjual_model->getDataProfit1($tanggal);
                $data['subdiskon'] = $this->laporan_pesanjual_model->getDiskonBarang1($tanggal)->row();
                $data['subdisakhir'] = $this->laporan_pesanjual_model->getDiskonAkhir1($tanggal)->row();
            } else {
                $data['no'] = 1;
                $data['noo'] = 1;
                $data['tot_item'] = 0;
                $data['tot_modal'] = 0;
                $data['tot_pendapatan'] = 0;
                $data['tot_profit'] = 0;
                $data['totbiaya'] = 0;
                $data['tanggal'] = $tanggal;
                $data['awal'] = $startdate;
                $data['akhir'] = $enddate;
                $data['filter'] = $filter;
                $data['profit'] = $this->laporan_pesanjual_model->getDataProfit($startdate, $enddate);
                $data['subdiskon'] = $this->laporan_pesanjual_model->getDiskonBarang($startdate, $enddate)->row();
                $data['subdisakhir'] = $this->laporan_pesanjual_model->getDiskonAkhir($startdate, $enddate)->row();
            }
        } else {
            $data['no'] = 1;
            $data['noo'] = 1;
            $data['tot_item'] = 0;
            $data['tot_modal'] = 0;
            $data['tot_pendapatan'] = 0;
            $data['tot_profit'] = 0;
            $data['totbiaya'] = 0;
            $data['tanggal'] = $tanggal;
            $data['awal'] = $startdate;
            $data['akhir'] = $enddate;
            $data['filter'] = $filter;
            $data['profit'] = $this->laporan_pesanjual_model->getDataProfit1($tanggal);
            $data['subdiskon'] = $this->laporan_pesanjual_model->getDiskonBarang1($tanggal)->row();
            $data['subdisakhir'] = $this->laporan_pesanjual_model->getDiskonAkhir1($tanggal)->row();
        }

        $username = $this->session->userdata('ses_username');
        $setting['user'] = $this->login_model->sistemuser($username)->row();
        $setting['seting'] = $this->login_model->seting()->row();

        $this->load->view('header', $setting);
        $this->load->view('laporan/penjualan/profit', $data);
        $this->load->view('footers');
    }

    public function rekap_perbarang()
    {
        $data['year'] = date('Y');
        $data['bulan'] = date('m');
        $data['tahun'] = $this->laporan_pesanjual_model->getTahunJual()->result_array();
        $username = $this->session->userdata('ses_username');
        $setting['user'] = $this->login_model->sistemuser($username)->row();
        $setting['seting'] = $this->login_model->seting()->row();

        $this->load->view('header', $setting);
        $this->load->view('laporan/penjualan/pilih_bulan_barang', $data);
        $this->load->view('footers');
    }
    public function rekap_penjualan_perbarang()
    {
        $KodeData = substr($this->db->database, 0, 5);
        $tahun = $this->input->post('tahun');
        $bulan = $this->input->post('bulan');
        $data_rekap = $this->laporan_pesanjual_model->getDataRekapPerbarang($KodeData, $tahun, $bulan)->result();
        $data['diskon'] = $this->laporan_pesanjual_model->getDiskon($KodeData, $tahun, $bulan)->result();
        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $data['rekap'] = $data_rekap;
        $data['aa'] = 0;
        $data['bb'] = 0;
        $data['cc'] = 0;
        $data['dd'] = 0;
        $data['ee'] = 0;

        $username = $this->session->userdata('ses_username');
        $setting['user'] = $this->login_model->sistemuser($username)->row();
        $setting['seting'] = $this->login_model->seting()->row();
        $this->load->view('header', $setting);
        $this->load->view('laporan/penjualan/lap_rekap_perbarang', $data);
        $this->load->view('footers');
    }


    public function rekap()
    {
        $data['year'] = date('Y');
        $data['bulan'] = date('m');
        $data['tahun'] = $this->laporan_pesanjual_model->getTahunJual()->result_array();
        $username = $this->session->userdata('ses_username');
        $setting['user'] = $this->login_model->sistemuser($username)->row();
        $setting['seting'] = $this->login_model->seting()->row();

        $this->load->view('header', $setting);
        $this->load->view('laporan/penjualan/pilih_bulan', $data);
        $this->load->view('footers');
    }

    public function rekap_penjualan()
    {
        $KodeData = 'tusd_';
        $tahun = $this->input->post('tahun');
        $bulan = $this->input->post('bulan');
        $data_rekap = $this->laporan_pesanjual_model->getDataRekap($KodeData, $tahun, $bulan)->result();
        $data['diskon'] = $this->laporan_pesanjual_model->getDiskon($KodeData, $tahun, $bulan)->result();
        //$data['toko'] = $this->laporan_pesanjual_model->get_toko();
        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $data['rekap'] = $data_rekap;
        $data['aa'] = 0;
        $data['bb'] = 0;
        $data['cc'] = 0;
        $data['dd'] = 0;
        $data['ee'] = 0;
        $data['ff'] = 0;
        $data['gg'] = 0;
        $data['tot'] = 0;
        $data['tot_a'] = 0;
        $data['tot_b'] = 0;
        $data['tot_c'] = 0;
        $data['tot_d'] = 0;
        $data['tot_tot'] = 0;
        //$data['biaya'] = $this->laporan_pesanjual_model->getDataPengeluaranRekapitulasi($tahun, $bulan);
        $username = $this->session->userdata('ses_username');
        $setting['user'] = $this->login_model->sistemuser($username)->row();
        $setting['seting'] = $this->login_model->seting()->row();

        $this->load->view('header', $setting);
        $this->load->view('laporan/penjualan/lap_rekap', $data);
        $this->load->view('footer');
    }


    /* ====================================================================================== */

    public function laporan_faktur_jual()
    {
        $KodeData = substr($this->db->database, 0, 5);
        $tanggal = date('Y-m-d');
        $filter = $this->input->get('filter');
        $startdate = $this->input->get('startdate'); //tahun bulan tanggal awal
        $enddate = $this->input->get('enddate'); //tahun bulan tanggal akhir

        $bawal = substr($startdate, 5, 2);
        $awal = substr($startdate, 0, 4);
        $bakhir = substr($startdate, 5, 2);
        $akhir = substr($startdate, 0, 4);

        $username = $this->session->userdata('ses_username');
        $setting['user'] = $this->login_model->sistemuser($username)->row();
        $setting['seting'] = $this->login_model->seting()->row();
        if ($filter == "ok") {
            if ($startdate == "" or $enddate == "") {
                $data['no'] = 1;
                $data['subtot'] = 0;
                $data['tanggal'] = $tanggal;
                $data['awal'] = $tanggal;
                $data['akhir'] = $tanggal;
                $data['filter'] = $filter;
                $data['penjualan'] = $this->laporan_pesanjual_model->getLaporanFakturPenjualan($tanggal);
            } else {
                $data['no'] = 1;
                $data['subtot'] = 0;
                $data['tanggal'] = $tanggal;
                $data['awal'] = $startdate;
                $data['akhir'] = $enddate;
                $data['filter'] = $filter;
                $data['penjualan'] = $this->laporan_pesanjual_model->getLaporanFakturPenjualanFilter($KodeData, $awal, $akhir, $bawal, $bakhir, $startdate, $enddate);
            }
        } else {
            $data['no'] = 1;
            $data['subtot'] = 0;
            $data['tanggal'] = $tanggal;
            $data['awal'] = $tanggal;
            $data['akhir'] = $tanggal;
            $data['filter'] = $filter;
            $data['penjualan'] = $this->laporan_pesanjual_model->getLaporanFakturPenjualan($tanggal);
        }

        $this->load->view('header', $setting);
        $this->load->view('laporan/penjualan/laporan_faktur_penjualan', $data);
        $this->load->view('footers');
    }

    public function laporan_pdf()
    {
        $data = array(
            "dataku" => array(
                "nama" => "Petani Kode",
                "url" => "http://petanikode.com"
            )
        );

        $data['profit'] = $this->laporan_pesanjual_model->laporanpdf();

        $this->load->library('pdf');

        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = "laporan-petanikode.pdf";
        $this->pdf->load_view('laporan/laporan_pdf', $data);
    }
}

/* End of file Laporan.php */
/* Location: ./application/controllers/Laporan.php */