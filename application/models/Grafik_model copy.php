<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Grafik_model extends CI_Model
{

	public function statistik_stok()
	{

		$query = $this->db->query("SELECT a.KdDept,a.NmBrg,a.Stock_Akhir,a.KdBrg,b.Akhir FROM barang a JOIN StockLokasi b ON a.KdBrg=b.KdBrg WHERE b.Akhir >= 0 ORDER BY b.KdBrg");

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $data) {
				$hasil[] = $data;
			}
			return $hasil;
		}
	}

	public function getTahunJual()
	{
		return $this->db->query("SELECT DISTINCT YEAR(tanggal) AS thn FROM mpesanjual");
	}

	public function graf_penjualan_perbulan($tahun, $bulan)
	{
		$query = $this->db->query("SELECT DATE_FORMAT(a.Tanggal,'%d') AS tanggal ,SUM(a.SubTotal) AS total FROM mpesanjual AS a WHERE EXISTS (SELECT 1 FROM tpesanjual AS b WHERE a.NoPesanJual=b.NoPesanJual) AND MONTH(a.Tanggal)='$bulan' AND YEAR(a.Tanggal)='$tahun' AND a.FLAG_SAVE='1' GROUP BY DAY(a.Tanggal)");

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $data) {
				$hasil[] = $data;
			}
			return $hasil;
		}
	}

	public function graf_profit_perbulan($tahun, $bulan)
	{
		$query = $this->db->query("SELECT DATE_FORMAT(a.Tanggal,'%d') AS tanggal ,SUM(b.harga*b.jumlah) AS tot_pendapatan, SUM(b.jumlah*b.HBT) AS tot_modal, SUM(b.Disc) AS tot_diskonrp FROM mpesanjual AS a  JOIN tpesanjual AS b ON a.NoPesanJual=b.NoPesanJual WHERE EXISTS (SELECT 1 FROM tpesanjual AS b WHERE a.NoPesanJual=b.NoPesanJual) AND MONTH(a.Tanggal)='$bulan' AND YEAR(a.Tanggal)='$tahun' AND a.FLAG_SAVE='1' GROUP BY DAY(a.Tanggal)");

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $data) {
				$hasil[] = $data;
			}
			return $hasil;
		}
	}

	public function getDiskon($tahun, $bulan)
	{
		$query = $this->db->select('SUM(Discont_Khusus) AS tot_diskon2')
			->where('MONTH(a.Tanggal)', $bulan)
			->where('YEAR(a.Tanggal)', $tahun)
			->where('a.FLAG_SAVE', '1')
			->group_by('a.Tanggal')
			->get('mpesanjual AS a');

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $data) {
				$hasil[] = $data;
			}
			return $hasil;
		}
	}

	public function graf_penjualan_pertahun($tahun)
	{
		$query = $this->db->query("SELECT DATE_FORMAT(a.tanggal,'%M') AS bulan, SUM(a.SubTotal) AS total FROM mpesanjual AS a WHERE EXISTS (SELECT 1 FROM tpesanjual AS b WHERE a.NoPesanJual=b.NoPesanJual) AND YEAR(a.tanggal)='$tahun' AND a.FLAG_Save='1' GROUP BY MONTH(a.tanggal)");

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $data) {
				$hasil[] = $data;
			}
			return $hasil;
		}
	}
}

/* End of file Grafik_model.php */
/* Location: ./application/models/Grafik_model.php */