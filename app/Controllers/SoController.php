<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SoModel;

class SoController extends BaseController
{
    public function index()
    {
        // JSON endpoint with optional search and pagination
        $tipe = $this->request->getGet('tipe');
        $ada_asuransi = (int) $this->request->getGet('ada_asuransi');
        $search = $this->request->getGet('search') ?? '';
        $page = max(1, (int) ($this->request->getGet('page') ?? 1));
        $perPage = max(1, (int) ($this->request->getGet('perPage') ?? 15));

        $model = new SoModel();
        $builder = $model->getSalesOrderBuilder($tipe, $ada_asuransi);

        if (!empty($search)) {
            $builder->groupStart()
                ->like('so.no_s_o', $search)
                ->orLike('pelanggan.nama', $search)
                ->orLike('sales.nama', $search)
                ->orLike('kk.nama_kategori_kargo', $search)
                ->orLike('so.keterangan', $search)
            ->groupEnd();
        }

        $countBuilder = clone $builder;
        $total = (int) $countBuilder->countAllResults(false);

        $offset = ($page - 1) * $perPage;
        $builder->limit($perPage, $offset);

        $orders = $builder->get()->getResultArray();

        return $this->response->setJSON([
            'orders' => $orders,
            'pager' => [
                'total' => $total,
                'perPage' => $perPage,
                'currentPage' => $page,
                'lastPage' => (int) ceil($total / $perPage),
            ],
            'search' => $search,
            'tipe' => $tipe,
            'ada_asuransi' => $ada_asuransi,
        ]);
    }

    public function listByRequest()
    {
        // Backwards-compatible alias for index JSON behavior
        return $this->index();
    }

    // New: HTML list with pagination and search
    public function list()
    {
        $tipe = $this->request->getGet('tipe');
        $ada_asuransi = (int) $this->request->getGet('ada_asuransi');
        $search = $this->request->getGet('search') ?? '';
        $page = max(1, (int) ($this->request->getGet('page') ?? 1));
        $perPage = 15;

        $model = new SoModel();
        $builder = $model->getSalesOrderBuilder($tipe, $ada_asuransi);

        if (!empty($search)) {
            // search across several text fields
            $builder->groupStart()
                ->like('so.no_s_o', $search)
                ->orLike('pelanggan.nama', $search)
                ->orLike('sales.nama', $search)
                ->orLike('kk.nama_kategori_kargo', $search)
                ->orLike('so.keterangan', $search)
            ->groupEnd();
        }

        // Get total count
        $countBuilder = clone $builder;
        $total = (int) $countBuilder->countAllResults(false); // false keeps builder state

        // Apply limit/offset
        $offset = ($page - 1) * $perPage;
        $builder->limit($perPage, $offset);

        $query = $builder->get();
        $orders = $query->getResultArray();

        $data = [
            'orders' => $orders,
            'pager' => [
                'total' => $total,
                'perPage' => $perPage,
                'currentPage' => $page,
                'lastPage' => (int) ceil($total / $perPage),
            ],
            'search' => $search,
            'tipe' => $tipe,
            'ada_asuransi' => $ada_asuransi,
        ];

        return view('so_list', $data);
    }

    // New: detail view
    public function view($id = null)
    {
        if (empty($id)) {
            return redirect()->to('/sales_order');
        }

        $model = new SoModel();
        $builder = $model->getSalesOrderBuilder();
        $builder->where('so.id_s_o', $id);
        $query = $builder->get();
        $order = $query->getRowArray();

        dd($order);

        return view('so_detail', ['order' => $order]);
    }
}
