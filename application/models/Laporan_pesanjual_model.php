<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_pesanjual_model extends CI_Model
{

    public function tampilpesanjual()
    {
        return $this->db->query("SELECT A.* FROM Mpesanjual A INNER JOIN (select nopesanjual from tpesanjual group by nopesanjual) B ON A.nopesanjual=b.nopesanjual where A.NoPesanJual LIKE '%PJ%'");
    }
    public function detaildaftarpesanjual($nofaktur)
    {
        return $this->db->query("SELECT * FROM mpesanjual M INNER JOIN tpesanjual T ON M.NoPesanJual=T.NoPesanJual WHERE M.NoPesanJual = '$nofaktur' ORDER BY T.Nomor");
    }

    public function getjualtanggal()
    {
        //$this->db->where('NoJual', $nofaktur);
        return $this->db->get('mjual');
    }
    public function getTahunJual()
    {
        return $this->db->query("SELECT DISTINCT YEAR(tanggal) AS thn FROM mjual");
    }




    // rekap penjualan perbarang
    public function getDataRekapPerbarang($KodeData, $tahun, $bulan)
    {
        return $this->db->query('SELECT mj.Tanggal, tj.KdBrg, tj.NamaBrg, SUM((tj.Jumlah * Tj.Isi) * IF(LEFT(tj.NoJual,2)="JR",-1,1)) AS Jumlah, SUM((tj.harga-tj.Disc) * tj.jumlah * IF(LEFT(tj.NoJual,2)="JR",-1,1)) AS tot_jual, SUM(tj.jumlah*tj.isi*tj.HBT) AS tot_modal, SUM(tj.Disc) AS tot_diskon1 
        FROM ' . $KodeData . $tahun . $bulan . '.Mjual AS mj Inner Join ' . $KodeData . $tahun . $bulan . '.Tjual AS tj on mj.NoJual = tj.NoJual group by tj.KdBrg, tj.NamaBrg ORDER BY Jumlah DESC');
    }

    public function getDataRekap($KodeData, $tahun, $bulan)
    {
        return $this->db->query('SELECT a.Tanggal, SUM((b.harga-b.Disc) * b.jumlah * IF(LEFT(b.NoJual,2)="JR",-1,1) - a.PotonganRp) AS tot_jual, SUM(b.jumlah*b.isi*b.HBT) AS tot_modal, SUM(b.Disc) AS tot_diskon1 from ' . $KodeData . $tahun . $bulan . '.mjual AS a inner join ' . $KodeData . $tahun . $bulan . '.tjual AS b on a.NoJual = b.NoJual group by a.Tanggal');
    }

    public function getDiskon($KodeData, $tahun, $bulan)
    {
        return $this->db->query("SELECT SUM(PotonganRp) AS tot_diskon2 FROM " . $KodeData . $tahun . $bulan . ".mjual AS a group by a.tanggal");
    }

    public function getDataPengeluaranRekapitulasi($tahun, $bulan)
    {
        return $this->db->select('*')
            ->where('MONTH(tgl)', $bulan)
            ->where('YEAR(tgl)', $tahun)
            ->group_by('tgl')
            ->get('tabel_biaya');
    }

    /* query dari tumbas =========================================================================================== */
    //    public function getLaporanFakturPenjualanFilter($awal, $akhir, $bawal, $bakhir, $KodeData)
    public function getLaporanFakturPenjualanFilter($KodeData, $awal, $akhir, $bawal, $bakhir, $startdate, $enddate)
    {
        $sqAwal = "SELECT M.NoJual,M.Tanggal,M.NamaCust,M.SubTotal,M.NmUser FROM " . $KodeData . $awal . $bawal . ".Customer C RIGHT JOIN  " . $KodeData . $awal . $bawal . ".MJUAL M ON C.KdCust=M.KdCust ";
        if ($awal == $akhir) {
            $bulanAwal = $bawal;
            for ($i = $bawal + 1; $i <= $bakhir; $i++) {
                $bulanAwal = $bulanAwal + 1;
                $sqAwal = $sqAwal . " union all SELECT M.NoJual,M.Tanggal,C.NmCust,M.SubTotal,M.NmUser FROM " . $KodeData . $awal . sprintf("%02d", $bulanAwal) . ".Customer C RIGHT JOIN  " . $KodeData . $awal . sprintf("%02d", $bulanAwal) . ".MJUAL M ON C.KdCust=M.KdCust ";
            }
            $sq = $this->db->query("$sqAwal");
        } else {
            $bulanAwal = $bawal + 1;
            for ($t = $awal; $t <= $akhir; $t++) {

                if ($t == $akhir) {
                    //$bulanAwal = $bawal;
                    for ($b = 1; $b <= $bakhir; $b++) {
                        //$bulanAwal = $bulanAwal + 1;
                        $sqAwal = $sqAwal . " union all SELECT M.NoJual,M.Tanggal,C.NmCust,M.SubTotal,M.NmUser FROM " . $KodeData . $t . sprintf("%02d", $bulanAwal) . ".Customer C RIGHT JOIN  " . $KodeData . $t . sprintf("%02d", $bulanAwal) . ".MJUAL M ON C.KdCust=M.KdCust ";

                        if ($bulanAwal < 12) {
                            $bulanAwal++;
                        } else {
                            $bulanAwal = 1;
                        }
                    }
                    $sq = $this->db->query("$sqAwal");
                } elseif ($t > $awal) {
                    //$bulanAwal = $bawal;
                    for ($b = 1; $b <= 12; $b++) {
                        $sqAwal = $sqAwal . " union all SELECT M.NoJual,M.Tanggal,M.KdCust,C.NmCust,M.SubTotal,M.NmUser FROM " . $KodeData . $t . sprintf("%02d", $bulanAwal) . ".Customer C RIGHT JOIN  " . $KodeData . $t . sprintf("%02d", $bulanAwal) . ".MJUAL M ON C.KdCust=M.KdCust ";
                        //$bulanAwal = $bulanAwal + 1;
                    }
                    $sq = $this->db->query("$sqAwal");
                } else {
                    $b = $bawal + 1;
                    //$bulanAwal = $bawal;
                    for ($i = $bawal + 1; $i <= 12; $i++) {
                        $sqAwal = $sqAwal . " union all SELECT M.NoJual,M.Tanggal,C.NmCust,M.SubTotal,M.NmUser FROM " . $KodeData . $awal . sprintf("%02d", $bulanAwal) . ".Customer C RIGHT JOIN  " . $KodeData . $awal . sprintf("%02d", $bulanAwal) . ".MJUAL M ON C.KdCust=M.KdCust ";
                        if ($bulanAwal < 12) {
                            $bulanAwal++;
                        } else {
                            $bulanAwal = 1;
                        }

                        //$bulanAwal = $bulanAwal + 1;
                    }
                    $sq = $this->db->query("$sqAwal");
                }
            }
        }
        return $sq;
    }

    public function getLaporanFakturPenjualan($tanggal)
    {
        return $this->db->select('*')
            ->where('Tanggal', $tanggal)
            ->get('mjual');
    }
    public function laporanpdf()
    {
        return $this->db->select('*')
            ->get('mjual');
    }
}

/* End of file Laporan_model.php */
/* Location: ./application/models/Laporan_model.php */