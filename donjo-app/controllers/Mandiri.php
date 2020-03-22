<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mandiri extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		session_start();
		$this->load->model('mandiri_model');
		$this->modul_ini = 14;
		$this->sub_modul_ini = 56;
	}

	public function clear()
	{
		unset($_SESSION['cari']);
		unset($_SESSION['filter']);
		redirect('mandiri');
	}

	public function index($p = 1, $o = 0)
	{
		$data['p'] = $p;
		$data['o'] = $o;

		if (isset($_SESSION['cari']))
			$data['cari'] = $_SESSION['cari'];
		else $data['cari'] = '';

		if (isset($_SESSION['filter']))
			$data['filter'] = $_SESSION['filter'];
		else $data['filter'] = '';

		if (isset($_POST['per_page']))
			$_SESSION['per_page'] = $_POST['per_page'];
		$data['per_page'] = $_SESSION['per_page'];

		$data['paging'] = $this->mandiri_model->paging($p, $o);
		$data['main'] = $this->mandiri_model->list_data($o, $data['paging']->offset, $data['paging']->per_page);
		$data['keyword'] = $this->mandiri_model->autocomplete();
		
		// Isi nilai true jika menggunakan minisidebar
		$this->render_view('mandiri/mandiri', $data);
	}

	public function search()
	{
		$cari = $this->input->post('cari');
		if ($cari != '')
			$_SESSION['cari']=$cari;
		else unset($_SESSION['cari']);
		redirect('mandiri');
	}

	public function ajax_pin($p = 1, $o = 0, $id = 0)
	{
		$data['penduduk'] = $this->mandiri_model->list_penduduk();
		$data['form_action'] = site_url("mandiri/insert/$id");
		$this->load->view('mandiri/ajax_pin', $data);
	}

	public function insert()
	{
		$pin = $this->mandiri_model->insert();

		status_sukses($pin); //Tampilkan Pesan

		$_SESSION['pin'] = $pin;
		redirect('mandiri');
	}

	public function delete($p = 1, $o = 0, $id = '')
	{
		$this->redirect_hak_akses('h', "mandiri");
		$this->mandiri_model->delete($id);		
		redirect("mandiri");
	}
}
