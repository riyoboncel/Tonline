<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cafe_model extends CI_Model
{

    public function getNoFaktur($ymd, $id_user, $nm_user)
    {
        $q = $this->db->query("SELECT MAX(RIGHT(NoPesanJual,5)) AS id_max FROM mpesanjual WHERE LEFT(NoPesanJual,2) LIKE 'PJ' AND NoPesanJual LIKE '%W%' AND substr(NoPesanJual,3,4) = '$ymd' AND NmUser = '$nm_user' ");
        $kd = "";
        $kodeawal = "PJ";
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
        return $kodeawal . $ymd . 'W' . $hsl . $kd;
    }

    public function getNo($id_user, $nm_user)
    {
        $q = $this->db->query("SELECT MAX(RIGHT(NoPesanJual,2)) AS id_max FROM mpesanjual WHERE LEFT(NoPesanJual,2) <> 'PJ' AND NoPesanJual LIKE '%W%' AND NmUser = '$nm_user'  ");
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
        return $hsl . 'W' . $kd;
    }

    public function getNox($id_user, $nm_user)
    {
        $q = $this->db->query("SELECT MAX(RIGHT(NoPesanJual,2)) AS id_max FROM mpesanjual WHERE LEFT(NoPesanJual,2) <> 'PJ' AND NmUser = '$nm_user' ");
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

    public function getitem()
    {
        return $this->db->query("SELECT * FROM barang Limit 16");
        //return $this->db->get('barang');
    }
    public function getitems($departemen)
    {
        return $this->db->query("SELECT * FROM barang WHERE kddept = '$departemen' Limit 16");
        //$this->db->where('KdDept', $departemen);
        //return $this->db->get('barang');
    }
    public function departemen()
    {
        return $this->db->get('departemen');
    }

    public function getProduk()
    {
        $this->load->library('datatables');
        $this->datatables->select('KdBrg,NmBrg,Stock_Akhir,NmDept');
        $this->datatables->from('barang');
        $this->db->where('NmBrg <>', '');
        $this->db->order_by('KdBrg');
        $this->datatables->add_column('Aksi', '<a href="javascript:void(0)" onClick="masuk(this,"$1")" id="data" class="edit_record" title="Edit data" data-kode="$1" data-nama="$2" data-satuan="$3" data-kategori="$4" data-supplier="$5" data-jual="$6" data-beli="$7" data-satuan="$8" data-porsi="$9"><i class="fa fa-pencil-square-o"></i>$1</a>', 'KdBrg, NmBrg, Stock_Akhirt');
        return print_r($this->datatables->generate());
    }

    public function cek_go_simpan($noresi, $nm_user)
    {
        $this->db->where('NoPesanJual', $noresi);
        $this->db->where('NmUser', $nm_user);
        $this->db->where('Flag_SAVE', '0');
        return $this->db->get('mpesanjual');
    }

    public function getDataPenjualan($noresi, $username)
    {
        $this->db->where('NoPesanJual', $noresi);
        $this->db->where('NmUser', $username);
        $this->db->where('Flag_SAVE', '0');
        return $this->db->get('mpesanjual');
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
        return $this->db->query("SELECT * FROM mpesanjual WHERE KdCust='$idcust' AND NoPesanJual='$nofaktur'");
    }

    //database sales
    public function getsales($idsales)
    {
        $this->db->where('KdSales', $idsales);
        return $this->db->get('sales');
    }
    public function cek_sales_ada($idsales, $nofaktur)
    {
        return $this->db->query("SELECT * FROM mpesanjual WHERE KdSales='$idsales' AND NoPesanJual='$nofaktur'");
    }

    public function getbarang($idbarang)
    {
        $this->db->where('KdBrg', $idbarang);
        $this->db->or_where('Barcode', $idbarang);
        return $this->db->get('barang');
    }

    public function cek_tpesan($nofaktur)
    {
        return $this->db->query("SELECT * FROM tpesanjual WHERE NoPesanJual='$nofaktur'");
    }

    public function cek_sudah_ada($kdb, $nofaktur)
    {
        return $this->db->query("SELECT * FROM tpesanjual WHERE KdBrg='$kdb' AND NoPesanJual='$nofaktur'");
    }

    public function cek_satuan_ada($idbarang, $nofaktur)
    {
        return $this->db->query("SELECT * FROM tpesanjual WHERE KdBrg='$idbarang' AND NoPesanJual='$nofaktur'");
    }

    public function ceksales_detail($idsales, $idbarang, $nofaktur)
    {
        return $this->db->query("SELECT KdSales FROM tpesanjual WHERE KdSales='$idsales'AND KdBrg='$idbarang' AND NoPesanJual='$nofaktur'");
    }

    public function cek_jenis_harga($nofaktur)
    {
        return $this->db->query("SELECT JenisHrg, KdCust, NmCust FROM mpesanjual WHERE NoPesanJual='$nofaktur'");
    }

    public function cek_jumlah_stok($idbarang)
    {
        return $this->db->query("SELECT barang.Stock_Akhir AS stok FROM barang WHERE barang.KdBrg='$idbarang'");
    }


    public function getListPenjualan($noresi)
    {
        return $this->db->query("SELECT * FROM tpesanjual WHERE NoPesanJual='$noresi' ORDER BY nomor DESC");
    }

    public function listsales($noresi)
    {
        return $this->db->query("SELECT
        MP.NoPesanJual,
        MP.NmUser,
        MP.Flag_SAVE,
        MP.KdSales,
        S.NmSales
        FROM
        mpesanjual AS MP
        Inner Join sales AS S ON MP.KdSales = S.KdSales
        WHERE NoPesanJual = '$noresi' AND Flag_SAVE ='0'");
    }

    public function getTotalBelanja($noresi)
    {
        return $this->db->query("SELECT SUM(Harga*Jumlah) AS tot_bel FROM tpesanjual WHERE NoPesanJual='$noresi'");
    }

    public function cari_cust($NmCust)
    {
        $this->db->like('NmCust', $NmCust, 'both');
        $this->db->order_by('KdCust', 'ASC');
        $this->db->limit(20);
        return $this->db->get('customer')->result();
    }

    public function cari_sales($Nmsales)
    {
        $this->db->like('NmSales', $Nmsales, 'both');
        $this->db->order_by('KdSales', 'ASC');
        $this->db->limit(20);
        return $this->db->get('sales')->result();
    }

    public function cari_brg($NmBrg)
    {
        $this->db->like('NmBrg', $NmBrg, 'both');
        $this->db->order_by('KdBrg', 'ASC');
        $this->db->limit(50);
        return $this->db->get('barang')->result();
    }

    public function antrianpra($id_user, $now, $before)
    {
        return $this->db->query("SELECT * FROM mpesanjual WHERE Flag_Save='0' AND NmUser='$id_user' AND Tanggal BETWEEN '" . $before . "' AND  '" . $now . "' ORDER BY NoPesanJual DESC");
    }



    public function reprintStruk($nofaktur)
    {
        $this->db->where('NoPesanJual', $nofaktur);
        return $this->db->get('mpesanjual');
    }
    public function getProdukDijual($nofaktur)
    {
        $this->db->where('NoPesanJual', $nofaktur);
        return $this->db->get('tpesanjual');
    }

    public function getAllBarangs()
    {
        return $this->db->get('barang')->result_array();
    }
    public function getBarangs($limit, $start, $keyword = null)
    {
        if ($keyword) {
            $this->db->like('NmBrg', $keyword);
        }
        return $this->db->get('barang', $limit, $start)->result_array();
    }
    public function countAllbarang()
    {
        return $this->db->get('barang')->num_rows();
    }
}

/* End of file Kasir_model.php */
/* Location: ./application/models/Kasir_model.php */