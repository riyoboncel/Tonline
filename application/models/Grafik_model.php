<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Grafik_model extends CI_Model
{
	var $kodedata = 'tusd_'; //nama database

	public function statistik_stok()
	{

		$query = $this->db->query("SELECT a.KdDept,a.NmBrg,a.Stock_Akhir,a.KdBrg,b.Akhir FROM barang a JOIN StockLokasi b ON a.KdBrg=b.KdBrg WHERE b.Akhir > 0 ORDER BY a.Stock_Akhir DESC");

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $data) {
				$hasil[] = $data;
			}
			return $hasil;
		}
	}

	public function getTahunJual()
	{
		return $this->db->query("SELECT DISTINCT YEAR(tanggal) AS thn FROM mjual");
	}

	public function graf_penjualan_perbulan($kodedata, $tahun, $bulan)
	{
		$query = $this->db->query("SELECT DATE_FORMAT(a.Tanggal,'%d') AS tanggal ,SUM(a.SubTotal) AS total FROM $kodedata$tahun$bulan.mjual AS a WHERE EXISTS (SELECT 1 FROM $kodedata$tahun$bulan.tjual AS b WHERE a.NoJual=b.NoJual) AND MONTH(a.Tanggal)='$bulan' AND YEAR(a.Tanggal)='$tahun'  GROUP BY DAY(a.Tanggal)");

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $data) {
				$hasil[] = $data;
			}
			return $hasil;
		}
	}

	public function graf_profit_perbulan($kodedata, $tahun, $bulan)
	{
		$query = $this->db->query("SELECT DATE_FORMAT(a.Tanggal,'%d') AS tanggal, Sum(b.Jumlah*b.Isi*IF(Left(b.NoJual,2)='JL',1,-1)) AS jumlah,
		Sum((b.Jumlah*IF(Left(b.NoJual,2)='JL',1,-1)*((b.Harga-b.Disc)*IF(a.PakaiHST=1,b.Isi,1))-IF(a.SubTotal=0,0,(b.Harga-b.Disc)*IF(a.PakaiHST=1,b.Isi,1)*b.Jumlah/a.SubTotal*a.PotonganRp))) AS hargajual, Sum(b.Jumlah*b.Isi*b.HBT*IF(Left(b.NoJual,2)='JL',1,-1)) AS hargabeli,  
Sum((b.Jumlah*IF(Left(b.NoJual,2)='JL',1,-1)*((b.Harga-b.Disc)*IF(a.PakaiHST=1,b.Isi,1))-IF(a.SubTotal=0,0,(b.Harga-b.Disc)*IF(a.PakaiHST=1,b.Isi,1)*b.Jumlah/a.SubTotal*a.PotonganRp))) - 
Sum(b.Jumlah*b.Isi*b.HBT*IF(Left(b.NoJual,2)='JL',1,-1)) AS rugilaba FROM $kodedata$tahun$bulan.mjual AS a  JOIN $kodedata$tahun$bulan.tjual AS b ON a.NoJual=b.NoJual WHERE EXISTS (SELECT 1 FROM $kodedata$tahun$bulan.tjual AS b WHERE a.NoJual=b.NoJual) AND MONTH(a.Tanggal)='$bulan' AND YEAR(a.Tanggal)='$tahun'  GROUP BY DAY(a.Tanggal)");
		/*
		$query = $this->db->query("SELECT DATE_FORMAT(a.Tanggal,'%d') AS tanggal ,SUM(b.harga * b.jumlah) AS tot_pendapatan, SUM(b.jumlah * b.HBT) AS tot_modal, SUM(b.Disc) AS tot_diskonrp FROM $kodedata$tahun$bulan.mjual AS a  JOIN $kodedata$tahun$bulan.tjual AS b ON a.NoJual=b.NoJual WHERE EXISTS (SELECT 1 FROM $kodedata$tahun$bulan.tjual AS b WHERE a.NoJual=b.NoJual) AND MONTH(a.Tanggal)='$bulan' AND YEAR(a.Tanggal)='$tahun'  GROUP BY DAY(a.Tanggal)");
		*/

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $data) {
				$hasil[] = $data;
			}
			return $hasil;
		}
	}

	public function getDiskon($kodedata, $tahun, $bulan)
	{
		$query = $this->db->query("SELECT SUM(PotonganRp) AS tot_diskon2 FROM $kodedata$tahun$bulan.mjual AS a WHERE MONTH(a.Tanggal) = '$bulan' AND YEAR(a.Tanggal) = '$tahun' GROUP BY a.tanggal ");
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $data) {
				$hasil[] = $data;
			}
			return $hasil;
		}
	}

	public function graf_penjualan_pertahun($kodedata, $tahun)
	{
		$sql = '';
		for ($i = 1; $i <= 12; $i++) {
			$query = $this->db->query("SELECT SCHEMA_NAME from information_schema.SCHEMATA where SCHEMA_NAME='" . $kodedata . $tahun . sprintf("%02d", $i) . "'");
			if ($query->num_rows() > 0) {
				if ($sql <> '') {
					$sql = $sql . ' UNION ALL ';
				} else {
					$sql = $sql;
				}

				$sql = $sql  . "SELECT month(MJ.tanggal) as bulan, sum(MJ.subtotal) as total TJ.NoJual, MJ.Tanggal, TJ.KdBrg, TJ.NamaBrg, TJ.KdHrg, TJ.Jumlah, TJ.Sat, MJ.KdCust, MJ.NamaCust,  MJ.NmUser,TJ.KdSales,   MJ.Jam FROM " . $kodedata  . $tahun . sprintf("%02d", $i) . ".MJual MJ INNER JOIN " . $kodedata  . $tahun . sprintf("%02d", $i) . ".TJual TJ ON MJ.NoJual = TJ.NoJual ";
			} else {
				$sql = $sql;
			}
			//return $sql;
		}
		return $sql;
		/*
		$query = $this->db->query("select month(tanggal) as bulan, sum(subtotal) as total FROM " . $kodedata . $tahun . "01.mjual where month(tanggal) = '01'
		union all
		select month(tanggal) as bulan, sum(subtotal) as total from " . $kodedata . $tahun . "02.mjual where month(tanggal) = '02'
		union all
		select month(tanggal) as bulan, sum(subtotal) as total from " . $kodedata . $tahun . "03.mjual where month(tanggal) = '03'
		");
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $data) {
				$hasil[] = $data;
			}
			return $hasil;
		}
		*/
	}
	public function graf_penjualan_pertahunxx($kodedata, $tahun)
	{
		$bulanAwal = 1;
		$bulanAkhir = 12;
		for ($i = 1; $i <= $bulanAkhir; $i++) {
			//$bulanAwal = $bulanAwal + 1;
			$q = " UNION ALL SELECT DATE_FORMAT(a.tanggal,'%M') AS bulan, SUM(a.SubTotal) AS total FROM " . $kodedata . $tahun . sprintf("%02d", $bulanAwal) . " .mjual AS a WHERE EXISTS (SELECT 1 FROM " . $kodedata . $tahun . sprintf("%02d", $bulanAwal) . ".tjual AS b WHERE a.NoJual=b.NoJual) AND YEAR(a.tanggal)='$tahun'  GROUP BY MONTH(a.tanggal)";
		}
		$query = $this->db->query("$q");
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $data) {
				$hasil[] = $data;
			}
			return $hasil;
		}
	}
	public function graf_penjualan_pertahunx($kodedata, $tahun)
	{
		$query = $this->db->query("SELECT DATE_FORMAT(a.tanggal,'%M') AS bulan, SUM(a.SubTotal) AS total FROM mjual AS a WHERE EXISTS (SELECT 1 FROM tjual AS b WHERE a.NoJual=b.NoJual) AND YEAR(a.tanggal)='$tahun'  GROUP BY MONTH(a.tanggal)");

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