<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{

	public function total_penjualan_user($tanggal, $username)
	{
		return $this->db->query("SELECT Tanggal,NmUser, sum(Subtotal) AS SubTotal, count(KdCust) as tcust FROM Mjual where Tanggal = '$tanggal' AND NoJual LIKE '%W%' AND NmUser = '$username' GROUP BY Tanggal, NmUser ");
	}
}

/* End of file Dashboard_model.php */
/* Location: ./application/models/Dashboard_model.php */