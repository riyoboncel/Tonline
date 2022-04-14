<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_penjualan_model extends CI_Model
{
    public function laporanfakturjual($tgl_sekarang)
    {
        return $this->db->query("SELECT NoJual, Tanggal, NamaCust, SubTotal+PPnRp-PotonganRp AS ToTJual, 
        If((SubTotal+PPnRp-PotonganRp>0 And Round(SubTotal+PPnRp-PotonganRp)>Bayar) Or (SubTotal+PPnRp-PotonganRp<0 And Round(SubTotal+PPnRp-PotonganRp)<Bayar),Bayar,SubTotal+PPnRp-PotonganRp)*If(LEFT(NoJual,2)='JL',1,-1) AS Tunai, 
        If((SubTotal+PPnRp-PotonganRp>0 And Round(SubTotal+PPnRp-PotonganRp)>Giro) Or (SubTotal+PPnRp-PotonganRp<0 And Round(SubTotal+PPnRp-PotonganRp)<Giro),Giro,SubTotal+PPnRp-PotonganRp-Bayar)*If(LEFT(NoJual,2)='JL',1,-1) AS Giro, 
        If((SubTotal+PPnRp-PotonganRp>0 And Round(SubTotal+PPnRp-PotonganRp)>Transfer) Or (SubTotal+PPnRp-PotonganRp<0 And Round(SubTotal+PPnRp-PotonganRp)<Transfer),Transfer,SubTotal+PPnRp-PotonganRp+PPnRp-Bayar-Giro)*If(LEFT(NoJual,2)='JL',1,-1) AS Transfer, 
        If((SubTotal+PPnRp-PotonganRp>0 And Round(SubTotal+PPnRp-PotonganRp)>(Bayar+Transfer+Giro+voucher)) Or (SubTotal+PPnRp-PotonganRp<0 And Round(SubTotal+PPnRp-PotonganRp)<(Bayar+Transfer+Giro+voucher)),(SubTotal+PPnRp-PotonganRp)-(Bayar+Transfer+Giro+voucher),0)*If(LEFT(NoJual,2)='JL',1,-1) AS Kredit, 
        Bayar*If(LEFT(NoJual,2)='JL',1,-1) AS Bayar FROM mjual");
    }
    public function laporandetailjual()
    {
        return $this->db->query("SELECT TJ.NoJual, MJ.Tanggal, MJ.KdCust, MJ.NamaCust, TJ.KdBrg, B.NmBrg, TJ.Jumlah, TJ.Sat, TJ.Harga*If(MJ.PakaiHST=1,TJ.Isi,1) AS Harga, TJ.Disc*If(MJ.PakaiHST=1,TJ.Isi,1) AS Disc, 
        Jumlah*(Harga-Disc)*If(Left(TJ.NoJual,2)='JL',1,-1)*If(MJ.PakaiHST=1,TJ.Isi,1) AS Total, 
        If(MJ.SubTotal*MJ.PotonganRp=0,0,Jumlah*(Harga-Disc)*If(Left(TJ.NoJual,2)='JL',1,-1)*If(MJ.PakaiHST=1,TJ.Isi,1)/MJ.SubTotal*MJ.PotonganRp) AS Potongan, 
        If(MJ.SubTotal*MJ.PPnRp=0,0,Jumlah*(Harga-Disc)*If(Left(TJ.NoJual,2)='JL',1,-1)*If(MJ.PakaiHST=1,TJ.Isi,1)/MJ.SubTotal*MJ.PPnRp) AS PPn, 
        If((SubTotal+PPnRp-PotonganRp>0 And Round(SubTotal+PPnRp-PotonganRp)>(Bayar+Transfer+Giro+voucher)) Or (SubTotal+PPnRp-PotonganRp<0 And Round(SubTotal+PPnRp-PotonganRp)<(Bayar+Transfer+Giro+voucher)),'Kredit','Tunai') AS CaraBayar, 
        MJ.SubTotal, MJ.PotonganRp, MJ.PPnRp, MJ.Bayar, MJ.Piutang, MJ.Ket, If(MJ.Termin>0,MJ.tanggal+MJ.Termin,'') AS TglJtp, MJ.Termin, MJ.NmUser, TJ.Jumlah*TJ.Isi*If(Left(TJ.NoJual,2)='JL',1,-1) AS JmlJual, 
        TJ.HBT, B.Kelompok, MJ.Jam, TJ.KdHrg, TJ.Isi, MJ.KdLokasi, TJ.Keterangan, TJ.Nomor
         FROM 
        MJual MJ INNER JOIN (Barang B RIGHT JOIN TJual TJ ON B.KdBrg = TJ.KdBrg) ON MJ.NoJual = TJ.NoJual");
    }



    /* ================================================================================================================================================= */

    public function getjualtanggal()
    {
        //$this->db->where('NoJual', $nofaktur);
        return $this->db->get('mjual');
    }
    public function getTahunJual()
    {
        return $this->db->query("SELECT DISTINCT YEAR(tanggal) AS thn FROM mjual");
    }

    public function getDataPenjualanTransaksiFilter($tgl_awal, $tgl_akhir)
    {
        return $this->db->select('a.*,b.*')
            ->join('tjual AS b', 'a.NoJual = b.NoJual')
            ->where('a.Tanggal BETWEEN "' . date('Y-m-d', strtotime($tgl_awal)) . '" and "' . date('Y-m-d', strtotime($tgl_akhir)) . '"')
            ->where('EXISTS (SELECT 1 FROM tjual AS b WHERE a.NoJual=b.NoJual)')
            //->where('a.FLAG_Save', '1')
            ->group_by('a.NoJual')
            ->get('mjual AS a');
    }

    public function getDataPenjualanTransaksi($tanggal)
    {
        return $this->db->select('a.*,b.*')
            ->join('tjual AS b', 'a.NoJual = b.NoJual')
            ->where('a.Tanggal', $tanggal)
            ->where('EXISTS (SELECT 1 FROM tjual AS b WHERE a.NoJual=b.NoJual)')
            //->where('a.FLAG_Save', '1')
            ->group_by('a.NoJual')
            ->get('mjual AS a');
    }

    public function reprintStruk($nofaktur)
    {
        $this->db->where('NoJual', $nofaktur);
        return $this->db->get('mjual');
    }
    public function getProdukDijual($nofaktur)
    {
        $this->db->where('NoJual', $nofaktur);
        return $this->db->get('tjual');
    }

    public function getDataPenjualanBarangFilter($tawal, $takhir, $bawal, $bakhir, $KodeData)
    {
        $sqAwal = "SELECT M.NoJual,T.KdBrg,T.NamaBrg, T.Jumlah AS jum_item FROM " . $KodeData . $tawal . $bawal . ".Tjual T RIGHT JOIN  " . $KodeData . $tawal . $bawal . ".MJUAL M ON T.NoJual=M.NoJual";
        if ($tawal == $takhir) {
            $bulanAwal = $bawal;
            for ($i = $bawal + 1; $i <= $bakhir; $i++) {
                $bulanAwal = $bulanAwal + 1;
                $sqAwal = $sqAwal . " UNION ALL SELECT M.NoJual,T.KdBrg,T.NamaBrg, T.Jumlah AS jum_item FROM " . $KodeData . $tawal . sprintf("%02d", $bulanAwal) . ".Tjual T INNER JOIN  " . $KodeData . $tawal . sprintf("%02d", $bulanAwal) . ".MJUAL M ON T.NoJual=M.NoJual";
            }
            $sqAwal = "SELECT AB.KdBrg, AB.NamaBrg, SUM(AB.jum_item) AS jum_item FROM (" . $sqAwal . ") AB group BY AB.KdBrg, AB.NamaBrg ORDER BY jum_item DESC";
            $sq = $this->db->query("$sqAwal");
        }
        return $sq;
    }

    public function getDataPenjualanBarang()
    {
        return $this->db->select('a.NoJual, b.KdBrg,b.NamaBrg, SUM(b.jumlah) AS jum_item')
            ->join('tjual AS b', 'a.NoJual = b.NoJual')
            //->where('a.Tanggal', $tanggal)
            ->where('EXISTS (SELECT 1 FROM tjual AS b WHERE a.NoJual=b.NoJual)')
            ->group_by('b.KdBrg')
            ->order_by('jum_item', 'DESC')
            ->get('mjual AS a');
    }

    public function getDataProfit($startdate, $enddate)
    {
        return $this->db->select('a.NoJual, b.KdBrg,b.NamaBrg,b.HrgBeli,b.harga, b.jumlah AS jum_item')
            ->join('tjual AS b', 'a.NoJual = b.NoJual')
            ->where('a.Tanggal BETWEEN "' . date('Y-m-d', strtotime($startdate)) . '" and "' . date('Y-m-d', strtotime($enddate)) . '"')
            ->where('EXISTS (SELECT 1 FROM tjual AS b WHERE a.NoJual=b.NoJual)')
            //->where('a.selesai', '1')
            ->order_by('b.KdBrg')
            ->get('mjual AS a');
    }
    public function getDiskonBarang($startdate, $enddate)
    {
        return $this->db->select('SUM(b.Disc) AS disk1')
            ->join('tjual AS b', 'a.NoJual = b.NoJual')
            ->where('a.Tanggal BETWEEN "' . date('Y-m-d', strtotime($startdate)) . '" and "' . date('Y-m-d', strtotime($enddate)) . '"')
            ->where('EXISTS (SELECT 1 FROM tjual AS b WHERE a.NoJual=b.NoJual)')
            //->where('a.selesai', '1')
            ->get('mjual AS a');
    }
    public function getDiskonAkhir($startdate, $enddate)
    {
        return $this->db->select('SUM(PotonganRp) AS diska')
            ->where('a.Tanggal BETWEEN "' . date('Y-m-d', strtotime($startdate)) . '" and "' . date('Y-m-d', strtotime($enddate)) . '"')
            ->where('EXISTS (SELECT 1 FROM tjual AS b WHERE a.NoJual=b.NoJual)')
            //->where('a.selesai', '1')
            ->get('mjual AS a');
    }

    public function getDataProfit1($tanggal)
    {
        return $this->db->select('a.NoJual, b.KdBrg,b.NamaBrg,b.HBT,b.harga, b.jumlah AS jum_item')
            ->join('tjual AS b', 'a.NoJual = b.NoJual')
            ->where('a.Tanggal', $tanggal)
            ->where('EXISTS (SELECT 1 FROM tjual AS b WHERE a.NoJual=b.NoJual)')
            ->order_by('b.KdBrg')
            ->get('mjual AS a');
    }

    public function getDiskonBarang1($tanggal)
    {
        return $this->db->select('SUM(b.Disc) AS disk1')
            ->join('tjual AS b', 'a.NoJual = b.NoJual')
            ->where('a.Tanggal', $tanggal)
            ->where('EXISTS (SELECT 1 FROM tjual AS b WHERE a.NoJual=b.NoJual)')
            //->where('a.selesai', '1')
            ->get('mjual AS a');
    }

    public function getDiskonAkhir1($tanggal)
    {
        return $this->db->select('SUM(PotonganRp) AS diska')
            ->where('a.Tanggal', $tanggal)
            ->where('EXISTS (SELECT 1 FROM tjual AS b WHERE a.NoJual=b.NoJual)')
            //->where('a.selesai', '1')
            ->get('mjual AS a');
    }

    public function getDataPengeluaranRinci1($tanggal)
    {
        return $this->db->select('*')
            ->where('tgl', $tanggal)
            ->get('tabel_biaya');
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
    public function getDataRekapTahun($KodeData, $tahun)
    {
        return $this->db->query('SELECT a.Tanggal, SUM((b.harga-b.Disc) * b.jumlah * IF(LEFT(b.NoJual,2)="JR",-1,1) - a.PotonganRp) AS tot_jual, SUM(b.jumlah*b.isi*b.HBT) AS tot_modal, SUM(b.Disc) AS tot_diskon1 from ' . $KodeData . $tahun . $bulan . '.mjual AS a inner join ' . $KodeData . $tahun . $bulan . '.tjual AS b on a.NoJual = b.NoJual group by a.Tanggal');
    }

    public function getDiskonTahun($KodeData, $tahun)
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