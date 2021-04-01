<?php
defined('BASEPATH') or exit('No direct script access allowed');

class crud extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_crud');
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('form');
	}

	public function index()
	{
		$this->load->view('V_home');
	}

	public function ambildata()
	{
		$dataBarang = $this->M_crud->ambildata();
		echo json_encode($dataBarang);
	}

	public function tambahdata()
	{
		// tangkap inputan dan simpan di variabel
		$kode_barang  = $this->input->post('kode_barang');
		$nama_barang  = $this->input->post('nama_barang');
		$harga  = $this->input->post('harga');
		$stok  = $this->input->post('stok');

		// cek validasi kosong
		if ($kode_barang == '') {
			$result['pesan'] = "Kode Barang harus diisi";
		} elseif ($nama_barang == '') {
			$result['pesan'] = "Nama Barang harus diisi";
		} elseif ($harga == '') {
			$result['pesan'] = "Harga Barang harus diisi";
		} elseif ($stok == '') {
			$result['pesan'] = "Stok Barang harus diisi";
		} else {
			// berhasil lolo validasi
			$result['pesan'] = '';

			$data = array(
				'kode_barang' => $kode_barang,
				'nama_barang' => $nama_barang,
				'harga' => $harga,
				'stok' => $stok
			);

			$this->M_crud->tambahdata($data);
		}

		echo json_encode($result);
	}

	public function ambilID()
	{
		$id = $this->input->post('id');

		$hasilID = $this->M_crud->ambilID($id);

		echo json_encode($hasilID);
	}

	public function editdata()
	{
		// tangkap inputan dan simpan di variabel
		$id = $this->input->post('id');
		$kode_barang  = $this->input->post('kode_barang');
		$nama_barang  = $this->input->post('nama_barang');
		$harga  = $this->input->post('harga');
		$stok  = $this->input->post('stok');

		// cek validasi kosong
		if ($kode_barang == '') {
			$result['pesan'] = "Kode Barang harus diisi";
		} elseif ($nama_barang == '') {
			$result['pesan'] = "Nama Barang harus diisi";
		} elseif ($harga == '') {
			$result['pesan'] = "Harga Barang harus diisi";
		} elseif ($stok == '') {
			$result['pesan'] = "Stok Barang harus diisi";
		} else {
			// berhasil lolo validasi
			$result['pesan'] = '';

			$data = array(
				'kode_barang' => $kode_barang,
				'nama_barang' => $nama_barang,
				'harga' => $harga,
				'stok' => $stok
			);

			$this->M_crud->editdata($id, $data);
		}

		echo json_encode($result);
	}

	public function hapusdata()
	{
		$id = $this->input->post('id');

		$this->M_crud->hapusdata($id);
	}
}
