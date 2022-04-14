<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        //validasi jika user belum login
        if ($this->session->userdata('masuk') != TRUE) {
            $url = base_url();
            redirect($url);
        }
        $this->load->model('Master_model');
        $this->load->model('login_model');
        $this->load->helper('random');
        $this->load->library('form_validation');
    }

    /* ==================== Menampilkan all data by json ====================== */
    public function index()
    {
        $cust = $this->Master_model->allcust();
        $response = array();
        foreach ($cust->result() as $key) {
            $response[] = array(
                'KdCust' => $key->KdCust,
                'NmCust' => $key->NmCust
            );
        }

        header('Content-Type: application/json');
        echo json_encode(
            array(
                'success' => true,
                //'message' => 'get all customer',
                'data' => $response
            )
        );
    }

    public function databarang()
    {
        $barang = $this->Master_model->alldatabarang();
        $response = array();
        foreach ($barang->result() as $key) {
            $response[] = array(
                'KdBrg' => $key->KdBrg,
                'NmBrg' => $key->NmBrg,
                'HrgJl11' => $key->HrgJl11
            );
        }

        header('Content-Type: application/json');
        echo json_encode(
            array(
                'success' => true,
                //'message' => 'get all customer',
                'data' => $response
            )
        );
    }
    public function mjual()
    {
        $nofaktur = $this->uri->segment(3);
        $faktur = $this->Master_model->mjual($nofaktur)->row();

        if ($faktur) {
            header('Content-Type: application/json');
            echo json_encode(
                array(
                    'success' => true,
                    'data' => array(
                        'NoJual' => $faktur->NoJual,
                        'Tanggal' => $faktur->Tanggal,
                        'NamaCust' => $faktur->NamaCust
                    )
                )
            );
        } else {
            header('Content-Type: application/json');
            echo json_encode(
                array(
                    'success' => false,
                    'message' => 'Data tidak ada'
                )
            );
        }
    }

    public function update_cust()
    {
        /* set validasi */
        $this->form_validation->set_rules('kdcust', 'kdcust', 'required');
        //$this->form_validation->set_rules('nama_siswa', 'Nama Siswa', 'required');
        //$this->form_validation->set_rules('alamat', 'Alamat Siswa', 'required');

        if ($this->form_validation->run() == TRUE) {

            $id['kdcust'] = $this->input->post("kdcust");
            $data = array(
                'NmCust' => $this->input->post("nama_cust"),
                'alamat'     => $this->input->post("alamat"),
            );

            $update = $this->Master_model->update_cust($data, $id);

            if ($update) {
                header('Content-Type: application/json');
                echo json_encode(
                    array(
                        'success' => true,
                        'message' => 'Data Berhasil Diupdate!'
                    )
                );
            } else {
                header('Content-Type: application/json');
                echo json_encode(
                    array(
                        'success' => false,
                        'message' => 'Data Gagal Diupdate!'
                    )
                );
            }
        } else {

            header('Content-Type: application/json');
            echo json_encode(
                array(
                    'success'    => false,
                    'message'    => validation_errors()
                )
            );
        }
    }






    /* ============================================================================ */
    public function customer()
    {
        $data['cust'] = $this->Master_model->customer();
        $data['no'] = 1;

        $username = $this->session->userdata('ses_username');
        $setting['user'] = $this->login_model->sistemuser($username)->row();
        $setting['seting'] = $this->login_model->seting()->row();

        $this->load->view('header', $setting);
        $this->load->view('master/customer', $data);
        $this->load->view('footers');
    }
    public function edit_cust()
    {
        $kode = $this->input->post('kdcust');
        $nama = $this->input->post('nmcust');
        $alamat = $this->input->post('alamat');
        $kota = $this->input->post('kota');
        $telp = $this->input->post('telp');

        $uri = base_url('master/customer/');

        $this->db->query("UPDATE customer SET NmCust=if(NmCust<>'$nama','$nama',NmCust), Alamat=if(Alamat<>'$alamat','$alamat',Alamat), Kota=if(Kota>'$kota','$kota',Kota), Telp=if(Telp<>'$telp','$telp',Telp) WHERE KdCust='$kode'");
        header("Location: " . $uri, TRUE, $http_response_code);
    }
}
