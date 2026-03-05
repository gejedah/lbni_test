<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SoModel;

class SoController extends BaseController
{
    public function index()
    {
        $model = new SoModel();
        $data = $model->getDoorToDoorInsuredOrders();
        return $this->response->setJSON($data);
    }

    public function listByRequest()
    {
        $tipe = $this->request->getGet('tipe') ?? 'Door to Door';
        $ada_asuransi = (int) ($this->request->getGet('ada_asuransi') ?? 1);

        $model = new SoModel();
        $data = $model->getDoorToDoorInsuredOrders($tipe, $ada_asuransi);
        return $this->response->setJSON($data);
    }
}
