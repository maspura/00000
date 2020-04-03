<?php class Web_komentar_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function autocomplete()
	{
		$str = autocomplete_str('komentar', 'komentar');
		return $str;
	}

	private function search_sql()
	{
		if (isset($_SESSION['cari']))
		{
			$cari = $_SESSION['cari'];
			$kw = $this->db->escape_like_str($cari);
			$kw = '%' .$kw. '%';
			$search_sql= " AND (komentar LIKE '$kw' OR subjek LIKE '$kw')";
			return $search_sql;
		}
	}

	private function filter_status_sql()
	{
		if (isset($_SESSION['filter_status']))
		{
			$kf = $_SESSION['filter_status'];
			$filter_sql= " AND k.status = $kf";
			return $filter_sql;
		}
	}

	private function filter_user_sql()
	{
		if (isset($_SESSION['filter_user']))
		{
			$kf = $_SESSION['filter_user'];
			$filter_sql= " AND k.tipe = $kf";
			if($_SESSION['grup'] != 1){
				$filter_sql .= " AND (subjek = ".$_SESSION['user']." OR subjek = '')";
			}
			return $filter_sql;
		}
	}

	public function paging($p=1, $o=0)
	{
		$sql = "SELECT COUNT(*) AS jml " . $this->list_data_sql();
		$query = $this->db->query($sql);
		$row = $query->row_array();
		$jml_data = $row['jml'];

		$this->load->library('paging');
		$cfg['page'] = $p;
		$cfg['per_page'] = $_SESSION['per_page'];
		$cfg['num_rows'] = $jml_data;
		$this->paging->init($cfg);

		return $this->paging;
	}

	private function list_data_sql()
	{
		$sql = "FROM komentar k
			LEFT JOIN artikel a ON k.id_artikel = a.id
			WHERE 1";
		
		$sql .= " AND id_artikel <> 775";
		$sql .= $this->search_sql();
		$sql .= $this->filter_status_sql();
		$sql .= $this->filter_user_sql();
		return $sql;
	}

	public function list_data($o=0, $offset=0, $limit=500)
	{
		switch ($o)
		{
			case 1: $order_sql = ' ORDER BY owner DESC'; break;
			case 2: $order_sql = ' ORDER BY owner'; break;
			case 3: $order_sql = ' ORDER BY email DESC'; break;
			case 4: $order_sql = ' ORDER BY email'; break;
			case 5: $order_sql = ' ORDER BY komentar DESC'; break;
			case 6: $order_sql = ' ORDER BY komentar'; break;
			case 7: $order_sql = ' ORDER BY status DESC'; break;
			case 8: $order_sql = ' ORDER BY status'; break;
			case 9: $order_sql = ' ORDER BY tgl_upload DESC'; break;
			case 10: $order_sql = ' ORDER BY tgl_upload'; break;

			default:$order_sql = ' ORDER BY tgl_upload DESC';
		}
		$paging_sql = ' LIMIT ' .$offset. ',' .$limit;

		$sql = "SELECT k.*, a.judul as artikel, YEAR(a.tgl_upload) AS thn, MONTH(a.tgl_upload) AS bln, DAY(a.tgl_upload) AS hri, a.slug AS slug " . $this->list_data_sql();
		$sql .= $order_sql;
		$sql .= $paging_sql;

		$query = $this->db->query($sql);
		$data = $query->result_array();

		$j = $offset;
		for ($i=0; $i<count($data); $i++)
		{
			$data[$i]['no'] = $j + 1;
			if ($data[$i]['status'] == 1)
				$data[$i]['aktif'] = "Ya";
			else
				$data[$i]['aktif'] = "Tidak";
			$j++;
		}
		return $data;
	}

	public function insert($id)
	{
		$admin 				= $this->db->where('id', $_SESSION['user'])->get('user')->row_array();
		$komentar			= $this->get_komentar($id);

		$data 				= $_POST;
		$data['id_artikel'] = $komentar['id_artikel']; //Id_artikel user yg login
		$data['owner'] 		= $admin['nama']; //Nama user yg login
		$data['subjek'] 	= $admin['user']; //Id user yg login
		$data['email'] 		= $admin['email']; //Email user yg login
		$data['tipe'] 		= 9; //Tipe 9 adalah balasan komentar untuk website
		$data['status']		= 1;
		$data['id_balas'] 	= $id;
		$outp = $this->db->insert('komentar', $data);
		
		//Jika admin balas maka komentar pengunjung otomatis di tampilkan
		$this->komentar_lock($id, 1);
		
		status_sukses($outp); //Tampilkan Pesan
	}

	public function update($id=0)
	{
		$data = $_POST;
		$data['updated_at'] = date('Y-m-d H:i:s');
		$this->db->where('id', $id);
		$outp = $this->db->update('komentar', $data);
		
		status_sukses($outp); //Tampilkan Pesan
	}

	public function delete($id='', $semua=false)
	{
		if (!$semua) $this->session->success = 1;
		
		$outp = $this->db->where('id', $id)->or_where('id_balas', $id)->delete('komentar');

		status_sukses($outp, $gagal_saja=true); //Tampilkan Pesan
	}

	public function delete_all()
	{
		$this->session->success = 1;

		$id_cb = $_POST['id_cb'];
		foreach ($id_cb as $id)
		{
			$this->delete($id, $semua=true);
		}
	}

	public function komentar_lock($id='',$status=1)
	{
		$outp = $this->db->where('id', $id)
			->update('komentar', array(
					'status' => $status,
					'updated_at' => date('Y-m-d H:i:s')));
		
		status_sukses($outp); //Tampilkan Pesan
	}

	public function get_komentar($id=0)
	{
		$data	= $this->db->where('id', $id)->get('komentar')->row_array();

		return $data;
	}

}
?>