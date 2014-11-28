<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Load Dependencies
		$this->load->database();
		$this->load->helper(array('url','form', 'file')); 
		$this->load->library(array('form_validation','pagination','session', 'image_lib', 'ion_auth')); 
		$this->load->model('posts_model');
		//Load Dependencies
		$this->load->helper('dbug');
		$this->load->helper('view'); 

		if ( !$this->ion_auth->logged_in() ) 
		{ 
			redirect('auth', 'refresh');
		}
		$this->load->helper('chrome_logger');

	}

	// List all your items
	public function index( $offset = 0 )
	{

		$data ='';
		// dbug($_REQUEST); 
		// dbug($this->input->post('search_info')); 

		if( $this->input->post('submit') )
        {

			$data['result'] = '';

        	$this->form_validation->set_rules('search_info', 'Search info', 'trim|required|xss_clean|min_length[3]');
        	$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
			$validated = $this->form_validation->run();

			if($validated){ 
				$data['search_results'] = $this->posts_model->get_searched_posts($this->input->post('search_info'));
				// dbug($data); 
				if($data['search_results'])
					$data['result'] = "Here are the search result below";
				else
					$data['result'] = "Sorry, no posts found on your search!";
				$this->load->view('search', $data, FALSE); 
			}
			else{
				$this->load->view('search');   
			}
		}
		else{
			$this->load->view('search');  
		}

	}

}

/* End of file search.php */
/* Location: ./application/controllers/search.php */
