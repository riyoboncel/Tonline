<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pra_model extends CI_Model
{

	public function getNoFaktur($ymd, $id_user, $nm_user)
	{
		$q = $this->db->query("SELECT MAX(RIGHT(NoPraPesanJual,5)) AS id_max FROM mprapesanjual WHERE LEFT(NoPraPesanJual,2) LIKE 'SJ' AND NoPraPesanJual LIKE '%a%' AND substr(NoPraPesanJual,3,4) = '$ymd' AND NmUser = '$nm_user' ");
		$kd = "";
		$kodeawal = "SJ";
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
		//$user = sprintf("%02d", $id_user);
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $k) {
				$tmp = ((int) $k->id_max) + 1;
				$kd = sprintf("%05s", $tmp);
			}
		} else {
			$kd = "00001";
		}
		return $kodeawal . $ymd . 'A' . $hsl . $kd;
	}

	public function getNo($id_user, $nm_user)
	{
		$q = $this->db->query("SELECT MAX(RIGHT(NoPraPesanJual,2)) AS id_max FROM mprapesanjual WHERE LEFT(NoPraPesanJual,2) <> 'SJ' AND NoPraPesanJual LIKE '%a%' AND NmUser = '$nm_user' ");
		$kd = "";
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
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $k) {
				$tmp = ((int) $k->id_max) + 1;
				$kd = sprintf("%02s", $tmp);
			}
		} else {
			$kd = "01";
		}
		return $hsl . 'A' . $kd;
	}

	public function getNox($id_user, $nm_user)
	{
		$q = $this->db->query("SELECT MAX(RIGHT(NoPraPesanJual,2)) AS id_max FROM mprapesanjual WHERE LEFT(NoPraPesanJual,2) <> 'SJ' AND NmUser = '$nm_user' ");
		$kd = "";
		//$kodeawal = "$id_user";
		$kodeawal = sprintf("%02d", $id_user);
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $k) {
				$tmp = ((int) $k->id_max) + 1;
				$kd = sprintf("%02s", $tmp);
			}
		} else {
			$kd = "01";
		}
		return $kodeawal . '-' . $kd;
	}

	public function cek_go_simpan($noresi, $nm_user)
	{
		$this->db->where('NoPraPesanJual', $noresi);
		$this->db->where('NmUser', $nm_user);
		$this->db->where('Flag_SAVE', '0');
		return $this->db->get('mprapesanjual');
	}

	public function getDataPenjualan($noresi, $username)
	{
		$this->db->where('NoPraPesanJual', $noresi);
		$this->db->where('NmUser', $username);
		$this->db->where('Flag_SAVE', '0');
		return $this->db->get('mprapesanjual');
	}

	public function getdetailbarang()
	{
		return $this->db->query("SELECT B.KdBrg, B.NmBrg, S.KdLokasi, S.Akhir FROM barang AS B Inner Join stocklokasi AS S ON B.KdBrg = S.KdBrg	");
	}

	public function getcustomer($idcust)
	{
		$this->db->where('KdCust', $idcust);
		return $this->db->get('customer');
	}


	public function cek_cust_ada($idcust, $nofaktur)
	{
		return $this->db->query("SELECT * FROM mprapesanjual WHERE KdCust='$idcust' AND NoPraPesanJual='$nofaktur'");
	}

	//database sales
	public function getsales($idsales)
	{
		$this->db->where('KdSales', $idsales);
		return $this->db->get('sales');
	}
	public function cek_sales_ada($idsales, $nofaktur)
	{
		return $this->db->query("SELECT * FROM mprapesanjual WHERE KdSales='$idsales' AND NoPraPesanJual='$nofaktur'");
	}

	public function getbarang($idbarang)
	{
		$this->db->where('KdBrg', $idbarang);
		$this->db->or_where('Barcode', $idbarang);
		return $this->db->get('barang');
	}

	public function cek_tpesan($nofaktur)
	{
		return $this->db->query("SELECT * FROM tprapesanjual WHERE NoPraPesanJual='$nofaktur'");
	}

	public function cek_sudah_ada($kdb, $nofaktur)
	{
		return $this->db->query("SELECT * FROM tprapesanjual WHERE KdBrg='$kdb' AND NoPraPesanJual='$nofaktur'");
	}

	public function cek_satuan_ada($idbarang, $nofaktur)
	{
		return $this->db->query("SELECT * FROM tprapesanjual WHERE KdBrg='$idbarang' AND NoPraPesanJual='$nofaktur'");
	}

	public function ceksales_detail($idsales, $idbarang, $nofaktur)
	{
		return $this->db->query("SELECT KdSales FROM tprapesanjual WHERE KdSales='$idsales'AND KdBrg='$idbarang' AND NoPraPesanJual='$nofaktur'");
	}

	public function cek_jenis_harga($nofaktur)
	{
		return $this->db->query("SELECT JenisHrg, KdCust, NmCust FROM mprapesanjual WHERE NoPraPesanJual='$nofaktur'");
	}

	public function cek_jumlah_stok($idbarang)
	{
		return $this->db->query("SELECT barang.Stock_Akhir AS stok FROM barang WHERE barang.KdBrg='$idbarang'");
	}


	public function getListPenjualan($noresi)
	{
		return $this->db->query("SELECT * FROM tprapesanjual WHERE NoPraPesanJual='$noresi' ORDER BY nomor DESC");
	}

	public function listsales($noresi)
	{
		return $this->db->query("SELECT
        MP.NoPraPesanJual,
        MP.NmUser,
        MP.Flag_SAVE,
        MP.KdSales,
        S.NmSales
        FROM
        mprapesanjual AS MP
        Inner Join sales AS S ON MP.KdSales = S.KdSales
        WHERE NoPraPesanJual = '$noresi' AND Flag_SAVE ='0'");
	}

	public function getTotalBelanja($noresi)
	{
		return $this->db->query("SELECT SUM(Harga*Jumlah) AS tot_bel FROM tprapesanjual WHERE NoPraPesanJual='$noresi'");
	}

	public function cari_cust($NmCust)
	{
		$this->db->like('NmCust', $NmCust, 'both');
		$this->db->order_by('KdCust', 'ASC');
		//$this->db->limit(1);
		return $this->db->get('customer')->result();
	}

	public function cari_sales($Nmsales)
	{
		$this->db->like('NmSales', $Nmsales, 'both');
		$this->db->order_by('KdSales', 'ASC');
		//$this->db->limit(1);
		return $this->db->get('sales')->result();
	}

	public function cari_brg($NmBrg)
	{
		$this->db->like('NmBrg', $NmBrg, 'both');
		$this->db->order_by('KdBrg', 'ASC');
		//$this->db->limit(10);
		return $this->db->get('barang')->result();
	}

	public function antrianpra($id_user, $now, $before)
	{
		return $this->db->query("SELECT * FROM mprapesanjual WHERE Flag_Save='0' AND NmUser='$id_user' AND Tanggal BETWEEN '" . $before . "' AND  '" . $now . "' ORDER BY NoPraPesanJual DESC");
	}

	/*
	public function pesanselesai($id_user, $now, $before) {
		return $this->db->query("SELECT * FROM mprapesanjual WHERE Flag_Save='1' AND NmUser='$id_user' AND Tanggal BETWEEN '" . $before . "' AND  '" . $now . "' ORDER BY NoPraPesanJual DESC");
	}
	
	public function pesanpending($id_user)
	{
		return $this->db->query("SELECT m.NoPraPesanJual, m.Tanggal, m.NmCust, m.NmUser, m.SubTotal FROM mprapesanjual AS m INNER JOIN (SELECT NoPraPesanJual FROM tprapesanjual GROUP BY NoPraPesanJual) AS t ON m.NoPraPesanJual = t.NoPraPesanJual WHERE Flag_Save='1' AND NmUser='$id_user'");
	}
	*/
	public function prapending($id_user)
	{
		return $this->db->query("SELECT
		TP.NoPraPesanJual, MP.Tanggal, TP.KdBrg, TP.NamaBrg, TP.KdHrg, TP.Jumlah, TP.Sat, TP.KdSales, MP.KdCust, MP.NmCust,  MP.NmUser, MP.Jam, 
		ifnull(TP.Jumlah*TP.Isi,0) AS Pending
		FROM
		mprapesanjual MP INNER JOIN tprapesanjual TP ON MP.NoPraPesanJual = TP.NoPraPesanJual WHERE NmUser='$id_user'");
	}

	public function lapjualkonter($id_user, $tgl_now)
	{
		return $this->db->query(" SELECT LPJ.KdBrg, LPJ.Nama_Barang, SUM(LPJ.Pesan) AS Pesan, SUM(LPJ.Jual) AS Jual, SUM(LPJ.Batal) AS Batal, SUM(LPJ.Pesan-LPJ.Jual-LPJ.Batal) AS Pending, LPJ.Sat, LPJ.KdCust, LPJ.NmCust, LPJ.Tanggal, LPJ.HrgCust, LPJ.NoPraPesanJual, LPJ.NmUser, LPJ.KdSales

		FROM
		(
		SELECT TPT.KdBrg, TPT.NmBrg AS Nama_Barang, TPT.Jumlah AS Pesan, TPT.JumlahJual AS Jual, TPT.JumlahBatal AS Batal, TPT.Sat, MTP.KdCust, MTP.Tanggal, 
		MTP.NmCust, TPT.KdHrg AS HrgCust, TPT.NoPraPesanJual, MTP.NmUser AS NmUser, TPT.KdSales
		FROM
		(SELECT TPJ.NoPraPesanJual, TPJ.KdBrg, TPJ.NmBrg, ifnull(TPJ.Jumlah,0) AS Jumlah, ifnull(TPJ.JumlahJual,0) AS JumlahJual, TPJ.JumlahBatal, TPJ.Sat, TPJ.KdHrg, TPJ.KdSales
		FROM
		(
		SELECT NoPraPesanJual, KdBrg, NamaBrg AS NmBrg, ifnull(Jumlah*Isi,0) AS Jumlah, 0 AS JumlahJual, 0 AS JumlahBatal, Sat, KdHrg, ifnull(KdSales,'') AS KdSales
		FROM tprapesanjual
		
		UNION ALL
		SELECT NoPraPesanJual, KdBrg, NamaBrg AS NmBrg, ifnull(JumlahJual*Isi,0) AS Jumlah, ifnull(JumlahJual*Isi,0) AS JumlahJual, 0 AS JumlahBatal, Sat, KdHrg, ifnull(KdSales,'') AS KdSales 
		FROM tprapesanjual_Jual
		
		UNION ALL
		SELECT NoPraPesanJual, KdBrg, NamaBrg AS NmBrg, ifnull(JumlahBatal*Isi,0) AS Jumlah, 0 AS JumlahJual, ifnull(JumlahBatal*Isi,0) AS JumlahBatal, Sat, KdHrg, ifnull(KdSales,'') AS KdSales 
		FROM tprapesanjual_Batal
		) TPJ
		WHERE TPJ.Jumlah<>0 ) TPT
		
		INNER JOIN (SELECT NoPraPesanJual, Tanggal, NmUser, KdCust, NmCust 
		FROM mprapesanjual WHERE NmUser='$id_user') MTP 
		ON TPT.NoPraPesanJual=MTP.NoPraPesanJual
		WHERE MTP.Tanggal='$tgl_now'
		) LPJ
		GROUP BY LPJ.NoPraPesanJual, LPJ.KdBrg, LPJ.KdSales
		ORDER BY LPJ.KdBrg, LPJ.NmCust, LPJ.KdCust ");
	}

	public function reprintStruk($nofaktur)
	{
		$this->db->where('NoPraPesanJual', $nofaktur);
		return $this->db->get('mprapesanjual');
	}
	public function getProdukDijual($nofaktur)
	{
		$this->db->where('NoPraPesanJual', $nofaktur);
		return $this->db->get('tprapesanjual');
	}
}

/* End of file Kasir_model.php */
/* Location: ./application/models/Kasir_model.php */