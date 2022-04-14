<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pesanjualdetail extends CI_Controller
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
		$this->load->model('pesanjualdetail_model');
		$this->load->model('login_model');
		$this->load->model('barang_model');
		$this->load->helper('random');
	}

	// menu untuk cek daftar pesan jual detail
	public function daftar_pesanjualdetail()
	{
		$data['daftar'] = $this->pesanjualdetail_model->daftarpesanjualdetail();
		$data['no'] = 1;

		$username = $this->session->userdata('ses_username');
		$setting['user'] = $this->login_model->sistemuser($username)->row();
		$setting['seting'] = $this->login_model->seting()->row();
		$this->load->view('header', $setting);
		$this->load->view('pesanjualdetail/daftar_pesanjualdetail', $data);
		$this->load->view('footers');
	}

	// tampilan proses entry item/barang di pesan jual detail cetak_nota
	public function entry_pesanjualdetail()
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
		$data_faktur = $this->pesanjualdetail_model->getDataPenjualan($noresi)->row();
		//$data_faktur = $this->pesanjualdetail_model->getDataPenjualan($noresi, $username)->row();
		$list_barang = $this->pesanjualdetail_model->getListPenjualan($noresi);
		$list_sales = $this->pesanjualdetail_model->listsales($noresi)->row();
		if ($cek_user->num_rows() > 0) {
			$cek = $cek_user->row_array();
			$username = $cek['NmUser'];
		}
		$spv = $this->login_model->sistemuser($username)->row();
		if ($data_faktur) {
			$data['title'] = 'Entry Pesan Jual Detail';
			$data['tgl'] = date('Y-m-d');
			$data['no'] = 1;
			$data['faktur'] = $data_faktur;
			$data['spv'] = $spv;
			$data['list'] = $list_barang;
			$data['lists'] = $list_sales;
			$data['tot_item'] = 0;
			$data['tot_belanja'] = 0;
			$data['belanja'] = $this->pesanjualdetail_model->getTotalBelanja($noresi)->row();

			$setting['user'] = $this->login_model->sistemuser($username)->row();
			$setting['seting'] = $this->login_model->seting()->row();

			$this->load->view('header', $setting);
			$this->load->view('pesanjualdetail/entry_pesanjualdetail', $data);
			//$this->load->view('footer');
		} else {
			$this->load->view('error404');
		}
	}


	// untuk buat nomer pesan jual detail baru 
	public function nomor_faktur_baru()
	{
		$ymd = date('ym');
		$tgl_now = date('Y-m-d');
		$waktu = date('H:i:s');
		$tgl = date('Y-m-d H:i:s');
		$id_user = $this->session->userdata('ses_userid');
		$nm_user = $this->session->userdata('ses_username');
		$nofaktur = $this->pesanjualdetail_model->getNoFaktur($ymd, $id_user, $nm_user);

		$setingjual = $this->login_model->setingjual()->row_array();
		$lokasiawal = $this->login_model->lokasiawal($id_user)->row_array();
		$data = array(
			'NoPesanJual' => $nofaktur,
			'Tanggal' => $tgl_now,
			//'JenisHrg' => 'H' . $setingjual['Harga'],
			'Jam' => $waktu,
			'TglEntry' => $tgl,
			'NmUser' => $nm_user,
			'KdLokasi' => $lokasiawal['LokasiAwal'],
			'Flag_SAVE' => '1',
		);
		$this->db->insert('mpesanjual', $data);
		redirect('pesanjualdetail/entry-pesanjualdetail/' . $nofaktur, 'refresh');
	}


	// cari customer
	function get_autocomplete_cust()
	{
		if (isset($_GET['term'])) {
			$result = $this->pesanjualdetail_model->cari_cust($_GET['term']);
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
			$result = $this->pesanjualdetail_model->cari_sales($_GET['term']);
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

	// cari data barang
	function get_autocomplete()
	{
		if (isset($_GET['term'])) {
			$result = $this->pesanjualdetail_model->cari_brg($_GET['term']);
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
	/* ================ function cari barang bentuk kotak atau list ===================== */
	public function cari_barang()
	{
		$noresi = $this->uri->segment(3);
		$nofaktur = urldecode($this->uri->segment(3));
		$idbarang = urldecode($this->uri->segment(4));
		$departemen = $this->input->post('departemen');

		if ($idbarang <> '') {
			/* ================ proses ambil barang kirim ke database ================ */
			$cek_jenishrg = $this->pesanjualdetail_model->cek_jenis_harga($nofaktur);
			$i = $cek_jenishrg->row_array();
			$jenis_sekarang = $i['JenisHrg'];
			$kdcust = $i['KdCust'];
			$lokasi = $this->pesanjualdetail_model->cek_lokasi($nofaktur)->row_array();
			$lok = $lokasi['KdLokasi'];

			$stock = $this->pesanjualdetail_model->stocklokasi($idbarang, $lok);
			$stk = $stock->row_array();
			$produk = $this->pesanjualdetail_model->getbarang($idbarang);
			$x = $produk->row_array();
			$kdb = isset($x['KdBrg']) ? $x['KdBrg'] : '';
			$kdept = isset($x['KdDept']) ? $x['KdDept'] : '';
			$jumlah = "1";

			$cek_sudah_ada = $this->pesanjualdetail_model->cek_sudah_ada($kdb, $nofaktur);
			$cek_tpesan = $this->pesanjualdetail_model->cek_tpesan($nofaktur);
			$cek_disc_customer = $this->pesanjualdetail_model->cek_disc_customer($kdcust, $kdept);
			$d = $cek_disc_customer->row_array();
			$diskon = isset($d['Discont']) ? $d['Discont'] : '';

			$uriupdate = base_url('pesanjualdetail/update-subtotal-pesanjual/') . $nofaktur;
			$uri = base_url('pesanjualdetail/entry-pesanjualdetail/') . $nofaktur;

			if ($produk->num_rows() > 0) {

				if ($cek_sudah_ada->num_rows() > 0) {
					$s = $cek_sudah_ada->row_array();
					$kode = $s['KdBrg'];
					$kodex = $s['Barcode'];
					$sat = $s['Sat'];
					$sat1 = $s['Sat_1'];
					$disc_per = $s['Disc_per'];
					$jum_beli = $s['Jumlah'];
					$harga_jual = $s['Harga'];
					$jum_beli_sekarang = $jumlah + $jum_beli;
					/* ==== untuk menghitung disc === */
					$hrg = $harga_jual;
					$hrgdisc = $hrg;
					//$dis = $diskon;
					$diss = explode('+', $disc_per);

					for ($i = 0; $i < count($diss); $i++) {
						if (strpos($diss[$i], '%') !== false) {
							$hrg = $hrg - ($hrg / 100) * ((int) str_replace("%", "", $diss[$i]));
						} else {
							$hrg = $hrg - $diss[$i];
						}
					}
					$disc = $hrgdisc - $hrg;

					if ($kode <> 1 and $sat == $sat1) {
						$this->db->query("UPDATE tpesanjual SET jumlah='$jum_beli_sekarang', Harga='$harga_jual', Disc='$disc' WHERE KdBrg='$kdb' AND NoPesanJual='$nofaktur'");
						header("Location: " . $uriupdate, TRUE, $http_response_code);
					} else if ($kdb == $kodex and $sat == $sat1) {
						$this->db->query("UPDATE tpesanjual SET jumlah='$jum_beli_sekarang', Harga='$harga_jual', Disc='$disc' WHERE KdBrg='$kdb' AND NoPesanJual='$nofaktur'");
						header("Location: " . $uriupdate, TRUE, $http_response_code);
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
						/* ==== untuk menghitung disc === */
						$hrg = $x['HrgJl11'];
						$hrgdisc = $hrg;
						//$dis = $diskon;
						$diss = explode('+', $diskon);

						for ($i = 0; $i < count($diss); $i++) {
							if (strpos($diss[$i], '%') !== false) {
								$hrg = $hrg - ($hrg / 100) * ((int) str_replace("%", "", $diss[$i]));
							} else {
								$hrg = $hrg - $diss[$i];
							}
						}
						$disc = $hrgdisc - $hrg;

						$input = array(
							'NoPesanJual' => $nofaktur,
							'KdBrg' => $x['KdBrg'],
							'Jumlah' => $jumlah,
							'Sat' => $x['Sat_1'],
							'Harga' => $x['HrgJl11'],
							'Disc_Per' => $diskon,
							'Disc' => $disc,
							'Isi' => '1',
							'KdHrg' => 'H1',
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
						header("Location: " . $uriupdate, TRUE, $http_response_code);
					} else if ($jenis_sekarang == 'H2') {
						/* ==== untuk menghitung disc === */
						$hrg = $x['HrgJl12'];
						$hrgdisc = $hrg;
						//$dis = $diskon;
						$diss = explode('+', $diskon);
						for ($i = 0; $i < count($diss); $i++) {
							if (strpos($diss[$i], '%') !== false) {
								$hrg = $hrg - ($hrg / 100) * ((int) str_replace("%", "", $diss[$i]));
							} else {
								$hrg = $hrg - $diss[$i];
							}
						}
						$disc = $hrgdisc - $hrg;
						$input = array(
							'NoPesanJual' => $nofaktur,
							'KdBrg' => $x['KdBrg'],
							'Jumlah' => $jumlah,
							'Sat' => $x['Sat_1'],
							'Harga' => $x['HrgJl12'],
							'Disc_Per' => $diskon,
							'Disc' => $disc,
							'Isi' => '1',
							'KdHrg' => 'H2',
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
						header("Location: " . $uriupdate, TRUE, $http_response_code);
					} else if ($jenis_sekarang == 'H3') {
						/* ==== untuk menghitung disc === */
						$hrg = $x['HrgJl13'];
						$hrgdisc = $hrg;
						//$dis = $diskon;
						$diss = explode('+', $diskon);

						for ($i = 0; $i < count($diss); $i++) {
							if (strpos($diss[$i], '%') !== false) {
								$hrg = $hrg - ($hrg / 100) * ((int) str_replace("%", "", $diss[$i]));
							} else {
								$hrg = $hrg - $diss[$i];
							}
						}
						$disc = $hrgdisc - $hrg;
						$input = array(
							'NoPesanJual' => $nofaktur,
							'KdBrg' => $x['KdBrg'],
							'Jumlah' => $jumlah,
							'Sat' => $x['Sat_1'],
							'Harga' => $x['HrgJl13'],
							'Disc_Per' => $diskon,
							'Disc' => $disc,
							'Isi' => '1',
							'KdHrg' => 'H3',
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
						header("Location: " . $uriupdate, TRUE, $http_response_code);
					} else if ($jenis_sekarang == 'H4') {
						/* ==== untuk menghitung disc === */
						$hrg = $x['HrgJl14'];
						$hrgdisc = $hrg;
						//$dis = $diskon;
						$diss = explode('+', $diskon);

						for ($i = 0; $i < count($diss); $i++) {
							if (strpos($diss[$i], '%') !== false) {
								$hrg = $hrg - ($hrg / 100) * ((int) str_replace("%", "", $diss[$i]));
							} else {
								$hrg = $hrg - $diss[$i];
							}
						}
						$disc = $hrgdisc - $hrg;
						$input = array(
							'NoPesanJual' => $nofaktur,
							'KdBrg' => $x['KdBrg'],
							'Jumlah' => $jumlah,
							'Sat' => $x['Sat_1'],
							'Harga' => $x['HrgJl14'],
							'Disc_Per' => $diskon,
							'Disc' => $disc,
							'Isi' => '1',
							'KdHrg' => 'H4',
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
						header("Location: " . $uriupdate, TRUE, $http_response_code);
					} else {
						echo $this->session->set_flashdata('error', 'Customer ' . $jenis_sekarang . ' tidak boleh kosong :(');
						header("Location: " . $uri, TRUE, $http_response_code);
					}
				}
			} else {
				echo $this->session->set_flashdata('error', 'Kode ' . $idbarang . ' tidak tersedia :(');
				header("Location: " . $uri, TRUE, $http_response_code = 0);
			}
		} else {
			$data['title'] = 'Cari Barang';
			$data['kategori'] = $this->pesanjualdetail_model->departemen_barang();
			$username = $this->session->userdata('ses_username');
			$setting['user'] = $this->login_model->sistemuser($username)->row();
			$setting['seting'] = $this->login_model->seting()->row();

			$data['faktur'] = $this->pesanjualdetail_model->getDataPenjualan($noresi)->row();
			//$data['faktur'] = $this->pesanjualdetail_model->getDataPenjualan($noresi, $username)->row();
			if ($departemen <> '') {
				$data['item'] = $this->pesanjualdetail_model->getItems($departemen);
			} else {
				$data['item'] = $this->pesanjualdetail_model->getItem();
			}

			$this->load->view('header', $setting);
			$this->load->view('pesanjualdetail/cari_barang', $data);
			$this->load->view('footers');
		}
	}
	function get_data_barang()
	{
		$nofaktur = urldecode($this->uri->segment(3));
		$list = $this->barang_model->get_datatables();
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $field) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $field->KdBrg;
			$row[] = $field->NmBrg;
			$row[] = $field->Stock_Akhir;
			$row[] = number_format($field->HrgJl11);
			$row[] = "<a href='$nofaktur/$field->KdBrg'><i class='fas fa-cart-plus' aria-hidden='true'></i></a>";
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->barang_model->count_all(),
			"recordsFiltered" => $this->barang_model->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	// proses cek data customer
	public function cekcust()
	{
		$nofaktur = urldecode($this->uri->segment(3));
		$idcust = urldecode($this->uri->segment(4));
		$customer = $this->pesanjualdetail_model->getcustomer($idcust);
		$cek_sudah_ada = $this->pesanjualdetail_model->cek_cust_ada($idcust, $nofaktur);
		$x = $customer->row_array();
		$kdcust = $x['KdCust'];
		$nmcust = $x['NmCust'];
		$harga = $x['HrgJual'];
		$uri = base_url('pesanjualdetail/entry-pesanjualdetail/') . $nofaktur;

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

	// Proses Cek data sales
	public function ceksales()
	{
		$nofaktur = urldecode($this->uri->segment(3));
		$idsales = urldecode($this->uri->segment(4));
		$sales = $this->pesanjualdetail_model->getsales($idsales);
		$cek_sudah_ada = $this->pesanjualdetail_model->cek_sales_ada($idsales, $nofaktur);
		$x = $sales->row_array();
		$kdsales = $x['KdSales'];
		$nmsales = $x['NmSales'];
		//$nmsales = $x['NmSales'];
		$uri = base_url('pesanjualdetail/entry-pesanjualdetail/') . $nofaktur;

		if ($sales->num_rows() > 0) {
			$x = $sales->row_array();
			$kode = $x['KdSales'];
			if ($cek_sudah_ada < $kode) {
				echo $this->session->set_flashdata('error', 'kode sudah ada');
				header("Location: " . $uri, TRUE, $http_response_code);
			} else {
				$this->db->query("UPDATE mpesanjual SET KdSales='$kdsales', NmSales='$nmsales'  WHERE  NoPesanJual='$nofaktur'");
				header("Location: " . $uri, TRUE, $http_response_code);
			}
		} else {
			echo $this->session->set_flashdata('error', 'Kode ' . $idsales . '' . $sales . ' tidak tersedia :(');
			header("Location: " . $uri, TRUE, $http_response_code);
		}
	}

	// proses edit satuan item/barang di faktur jual
	public function edit_satuan()
	{
		$idbarang = $this->input->post('kdbrg_s');
		$nofaktur = $this->input->post('nofak_s');
		$barang = $this->input->post('kdbrg_s');
		$satuan = $this->input->post('sat');
		$jumlah = $this->input->post('jumlah');

		$cek_satuan_ada = $this->pesanjualdetail_model->cek_satuan_ada($idbarang, $nofaktur);
		$x = $cek_satuan_ada->row_array();
		$kode = $x['KdHrg'];

		$sat = $x['Sat'];
		$s1 = $x['Sat_1'];
		$s2 = $x['Sat_2'];
		$s3 = $x['Sat_3'];
		$s4 = $x['Sat_4'];
		$harga = $x['Harga'];
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
		$uriupdate = base_url('pesanjualdetail/update-subtotal-pesanjual/') . $nofaktur;
		$uri = base_url('pesanjualdetail/entry-pesanjualdetail/') . $nofaktur;

		if ($satuan <> '') {
			if ($satuan == $s1) {
				if ($kode == 'H1') {
					$this->db->query("UPDATE tpesanjual SET Sat='$s1', Jumlah=if($jumlah<=0,1,$jumlah), Harga='$h11', Isi='1', Disc_per='0', Disc='0'  WHERE KdBrg='$barang' AND  NoPesanJual='$nofaktur'");
					header("Location: " . $uriupdate, TRUE, $http_response_code);
				} else if ($kode == 'H2') {
					$this->db->query("UPDATE tpesanjual SET Sat='$s1', Jumlah=if($jumlah<=0,1,$jumlah), Harga='$h12', Isi='1', Disc_per='0', Disc='0'  WHERE KdBrg='$barang' AND  NoPesanJual='$nofaktur'");
					header("Location: " . $uriupdate, TRUE, $http_response_code);
				} else if ($kode == 'H3') {
					$this->db->query("UPDATE tpesanjual SET Sat='$s1', Jumlah=if($jumlah<=0,1,$jumlah), Harga='$h13', Isi='1', Disc_per='0', Disc='0'  WHERE KdBrg='$barang' AND  NoPesanJual='$nofaktur'");
					header("Location: " . $uriupdate, TRUE, $http_response_code);
				} else if ($kode == 'H4') {
					$this->db->query("UPDATE tpesanjual SET Sat='$s1', Jumlah=if($jumlah<=0,1,$jumlah), Harga='$h14', Isi='1', Disc_per='0', Disc='0'  WHERE KdBrg='$barang' AND  NoPesanJual='$nofaktur'");
					header("Location: " . $uriupdate, TRUE, $http_response_code);
				} else {
					echo $this->session->set_flashdata('error', 'Satuan ' . $satuan . '' . $barang .  ' tidak tersediax :(');
				}
			} else if ($satuan == $s2) {
				if ($kode == 'H1') {
					$this->db->query("UPDATE tpesanjual SET Sat='$s2', Jumlah=if($jumlah<=0,1,$jumlah), Harga='$h21',  Isi=Isi_2, Disc_per='0', Disc='0'   WHERE KdBrg='$barang' AND  NoPesanJual='$nofaktur'");
					header("Location: " . $uriupdate, TRUE, $http_response_code);
				} else if ($kode == 'H2') {
					$this->db->query("UPDATE tpesanjual SET Sat='$s2', Jumlah=if($jumlah<=0,1,$jumlah), Harga='$h22', Isi=Isi_2, Disc_per='0', Disc='0'  WHERE KdBrg='$barang' AND  NoPesanJual='$nofaktur'");
					header("Location: " . $uriupdate, TRUE, $http_response_code);
				} else if ($kode == 'H3') {
					$this->db->query("UPDATE tpesanjual SET Sat='$s2', Jumlah=if($jumlah<=0,1,$jumlah), Harga='$h23', Isi=Isi_2, Disc_per='0', Disc='0'  WHERE KdBrg='$barang' AND  NoPesanJual='$nofaktur'");
					header("Location: " . $uriupdate, TRUE, $http_response_code);
				} else if ($kode == 'H4') {
					$this->db->query("UPDATE tpesanjual SET Sat='$s2', Jumlah=if($jumlah<=0,1,$jumlah), Harga='$h24', Isi=Isi_2, Disc_per='0', Disc='0'  WHERE KdBrg='$barang' AND  NoPesanJual='$nofaktur'");
					header("Location: " . $uriupdate, TRUE, $http_response_code);
				} else {
					echo $this->session->set_flashdata('error', 'Satuan ' . $satuan . '' . $barang .  ' tidak tersediax :(');
					header("Location: " . $uri, TRUE, $http_response_code);
				}
			} else if ($satuan == $s3) {
				if ($kode == 'H1') {
					$this->db->query("UPDATE tpesanjual SET Sat='$s3', Jumlah=if($jumlah<=0,1,$jumlah), Harga='$h31',  Isi=Isi_3, Disc_per='0', Disc='0'   WHERE KdBrg='$barang' AND  NoPesanJual='$nofaktur'");
					header("Location: " . $uriupdate, TRUE, $http_response_code);
				} else if ($kode == 'H2') {
					$this->db->query("UPDATE tpesanjual SET Sat='$s3', Jumlah=if($jumlah<=0,1,$jumlah), Harga='$h32', Isi=Isi_3, Disc_per='0', Disc='0'  WHERE KdBrg='$barang' AND  NoPesanJual='$nofaktur'");
					header("Location: " . $uriupdate, TRUE, $http_response_code);
				} else if ($kode == 'H3') {
					$this->db->query("UPDATE tpesanjual SET Sat='$s3', Jumlah=if($jumlah<=0,1,$jumlah), Harga='$h33', Isi=Isi_3, Disc_per='0', Disc='0'  WHERE KdBrg='$barang' AND  NoPesanJual='$nofaktur'");
					header("Location: " . $uriupdate, TRUE, $http_response_code);
				} else if ($kode == 'H4') {
					$this->db->query("UPDATE tpesanjual SET Sat='$s3', Jumlah=if($jumlah<=0,1,$jumlah), Harga='$h34', Isi=Isi_3, Disc_per='0', Disc='0'  WHERE KdBrg='$barang' AND  NoPesanJual='$nofaktur'");
					header("Location: " . $uriupdate, TRUE, $http_response_code);
				} else {
					echo $this->session->set_flashdata('error', 'Satuan ' . $satuan . '' . $barang .  ' tidak tersediax :(');
					header("Location: " . $uri, TRUE, $http_response_code);
				}
			} else if ($satuan == $s4) {
				if ($kode == 'H1') {
					$this->db->query("UPDATE tpesanjual SET Sat='$s4', Jumlah=if($jumlah<=0,1,$jumlah), Harga='$h41', Isi=Isi_4, Disc_per='0', Disc='0'  WHERE KdBrg='$barang' AND  NoPesanJual='$nofaktur'");
					header("Location: " . $uriupdate, TRUE, $http_response_code);
				} else if ($kode == 'H2') {
					$this->db->query("UPDATE tpesanjual SET Sat='$s4', Jumlah=if($jumlah<=0,1,$jumlah), Harga='$h42', Isi=Isi_4, Disc_per='0', Disc='0'  WHERE KdBrg='$barang' AND  NoPesanJual='$nofaktur'");
					header("Location: " . $uriupdate, TRUE, $http_response_code);
				} else if ($kode == 'H3') {
					$this->db->query("UPDATE tpesanjual SET Sat='$s4', Jumlah=if($jumlah<=0,1,$jumlah), Harga='$h43', Isi=Isi_4, Disc_per='0', Disc='0'  WHERE KdBrg='$barang' AND  NoPesanJual='$nofaktur'");
					header("Location: " . $uriupdate, TRUE, $http_response_code);
				} else if ($kode == 'H4') {
					$this->db->query("UPDATE tpesanjual SET Sat='$s4', Jumlah=if($jumlah<=0,1,$jumlah), Harga='$h44', Isi=Isi_4, Disc_per='0', Disc='0'  WHERE KdBrg='$barang' AND  NoPesanJual='$nofaktur'");
					header("Location: " . $uriupdate, TRUE, $http_response_code);
				} else {
					echo $this->session->set_flashdata('error', 'Satuan ' . $satuan . '' . $barang .  ' tidak tersediax :(');
					header("Location: " . $uri, TRUE, $http_response_code);
				}
			} else {
				echo $this->session->set_flashdata('error', 'Satuan ' . $satuan . ' xtidak tersedia :(');
				header("Location: " . $uri, TRUE, $http_response_code);
			}
		} else if ($satuan == '') {
			$this->db->query("UPDATE tpesanjual SET Sat='$sat', Jumlah=if($jumlah<=0,1,$jumlah), Harga='$harga', Isi='1', Disc_per='0', Disc='0'  WHERE KdBrg='$barang' AND  NoPesanJual='$nofaktur'");
			header("Location: " . $uriupdate, TRUE, $http_response_code);
		} else {
			header("Location: " . $uri, TRUE, $http_response_code);
		}
	}

	// proses ganti kode harga jual di faktur jual
	function edit_jenis_harga()
	{
		$nofaktur = $this->input->post('nofak');
		$nmuser = $this->input->post('nmuser');
		$jenis = $this->input->post('jnshrg');
		$cek_jenishrg = $this->pesanjualdetail_model->cek_jenis_harga($nofaktur);
		$x = $cek_jenishrg->row_array();
		$kode = $x['JenisHrg'];

		$uriupdate = base_url('pesanjualdetail/update-subtotal-pesanjual/') . $nofaktur;
		$uri = base_url('pesanjualdetail/entry-pesanjualdetail/') . $nofaktur;

		if ($jenis == $kode) {
			echo $this->session->set_flashdata('error', 'Jenis Harga ' . $jenis . ' sudah sama :(');
			header("Location: " . $uri, TRUE, $http_response_code);
		} elseif ($jenis <> $kode) {
			$this->db->query("UPDATE mpesanjual SET JenisHrg='$jenis' WHERE  NoPesanJual='$nofaktur'");
			$h = substr($jenis, 1); //2;// RIGHT($jenis,1);
			$this->db->query("UPDATE tpesanjual SET KdHrg='$jenis', Harga=if(Sat=Sat_1,HrgJl1$h,if(Sat=Sat_2,HrgJl2$h,if(Sat=Sat_3,HrgJl3$h,if(Sat=Sat_4,HrgJl4$h,HrgJl1$h)))), Disc_per='0', Disc='0', SPV_Pesan='$nmuser' WHERE  NoPesanJual='$nofaktur'");
			header("Location: " . $uriupdate, TRUE, $http_response_code);
		} else {
			echo $this->session->set_flashdata('error', 'Jenis Harga ' . $nofaktur . ' tidak ada :(');
			header("Location: " . $uri, TRUE, $http_response_code);
		}
	}

	/* ============================ update subtotal tabel M ======================= */
	public function update_subtotal_pesanjual()
	{
		$nofaktur = urldecode($this->uri->segment(3));
		$tdetail = $this->pesanjualdetail_model->ambildatadetail($nofaktur);

		$uri = base_url('pesanjualdetail/entry-pesanjualdetail/') . $nofaktur;

		foreach ($tdetail->result() as $key) {
			$total += (($key->Harga - $key->Disc) * $key->Jumlah);
		}

		$this->db->query("UPDATE mpesanjual set SubTotal = '$total' WHERE  NoPesanJual='$nofaktur'");
		header("Location: " . $uri, TRUE, $http_response_code);
	}


	/* ========================== untuk proses entry item barang di form Pesan jual detail ==================== */
	public function cekbarang()
	{
		$nofaktur = urldecode($this->uri->segment(3));
		$idbarang = urldecode($this->uri->segment(4));

		$cek_jenishrg = $this->pesanjualdetail_model->cek_jenis_harga($nofaktur);
		$i = $cek_jenishrg->row_array();
		$jenis_sekarang = $i['JenisHrg'];
		$kdcust = $i['KdCust'];
		$lokasi = $this->pesanjualdetail_model->cek_lokasi($nofaktur)->row_array();
		$lok = $lokasi['KdLokasi'];

		$stock = $this->pesanjualdetail_model->stocklokasi($idbarang, $lok);
		$stk = $stock->row_array();
		$produk = $this->pesanjualdetail_model->getbarang($idbarang);
		$x = $produk->row_array();
		$kdb = isset($x['KdBrg']) ? $x['KdBrg'] : '';
		$kdept = isset($x['KdDept']) ? $x['KdDept'] : '';
		$jumlah = "1";

		$cek_sudah_ada = $this->pesanjualdetail_model->cek_sudah_ada($kdb, $nofaktur);
		$cek_tpesan = $this->pesanjualdetail_model->cek_tpesan($nofaktur);
		$cek_disc_customer = $this->pesanjualdetail_model->cek_disc_customer($kdcust, $kdept);
		$d = $cek_disc_customer->row_array();
		$diskon = isset($d['Discont']) ? $d['Discont'] : '';

		$uri = base_url('pesanjualdetail/entry-pesanjualdetail/') . $nofaktur;
		$uriupdate = base_url('pesanjualdetail/update-subtotal-pesanjual/') . $nofaktur;

		if ($produk->num_rows() > 0) {

			if ($cek_sudah_ada->num_rows() > 0) {
				$s = $cek_sudah_ada->row_array();
				$kode = $s['KdBrg'];
				$kodex = $s['Barcode'];
				$sat = $s['Sat'];
				$sat1 = $s['Sat_1'];
				$disc_per = $s['Disc_per'];
				$jum_beli = $s['Jumlah'];
				$harga_jual = $s['Harga'];
				$jum_beli_sekarang = $jumlah + $jum_beli;
				/* ==== untuk menghitung disc === */
				$hrg = $harga_jual;
				$hrgdisc = $hrg;
				//$dis = $diskon;
				$diss = explode('+', $disc_per);

				for ($i = 0; $i < count($diss); $i++) {
					if (strpos($diss[$i], '%') !== false) {
						$hrg = $hrg - ($hrg / 100) * ((int) str_replace("%", "", $diss[$i]));
					} else {
						$hrg = $hrg - $diss[$i];
					}
				}
				$disc = $hrgdisc - $hrg;

				if ($kode <> 1 and $sat == $sat1) {
					$this->db->query("UPDATE tpesanjual SET jumlah='$jum_beli_sekarang', Harga='$harga_jual', Disc='$disc' WHERE KdBrg='$kdb' AND NoPesanJual='$nofaktur'");
					header("Location: " . $uriupdate, TRUE, $http_response_code);
				} else if ($kdb == $kodex and $sat == $sat1) {
					$this->db->query("UPDATE tpesanjual SET jumlah='$jum_beli_sekarang', Harga='$harga_jual', Disc='$disc' WHERE KdBrg='$kdb' AND NoPesanJual='$nofaktur'");
					header("Location: " . $uriupdate, TRUE, $http_response_code);
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
					/* ==== untuk menghitung disc === */
					$hrg = $x['HrgJl11'];
					$hrgdisc = $hrg;
					//$dis = $diskon;
					$diss = explode('+', $diskon);

					for ($i = 0; $i < count($diss); $i++) {
						if (strpos($diss[$i], '%') !== false) {
							$hrg = $hrg - ($hrg / 100) * ((int) str_replace("%", "", $diss[$i]));
						} else {
							$hrg = $hrg - $diss[$i];
						}
					}
					$disc = $hrgdisc - $hrg;

					$input = array(
						'NoPesanJual' => $nofaktur,
						'KdBrg' => $x['KdBrg'],
						'Jumlah' => $jumlah,
						'Sat' => $x['Sat_1'],
						'Harga' => $x['HrgJl11'],
						'Disc_Per' => $diskon,
						'Disc' => $disc,
						'Isi' => '1',
						'KdHrg' => 'H1',
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
					header("Location: " . $uriupdate, TRUE, $http_response_code);
				} else if ($jenis_sekarang == 'H2') {
					/* ==== untuk menghitung disc === */
					$hrg = $x['HrgJl12'];
					$hrgdisc = $hrg;
					//$dis = $diskon;
					$diss = explode('+', $diskon);
					for ($i = 0; $i < count($diss); $i++) {
						if (strpos($diss[$i], '%') !== false) {
							$hrg = $hrg - ($hrg / 100) * ((int) str_replace("%", "", $diss[$i]));
						} else {
							$hrg = $hrg - $diss[$i];
						}
					}
					$disc = $hrgdisc - $hrg;
					$input = array(
						'NoPesanJual' => $nofaktur,
						'KdBrg' => $x['KdBrg'],
						'Jumlah' => $jumlah,
						'Sat' => $x['Sat_1'],
						'Harga' => $x['HrgJl12'],
						'Disc_Per' => $diskon,
						'Disc' => $disc,
						'Isi' => '1',
						'KdHrg' => 'H2',
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
					header("Location: " . $uriupdate, TRUE, $http_response_code);
				} else if ($jenis_sekarang == 'H3') {
					/* ==== untuk menghitung disc === */
					$hrg = $x['HrgJl13'];
					$hrgdisc = $hrg;
					//$dis = $diskon;
					$diss = explode('+', $diskon);

					for ($i = 0; $i < count($diss); $i++) {
						if (strpos($diss[$i], '%') !== false) {
							$hrg = $hrg - ($hrg / 100) * ((int) str_replace("%", "", $diss[$i]));
						} else {
							$hrg = $hrg - $diss[$i];
						}
					}
					$disc = $hrgdisc - $hrg;
					$input = array(
						'NoPesanJual' => $nofaktur,
						'KdBrg' => $x['KdBrg'],
						'Jumlah' => $jumlah,
						'Sat' => $x['Sat_1'],
						'Harga' => $x['HrgJl13'],
						'Disc_Per' => $diskon,
						'Disc' => $disc,
						'Isi' => '1',
						'KdHrg' => 'H3',
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
					header("Location: " . $uriupdate, TRUE, $http_response_code);
				} else if ($jenis_sekarang == 'H4') {
					/* ==== untuk menghitung disc === */
					$hrg = $x['HrgJl14'];
					$hrgdisc = $hrg;
					//$dis = $diskon;
					$diss = explode('+', $diskon);

					for ($i = 0; $i < count($diss); $i++) {
						if (strpos($diss[$i], '%') !== false) {
							$hrg = $hrg - ($hrg / 100) * ((int) str_replace("%", "", $diss[$i]));
						} else {
							$hrg = $hrg - $diss[$i];
						}
					}
					$disc = $hrgdisc - $hrg;
					$input = array(
						'NoPesanJual' => $nofaktur,
						'KdBrg' => $x['KdBrg'],
						'Jumlah' => $jumlah,
						'Sat' => $x['Sat_1'],
						'Harga' => $x['HrgJl14'],
						'Disc_Per' => $diskon,
						'Disc' => $disc,
						'Isi' => '1',
						'KdHrg' => 'H4',
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
					header("Location: " . $uriupdate, TRUE, $http_response_code);
				} else {
					echo $this->session->set_flashdata('error', 'Customer ' . $jenis_sekarang . ' tidak boleh kosong :(');
					header("Location: " . $uri, TRUE, $http_response_code);
				}
			}
		} else {
			echo $this->session->set_flashdata('error', 'Kode ' . $idbarang . ' tidak tersedia :(');
			header("Location: " . $uri, TRUE, $http_response_code = 0);
		}
	}

	// untuk hapus item barang di form pesan jual detail
	public function hapus_barang_beli()
	{
		$nofaktur = urldecode($this->uri->segment(3));
		$idbarang = urldecode($this->uri->segment(4));

		$uri = base_url('pesanjualdetail/update-subtotal-pesanjual/') . $nofaktur;
		//$uri = base_url('pesanjualdetail/entry-pesanjualdetail/') . $nofaktur;
		$this->db->query("DELETE FROM tpesanjual WHERE NoPesanJual='$nofaktur' AND KdBrg='$idbarang'");
		header("Location: " . $uri, TRUE, $http_response_code);
	}

	// untuk proses edit jumlah item di form pesan jual detail
	public function edit_jumlah_beli()
	{
		$idbarang = $this->input->post('KdBrg_e');
		$nofaktur = $this->input->post('nofak_e');
		$jumlah = $this->input->post('jml');

		$uri = base_url('pesanjualdetail/entry-pesanjualdetail/') . $nofaktur;
		$uriupdate = base_url('pesanjualdetail/update-subtotal-pesanjual/') . $nofaktur;

		$cek_stok = $this->pesanjualdetail_model->cek_jumlah_stok($idbarang);
		$rinci = $this->pesanjualdetail_model->cek_sudah_ada($idbarang, $nofaktur);

		$x = $rinci->row_array();
		$kodeharga = $x['KdHrg'];
		$sat = $x['Sat'];
		$sat1 = $x['Sat_1'];
		$isi2 = $x['Isi_2'];
		$isi3 = $x['Isi_3'];
		$isi4 = $x['Isi_4'];
		// H1
		$h11 = $x['HrgJl11'];

		if ($sat == $sat1) {
			if ($kodeharga == 'H1') {
				if ($jumlah >= $isi4 and $isi4 <> 0) {
					$this->db->query("UPDATE tpesanjual SET Jumlah='$jumlah', Harga=HrgJl41/Isi_4, Disc_per='0', Disc='0' WHERE KdBrg='$idbarang' AND NoPesanJual='$nofaktur'");
					header("Location: " . $uriupdate, TRUE, $http_response_code);
				} else if ($jumlah >= $isi3 and $isi3 <> 0) {
					$this->db->query("UPDATE tpesanjual SET Jumlah='$jumlah', Harga=HrgJl31/Isi_3, Disc_per='0', Disc='0' WHERE KdBrg='$idbarang' AND NoPesanJual='$nofaktur'");
					header("Location: " . $uriupdate, TRUE, $http_response_code);
				} else if ($jumlah >= $isi2 and $isi2 <> 0) {
					$this->db->query("UPDATE tpesanjual SET Jumlah='$jumlah', Harga=HrgJl21/Isi_2, Disc_per='0', Disc='0' WHERE KdBrg='$idbarang' AND NoPesanJual='$nofaktur'");
					header("Location: " . $uriupdate, TRUE, $http_response_code);
				} /* else if ($jumlah < $stok_sekarang) {
					echo $this->session->set_flashdata('error', 'isi jumlah tidak benar');
					header("Location: " . $uri, TRUE, $http_response_code);
				} */ else if ($jumlah == 0) {
					echo $this->session->set_flashdata('error', 'isi jumlah tidak boleh 0');
					header("Location: " . $uri, TRUE, $http_response_code);
				} else {
					$this->db->query("UPDATE tpesanjual SET Jumlah='$jumlah', Harga='$h11', Disc_per='0', Disc='0' WHERE KdBrg='$idbarang' AND NoPesanJual='$nofaktur'");
					header("Location: " . $uriupdate, TRUE, $http_response_code);
				}
			} elseif ($kodeharga == 'H2') {
				if ($jumlah >= $isi4 and $isi4 <> 0) {
					$this->db->query("UPDATE tpesanjual SET Jumlah='$jumlah', Harga=HrgJl42/Isi_4, Disc_per='0', Disc='0' WHERE KdBrg='$idbarang' AND NoPesanJual='$nofaktur'");
					header("Location: " . $uriupdate, TRUE, $http_response_code);
				} else if ($jumlah >= $isi3 and $isi3 <> 0) {
					$this->db->query("UPDATE tpesanjual SET Jumlah='$jumlah', Harga=HrgJl32/Isi_3, Disc_per='0', Disc='0' WHERE KdBrg='$idbarang' AND NoPesanJual='$nofaktur'");
					header("Location: " . $uriupdate, TRUE, $http_response_code);
				} else if ($jumlah >= $isi2 and $isi2 <> 0) {
					$this->db->query("UPDATE tpesanjual SET Jumlah='$jumlah', Harga=HrgJl22/Isi_2, Disc_per='0', Disc='0' WHERE KdBrg='$idbarang' AND NoPesanJual='$nofaktur'");
					header("Location: " . $uriupdate, TRUE, $http_response_code);
				} /* else if ($jumlah < $stok_sekarang) {
					echo $this->session->set_flashdata('error', 'isi jumlah tidak benar');
					header("Location: " . $uri, TRUE, $http_response_code);
				} */ else if ($jumlah == 0) {
					echo $this->session->set_flashdata('error', 'isi jumlah tidak boleh 0');
					header("Location: " . $uri, TRUE, $http_response_code);
				} else {
					$this->db->query("UPDATE tpesanjual SET Jumlah='$jumlah', Harga=Hrgjl12, Disc_per='0', Disc='0' WHERE KdBrg='$idbarang' AND NoPesanJual='$nofaktur'");
					header("Location: " . $uriupdate, TRUE, $http_response_code);
				}
			} elseif ($kodeharga == 'H3') {
				if ($jumlah >= $isi4 and $isi4 <> 0) {
					$this->db->query("UPDATE tpesanjual SET Jumlah='$jumlah', Harga=HrgJl43/Isi_4, Disc_per='0', Disc='0' WHERE KdBrg='$idbarang' AND NoPesanJual='$nofaktur'");
					header("Location: " . $uriupdate, TRUE, $http_response_code);
				} else if ($jumlah >= $isi3 and $isi3 <> 0) {
					$this->db->query("UPDATE tpesanjual SET Jumlah='$jumlah', Harga=HrgJl33/Isi_3, Disc_per='0', Disc='0' WHERE KdBrg='$idbarang' AND NoPesanJual='$nofaktur'");
					header("Location: " . $uriupdate, TRUE, $http_response_code);
				} else if ($jumlah >= $isi2 and $isi2 <> 0) {
					$this->db->query("UPDATE tpesanjual SET Jumlah='$jumlah', Harga=HrgJl23/Isi_2, Disc_per='0', Disc='0' WHERE KdBrg='$idbarang' AND NoPesanJual='$nofaktur'");
					header("Location: " . $uriupdate, TRUE, $http_response_code);
				} else if ($jumlah == 0) {
					echo $this->session->set_flashdata('error', 'isi jumlah tidak boleh 0');
					header("Location: " . $uri, TRUE, $http_response_code);
				} else {
					$this->db->query("UPDATE tpesanjual SET Jumlah='$jumlah', Harga=HrgJl13, Disc_per='0', Disc='0' WHERE KdBrg='$idbarang' AND NoPesanJual='$nofaktur'");
					header("Location: " . $uriupdate, TRUE, $http_response_code);
				}
			} elseif ($kodeharga == 'H4') {
				if ($jumlah >= $isi4 and $isi4 <> 0) {
					$this->db->query("UPDATE tpesanjual SET Jumlah='$jumlah', Harga=HrgJl44/Isi_4, Disc_per='0', Disc='0' WHERE KdBrg='$idbarang' AND NoPesanJual='$nofaktur'");
					header("Location: " . $uriupdate, TRUE, $http_response_code);
				} else if ($jumlah >= $isi3 and $isi3 <> 0) {
					$this->db->query("UPDATE tpesanjual SET Jumlah='$jumlah', Harga=HrgJl34/Isi_3, Disc_per='0', Disc='0' WHERE KdBrg='$idbarang' AND NoPesanJual='$nofaktur'");
					header("Location: " . $uriupdate, TRUE, $http_response_code);
				} else if ($jumlah >= $isi2 and $isi2 <> 0) {
					$this->db->query("UPDATE tpesanjual SET Jumlah='$jumlah', Harga=HrgJl24/Isi_2, Disc_per='0', Disc='0' WHERE KdBrg='$idbarang' AND NoPesanJual='$nofaktur'");
					header("Location: " . $uriupdate, TRUE, $http_response_code);
				} else if ($jumlah == 0) {
					echo $this->session->set_flashdata('error', 'isi jumlah tidak boleh 0');
					header("Location: " . $uri, TRUE, $http_response_code);
				} else {
					$this->db->query("UPDATE tpesanjual SET Jumlah='$jumlah', Harga=HrgJl14, Disc_per='0', Disc='0' WHERE KdBrg='$idbarang' AND NoPesanJual='$nofaktur'");
					header("Location: " . $uriupdate, TRUE, $http_response_code);
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

	// untuk merubah harga jual di faktur jual
	public function edit_harga_jual()
	{
		$idbarang = $this->input->post('KdBrg_h');
		$nmuser = $this->input->post('nmuser');
		$nofaktur = $this->input->post('nofak_h');
		$harga = $this->input->post('hrg');
		$uri = base_url('pesanjualdetail/entry-pesanjualdetail/') . $nofaktur;
		$uriupdate = base_url('pesanjualdetail/update-subtotal-pesanjual/') . $nofaktur;

		$rinci = $this->pesanjualdetail_model->cek_sudah_ada($idbarang, $nofaktur);
		$x = $rinci->row_array();
		$hbt = $x['HBT'];
		$diskon = $x['Disc_per'];
		/* ==== untuk menghitung disc === */
		$hrg = $harga;
		$hrgdisc = $hrg;
		$diss = explode('+', $diskon);

		for ($i = 0; $i < count($diss); $i++) {
			if (strpos($diss[$i], '%') !== false) {
				$hrg = $hrg - ($hrg / 100) * ((int) str_replace("%", "", $diss[$i]));
			} else {
				$hrg = $hrg - $diss[$i];
			}
		}
		$disc = $hrgdisc - $hrg;

		if ($harga <= $hbt) {
			echo $this->session->set_flashdata('error', 'cek harga rugi');
			header("Location: " . $uri, TRUE, $http_response_code);
		} else {
			$this->db->query("UPDATE tpesanjual SET Harga='$harga', Disc='$disc', SPV_Pesan='$nmuser' WHERE KdBrg='$idbarang' AND NoPesanJual='$nofaktur'");
			header("Location: " . $uriupdate, TRUE, $http_response_code);
		}
	}

	// proses untuk edit sales faktur jual yang tpesanjual
	public function edit_kdsales()
	{
		$idsales = $this->input->post('sales');
		$nofaktur = $this->input->post('nofak');
		$idbarang = $this->input->post('kdbrg');
		$ceksales = $this->pesanjualdetail_model->ceksales_detail($idsales, $idbarang, $nofaktur);
		$getsales = $this->pesanjualdetail_model->getsales($idsales);
		$k = $getsales->row_array();
		$x = $ceksales->row_array();
		$kode = $x['KdSales'];
		$sales = $k['KdSales'];
		$uri = base_url('pesanjualdetail/entry-pesanjualdetail/') . $nofaktur;

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


	// proses edit disc di form faktur jual
	public function edit_diskon_beli()
	{
		$nofaktur = $this->input->post('nofak');
		$idbarang = $this->input->post('kdbrg');
		$nmuser = $this->input->post('nmuser');
		$diskon = $this->input->post('disc');
		$uri = base_url('pesanjualdetail/entry-pesanjualdetail/') . $nofaktur;
		$uriupdate = base_url('pesanjualdetail/update-subtotal-pesanjual/') . $nofaktur;

		$rinci = $this->pesanjualdetail_model->cek_sudah_ada($idbarang, $nofaktur);
		$x = $rinci->row_array();
		/* ==== untuk menghitung disc === */
		$hrg = $x['Harga'];
		$hrgdisc = $hrg;
		$diss = explode('+', $diskon);

		for ($i = 0; $i < count($diss); $i++) {
			if (strpos($diss[$i], '%') !== false) {
				$hrg = $hrg - ($hrg / 100) * ((int) str_replace("%", "", $diss[$i]));
			} else {
				$hrg = $hrg - $diss[$i];
			}
		}
		$disc = $hrgdisc - $hrg;

		if ($diskon == '') {
			echo $this->session->set_flashdata('error', 'Diskon tidak valid');
			header("Location: " . $uri, TRUE, $http_response_code);
		} else if (strpos($diskon, '-') !== false) {
			echo $this->session->set_flashdata('error', 'Diskon Minus tidak valid');
			header("Location: " . $uri, TRUE, $http_response_code);
		} else {
			$this->db->query("UPDATE tpesanjual SET Disc_Per='$diskon',Disc='$disc',SPV_pesan='$nmuser'  WHERE KdBrg='$idbarang' AND NoPesanJual='$nofaktur'");
			header("Location: " . $uriupdate, TRUE, $http_response_code);
		}
	}


	// proses hapus antrian jual faktur jual
	public function hapus_faktur()
	{
		$nofaktur = urldecode($this->uri->segment(3));
		$this->db->query("DELETE FROM mpesanjual WHERE NoPesanJual='$nofaktur'");
		$this->db->query("DELETE FROM tpesanjual WHERE NoPesanJual='$nofaktur'");
		echo $this->session->set_flashdata('msg', 'Faktur berhasil ' . $nofaktur . ' dihapus');
		redirect('pesanjualdetail/daftar_pesanjualdetail/', 'refresh');
	}

	// untuk mencetak nota
	public function cetak_nota()
	{
		$tgl = date('d-m-Y');
		$waktu = date('H:i:s');
		$nofaktur = $this->uri->segment(3);
		$data_faktur = $this->pesanjualdetail_model->reprintStruk($nofaktur)->row();
		$produk = $this->pesanjualdetail_model->getProdukDijual($nofaktur);
		if ($data_faktur) {
			//$data['toko'] = $this->login_model->seting();
			$data['faktur'] = $data_faktur;
			$data['tgl'] = $tgl;
			$data['waktu'] = $waktu;
			$data['produk'] = $produk;
			$data['total_item'] = 0;
			$data['subtotal'] = 0;
			$data['setting'] = $this->login_model->seting()->row();

			$username = $this->session->userdata('ses_username');
			$setting['user'] = $this->login_model->sistemuser($username)->row();
			$setting['seting'] = $this->login_model->seting()->row();

			//$this->load->view('header', $setting);
			$this->load->view('pesanjualdetail/cetak_nota', $data);
			//$this->load->view('footers');
		} else {
			$this->load->view('error404');
		}
	}
}

/* End of file Kasir.php */
/* Location: ./application/controllers/Kasir.php */