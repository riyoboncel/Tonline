<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master_model extends CI_Model
{
    /* ==================== Menampilkan all data by json ====================== */
    public function allcust()
    {
        $this->db->select("*");
        $this->db->from(" customer ");
        //$this->db->where("NmCust", "DESC");
        return $this->db->get();
    }
    public function update_cust($data, $id)
    {
        $update = $this->db->update("customer", $data, $id);

        if ($update) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function alldatabarang()
    {
        return $this->db->query("SELECT * FROM barang WHERE NmBrg <> '' ");
    }

    public function mjual($nofaktur)
    {
        return $this->db->query("SELECT * FROM mjual WHERE NoJual = '$nofaktur' ");
    }



    /* ================================================================================ */

    public function customer()
    {
        $this->db->select('KdCust, NmCust, Alamat,Kota, Telp');
        $this->db->order_by('KdCust', 'ASC');
        return $this->db->get('customer');
    }
}
