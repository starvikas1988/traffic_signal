<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SignalController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->database();
    }

    public function index() {
      
        $this->load->view('signal_form');
    }

    public function start_signal() {
        $this->form_validation->set_rules('sequence', 'Sequence', 'required');
        $this->form_validation->set_rules('green_interval', 'Green Interval', 'required|integer');
        $this->form_validation->set_rules('yellow_interval', 'Yellow Interval', 'required|integer');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array('error' => validation_errors()));
        } else {
            $data = array(
                'sequence' => $this->input->post('sequence'),
                'green_interval' => $this->input->post('green_interval'),
                'yellow_interval' => $this->input->post('yellow_interval'),
                'status' => 'running'
            );
            $this->db->insert('signals', $data);
            echo json_encode(array('success' => 'Signal started successfully.'));
        }
    }

    public function stop_signal() {
        $this->db->set('status', 'stopped')->update('signals');
        echo json_encode(array('success' => 'Signal stopped successfully.'));
    }
}
