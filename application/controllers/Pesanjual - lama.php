<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pesanjual extends CI_Controller
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
		$this->load->model('pesanjual_model');
		$this->load->model('login_model');
		$this->load->helper('random');
	}

	public function nomor_faktur()
	{
		$tgl_now = date('Y-m-d');
		$waktu = date('H:i:s');
		$tgl = date('Y-m-d H:i:s');
		$id_user = $this->session->userdata('ses_userid');
		$nm_user = $this->session->userdata('ses_username');
		$hrf = "0ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$jh = (strlen($hrf) - 1);
		if ($id_user <= 99) {
			$hsl = sprintf("%02d", $id_user);
		} else {
			$angka = $id_user - 99;
			if ($angka <= $jh) {
				$h = substr($hrf, $angka, 1);
				$hsl = 0 . "$h";
			} else {
				$a1 = floor($angka / $jh);
				$a2 = $angka - ($a1 * $jh);
				$hsl = substr($hrf, $a1, 1) . substr($hrf, $a2, 1);
			}
		}
		//$kodeawal = sprintf("%02d", $id_user);;
		//$max = $this->db->query("SELECT MAX(RIGHT(NoPesanJual,3)) AS last FROM tabel_penjualan WHERE substr(NoPesanJual,6,6)='$ymd'");
		$max = $this->db->query("SELECT MAX(RIGHT(NoPesanJual,2)) AS id_max FROM mpesanjual WHERE LEFT(NoPesanJual,2) <> 'PJ' AND NmUser ='$nm_user' ");
		$x = $max->row_array();
		$last = $x['id_max'];
		//$cek = $this->db->query("SELECT * FROM tabel_penjualan WHERE substr(NoPesanJual,-3)='$last' AND substr(NoPesanJual,6,6)='$ymd'");
		$cek = $this->db->query("SELECT * FROM mpesanjual WHERE substr(NoPesanJual,-2)='$last' AND LEFT(NoPesanJual,2) <> 'PJ' AND NmUser ='$nm_user' ");
		$i = $cek->row_array();
		$user = $i['NmUser'];
		$selesai = $i['Flag_SAVE'];

		$lokasiawal = $this->login_model->lokasiawal($id_user)->row_array();

		if ($user == $nm_user && $selesai == '0') {
			$nofaktur = $hsl . '-' . $last;
		} else {
			$nofaktur = $this->pesanjual_model->getNo($id_user, $nm_user);
			$data = array(
				'NoPesanJual' => $nofaktur,
				'Tanggal' => $tgl_now,
				'Jam' => $waktu,
				'TglEntry' => $tgl,
				'NmUser' => $nm_user,
				'KdLokasi' => $lokasiawal['LokasiAwal'],
				'Flag_SAVE' => '0',
			);
			$this->db->insert('mpesanjual', $data);
		}
		redirect('pesanjual/form-pesan/' . $nofaktur, 'refresh');
	}

	// untuk buat nomer pesan pj baru 
	public function nomor_faktur_new()
	{
		//$ymd = date('ymd');
		$tgl_now = date('Y-m-d');
		$waktu = date('H:i:s');
		$tgl = date('Y-m-d H:i:s');
		$id_user = $this->session->userdata('ses_userid');
		$nm_user = $this->session->userdata('ses_username');
		$nofaktur = $this->pesanjual_model->getNo($id_user, $nm_user);
		$lokasiawal = $this->login_model->lokasiawal($id_user)->row_array();
		$data = array(
			'NoPesanJual' => $nofaktur,
			'Tanggal' => $tgl_now,
			'Jam' => $waktu,
			'TglEntry' => $tgl,
			'NmUser' => $nm_user,
			'KdLokasi' => $lokasiawal['LokasiAwal'],
			'Flag_SAVE' => '0',
		);
		$this->db->insert('mpesanjual', $data);
		redirect('pesanjual/form-pesan/' . $nofaktur, 'refresh');
	}

	// tampilan proses entry item
	public function form_pesan()
	{

		$username = htmlspecialchars($this->input->post('username', TRUE), ENT_QUOTES);
		$password = htmlspecialchars($this->input->post('password', TRUE), ENT_QUOTES);

		$t = $password;
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

		$password_hash = $teksjadi;

		$cek_user = $this->login_model->cek_user($username, $password_hash);

		$noresi = $this->uri->segment(3);
		$username = $this->session->userdata('ses_username');
		$data_faktur = $this->pesanjual_model->getDataPenjualan($noresi, $username)->row();
		$list_barang = $this->pesanjual_model->getListPenjualan($noresi);
		$list_sales = $this->pesanjual_model->listsales($noresi)->row();
		if ($cek_user->num_rows() > 0) {
			$cek = $cek_user->row_array();
			$username = $cek['NmUser'];
		}
		$spv = $this->login_model->sistemuser($username)->row();
		if ($data_faktur) {
			$data['title'] = 'Entry Pesan Jual';
			$data['tgl'] = date('Y-m-d');
			$data['no'] = 1;
			$data['faktur'] = $data_faktur;
			$data['spv'] = $spv;
			$data['list'] = $list_barang;
			$data['lists'] = $list_sales;
			$data['tot_item'] = 0;
			$data['tot_belanja'] = 0;
			$data['belanja'] = $this->pesanjual_model->getTotalBelanja($noresi)->row();

			$setting['user'] = $this->login_model->sistemuser($username)->row();
			$setting['seting'] = $this->login_model->seting()->row();

			$this->load->view('header', $setting);
			$this->load->view('pesanjual/form_pesan', $data);
			//$this->load->view('footer');
		} else {
			$this->load->view('error404');
		}
	}


	// tampilan pesan yang belum di selesaikan 
	public function antrian_pesan()
	{
		$id_user = $this->session->userdata('ses_username');
		$now = date('Y-m-d');
		$before = date('Y-m-d', strtotime('-30 days', strtotime($now)));
		$data['pending'] = $this->pesanjual_model->antrianpesan($id_user, $now, $before);
		$data['no'] = 1;

		$username = $this->session->userdata('ses_username');
		$setting['user'] = $this->login_model->sistemuser($username)->row();
		$setting['seting'] = $this->login_model->seting()->row();
		$this->load->view('header', $setting);
		$this->load->view('pesanjual/antrian_pesan', $data);
		$this->load->view('footers');
	}

	function get_autocomplete_cust()
	{
		if (isset($_GET['term'])) {
			$result = $this->pesanjual_model->cari_cust($_GET['term']);
			if (count($result) > 0) {
				foreach ($result as $row) {
					$arr_result[] = array(
						'label' => $row->NmCust,
						'kode' => $row->KdCust,
						'value' => $row->KdCust,
					);
				}
				echo json_encode($arr_result);
			}
		}
	}

	// cari sales M 
	function get_autocomplete_sales()
	{
		if (isset($_GET['term'])) {
			$result = $this->pesanjual_model->cari_sales($_GET['term']);
			if (count($result) > 0) {
				foreach ($result as $row) {
					$arr_result[] = array(
						'label' => $row->NmSales,
						'kode' => $row->KdSales,
						'value' => $row->KdSales,
					);
				}
				echo json_encode($arr_result);
			}
		}
	}


	function get_autocomplete()
	{
		if (isset($_GET['term'])) {
			$result = $this->pesanjual_model->cari_brg($_GET['term']);
			if (count($result) > 0) {
				foreach ($result as $row) {
					$arr_result[] = array(
						'kode' => $row->KdBrg,
						'label' => $row->NmBrg,
						'value' => $row->KdBrg,
					);
				}
				echo json_encode($arr_result);
			}
		}
	}

	// proses simpan pesan yang sudah final
	public function go_to_simpan()
	{
		$ymd = date('ym');
		$tgl_now = date('Y-m-d');
		$waktu = date('H:i:s');
		$id_user = $this->session->userdata('ses_userid');
		$nm_user = $this->session->userdata('ses_username');
		$noresi = $this->input->post('nofak_bayar');
		$total_penjualan = $this->input->post('total_belanja');
		$nofaktur = $this->pesanjual_model->getNoFaktur($ymd, $id_user, $nm_user);
		$cek = $this->pesanjual_model->cek_go_simpan($noresi, $nm_user);
		$urix = base_url('pesanjual/form_pesan/') . $noresi;
		$uri = base_url('pesanjual/nomor-faktur/');
		$x = $cek->row_array();
		$cust = $x['KdCust'];

		if ($cust == '') {
			echo $this->session->set_flashdata('error', 'Customer Tidak Boleh Kosong');
			header("Location: " . $urix, TRUE, $http_response_code);
		} else {
			$data = array(
				'NoPesanJual' => $nofaktur,
				'SubTotal' => $total_penjualan,
				'Tanggal' => $tgl_now,
				'Jam' => $waktu,
				'Flag_SAVE' => '1',
			);
			$this->db->where('NoPesanJual', $noresi);
			$this->db->update('mpesanjual', $data);
			header("Location: " . $uri, TRUE, $http_response_code);
		}
	}


	public function pesan_pending()
	{
		$id_user = $this->session->userdata('ses_username');
		$data['selesai'] = $this->pesanjual_model->pesanpending($id_user);
		$data['no'] = 1;

		$username = $this->session->userdata('ses_username');
		$setting['user'] = $this->login_model->sistemuser($username)->row();
		$setting['seting'] = $this->login_model->seting()->row();
		$this->load->view('header', $setting);
		$this->load->view('pesanjual/pending_pesan', $data);
		$this->load->view('footers');
	}


	public function kirimprint()
	{
		$nofaktur = $this->input->post('nofak');
		//$data['pj'] = $this->pesanjual_model->cek_nopj($nofaktur);
		$cekpesanjual = $this->pesanjual_model->cek_nopj($nofaktur);
		$pj = $cekpesanjual->row_array();
		$telp = $pj['Telp'];
		$nmcust = $pj['NmCust'];
		$total = $pj['SubTotal'];
		$uri = base_url('pesanjual/pending_pesan/');

		$input = array(
			'wa_mode' => 0,
			'wa_no' => $telp,
			'wa_text' => nl2br('TOKO ABC KALIWATES - JEMBER \n Total belanja dengan nomor faktur ' . $nofaktur . ' anda sebanyak Rp ' . $total . ' \n Terima Kasih Mr/Mrs ' . $nmcust . ' Kami Tunggu Kehadiran Anda Selanjutnya')
		);
		$this->db = $this->load->database('db3', TRUE);
		$this->db->insert('outbox', $input);
		echo $this->session->set_flashdata('error', 'faktur ' . $nofaktur . ' Sukses di kirim :(');
		header("Location: " . $uri, TRUE, $http_response_code);
	}

	public function cekcust()
	{
		$nofaktur = urldecode($this->uri->segment(3));
		$idcust = urldecode($this->uri->segment(4));
		$customer = $this->pesanjual_model->getcustomer($idcust);
		$cek_sudah_ada = $this->pesanjual_model->cek_cust_ada($idcust, $nofaktur);
		$x = $customer->row_array();
		$kdcust = $x['KdCust'];
		$nmcust = $x['NmCust'];
		$harga = $x['HrgJual'];
		$uri = base_url('pesanjual/form-pesan/') . $nofaktur;

		if ($customer->num_rows() > 0) {
			$x = $customer->row_array();
			$kode = $x['KdCust'];
			if ($cek_sudah_ada < $kode) {
				echo $this->session->set_flashdata('error', 'kode sudah ada');
				header("Location: " . $uri, TRUE, $http_response_code);
			} else {
				$this->db->query("UPDATE mpesanjual SET KdCust='$kdcust', NmCust='$nmcust', JenisHrg='$harga' WHERE  NoPesanJual='$nofaktur'");
				header("Location: " . $uri, TRUE, $http_response_code);
			}
		} else {
			echo $this->session->set_flashdata('error', 'Kode ' . $idcust . $customer . ' tidak tersedia :(');
			header("Location: " . $uri, TRUE, $http_response_code);
		}
	}

	// Cek data sales
	public function ceksales()
	{
		$nofaktur = urldecode($this->uri->segment(3));
		$idsales = urldecode($this->uri->segment(4));
		$sales = $this->pesanjual_model->getsales($idsales);
		$cek_sudah_ada = $this->pesanjual_model->cek_sales_ada($idsales, $nofaktur);
		$x = $sales->row_array();
		$kdsales = $x['KdSales'];
		//$nmsales = $x['NmSales'];
		$uri = base_url('pesanjual/form-pesan/') . $nofaktur;

		if ($sales->num_rows() > 0) {
			$x = $sales->row_array();
			$kode = $x['KdSales'];
			if ($cek_sudah_ada < $kode) {
				echo $this->session->set_flashdata('error', 'kode sudah ada');
				header("Location: " . $uri, TRUE, $http_response_code);
			} else {
				$this->db->query("UPDATE mpesanjual SET KdSales='$kdsales'  WHERE  NoPesanJual='$nofaktur'");
				header("Location: " . $uri, TRUE, $http_response_code);
			}
		} else {
			echo $this->session->set_flashdata('error', 'Kode ' . $idsales . '' . $sales . ' tidak tersedia :(');
			header("Location: " . $uri, TRUE, $http_response_code);
		}
	}

	public function edit_satuan()
	{
		$idbarang = $this->input->post('kdbrg_s');
		$nofaktur = $this->input->post('nofak_s');
		$barang = $this->input->post('kdbrg_s');
		$satuan = $this->input->post('sat');
		$jumlah = $this->input->post('jumlah');

		$cek_satuan_ada = $this->pesanjual_model->cek_satuan_ada($idbarang, $nofaktur);
		$x = $cek_satuan_ada->row_array();
		$kode = $x['KdHrg'];

		$s1 = $x['Sat_1'];
		$s2 = $x['Sat_2'];
		$s3 = $x['Sat_3'];
		$s4 = $x['Sat_4'];
		$h11 = $x['HrgJl11'];
		$h12 = $x['HrgJl12'];
		$h13 = $x['HrgJl13'];
		$h14 = $x['HrgJl14'];
		$h21 = $x['HrgJl21'];
		$h22 = $x['HrgJl22'];
		$h23 = $x['HrgJl23'];
		$h24 = $x['HrgJl24'];
		$h31 = $x['HrgJl31'];
		$h32 = $x['HrgJl32'];
		$h33 = $x['HrgJl33'];
		$h34 = $x['HrgJl34'];
		$h41 = $x['HrgJl41'];
		$h42 = $x['HrgJl42'];
		$h43 = $x['HrgJl41'];
		$h44 = $x['HrgJl41'];
		//$isi2=$x['Isi_2'];$isi3=$x['Isi_3'];$isi4=$x['Isi_4'];

		$uri = base_url('pesanjual/form-pesan/') . $nofaktur;

		if ($satuan <> '') {
			if ($satuan == $s1) {
				if ($kode == 'H1') {
					$this->db->query("UPDATE tpesanjual SET Sat='$s1', Jumlah=if($jumlah<=0,1,$jumlah), Harga='$h11', Isi='1'  WHERE KdBrg='$barang' AND  NoPesanJual='$nofaktur'");
					header("Location: " . $uri, TRUE, $http_response_code);
				} else if ($kode == 'H2') {
					$this->db->query("UPDATE tpesanjual SET Sat='$s1', Jumlah=if($jumlah<=0,1,$jumlah), Harga='$h12', Isi='1'  WHERE KdBrg='$barang' AND  NoPesanJual='$nofaktur'");
					header("Location: " . $uri, TRUE, $http_response_code);
				} else if ($kode == 'H3') {
					$this->db->query("UPDATE tpesanjual SET Sat='$s1', Jumlah=if($jumlah<=0,1,$jumlah), Harga='$h13', Isi='1'  WHERE KdBrg='$barang' AND  NoPesanJual='$nofaktur'");
					header("Location: " . $uri, TRUE, $http_response_code);
				} else if ($kode == 'H4') {
					$this->db->query("UPDATE tpesanjual SET Sat='$s1', Jumlah=if($jumlah<=0,1,$jumlah), Harga='$h14', Isi='1'  WHERE KdBrg='$barang' AND  NoPesanJual='$nofaktur'");
					header("Location: " . $uri, TRUE, $http_response_code);
				} else {
					echo $this->session->set_flashdata('error', 'Satuan ' . $satuan . '' . $barang .  ' tidak tersediax :(');
				}
			} else if ($satuan == $s2) {
				if ($kode == 'H1') {
					$this->db->query("UPDATE tpesanjual SET Sat='$s2', Jumlah=if($jumlah<=0,1,$jumlah), Harga='$h21',  Isi=Isi_2   WHERE KdBrg='$barang' AND  NoPesanJual='$nofaktur'");
					header("Location: " . $uri, TRUE, $http_response_code);
				} else if ($kode == 'H2') {
					$this->db->query("UPDATE tpesanjual SET Sat='$s2', Jumlah=if($jumlah<=0,1,$jumlah), Harga='$h22', Isi=Isi_2  WHERE KdBrg='$barang' AND  NoPesanJual='$nofaktur'");
					header("Location: " . $uri, TRUE, $http_response_code);
				} else if ($kode == 'H3') {
					$this->db->query("UPDATE tpesanjual SET Sat='$s2', Jumlah=if($jumlah<=0,1,$jumlah), Harga='$h23', Isi=Isi_2  WHERE KdBrg='$barang' AND  NoPesanJual='$nofaktur'");
					header("Location: " . $uri, TRUE, $http_response_code);
				} else if ($kode == 'H4') {
					$this->db->query("UPDATE tpesanjual SET Sat='$s2', Jumlah=if($jumlah<=0,1,$jumlah), Harga='$h24', Isi=Isi_2  WHERE KdBrg='$barang' AND  NoPesanJual='$nofaktur'");
					header("Location: " . $uri, TRUE, $http_response_code);
				} else {
					echo $this->session->set_flashdata('error', 'Satuan ' . $satuan . '' . $barang .  ' tidak tersediax :(');
					header("Location: " . $uri, TRUE, $http_response_code);
				}
			} else if ($satuan == $s3) {
				if ($kode == 'H1') {
					$this->db->query("UPDATE tpesanjual SET Sat='$s3', Jumlah=if($jumlah<=0,1,$jumlah), Harga='$h31',  Isi=Isi_3   WHERE KdBrg='$barang' AND  NoPesanJual='$nofaktur'");
					header("Location: " . $uri, TRUE, $http_response_code);
				} else if ($kode == 'H2') {
					$this->db->query("UPDATE tpesanjual SET Sat='$s3', Jumlah=if($jumlah<=0,1,$jumlah), Harga='$h32', Isi=Isi_3  WHERE KdBrg='$barang' AND  NoPesanJual='$nofaktur'");
					header("Location: " . $uri, TRUE, $http_response_code);
				} else if ($kode == 'H3') {
					$this->db->query("UPDATE tpesanjual SET Sat='$s3', Jumlah=if($jumlah<=0,1,$jumlah), Harga='$h33', Isi=Isi_3  WHERE KdBrg='$barang' AND  NoPesanJual='$nofaktur'");
					header("Location: " . $uri, TRUE, $http_response_code);
				} else if ($kode == 'H4') {
					$this->db->query("UPDATE tpesanjual SET Sat='$s3', Jumlah=if($jumlah<=0,1,$jumlah), Harga='$h34', Isi=Isi_3  WHERE KdBrg='$barang' AND  NoPesanJual='$nofaktur'");
					header("Location: " . $uri, TRUE, $http_response_code);
				} else {
					echo $this->session->set_flashdata('error', 'Satuan ' . $satuan . '' . $barang .  ' tidak tersediax :(');
					header("Location: " . $uri, TRUE, $http_response_code);
				}
			} else if ($satuan == $s4) {
				if ($kode == 'H1') {
					$this->db->query("UPDATE tpesanjual SET Sat='$s4', Jumlah=if($jumlah<=0,1,$jumlah), Harga='$h41', Isi=Isi_4  WHERE KdBrg='$barang' AND  NoPesanJual='$nofaktur'");
					header("Location: " . $uri, TRUE, $http_response_code);
				} else if ($kode == 'H2') {
					$this->db->query("UPDATE tpesanjual SET Sat='$s4', Jumlah=if($jumlah<=0,1,$jumlah), Harga='$h42', Isi=Isi_4  WHERE KdBrg='$barang' AND  NoPesanJual='$nofaktur'");
					header("Location: " . $uri, TRUE, $http_response_code);
				} else if ($kode == 'H3') {
					$this->db->query("UPDATE tpesanjual SET Sat='$s4', Jumlah=if($jumlah<=0,1,$jumlah), Harga='$h43', Isi=Isi_4  WHERE KdBrg='$barang' AND  NoPesanJual='$nofaktur'");
					header("Location: " . $uri, TRUE, $http_response_code);
				} else if ($kode == 'H4') {
					$this->db->query("UPDATE tpesanjual SET Sat='$s4', Jumlah=if($jumlah<=0,1,$jumlah), Harga='$h44', Isi=Isi_4  WHERE KdBrg='$barang' AND  NoPesanJual='$nofaktur'");
					header("Location: " . $uri, TRUE, $http_response_code);
				} else {
					echo $this->session->set_flashdata('error', 'Satuan ' . $satuan . '' . $barang .  ' tidak tersediax :(');
					header("Location: " . $uri, TRUE, $http_response_code);
				}
			} else {
				echo $this->session->set_flashdata('error', 'Satuan ' . $satuan . ' xtidak tersedia :(');
				header("Location: " . $uri, TRUE, $http_response_code);
			}
		} else {
			header("Location: " . $uri, TRUE, $http_response_code);
		}
	}

	function edit_jenis_harga()
	{
		$nofaktur = $this->input->post('nofak');
		$nmuser = $this->input->post('nmuser');
		$jenis = $this->input->post('jnshrg');
		$cek_jenishrg = $this->pesanjual_model->cek_jenis_harga($nofaktur);
		//$cek_tpesan = $this->pesanjual_model->cek_tpesan($nofaktur);
		$x = $cek_jenishrg->row_array();
		$kode = $x['JenisHrg'];
		$uri = base_url('pesanjual/form-pesan/') . $nofaktur;

		if ($jenis == $kode) {
			echo $this->session->set_flashdata('error', 'Jenis Harga ' . $jenis . ' sudah sama :(');
			header("Location: " . $uri, TRUE, $http_response_code);
		} elseif ($jenis <> $kode) {
			$this->db->query("UPDATE mpesanjual SET JenisHrg='$jenis' WHERE  NoPesanJual='$nofaktur'");
			$h = substr($jenis, 1); //2;// RIGHT($jenis,1);
			$this->db->query("UPDATE tpesanjual SET KdHrg='$jenis', Harga=if(Sat=Sat_1,HrgJl1$h,if(Sat=Sat_2,HrgJl2$h,if(Sat=Sat_3,HrgJl3$h,if(Sat=Sat_4,HrgJl4$h,HrgJl1$h)))), SPV_Pesan='$nmuser' WHERE  NoPesanJual='$nofaktur'");
			header("Location: " . $uri, TRUE, $http_response_code);
		} else {
			echo $this->session->set_flashdata('error', 'Jenis Harga ' . $nofaktur . ' tidak ada :(');
			header("Location: " . $uri, TRUE, $http_response_code);
		}
	}

	// untuk proses entry item di form pesan
	public function cekbarang()
	{
		$nofaktur = urldecode($this->uri->segment(3));
		$idbarang = urldecode($this->uri->segment(4));

		$produk = $this->pesanjual_model->getbarang($idbarang);
		$cek_jenishrg = $this->pesanjual_model->cek_jenis_harga($nofaktur);
		$lokasi = $this->pesanjual_model->cek_lokasi($nofaktur)->row_array();
		$lok = $lokasi['KdLokasi'];

		$stock = $this->pesanjual_model->stocklokasi($idbarang, $lok);
		$stk = $stock->row_array();
		$x = $produk->row_array();
		$kdb = $x['KdBrg'];
		$h1 = $x['HrgJl11'];
		$h2 = $x['HrgJl12'];
		$h3 = $x['HrgJl13'];
		$h4 = $x['HrgJl14'];
		$jumlah = "1";
		$diskonrp = "0";
		$diskonpersen = "0";
		$cek_sudah_ada = $this->pesanjual_model->cek_sudah_ada($kdb, $nofaktur);
		$cek_tpesan = $this->pesanjual_model->cek_tpesan($nofaktur);


		$uri = base_url('pesanjual/form-pesan/') . $nofaktur;

		if ($produk->num_rows() > 0) {
			$i = $cek_jenishrg->row_array();
			$jenis_sekarang = $i['JenisHrg'];
			if ($cek_sudah_ada->num_rows() > 0) {
				$s = $cek_sudah_ada->row_array();
				$kode = $s['KdBrg'];
				$kodex = $s['Barcode'];
				$sat = $s['Sat'];
				$sat1 = $s['Sat_1'];
				$jum_beli = $s['Jumlah'];
				$harga_jual = $s['Harga'];
				$jum_beli_sekarang = $jumlah + $jum_beli;

				if ($kode <> 1 and $sat == $sat1) {
					$this->db->query("UPDATE tpesanjual SET jumlah='$jum_beli_sekarang', Harga='$harga_jual', Disc='$diskonrp', Disc_per='$diskonpersen' WHERE KdBrg='$kdb' AND NoPesanJual='$nofaktur'");
					header("Location: " . $uri, TRUE, $http_response_code);
				} else if ($kdb == $kodex and $sat == $sat1) {
					$this->db->query("UPDATE tpesanjual SET jumlah='$jum_beli_sekarang', Harga='$harga_jual', Disc='$diskonrp', Disc_per='$diskonpersen' WHERE KdBrg='$kdb' AND NoPesanJual='$nofaktur'");
					header("Location: " . $uri, TRUE, $http_response_code);
				} else {
					echo $this->session->set_flashdata('error', 'Satuan Saat ini' . $sat . ' harus satuan pertama :(');
					header("Location: " . $uri, TRUE, $http_response_code);
				}
			} elseif ($cek_tpesan->num_rows() >= 0) {
				$sales = $cek_tpesan->last_row('array');
				if ($sales <> '') {
					$sls = $sales['KdSales'];
				} else {
					$sls = '';
				}
				if ($jenis_sekarang == 'H1') {
					$input = array(
						'NoPesanJual' => $nofaktur,
						'KdBrg' => $x['KdBrg'],
						'Sat' => $x['Sat_1'],
						'Harga' => $h1,
						'Disc' => $diskonrp,
						'Disc_Per' => $diskonpersen,
						'Isi' => '1',
						'KdHrg' => 'H1',
						'Jumlah' => $jumlah,
						'HBT' => $x['Hrg_Beli_Akhir'],
						'HrgBeli' => $x['Hrg_Beli_Rata'],
						'Jasa' => $x['Jasa'],
						'JualRugi' => $x['JualRugi'],
						'NamaBrg' => $x['NmBrg'],
						'Sat_1' => $x['Sat_1'], 'Sat_2' => $x['Sat_2'], 'Sat_3' => $x['Sat_3'], 'Sat_4' => $x['Sat_4'],
						'Isi_2' => $x['Isi_2'], 'Isi_3' => $x['Isi_3'], 'Isi_4' => $x['Isi_4'],
						'HrgJl11' => $x['HrgJl11'], 'HrgJl21' => $x['HrgJl21'], 'HrgJl31' => $x['HrgJl31'], 'HrgJl41' => $x['HrgJl41'],
						'HrgJl12' => $x['HrgJl12'], 'HrgJl22' => $x['HrgJl22'], 'HrgJl32' => $x['HrgJl32'], 'HrgJl42' => $x['HrgJl42'],
						'HrgJl13' => $x['HrgJl13'], 'HrgJl23' => $x['HrgJl23'], 'HrgJl33' => $x['HrgJl33'], 'HrgJl43' => $x['HrgJl43'],
						'HrgJl14' => $x['HrgJl14'], 'HrgJl24' => $x['HrgJl24'], 'HrgJl34' => $x['HrgJl34'], 'HrgJl44' => $x['HrgJl44'],
						'HrgJl15' => $x['HrgJl15'], 'HrgJl25' => $x['HrgJl25'], 'HrgJl35' => $x['HrgJl35'], 'HrgJl45' => $x['HrgJl45'],
						'Keterangan' => $x['Ket1'],
						'KdSales' => $sls,
						'KdDept' => $x['KdDept'],
						'Stock' => $stk['Akhir'] + 0,
						'Barcode' => $idbarang,
					);
					$this->db->insert('tpesanjual', $input);
					header("Location: " . $uri, TRUE, $http_response_code);
				} else if ($jenis_sekarang == 'H2') {
					$input = array(
						'NoPesanJual' => $nofaktur,
						'KdBrg' => $x['KdBrg'],
						'Sat' => $x['Sat_1'],
						'Harga' => $h2,
						'Disc' => $diskonrp,
						'Disc_Per' => $diskonpersen,
						'Isi' => '1',
						'KdHrg' => 'H2',
						'Jumlah' => $jumlah,
						'HBT' => $x['Hrg_Beli_Akhir'],
						'HrgBeli' => $x['Hrg_Beli_Rata'],
						'Jasa' => $x['Jasa'],
						'JualRugi' => $x['JualRugi'],
						'NamaBrg' => $x['NmBrg'],
						'Sat_1' => $x['Sat_1'], 'Sat_2' => $x['Sat_2'], 'Sat_3' => $x['Sat_3'], 'Sat_4' => $x['Sat_4'],
						'Isi_2' => $x['Isi_2'], 'Isi_3' => $x['Isi_3'], 'Isi_4' => $x['Isi_4'],
						'HrgJl11' => $x['HrgJl11'], 'HrgJl21' => $x['HrgJl21'], 'HrgJl31' => $x['HrgJl31'], 'HrgJl41' => $x['HrgJl41'],
						'HrgJl12' => $x['HrgJl12'], 'HrgJl22' => $x['HrgJl22'], 'HrgJl32' => $x['HrgJl32'], 'HrgJl42' => $x['HrgJl42'],
						'HrgJl13' => $x['HrgJl13'], 'HrgJl23' => $x['HrgJl23'], 'HrgJl33' => $x['HrgJl33'], 'HrgJl43' => $x['HrgJl43'],
						'HrgJl14' => $x['HrgJl14'], 'HrgJl24' => $x['HrgJl24'], 'HrgJl34' => $x['HrgJl34'], 'HrgJl44' => $x['HrgJl44'],
						'HrgJl15' => $x['HrgJl15'], 'HrgJl25' => $x['HrgJl25'], 'HrgJl35' => $x['HrgJl35'], 'HrgJl45' => $x['HrgJl45'],
						'Keterangan' => $x['Ket1'],
						'KdSales' => $sls,
						'KdDept' => $x['KdDept'],
						'Stock' => $stk['Akhir'] + 0,
						'Barcode' => $idbarang,
					);
					$this->db->insert('tpesanjual', $input);
					header("Location: " . $uri, TRUE, $http_response_code);
				} else if ($jenis_sekarang == 'H3') {
					$input = array(
						'NoPesanJual' => $nofaktur,
						'KdBrg' => $x['KdBrg'],
						'Sat' => $x['Sat_1'],
						'Harga' => $h3,
						'Disc' => $diskonrp,
						'Disc_Per' => $diskonpersen,
						'Isi' => '1',
						'KdHrg' => 'H3',
						'Jumlah' => $jumlah,
						'HBT' => $x['Hrg_Beli_Akhir'],
						'HrgBeli' => $x['Hrg_Beli_Rata'],
						'Jasa' => $x['Jasa'],
						'JualRugi' => $x['JualRugi'],
						'NamaBrg' => $x['NmBrg'],
						'Sat_1' => $x['Sat_1'], 'Sat_2' => $x['Sat_2'], 'Sat_3' => $x['Sat_3'], 'Sat_4' => $x['Sat_4'],
						'Isi_2' => $x['Isi_2'], 'Isi_3' => $x['Isi_3'], 'Isi_4' => $x['Isi_4'],
						'HrgJl11' => $x['HrgJl11'], 'HrgJl21' => $x['HrgJl21'], 'HrgJl31' => $x['HrgJl31'], 'HrgJl41' => $x['HrgJl41'],
						'HrgJl12' => $x['HrgJl12'], 'HrgJl22' => $x['HrgJl22'], 'HrgJl32' => $x['HrgJl32'], 'HrgJl42' => $x['HrgJl42'],
						'HrgJl13' => $x['HrgJl13'], 'HrgJl23' => $x['HrgJl23'], 'HrgJl33' => $x['HrgJl33'], 'HrgJl43' => $x['HrgJl43'],
						'HrgJl14' => $x['HrgJl14'], 'HrgJl24' => $x['HrgJl24'], 'HrgJl34' => $x['HrgJl34'], 'HrgJl44' => $x['HrgJl44'],
						'HrgJl15' => $x['HrgJl15'], 'HrgJl25' => $x['HrgJl25'], 'HrgJl35' => $x['HrgJl35'], 'HrgJl45' => $x['HrgJl45'],
						'Keterangan' => $x['Ket1'],
						'KdSales' => $sls,
						'KdDept' => $x['KdDept'],
						'Stock' => $stk['Akhir'] + 0,
						'Barcode' => $idbarang,
					);
					$this->db->insert('tpesanjual', $input);
					header("Location: " . $uri, TRUE, $http_response_code);
				} else if ($jenis_sekarang == 'H4') {
					$input = array(
						'NoPesanJual' => $nofaktur,
						'KdBrg' => $x['KdBrg'],
						'Sat' => $x['Sat_1'],
						'Harga' => $h4,
						'Disc' => $diskonrp,
						'Disc_Per' => $diskonpersen,
						'Isi' => '1',
						'KdHrg' => 'H4',
						'Jumlah' => $jumlah,
						'HBT' => $x['Hrg_Beli_Akhir'],
						'HrgBeli' => $x['Hrg_Beli_Rata'],
						'Jasa' => $x['Jasa'],
						'JualRugi' => $x['JualRugi'],
						'NamaBrg' => $x['NmBrg'],
						'Sat_1' => $x['Sat_1'], 'Sat_2' => $x['Sat_2'], 'Sat_3' => $x['Sat_3'], 'Sat_4' => $x['Sat_4'],
						'Isi_2' => $x['Isi_2'], 'Isi_3' => $x['Isi_3'], 'Isi_4' => $x['Isi_4'],
						'HrgJl11' => $x['HrgJl11'], 'HrgJl21' => $x['HrgJl21'], 'HrgJl31' => $x['HrgJl31'], 'HrgJl41' => $x['HrgJl41'],
						'HrgJl12' => $x['HrgJl12'], 'HrgJl22' => $x['HrgJl22'], 'HrgJl32' => $x['HrgJl32'], 'HrgJl42' => $x['HrgJl42'],
						'HrgJl13' => $x['HrgJl13'], 'HrgJl23' => $x['HrgJl23'], 'HrgJl33' => $x['HrgJl33'], 'HrgJl43' => $x['HrgJl43'],
						'HrgJl14' => $x['HrgJl14'], 'HrgJl24' => $x['HrgJl24'], 'HrgJl34' => $x['HrgJl34'], 'HrgJl44' => $x['HrgJl44'],
						'HrgJl15' => $x['HrgJl15'], 'HrgJl25' => $x['HrgJl25'], 'HrgJl35' => $x['HrgJl35'], 'HrgJl45' => $x['HrgJl45'],
						'Keterangan' => $x['Ket1'],
						'KdSales' => $sls,
						'KdDept' => $x['KdDept'],
						'Stock' => $stk['Akhir'] + 0,
						'Barcode' => $idbarang,
					);
					$this->db->insert('tpesanjual', $input);
					header("Location: " . $uri, TRUE, $http_response_code);
				} else {
					echo $this->session->set_flashdata('error', 'Customer ' . $jenis_sekarang . ' tidak boleh kosong :(');
					header("Location: " . $uri, TRUE, $http_response_code);
				}
			}
		} else {
			echo $this->session->set_flashdata('error', 'Kode ' . $idbarang . ' tidak tersedia :(');
			header("Location: " . $uri, TRUE, $http_response_code);
		}
	}

	// untuk hapus item di form pesan 
	public function hapus_barang_beli()
	{
		$nofaktur = urldecode($this->uri->segment(3));
		$idbarang = urldecode($this->uri->segment(4));
		$uri = base_url('pesanjual/form-pesan/') . $nofaktur;
		$this->db->query("DELETE FROM tpesanjual WHERE NoPesanJual='$nofaktur' AND KdBrg='$idbarang'");
		header("Location: " . $uri, TRUE, $http_response_code);
	}

	// untuk proses edit jumlah item di form pesan
	public function edit_jumlah_beli()
	{
		$idbarang = $this->input->post('KdBrg_e');
		$nofaktur = $this->input->post('nofak_e');
		$jumlah = $this->input->post('jml');
		$uri = base_url('pesanjual/form-pesan/') . $nofaktur;

		$cek_stok = $this->pesanjual_model->cek_jumlah_stok($idbarang);
		$rinci = $this->pesanjual_model->cek_sudah_ada($idbarang, $nofaktur);

		$x = $rinci->row_array();
		$kodeharga = $x['KdHrg'];
		$sat = $x['Sat'];
		$sat1 = $x['Sat_1'];
		$isi2 = $x['Isi_2'];
		$isi3 = $x['Isi_3'];
		$isi4 = $x['Isi_4'];
		// H1
		$h11 = $x['HrgJl11'];

		$diskonrp = $jumlah * $x['Harga'] * $x['Disc_per'] / 100;

		//$i = $cek_stok->row_array();
		//$stok_sekarang = $i['Stock_Akhir'];

		//$subtot_sekarang = ($x['Harga'] * $jumlah) - $diskonrp;
		if ($sat == $sat1) {
			if ($kodeharga == 'H1') {
				if ($jumlah >= $isi4 and $isi4 <> 0) {
					$this->db->query("UPDATE tpesanjual SET Jumlah='$jumlah', Harga=HrgJl41/Isi_4, Disc='$diskonrp' WHERE KdBrg='$idbarang' AND NoPesanJual='$nofaktur'");
					header("Location: " . $uri, TRUE, $http_response_code);
				} else if ($jumlah >= $isi3 and $isi3 <> 0) {
					$this->db->query("UPDATE tpesanjual SET Jumlah='$jumlah', Harga=HrgJl31/Isi_3, Disc='$diskonrp' WHERE KdBrg='$idbarang' AND NoPesanJual='$nofaktur'");
					header("Location: " . $uri, TRUE, $http_response_code);
				} else if ($jumlah >= $isi2 and $isi2 <> 0) {
					$this->db->query("UPDATE tpesanjual SET Jumlah='$jumlah', Harga=HrgJl21/Isi_2, Disc='$diskonrp' WHERE KdBrg='$idbarang' AND NoPesanJual='$nofaktur'");
					header("Location: " . $uri, TRUE, $http_response_code);
				} /* else if ($jumlah < $stok_sekarang) {
					echo $this->session->set_flashdata('error', 'isi jumlah tidak benar');
					header("Location: " . $uri, TRUE, $http_response_code);
				} */ else if ($jumlah == 0) {
					echo $this->session->set_flashdata('error', 'isi jumlah tidak boleh 0');
					header("Location: " . $uri, TRUE, $http_response_code);
				} else {
					$this->db->query("UPDATE tpesanjual SET Jumlah='$jumlah', Harga='$h11', Disc='$diskonrp' WHERE KdBrg='$idbarang' AND NoPesanJual='$nofaktur'");
					header("Location: " . $uri, TRUE, $http_response_code);
				}
			} elseif ($kodeharga == 'H2') {
				if ($jumlah >= $isi4 and $isi4 <> 0) {
					$this->db->query("UPDATE tpesanjual SET Jumlah='$jumlah', Harga=HrgJl42/Isi_4, Disc='$diskonrp' WHERE KdBrg='$idbarang' AND NoPesanJual='$nofaktur'");
					header("Location: " . $uri, TRUE, $http_response_code);
				} else if ($jumlah >= $isi3 and $isi3 <> 0) {
					$this->db->query("UPDATE tpesanjual SET Jumlah='$jumlah', Harga=HrgJl32/Isi_3, Disc='$diskonrp' WHERE KdBrg='$idbarang' AND NoPesanJual='$nofaktur'");
					header("Location: " . $uri, TRUE, $http_response_code);
				} else if ($jumlah >= $isi2 and $isi2 <> 0) {
					$this->db->query("UPDATE tpesanjual SET Jumlah='$jumlah', Harga=HrgJl22/Isi_2, Disc='$diskonrp' WHERE KdBrg='$idbarang' AND NoPesanJual='$nofaktur'");
					header("Location: " . $uri, TRUE, $http_response_code);
				} /* else if ($jumlah < $stok_sekarang) {
					echo $this->session->set_flashdata('error', 'isi jumlah tidak benar');
					header("Location: " . $uri, TRUE, $http_response_code);
				} */ else if ($jumlah == 0) {
					echo $this->session->set_flashdata('error', 'isi jumlah tidak boleh 0');
					header("Location: " . $uri, TRUE, $http_response_code);
				} else {
					$this->db->query("UPDATE tpesanjual SET Jumlah='$jumlah', Harga=Hrgjl12, Disc='$diskonrp' WHERE KdBrg='$idbarang' AND NoPesanJual='$nofaktur'");
					header("Location: " . $uri, TRUE, $http_response_code);
				}
			} elseif ($kodeharga == 'H3') {
				if ($jumlah >= $isi4 and $isi4 <> 0) {
					$this->db->query("UPDATE tpesanjual SET Jumlah='$jumlah', Harga=HrgJl43/Isi_4, Disc='$diskonrp' WHERE KdBrg='$idbarang' AND NoPesanJual='$nofaktur'");
					header("Location: " . $uri, TRUE, $http_response_code);
				} else if ($jumlah >= $isi3 and $isi3 <> 0) {
					$this->db->query("UPDATE tpesanjual SET Jumlah='$jumlah', Harga=HrgJl33/Isi_3, Disc='$diskonrp' WHERE KdBrg='$idbarang' AND NoPesanJual='$nofaktur'");
					header("Location: " . $uri, TRUE, $http_response_code);
				} else if ($jumlah >= $isi2 and $isi2 <> 0) {
					$this->db->query("UPDATE tpesanjual SET Jumlah='$jumlah', Harga=HrgJl23/Isi_2, Disc='$diskonrp' WHERE KdBrg='$idbarang' AND NoPesanJual='$nofaktur'");
					header("Location: " . $uri, TRUE, $http_response_code);
				} else if ($jumlah == 0) {
					echo $this->session->set_flashdata('error', 'isi jumlah tidak boleh 0');
					header("Location: " . $uri, TRUE, $http_response_code);
				} else {
					$this->db->query("UPDATE tpesanjual SET Jumlah='$jumlah', Harga=HrgJl13, Disc='$diskonrp' WHERE KdBrg='$idbarang' AND NoPesanJual='$nofaktur'");
					header("Location: " . $uri, TRUE, $http_response_code);
				}
			} elseif ($kodeharga == 'H4') {
				if ($jumlah >= $isi4 and $isi4 <> 0) {
					$this->db->query("UPDATE tpesanjual SET Jumlah='$jumlah', Harga=HrgJl44/Isi_4, Disc='$diskonrp' WHERE KdBrg='$idbarang' AND NoPesanJual='$nofaktur'");
					header("Location: " . $uri, TRUE, $http_response_code);
				} else if ($jumlah >= $isi3 and $isi3 <> 0) {
					$this->db->query("UPDATE tpesanjual SET Jumlah='$jumlah', Harga=HrgJl34/Isi_3, Disc='$diskonrp' WHERE KdBrg='$idbarang' AND NoPesanJual='$nofaktur'");
					header("Location: " . $uri, TRUE, $http_response_code);
				} else if ($jumlah >= $isi2 and $isi2 <> 0) {
					$this->db->query("UPDATE tpesanjual SET Jumlah='$jumlah', Harga=HrgJl24/Isi_2, Disc='$diskonrp' WHERE KdBrg='$idbarang' AND NoPesanJual='$nofaktur'");
					header("Location: " . $uri, TRUE, $http_response_code);
				} else if ($jumlah == 0) {
					echo $this->session->set_flashdata('error', 'isi jumlah tidak boleh 0');
					header("Location: " . $uri, TRUE, $http_response_code);
				} else {
					$this->db->query("UPDATE tpesanjual SET Jumlah='$jumlah', Harga=HrgJl14, Disc='$diskonrp' WHERE KdBrg='$idbarang' AND NoPesanJual='$nofaktur'");
					header("Location: " . $uri, TRUE, $http_response_code);
				}
			} else {
				echo $this->session->set_flashdata('error', 'kpode harga tidak ada');
				header("Location: " . $uri, TRUE, $http_response_code);
			}
		} else {
			echo $this->session->set_flashdata('error', 'Satuan sekarang Harus Satuan pertama');
			header("Location: " . $uri, TRUE, $http_response_code);
		}
	}

	// untuk merubah harga jual
	public function edit_harga_jual()
	{
		$idbarang = $this->input->post('KdBrg_h');
		$nmuser = $this->input->post('nmuser');
		$nofaktur = $this->input->post('nofak_h');
		$harga = $this->input->post('hrg');
		$uri = base_url('pesanjual/form-pesan/') . $nofaktur;
		$rinci = $this->pesanjual_model->cek_sudah_ada($idbarang, $nofaktur);
		$x = $rinci->row_array();
		$hbt = $x['HBT'];

		if ($harga <= $hbt) {
			echo $this->session->set_flashdata('error', 'cek harga rugi');
			header("Location: " . $uri, TRUE, $http_response_code);
		} else {
			$this->db->query("UPDATE tpesanjual SET Harga='$harga', SPV_Pesan='$nmuser' WHERE KdBrg='$idbarang' AND NoPesanJual='$nofaktur'");
			header("Location: " . $uri, TRUE, $http_response_code);
		}
	}

	public function edit_kdsales()
	{
		$idsales = $this->input->post('sales');
		$nofaktur = $this->input->post('nofak');
		$idbarang = $this->input->post('kdbrg');
		$ceksales = $this->pesanjual_model->ceksales_detail($idsales, $idbarang, $nofaktur);
		$getsales = $this->pesanjual_model->getsales($idsales);
		$k = $getsales->row_array();
		$x = $ceksales->row_array();
		$kode = $x['KdSales'];
		$sales = $k['KdSales'];
		$uri = base_url('pesanjual/form-pesan/') . $nofaktur;

		if ($idsales = $kode) {
			header("Location: " . $uri, TRUE, $http_response_code);
		} elseif ($sales <> $kode) {
			//echo $this->session->set_flashdata('error', 'Kode ' . $idsales . ' tidak tersedi :(');
			$this->db->query("UPDATE tpesanjual SET KdSales='$sales' WHERE KdBrg='$idbarang' AND NoPesanJual='$nofaktur'");
			header("Location: " . $uri, TRUE, $http_response_code);
		} else {
			echo $this->session->set_flashdata('error', 'Kode ' . $idsales . ' tidak tersedia :(');
			header("Location: " . $uri, TRUE, $http_response_code);
		}
	}


	// proses edit disc di form pesan
	public function edit_diskon_beli()
	{
		$idbarang = $this->input->post('kd_barang_d');
		$nofaktur = $this->input->post('nofak_d');
		$diskonpersen = $this->input->post('dis_d');
		$uri = base_url('pesanjual/form-pesan/') . $nofaktur;
		$rinci = $this->pesanjual_model->cek_sudah_ada($idbarang, $nofaktur);
		$x = $rinci->row_array();
		$diskonrp =  $x['Harga'] * $diskonpersen / 100;
		//$subtot_sekarang = ($x['Harga'] * $x['Jumlah']) - $diskonrp;
		if ($diskonpersen > 100) {
			echo $this->session->set_flashdata('error', 'Diskon tidak valid');
			header("Location: " . $uri, TRUE, $http_response_code);
		} else {
			$this->db->query("UPDATE tpesanjual SET Disc='$diskonrp', Disc_Per='$diskonpersen' WHERE KdBrg='$idbarang' AND NoPesanJual='$nofaktur'");
			header("Location: " . $uri, TRUE, $http_response_code);
		}
	}

	public function hitung_diskon()
	{
		$nofaktur = $this->input->post('nofak_dis');
		$input_diskon = $this->input->post('diskon');
		$total_penjualan = $this->input->post('sum_belanja');
		$diskon = str_replace(".", "", $input_diskon);
		$ket_dis = $this->input->post('ket_dis');
		$penjualan_sdiskon = $total_penjualan - $diskon;
		$uri = base_url('pesanjual/form-pesan/') . $nofaktur;
		if ($penjualan_sdiskon < 0) {
			echo $this->session->set_flashdata('error', 'Diskon tidak valid');
			header("Location: " . $uri, TRUE, $http_response_code);
		} else {
			$data = array(
				'total_penjualan' => $total_penjualan,
				'diskon' => $diskon,
				'total_penjualan_sdiskon' => $penjualan_sdiskon,
				'ket_diskon' => $ket_dis,
			);
			$this->db->where('no_faktur_penjualan', $nofaktur);
			$this->db->update('tabel_penjualan', $data);
			header("Location: " . $uri, TRUE, $http_response_code);
		}
	}

	public function transaksi_selesai()
	{
		$this->load->view('header');
		$this->load->view('pesanjual/transaksi_selesai');
	}

	// proses hapus pesan jual pending
	public function hapus_faktur()
	{
		$nofaktur = urldecode($this->uri->segment(3));
		$this->db->query("DELETE FROM mpesanjual WHERE NoPesanJual='$nofaktur'");
		$this->db->query("DELETE FROM tpesanjual WHERE NoPesanJual='$nofaktur'");
		echo $this->session->set_flashdata('msg', 'Faktur berhasil ' . $nofaktur . ' dihapus');
		redirect('pesanjual/nomor-faktur/', 'refresh');
	}

	public function cetak_struk()
	{
		$tgl = date('Y-m-d');
		$waktu = date('H:i:s');
		$kd_toko = "SS001";
		$debet = 0;
		$bayar = 0;
		$id_user = $this->session->userdata('ses_username');
		$nofaktur = $this->input->post('nofak_print');
		$diskon = $this->input->post('diskon_print');
		$total_penjualan = $this->input->post('sum_print');
		$bayar = $this->input->post('cash_print');
		$debet = $this->input->post('debet_print');
		$bank = $this->input->post('bank_print');
		$cash = $total_penjualan - $debet;
		$kembali = ($bayar + $debet) - $total_penjualan;
		$selesai = 1;
		$ket_ks = "Penjualan " . $nofaktur;
		$uri = base_url('pesanjual/form-pesan/') . $nofaktur;
		$this->db->trans_start();
		$data_faktur = $this->pesanjual_model->getPenjualanSelesai($nofaktur, $id_user)->row();
		$list_produk = $this->pesanjual_model->getProdukDijual($nofaktur)->result();
		if ($data_faktur && $list_produk) {
			foreach ($list_produk as $key) {
				$kd_barang_item = $key->kd_barang;
				$jumlah_item = $key->jumlah;
				$validasi_stok = $this->pesanjual_model->getStok($kd_barang_item);
				$i = $validasi_stok->row_array();
				$stok_sekarang = $i['stok'];
				if ($stok_sekarang < $jumlah_item) {
					echo $this->session->set_flashdata('error', 'Stok ada yang kurang');
					header("Location: " . $uri, TRUE, $http_response_code);
					return false;
				} else {
					$stok_porsi = $this->pesanjual_model->getStokPorsi($kd_barang_item)->result();
					foreach ($stok_porsi as $key) {
						$kd_bahan = $key->kode_bahan;
						$stok_bahan = $key->stok;
						$stok_baru = (int) $stok_bahan - (int) $jumlah_item;
						$this->db->query("UPDATE tabel_stok_toko SET stok='$stok_baru' WHERE kd_barang='$kd_bahan'");
						$this->db->query("INSERT INTO tabel_kartu_stok (kode_toko,kode_barang,waktu,jam,sebelumnya,keluar,masuk,saldo,keterangan,user,publish) VALUES ('$kd_toko','$kd_bahan','$tgl','$waktu','$stok_bahan','$jumlah_item','0','$stok_baru','$ket_ks','$id_user','0')");
					}
				}
			};
			$update = array(
				'waktu' => $waktu,
				'cash' => $cash,
				'debet' => $debet,
				'ket' => $bank,
				'selesai' => $selesai,
			);
			$this->db->where('id_user', $id_user);
			$this->db->where('no_faktur_penjualan', $nofaktur);
			$this->db->update('tabel_penjualan', $update);
			$this->db->trans_complete();
			$data_cetak['toko'] = $this->pesanjual_model->get_toko();
			$data_cetak['faktur'] = $data_faktur;
			$data_cetak['tgl'] = $tgl;
			$data_cetak['waktu'] = $waktu;
			$data_cetak['bayar'] = $bayar;
			$data_cetak['kembali'] = $kembali;
			$data_cetak['debet'] = $debet;
			$data_cetak['produk'] = $list_produk;
			$data_cetak['total_item'] = 0;
			$data_cetak['subtotal'] = 0;
			$this->load->view('pesanjual/struk_transaksi', $data_cetak);
		} else {
			echo "Error retrieving information from server. <br><br>Halaman ini tidak bisa dimuat ulang, silahkan tutup halaman ini.";
		}
	}

	public function reprint_struk()
	{
		$tgl = date('d-m-Y');
		$waktu = date('H:i:s');
		$nofaktur = $this->uri->segment(3);
		$data_faktur = $this->pesanjual_model->reprintStruk($nofaktur)->row();
		$produk = $this->pesanjual_model->getProdukDijual($nofaktur);
		if ($data_faktur) {
			$data['toko'] = $this->login_model->seting();
			$data['faktur'] = $data_faktur;
			$data['tgl'] = $tgl;
			$data['waktu'] = $waktu;
			$data['produk'] = $produk;
			$data['total_item'] = 0;
			$data['subtotal'] = 0;
			$this->load->view('pesanjual/reprint_struk_transaksi', $data);
		} else {
			$this->load->view('error404');
		}
	}
}

/* End of file Kasir.php */
/* Location: ./application/controllers/Kasir.php */