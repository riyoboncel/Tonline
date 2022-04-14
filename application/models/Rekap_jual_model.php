<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rekap_jual_model extends CI_Model
{
    public function schema($KodeData, $jkode)
    {
        return $this->db->query("SELECT schema_name AS nama_database, Substring(schema_name,'$jkode') as thnbln
        FROM information_schema.schemata
        WHERE schema_name LIKE '$KodeData%'
        GROUP BY schema_name
        ORDER BY nama_database");
    }
    public function getTahunJual($KodeData, $jkode)
    {
        return $this->db->query("SELECT schema_name AS nama_database, Substring(schema_name,'$jkode',4) as thn
        FROM information_schema.schemata
        WHERE schema_name LIKE '$KodeData%'
        GROUP BY Substring(schema_name,'$jkode',4)
        ORDER BY nama_database");
    }


    public function cek_tahun_bulan($KodeData, $tahun, $bulan, $jkode)
    {
        return $this->db->query("SELECT schema_name AS nama_database
        FROM information_schema.schemata
        WHERE schema_name = '$KodeData$tahun$bulan'
        ORDER BY nama_database");
    }
    public function getDataRekapPerbarang($KodeData, $tahun, $bulan)
    {
        return $this->db->query('SELECT mj.Tanggal, tj.KdBrg, tj.NamaBrg, SUM((tj.Jumlah * Tj.Isi) * IF(LEFT(tj.NoJual,2)="JR",-1,1)) AS Jumlah, SUM((tj.harga-tj.Disc) * tj.jumlah * IF(LEFT(tj.NoJual,2)="JR",-1,1)) AS tot_jual, SUM(tj.jumlah*tj.isi*tj.HBT) AS tot_modal, SUM(tj.Disc) AS tot_diskon1 
        FROM ' . $KodeData . $tahun . $bulan . '.Mjual AS mj Inner Join ' . $KodeData . $tahun . $bulan . '.Tjual AS tj on mj.NoJual = tj.NoJual group by tj.KdBrg, tj.NamaBrg ORDER BY Jumlah DESC');
    }
    public function getDataRekapPercustomer($KodeData, $tahun, $bulan)
    {
        return $this->db->query("SELECT concat(KdCust,' - ',NmCust,' ',Kota) AS Keterangan, Alamat,  
        count(KdCust) AS JumlahNota,
        SUM(Jumlah*Isi*If( Left(NoJual,2)='JL',1,-1)) AS Jumlah,
        SUM(Jumlah*Harga*If(Left(NoJual,2)='JL',1,-1)*If(PakaiHST=1,Isi,1)) AS Total, 
        SUM(Jumlah*Disc*If(Left(NoJual,2)='JL',1,-1)*If(PakaiHST=1,Isi,1)) AS Discont,
        SUM(If(SubTotal=0 Or PotonganRp=0,0,(Jumlah*(Harga-Disc)*If(Left(NoJual,2)='JL',1,-1)*IF(PakaiHST=1,Isi,1))/SubTotal*PotonganRp)) AS Potongan,
        SUM(If(SubTotal=0 Or PPnRp=0,0,(Jumlah*(Harga-Disc)*If(Left(NoJual,2)='JL',1,-1)*IF(PakaiHST=1,Isi,1))/SubTotal*PPnRp)) AS PPN
        FROM (SELECT MJ.KdCust, C.NmCust, C.Kota, C.Alamat, TJ.KdBrg, TJ.Jumlah, TJ.Isi, TJ.Harga, TJ.Disc, TJ.NoJual , MJ.PakaiHST, MJ.SubTotal, MJ.PotonganRp, MJ.PPnRp 
            FROM ($KodeData$tahun$bulan.MJual AS MJ LEFT JOIN $KodeData$tahun$bulan.Customer AS C ON  MJ.KdCust=C.KdCust) INNER JOIN $KodeData$tahun$bulan.TJual AS TJ ON MJ.NoJual = TJ.NoJual) AS X GROUP BY KdCust, NmCust, Alamat ORDER BY KdCust");
    }
    public function getDataRekapPertanggal($KodeData, $tahun, $bulan)
    {
        return $this->db->query("SELECT Tanggal AS Keterangan, 
        count(Tanggal) AS JumlahNota,
        SUM(Jumlah*Isi*If( Left(NoJual,2)='JL',1,-1)) AS Jumlah,
        SUM(Jumlah*Harga*If(Left(NoJual,2)='JL',1,-1)*If(PakaiHST=1,Isi,1)) AS Total, 
        SUM(Jumlah*Disc*If(Left(NoJual,2)='JL',1,-1)*If(PakaiHST=1,Isi,1)) AS Discont,
        SUM(If(SubTotal=0 Or PotonganRp=0,0,(Jumlah*(Harga-Disc)*If(Left(NoJual,2)='JL',1,-1)*IF(PakaiHST=1,Isi,1))/SubTotal*PotonganRp)) AS Potongan,
        SUM(If(SubTotal=0 Or PPnRp=0,0,(Jumlah*(Harga-Disc)*If(Left(NoJual,2)='JL',1,-1)*IF(PakaiHST=1,Isi,1))/SubTotal*PPnRp)) AS PPN
        FROM (SELECT MJ.Tanggal, TJ.Jumlah, TJ.Isi, TJ.Harga, TJ.Disc, TJ.NoJual , MJ.PakaiHST, MJ.SubTotal, MJ.PotonganRp, MJ.PPnRp 
            FROM ($KodeData$tahun$bulan.MJual AS MJ LEFT JOIN $KodeData$tahun$bulan.Customer AS C ON  MJ.KdCust=C.KdCust) INNER JOIN $KodeData$tahun$bulan.TJual AS TJ ON MJ.NoJual = TJ.NoJual) AS X
        GROUP BY Tanggal ORDER BY Tanggal");
    }
}

/* End of file Laporan_model.php */
/* Location: ./application/models/Laporan_model.php */