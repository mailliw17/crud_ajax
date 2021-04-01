<?php

class M_crud extends CI_Model
{
    public function ambildata()
    {
        return $this->db->query("SELECT * FROM barang")->result();
    }

    public function tambahdata($data)
    {
        $this->db->insert('barang', $data);
    }

    public function ambilID($id)
    {
        return $this->db->query("SELECT * FROM barang WHERE id= '$id'")->result();
    }

    public function editdata($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('barang', $data);
    }

    public function hapusdata($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('barang');
    }
}
