<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		//validasi jika user belum login
		if ($this->session->userdata('masuk') != TRUE) {
			$url = base_url();
			redirect($url);
		}
		$this->load->model('Barang_model');
		$this->load->model('login_model');
		$this->load->helper('random');
	}

	public function index()
	{
		$data['barang'] = $this->Barang_model->KodeBarang();
		$username = $this->session->userdata('ses_username');
		$setting['user'] = $this->login_model->sistemuser($username)->row();
		$setting['seting'] = $this->login_model->seting()->row();

		$this->load->view('header', $setting);
		$this->load->view('barang/list', $data);
		$this->load->view('footers');
	}

	function get_data_barang()
	{
		$list = $this->Barang_model->get_datatables();
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
			$row[] = "<a href='detailbarang/$field->KdBrg'><i class='fa fa-info-circle' aria-hidden='true'></i></a>";
			//$row[] = "<a href='#modalKeyword$field->KdBrg' data-toggle='modal'><i class='fa fa-info-circle' aria-hidden='true'></i></a>";
			//$row[] = $field->HrgJl15;

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Barang_model->count_all(),
			"recordsFiltered" => $this->Barang_model->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}
	/* =============== data barang 1 =================== */


	/* =============== data barang 2 =================== */
	public function databarang()
	{
		$data['barang'] = $this->Barang_model->KodeBarang();
		$username = $this->session->userdata('ses_username');
		$setting['user'] = $this->login_model->sistemuser($username)->row();
		$setting['seting'] = $this->login_model->seting()->row();

		$this->load->view('header', $setting);
		$this->load->view('barang/databarang', $data);
		$this->load->view('footers');
	}

	public function json_produk()
	{
		if ($this->input->is_ajax_request()) {
			$this->Barang_model->getProduk();
		} else {
			redirect('barang/databarang/', 'refresh');
		}
	}

	public function detailbarang()
	{
		$kode = urldecode($this->uri->segment(3));
		$data['barang'] = $this->Barang_model->cekKodeBarang($kode);
		$username = $this->session->userdata('ses_username');
		$setting['user'] = $this->login_model->sistemuser($username)->row();
		$setting['seting'] = $this->login_model->seting()->row();

		$this->load->view('header', $setting);
		$this->load->view('barang/detailbarang', $data);
		$this->load->view('footers');
	}

	/* ===================== function cek harga barang ============================ */
	public function cekharga()
	{
		$idbarang = urldecode($this->uri->segment(3));
		$data['barangx'] = $this->Barang_model->getbarang($idbarang);
		$data['global'] = $this->Barang_model->StockGlobal($idbarang)->row();
		$data['tgl'] = date('Y-m-d');
		$username = $this->session->userdata('ses_username');
		$setting['user'] = $this->login_model->sistemuser($username)->row();
		$setting['seting'] = $this->login_model->seting()->row();

		$this->load->view('header', $setting);
		$this->load->view('barang/cekharga', $data);
		$this->load->view('footers');
	}
	function get_autocomplete()
	{
		if (isset($_GET['term'])) {
			$result = $this->Barang_model->cari_brg($_GET['term']);
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


	/* ===================== function pagination barang default ci ============================ */

	public function paging()
	{
		$this->load->library('pagination');

		$keyword = $this->input->post('keyword');
		//$this->session->set_userdata('keyword', $keyword);

		$config['base_url'] = base_url('barang/paging');
		//$config['base_url'] = 'http://localhost/admin/barang/paging';

		$this->db->like('KdBrg', $keyword);
		$this->db->or_like('NmBrg', $keyword);
		$this->db->from('barang');
		$config['total_rows'] = $this->db->count_all_results();
		//$config['total_rows'] = $this->Barang_model->countBarangPaging();
		$data['total_rows'] = $config['total_rows'];

		$config['per_page'] = 8;
		$config['num_links'] = 3;

		$config['full_tag_open'] = '<nav><ul class="pagination justify-content-center">';
		$config['full_tag_close'] = '</ul></nav>';

		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';

		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li class="page-item">';
		$config['last_tag_close'] = '</li>';

		$config['next_link'] = '&raquo;';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tag_close'] = '</li>';

		$config['prev_link'] = '&laquo;';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';

		$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#" aria-label="Previous">';
		$config['cur_tag_close'] = '</a></li>';

		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';

		$config['attributes'] = array('class' => 'page-link');


		// initialize
		$this->pagination->initialize($config);
		$data['start'] = $this->uri->segment(3);

		$username = $this->session->userdata('ses_username');
		$data['barang'] = $this->Barang_model->BarangPaging($config['per_page'], $data['start'], $keyword);
		$setting['user'] = $this->login_model->sistemuser($username)->row();
		$setting['seting'] = $this->login_model->seting()->row();

		$this->load->view('header', $setting);
		$this->load->view('barang/paging', $data);
		$this->load->view('footers');
	}
}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */