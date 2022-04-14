<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang_model extends CI_Model
{
	var $table = 'barang'; //nama tabel dari database
	var $column_order = array(null, 'KdBrg', 'NmBrg'); //field yang ada di table user
	var $column_search = array('NmBrg', 'KdBrg'); //field yang diizin untuk pencarian 
	var $order = array('KdBrg' => 'ASC'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		$this->db->from($this->table);
		$i = 0;
		foreach ($this->column_search as $item) // loop column 
		{
			if ($_POST['search']['value']) // if datatable send POST for search
			{
				if ($i === 0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}
				if (count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}

		if (isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->order)) {
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	/* ================data barang 1 ===================== */

	public function getKategory()
	{
		$this->db->order_by('kd_kategori');
		return $this->db->get('tabel_kategori_barang');
	}
	public function getSatuan()
	{
		$this->db->order_by('nm_satuan');
		return $this->db->get('tabel_satuan_barang');
	}
	public function getSupplier()
	{
		$this->db->order_by('kd_supplier');
		return $this->db->get('tabel_supplier');
	}

	public function getProduk()
	{
		$this->load->library('datatables');
		$this->datatables->select('KdBrg,NmBrg,Stock_Akhir');
		$this->datatables->from('barang');
		$this->db->where('NmBrg <>', '');
		$this->db->order_by('KdBrg');
		//$this->datatables->add_column('Aksi', '<a href="#modalKeyword$1" data-toggle="modal" class="edit_record" title="Edit data" data-kode="$1" data-nama="$2" data-satuan="$3" data-kategori="$4" data-supplier="$5" data-jual="$6" data-beli="$7" data-satuan="$8" data-porsi="$9"><i class="fa fa-pencil-square-o"></i></a>', 'KdBrg, NmBrg, Stock_Akhir');
		$this->datatables->add_column('Aksi', '<a href="detailbarang/$1" class="edit_record" title="Edit data" data-kode="$1" data-nama="$2" data-satuan="$3" data-kategori="$4" data-supplier="$5" data-jual="$6" data-beli="$7" data-satuan="$8" data-porsi="$9"><i class="fa fa-pencil-square-o"></i></a>', 'KdBrg, NmBrg, Stock_Akhir');
		return print_r($this->datatables->generate());
	}


	public function cekKodeBarang($kode)
	{
		return $this->db->query("SELECT * FROM barang WHERE KdBrg='$kode'");
	}

	public function KodeBarang()
	{
		return $this->db->query("SELECT * FROM barang");
	}

	public function totalbarang()
	{
		return $this->db->query("SELECT count(*) AS Jbarang FROM barang");
	}
	public function totalcustomer()
	{
		return $this->db->query("SELECT count(*) AS Jcust FROM customer");
	}
	public function cari_brg($NmBrg)
	{
		if (strpos($NmBrg, " ") !== false) {
			$sql = "SELECT KdBrg, NmBrg, Barcode FROM barang Where (NmBrg LIKE '%" . str_replace(" ", "%' AND NmBrg LIKE '%", "$NmBrg") . "%') limit 20";
		} else {
			$sql = "SELECT KdBrg, NmBrg, Barcode FROM barang Where NmBrg LIKE '%$NmBrg%' limit 20";
		}
		return $this->db->query($sql)->result();
	}
	public function cari_brgxxx($NmBrg)
	{
		$this->db->like('NmBrg', $NmBrg, 'both');
		$this->db->order_by('KdBrg', 'ASC');
		$this->db->limit(50);
		return $this->db->get('barang')->result();
	}
	public function getbarang($idbarang)
	{
		$this->db->where('KdBrg', $idbarang);
		$this->db->or_where('Barcode', $idbarang);
		return $this->db->get('barang');
	}
	public function StockGlobal($idbarang)
	{
		return $this->db->query("SELECT kdbrg, sum(akhir) AS StockGlobal FROM vstocklokasi WHERE kdbrg = '$idbarang'");
	}


	/**          query barang pagination ci      */
	public function BarangPaging($limit, $start, $keyword = null)
	{
		if ($keyword) {
			$this->db->like('KdBrg', $keyword);
			$this->db->or_like('NmBrg', $keyword);
		}
		return $this->db->get('barang', $limit, $start)->result_array();
	}
	public function countBarangPaging()
	{
		return $this->db->get('barang')->num_rows();
	}
}

/* End of file Barang_model.php */
/* Location: ./application/models/Barang_model.php */