<?php
namespace App\Models;

use CodeIgniter\Model;

class SoModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 's_o';

    public function getDoorToDoorInsuredOrders(string $tipe = 'Door to Door', int $ada_asuransi = 1)
    {
        $builder = $this->db->table('s_o so');

        $builder->select([
            'so.id_s_o',
            'so.no_s_o',
            'so.tipe',
            'so.qty',
            'so.tanggal',
            'so.jam',
            'pelanggan.kode_pelanggan',
            'pelanggan.nama as nama_pelanggan',
            'sales.kode_salesman',
            'sales.nama as nama_salesman',
            'kk.nama_kategori_kargo as kategori_kargo',
            "(CASE WHEN so.ada_asuransi = 1 THEN 'YA' END) as asuransi",
            'so.tagihan_asuransi',
            'so.keterangan as keterangan_so',
            'jk.no_reff as jadwal_kapal',
            'kapal.kode_kapal',
            'jk.rencana_berangkat_etd as tanggal_rencana_berangkat_etd',
            'wm.nama_wilayah as wilayah_muat',
            'pm.kode as kode_partner_muat',
            'pm.nama as partner_muat',
            'wb.nama_wilayah as wilayah_bongkar',
            'pb.kode as kode_partner_bongkar',
            'pb.nama as partner_bongkar',
            'soohj.otorisasi_harga_jual as harga_jual',
            'soohj.tanggal_otorisasi as tanggal_otorisasi',
        ]);

        $builder->join('pelanggan pelanggan', 'pelanggan.id_pelanggan = so.id_pelanggan', 'left');
        $builder->join('salesman sales', 'sales.id_salesman = so.id_salesman', 'left');
        $builder->join('kategori_kargo kk', 'kk.id_kategori_kargo = so.id_kategori_kargo', 'inner');
        $builder->join('jadwal_kapal jk', 'jk.id_jadwal_kapal = so.id_jadwal_kapal', 'inner');
        $builder->join('kapal kapal', 'kapal.id_kapal = jk.id_kapal', 'inner');
        $builder->join('partner pm', 'so.id_partner_muat = pm.id_partner', 'left');
        $builder->join('partner pb', 'so.id_partner_bongkar = pb.id_partner', 'left');
        $builder->join('wilayah wm', 'jk.id_wilayah_muat = wm.id_wilayah', 'left');
        $builder->join('wilayah wb', 'wb.id_wilayah = jk.id_wilayah_bongkar', 'left');
        $builder->join('s_o_otorisasi_harga_jual soohj', 'soohj.id_s_o = so.id_s_o', 'inner');

        $builder->where('so.tipe', $tipe);
        $builder->where('so.ada_asuransi', $ada_asuransi);

        $query = $builder->get();
        return $query->getResultArray();
    }
}
