<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class So extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('So_model');
    }

    public function index()
    {
        $data = $this->So_model->get_door_to_door_insured_orders();
        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode($data));
    }

    public function list_by_request()
    {
        $tipe = $this->input->get('tipe') ?? 'Door to Door';
        $ada_asuransi = (int) ($this->input->get('ada_asuransi') ?? 1);

        $data = $this->So_model->get_door_to_door_insured_orders($tipe, $ada_asuransi);
        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode($data));
    }
}
