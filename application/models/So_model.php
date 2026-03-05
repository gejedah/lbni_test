<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class So_model extends CI_Model {

    public function get_door_to_door_insured_orders($tipe = 'Door to Door', $ada_asuransi = 1)
    {
        $select = "
            so.id_s_o,
            so.no_s_o,
            so.tipe,
            so.qty,
            so.tanggal,
            so.jam,
            pelanggan.kode_pelanggan,
            pelanggan.nama AS nama_pelanggan,
            sales.kode_salesman,
            sales.nama AS nama_salesman,
            kk.nama_kategori_kargo AS kategori_kargo,
            CASE WHEN so.ada_asuransi = 1 THEN 'YA' END AS asuransi,
            so.tagihan_asuransi,
            so.keterangan AS keterangan_so,
            jk.no_reff AS jadwal_kapal,
            kapal.kode_kapal,
            jk.rencana_berangkat_etd AS tanggal_rencana_berangkat_etd,
            wm.nama_wilayah AS wilayah_muat,
            pm.kode AS kode_partner_muat,
            pm.nama AS partner_muat,
            wb.nama_wilayah AS wilayah_bongkar,
            pb.kode AS kode_partner_bongkar,
            pb.nama AS partner_bongkar,
            soohj.otorisasi_harga_jual AS harga_jual,
            soohj.tanggal_otorisasi AS tanggal_otorisasi
        ";

        $this->db->select($select);
        $this->db->from('s_o so');

        $this->db->join('pelanggan pelanggan', 'pelanggan.id_pelanggan = so.id_pelanggan', 'left');
        $this->db->join('salesman sales', 'sales.id_salesman = so.id_salesman', 'left');
        $this->db->join('kategori_kargo kk', 'kk.id_kategori_kargo = so.id_kategori_kargo', 'inner');
        $this->db->join('jadwal_kapal jk', 'jk.id_jadwal_kapal = so.id_jadwal_kapal', 'inner');
        $this->db->join('kapal kapal', 'kapal.id_kapal = jk.id_kapal', 'inner');
        $this->db->join('partner pm', 'so.id_partner_muat = pm.id_partner', 'left');
        $this->db->join('partner pb', 'so.id_partner_bongkar = pb.id_partner', 'left');
        $this->db->join('wilayah wm', 'jk.id_wilayah_muat = wm.id_wilayah', 'left');
        $this->db->join('wilayah wb', 'wb.id_wilayah = jk.id_wilayah_bongkar', 'left');
        $this->db->join('s_o_otorisasi_harga_jual soohj', 'soohj.id_s_o = so.id_s_o', 'inner');

        $this->db->where('so.tipe', $tipe);
        $this->db->where('so.ada_asuransi', (int)$ada_asuransi);

        $query = $this->db->get();
        return $query->result_array();
    }
}
