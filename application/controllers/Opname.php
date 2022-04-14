<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Opname extends CI_Controller
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
        $this->load->model('opname_model');
        $this->load->model('login_model');
        $this->load->helper('random');
    }

    public function nomor_faktur()
    {
        $tgl_now = date('Y-m-d');
        $waktu = date('H:i:s');
        $tgl = date('Y-m-d H:i:s');
        $id_user = $this->session->userdata('ses_userid');
        $nm_user = $this->session->userdata('ses_username');
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
        $max = $this->db->query("SELECT MAX(RIGHT(NoOpname,2)) AS id_max FROM temp_mopname WHERE LEFT(NoOpname,2) <> 'OP' AND NoOpname LIKE '%W%'  AND NmUser ='$nm_user' ");
        $x = $max->row_array();
        $last = $x['id_max'];
        $cek = $this->db->query("SELECT * FROM temp_mopname WHERE substr(NoOpname,-2)='$last' AND LEFT(NoOpname,2) <> 'OP' AND NoOpname LIKE '%W%' AND NmUser ='$nm_user' ");
        $i = $cek->row_array();
        $user = $i['NmUser'];
        $selesai = $i['Flag'];
        $lokasiawal = $this->login_model->lokasiawal($id_user)->row_array();

        if ($user == $nm_user && $selesai == '0') {
            $nofaktur = $hsl . 'W' . $last;
        } else {
            $nofaktur = $this->opname_model->getNo($id_user, $nm_user);
            $data = array(
                'NoOpname' => $nofaktur,
                'Tanggal' => $tgl_now,
                'Jam' => $waktu,
                'TglEntry' => $tgl,
                'NmUser' => $nm_user,
                'KdLokasi' => $lokasiawal['LokasiAwal'],
                'Flag' => '0',
            );
            $this->db->insert('temp_mopname', $data);
        }
        redirect('opname/form-opname/' . $nofaktur, 'refresh');
    }

    // untuk buat nomer pesan pj baru 
    public function nomor_faktur_new()
    {
        //$ymd = date('ymd');
        $tgl_now = date('Y-m-d');
        $waktu = date('H:i:s');
        $tgl = date('Y-m-d H:i:s');
        $id_user = $this->session->userdata('ses_userid');
        $nm_user = $this->session->userdata('ses_username');
        $nofaktur = $this->opname_model->getNo($id_user, $nm_user);
        $lokasiawal = $this->login_model->lokasiawal($id_user)->row_array();
        $data = array(
            'NoOpname' => $nofaktur,
            'Tanggal' => $tgl_now,
            'Jam' => $waktu,
            'TglEntry' => $tgl,
            'NmUser' => $nm_user,
            'KdLokasi' => $lokasiawal['LokasiAwal'],
            'Flag' => '0',
        );
        $this->db->insert('temp_mopname', $data);
        redirect('opname/form-opname/' . $nofaktur, 'refresh');
    }

    // tampilan proses entry item
    public function form_opname()
    {
        $noresi = $this->uri->segment(3);
        $username = $this->session->userdata('ses_username');
        $data_faktur = $this->opname_model->getDataOpname($noresi, $username)->row();
        $list_barang = $this->opname_model->getListOpname($noresi);
        $list_lokasi = $this->opname_model->getListLokasi();

        if ($data_faktur) {
            $data['title'] = 'Entry Opname Final';
            $data['tgl'] = date('Y-m-d');
            $data['no'] = 1;
            $data['faktur'] = $data_faktur;
            $data['list'] = $list_barang;
            $data['lokasi'] = $list_lokasi;
            $setting['user'] = $this->login_model->sistemuser($username)->row();
            $setting['seting'] = $this->login_model->seting()->row();

            $this->load->view('header', $setting);
            $this->load->view('opname/form_opname', $data);
            $this->load->view('footers');
        } else {
            $this->load->view('error404');
        }
    }

    public function ganti_lokasi()
    {
        $noresi = $this->input->post('nofak');
        $asal = $this->input->post('asal');
        $uri = base_url('opname/form-opname/') . $noresi;
        if ($asal == '') {
            echo $this->session->set_flashdata('error', 'Lokasi  tidak boleh kosong');
            header("Location: " . $uri, TRUE, $http_response_code);
        } else {
            $this->db->query("UPDATE temp_mopname SET KdLokasi='$asal' WHERE NoOpname='$noresi'");
            header("Location: " . $uri, TRUE, $http_response_code);
        }
    }

    // tampilan pesan yang belum di selesaikan 
    public function antrian_opname()
    {
        $id_user = $this->session->userdata('ses_username');
        $username = $this->session->userdata('ses_username');
        $now = date('Y-m-d');
        $before = date('Y-m-d', strtotime('-30 days', strtotime($now)));
        $data['pending'] = $this->opname_model->antrianopname($id_user, $now, $before);
        $data['no'] = 1;

        $setting['user'] = $this->login_model->sistemuser($username)->row();
        $setting['seting'] = $this->login_model->seting()->row();
        $this->load->view('header', $setting);
        $this->load->view('opname/antrian_opname', $data);
        $this->load->view('footers');
    }


    function get_autocomplete()
    {
        if (isset($_GET['term'])) {
            $result = $this->opname_model->cari_brg($_GET['term']);
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

    // proses simpan pesan yang sudah final
    public function go_simpan()
    {
        $ymd = date('ym');
        $tgl_now = date('Y-m-d');
        $waktu = date('H:i:s');
        $id_user = $this->session->userdata('ses_userid');
        $nm_user = $this->session->userdata('ses_username');
        $noresi = $this->input->post('noopname');

        $nofaktur = $this->opname_model->getNoFaktur($ymd, $id_user, $nm_user);

        $uri = base_url('opname/antrian_opname/');

        $this->db->query("INSERT INTO mopname (NoOpname,Tanggal,Ket,NmUser,KdLokasi,Flag,Jam,TglEntry) SELECT '$nofaktur',Tanggal,Ket,NmUser,KdLokasi,Flag,Jam,TglEntry FROM temp_mopname WHERE NoOpname= '$noresi'");

        $this->db->query("INSERT INTO topname (NoOpname,KdBrg,Stock,Fisik,Jumlah,Sat,HBT,Isi,HrgBeli,Keterangan,NamaBrg,Jasa,Barcode) SELECT '$nofaktur',KdBrg,Stock,Fisik,Jumlah,Sat,HBT,Isi,HrgBeli,Keterangan,NamaBrg,Jasa,Barcode FROM temp_topname WHERE NoOpname= '$noresi'");

        $tables = array('temp_mopname', 'temp_topname');
        $this->db->where('NoOpname', $noresi);
        $this->db->delete($tables);
        header("Location: " . $uri, TRUE, $http_response_code);
    }


    // untuk proses entry item di form pesan
    public function cekbarang()
    {
        $noresi = urldecode($this->uri->segment(3));
        $nofaktur = urldecode($this->uri->segment(3));
        $idbarang = urldecode($this->uri->segment(4));
        $username = $this->session->userdata('ses_username');
        $data_faktur = $this->opname_model->getDataOpname($noresi, $username);
        $f = $data_faktur->row_array();
        $lokasi = $f['KdLokasi'];
        $produk = $this->opname_model->getbarang($idbarang);

        $x = $produk->row_array();
        $kdb = $x['KdBrg'];
        $stock = $x['Akhir'] + 0;
        $jumlah = $stock - 0;

        $cek_sudah_ada = $this->opname_model->cek_sudah_ada($kdb, $nofaktur);
        $viewstock = $this->opname_model->viewstock($idbarang, $lokasi);
        $vs = $viewstock->row_array();
        $vstock = $vs['Akhir'];

        $uri = base_url('opname/form-opname/') . $nofaktur;

        if ($produk->num_rows() > 0) {
            if ($cek_sudah_ada->num_rows() > 0) {
                echo $this->session->set_flashdata('error', 'Kode ' . $idbarang . ' sudah ada :(');
                header("Location: " . $uri, TRUE, $http_response_code);
            } else {
                $input = array(
                    'NoOpname' => $nofaktur,
                    'KdBrg' => $x['KdBrg'],
                    'Stock' => $vstock + 0,
                    'Fisik' => 0,
                    'Jumlah' => $vstock - 0,
                    'Sat' => $x['Sat_1'],
                    'HBT' => $x['Hrg_Beli_Akhir'],
                    'Isi' => '1',
                    'HrgBeli' => $x['Hrg_Beli_Rata'],
                    'Keterangan' => $x['Ket1'],
                    'NamaBrg' => $x['NmBrg'],
                    'Sat_1' => $x['Sat_1'], 'Sat_2' => $x['Sat_2'], 'Sat_3' => $x['Sat_3'], 'Sat_4' => $x['Sat_4'],
                    'Isi_2' => $x['Isi_2'], 'Isi_3' => $x['Isi_3'], 'Isi_4' => $x['Isi_4'],
                    'Jasa' => $x['Jasa'],
                    'Barcode' => $idbarang,
                );
                $this->db->insert('temp_topname', $input);
                header("Location: " . $uri, TRUE, $http_response_code);
            }
        } else {
            echo $this->session->set_flashdata('error', 'Kode ' . $idbarang . ' tidak tersedia :(');
            header("Location: " . $uri, TRUE, $http_response_code);
        }
    }

    public function edit_fisik()
    {
        $idbarang = $this->input->post('kdbrg');
        $nofaktur = $this->input->post('nofak');
        $fisik = $this->input->post('fisik');
        $uri = base_url('opname/form-opname/') . $nofaktur;

        $this->db->query("UPDATE temp_topname SET Fisik='$fisik', Jumlah=Stock-Fisik WHERE KdBrg='$idbarang' AND NoOpname='$nofaktur'");
        header("Location: " . $uri, TRUE, $http_response_code);
    }

    // untuk hapus item di form pesan 
    public function hapus_barang_opname()
    {
        $nofaktur = urldecode($this->uri->segment(3));
        $idbarang = urldecode($this->uri->segment(4));
        $uri = base_url('opname/form-opname/') . $nofaktur;
        $this->db->query("DELETE FROM temp_topname WHERE NoOpname='$nofaktur' AND KdBrg='$idbarang'");
        header("Location: " . $uri, TRUE, $http_response_code);
    }
    public function hapus_faktur()
    {
        $nofaktur = urldecode($this->uri->segment(3));
        $this->db->query("DELETE FROM temp_mopname WHERE NoOpname='$nofaktur'");
        $this->db->query("DELETE FROM temp_topname WHERE NoOpname='$nofaktur'");
        echo $this->session->set_flashdata('msg', 'Faktur berhasil ' . $nofaktur . ' dihapus');
        redirect('pra/nomor-faktur/', 'refresh');
    }
}

/* End of file Kasir.php */
/* Location: ./application/controllers/Kasir.php */