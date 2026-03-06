<?php
namespace App\Models;

use CodeIgniter\Model;

class SoModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 's_o';

    public function getSalesOrder(?string $tipe = null, ?int $ada_asuransi = null)
    {
        // initialize row number and select from s_o
        $builder = $this->db->table('(SELECT @row_number := 0) AS ori, s_o so');

        $builder->select([
            "(@row_number := @row_number + 1) AS `No`",
            "so.no_s_o as `No SO`",
            "so.tipe as `Tipe SO`",
            "so.qty as `Qty`",
            "so.tanggal as `Tanggal`",
            "so.jam as `Jam`",
            "pelanggan.kode_pelanggan as `Kode Pelanggan`",
            "pelanggan.nama as `Nama Pelanggan`",
            "sales.kode_salesman as `Kode Salesman`",
            "sales.nama as `Nama Salesman`",
            "kk.nama_kategori_kargo as `kategori kargo`",
            "CASE WHEN so.ada_asuransi = 1 THEN 'YA' ELSE '' END as `Asuransi`",
            "COALESCE(so.tagihan_asuransi, '') as `Tagihan Asuransi`",
            "so.keterangan as `Keterangan So`",
            "CONCAT_WS(' ', kapal.nama_kapal , ' V. ', jk.no_voyage ) as `Jadwal Kapal`",
            "kapal.kode_kapal as `Kode Kapal`",
            "jk.rencana_berangkat_etd as `Tanggal Rencana Berangkat (ETD)`",
            "wm.nama_wilayah as `Wilayah Muat`",
            "COALESCE(pm.kode, '') as `Kode Partner Muat`",
            "COALESCE(pm.nama, '') as `Partner Muat`",
            "COALESCE(wb.nama_wilayah, '') as `Wilayah Bongkar`",
            "COALESCE(pb.kode, '') as `Kode Partner Bongkar`",
            "COALESCE(pb.nama, '') as `Partner Bongkar`",
            "CASE WHEN soohj.otorisasi_harga_jual IS NOT NULL THEN soohj.otorisasi_harga_jual ELSE so.harga_jual END as `Harga Jual`",
            "COALESCE(soohj.tanggal_otorisasi, '') as `Tanggal Otorisasi`",
        ]);

        $builder->join('pelanggan pelanggan', 'pelanggan.id_pelanggan = so.id_pelanggan', 'left');
        $builder->join('salesman sales', 'sales.id_salesman = so.id_salesman', 'left');
        $builder->join('kategori_kargo kk', 'kk.id_kategori_kargo = so.id_kategori_kargo', 'left');
        $builder->join('jadwal_kapal jk', 'jk.id_jadwal_kapal = so.id_jadwal_kapal', 'left');
        $builder->join('kapal kapal', 'kapal.id_kapal = jk.id_kapal', 'left');
        $builder->join('partner pm', 'so.id_partner_muat = pm.id_partner', 'left');
        $builder->join('partner pb', 'so.id_partner_bongkar = pb.id_partner', 'left');
        $builder->join('wilayah wm', 'jk.id_wilayah_muat = wm.id_wilayah', 'left');
        $builder->join('wilayah wb', 'wb.id_wilayah = jk.id_wilayah_bongkar', 'left');
        $builder->join('s_o_otorisasi_harga_jual soohj', 'soohj.id_s_o = so.id_s_o', 'left');

        // Use strict null checks so 0 values (e.g. ada_asuransi = 0) are preserved
        if ($tipe !== null) {
            $builder->where('so.tipe', $tipe);
        }
        if ($ada_asuransi !== null) {
            $builder->where('so.ada_asuransi', $ada_asuransi);
        }

        $query = $builder->get();
        return $query->getResultArray();
    }

    // New: return the prepared builder so controllers can add search/limit/offset and count
    public function getSalesOrderBuilder(?string $tipe = null, ?int $ada_asuransi = null)
    {
        // initialize row number and select from s_o so (initialized in FROM)
        $builder = $this->db->table('(SELECT @row_number := 0) AS ori, s_o so');

        $builder->select([
            "(@row_number := @row_number + 1) AS `No`",
            "so.no_s_o as `No SO`",
            "so.tipe as `Tipe SO`",
            "so.qty as `Qty`",
            "so.tanggal as `Tanggal`",
            "so.jam as `Jam`",
            "pelanggan.kode_pelanggan as `Kode Pelanggan`",
            "pelanggan.nama as `Nama Pelanggan`",
            "sales.kode_salesman as `Kode Salesman`",
            "sales.nama as `Nama Salesman`",
            "kk.nama_kategori_kargo as `kategori kargo`",
            "CASE WHEN so.ada_asuransi = 1 THEN 'YA' ELSE '' END as `Asuransi`",
            "COALESCE(so.tagihan_asuransi, '') as `Tagihan Asuransi`",
            "so.keterangan as `Keterangan So`",
            "CONCAT_WS(' ', kapal.nama_kapal , ' V. ', jk.no_voyage ) as `Jadwal Kapal`",
            "kapal.kode_kapal as `Kode Kapal`",
            "jk.rencana_berangkat_etd as `Tanggal Rencana Berangkat (ETD)`",
            "wm.nama_wilayah as `Wilayah Muat`",
            "COALESCE(pm.kode, '') as `Kode Partner Muat`",
            "COALESCE(pm.nama, '') as `Partner Muat`",
            "COALESCE(wb.nama_wilayah, '') as `Wilayah Bongkar`",
            "COALESCE(pb.kode, '') as `Kode Partner Bongkar`",
            "COALESCE(pb.nama, '') as `Partner Bongkar`",
            "CASE WHEN soohj.otorisasi_harga_jual IS NOT NULL THEN soohj.otorisasi_harga_jual ELSE so.harga_jual END as `Harga Jual`",
            "COALESCE(soohj.tanggal_otorisasi, '') as `Tanggal Otorisasi`",
        ]);
        // log_message('debug', 'getSalesOrderBuilder: ' . $builder->getCompiledSelect(false)); // Log the compiled SQL for debugging

        $builder->join('pelanggan pelanggan', 'pelanggan.id_pelanggan = so.id_pelanggan', 'left');
        $builder->join('salesman sales', 'sales.id_salesman = so.id_salesman', 'left');
        $builder->join('kategori_kargo kk', 'kk.id_kategori_kargo = so.id_kategori_kargo', 'left');
        $builder->join('jadwal_kapal jk', 'jk.id_jadwal_kapal = so.id_jadwal_kapal', 'left');
        $builder->join('kapal kapal', 'kapal.id_kapal = jk.id_kapal', 'left');
        $builder->join('partner pm', 'so.id_partner_muat = pm.id_partner', 'left');
        $builder->join('partner pb', 'so.id_partner_bongkar = pb.id_partner', 'left');
        $builder->join('wilayah wm', 'jk.id_wilayah_muat = wm.id_wilayah', 'left');
        $builder->join('wilayah wb', 'wb.id_wilayah = jk.id_wilayah_bongkar', 'left');
        $builder->join('s_o_otorisasi_harga_jual soohj', 'soohj.id_s_o = so.id_s_o', 'left');

        if ($tipe !== null) {
            $builder->where('so.tipe', $tipe);
        }
        if ($ada_asuransi !== null) {
            $builder->where('so.ada_asuransi', $ada_asuransi);
        }

        return $builder;
    }
}
