<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Load Dependencies
		$this->load->database();
		$this->load->helper(array('url','form', 'file')); 
		$this->load->library(array('form_validation','pagination','session', 'image_lib', 'ion_auth')); 
		$this->load->model('tasks_model');
		$this->load->helper('view'); 

	}

	// List all your items
	public function index( $offset = 0 )
	{

		if (!$this->input->is_ajax_request()) {
			$events_data['data'] = $this->tasks_model->get_tasks_for_month();  
			$this->load->view('ajax', $events_data, FALSE);
		}
		else if ($this->input->is_ajax_request()) {

			$id = $this->input->post('id');
			$value = $this->input->post('value');
		
			if($this->tasks_model->update_current_event_state($id, $value)){
				echo json_encode(array("id" => $id , "value" => $value));   
			}
		
		}

	} 

}
 
/* End of file ajax.php */
/* Location: ./application/controllers/ajax.php */