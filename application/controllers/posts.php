<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Posts extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('url','form', 'file')); 
		$this->load->library(array('form_validation','pagination','session', 'image_lib', 'ion_auth')); 
		$this->load->model('posts_model');
		//Load Dependencies

		if ( !$this->ion_auth->logged_in() ) 
		{ 
			redirect('auth', 'refresh');
		}
		 $this->load->helper('chrome_logger');
		 ChromePhp::warn($_REQUEST);
		 ChromePhp::warn($_ENV);
		 // ChromePhp::log($_FILES);

	}

	// List all your items
	public function index( $offset = 0 )
	{

		// Start pagination
		$config = array();
		$config["base_url"] = base_url() . "posts/";
		$config["total_rows"] = $this->posts_model->record_count();
		$config["per_page"] = 2;
		$config["uri_segment"] = 2;
		/* This Application Must Be Used With BootStrap 3 *  */
		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] ="</ul>";
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";
		$this->pagination->initialize($config);


		$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
		

		// $this->session->set_userdata('current_page', $page);
		// $this->session->set_userdata('max_pages', $config["total_rows"]/$config["per_page"]);
		// echo "max pages:".$this->session->userdata('max_pages');
		

		$data['posts'] = $this->posts_model->get_posts($config["per_page"], $page);
		

		$data["links"] = $this->pagination->create_links();


		 ChromePhp::log($data);
		$this->load->view('posts', $data);
	} 

	public function delete_post(){

		$image_info_result = $this->posts_model->get_current_image_info($this->uri->segment(2)) ;
		$path = "Z:/home/localhost/www/ci/assets/uploads/";
		unlink($path.$image_info_result[0]->image_path); 
		$this->posts_model->delete_post();  

		$this->session->set_flashdata('message', "<div class='alert alert-info'> Your post has been deleted. <button type='button' class='close' data-dismiss='alert'> <span aria-hidden='true'>&times;</span> </button></div>");
			redirect('posts/');   

	}

	public function add_post(){
		$data['post'][0]['content'] = $this->input->post('content');
		$data['post'][0]['title'] = $this->input->post('title');
		$data['post'][0]['author'] = $this->input->post('author');
		$data['file_errors'] = '';
		// $last_page = $this->session->userdata('max_pages');
		// print_r($_FILES);  

		if( $this->input->post('submit') )
        {

        	$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
        	$this->form_validation->set_rules('author', 'Author', 'trim|required|xss_clean');
        	$this->form_validation->set_rules('content', 'Content', 'trim|required|xss_clean');
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
			$validated = $this->form_validation->run();

			if($validated === FALSE){ 
				$data['file_errors'] = "<div class='alert alert-danger'>Please fill in the form in a right order and then attach the file</div>";
				$this->load->view('add_post', $data);   
			} 
			else{  

				$config['upload_path'] = './assets/uploads/';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size']  = '100010';
				$config['max_width']  = '101024';
				$config['encrypt_name'] = TRUE;
				$config['max_height']  = '70618';
				$data['file_errors'] = '';
				$this->load->library('upload', $config);


				if ( ! $this->upload->do_upload()){
					$data['file_errors'] = "<div class='alert alert-danger'>".$this->upload->display_errors()."</div>";
					$this->load->view('add_post', $data);   
				}
				else{
					$data['upload_data'] =  $this->upload->data() ;
					$image_src = $data['upload_data']['file_name'];

					$config['image_library'] = 'gd2';
					$config['source_image'] = './assets/uploads/'.$image_src; 
					$config['maintain_ratio'] = FALSE;
					$config['width']     = 120;
					$config['height']   = 120;

					$this->image_lib->clear();
					$this->image_lib->initialize($config);
					$this->image_lib->resize();


					// $data['file_errors'] = "<div class='alert alert-success'>Your file has been added with success</div>";
					$this->posts_model->add_post($image_src); 
					$this->session->set_flashdata('message', "<div class='alert alert-info'> Your post has been added with success!<button type='button' class='close' data-dismiss='alert'> <span aria-hidden='true'>&times;</span> </button></div>");
					// $this->load->view('add_post', $data);   
					redirect('posts/');    
				}
			} 
        }
        else{
			$this->load->view('add_post', $data);  
        }
	}

	// Edit item
	public function edit_post(){


		$data['post'] = $this->posts_model->get_current_post();
		
		// If we submit the form
		if( $this->input->post('submit') )
        {

        	$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
        	$this->form_validation->set_rules('author', 'Author', 'trim|required|xss_clean');
        	$this->form_validation->set_rules('content', 'Content', 'trim|required|xss_clean');

			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
			$validated = $this->form_validation->run();
 			
 			// If some file exists
			if(  $_FILES['userfile']['name'] !='' ){

				$config['upload_path'] = './assets/uploads/';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size']  = '100010';
				$config['max_width']  = '101024';
				$config['overwrite'] = TRUE;
				$config['file_name'] = $data['post'][0]['image_path']; 
				$config['max_height']  = '70618';
				$data['file_errors'] = '';
				$this->load->library('upload', $config);

				// If upload is success
				if ($this->upload->do_upload()){
					$data['file_errors'] = "<div class='alert alert-danger'>".$this->upload->display_errors()."</div>";
					$config['image_library'] = 'gd2';
					$config['source_image'] = './assets/uploads/'.$config['file_name']; 
					$config['maintain_ratio'] = FALSE;
					$config['width']     = 120;
					$config['height']   = 120;
					$this->image_lib->clear();
					$this->image_lib->initialize($config);
					$this->image_lib->resize();
					if($validated === TRUE){
						$this->session->set_flashdata('message', "<div class='alert alert-success'> Your post has been saved with success!<button type='button' class='close' data-dismiss='alert'> <span aria-hidden='true'>&times;</span> </button></div>");
						redirect('/posts/');      
					}
					else{
						redirect('/edit_post/'.$this->uri->segment(2));     
					}
				} 			

			}

			// If validation not success
			if($validated === FALSE){
				// Store the values
				$data['post'][0]['content'] = $this->input->post('content');
				$data['post'][0]['title'] = $this->input->post('title');
				$data['post'][0]['author'] = $this->input->post('author');
				// Loading view with the new calues
				$this->load->view('edit_post', $data);   
			}
			else{  
				// If all from the form are succeed updating the post
				$this->posts_model->update_post(); 
				$this->session->set_flashdata('message', "<div class='alert alert-success'> Your post has been saved with success!<button type='button' class='close' data-dismiss='alert'> <span aria-hidden='true'>&times;</span> </button></div>");
				redirect('posts/');   

			} 
        }
        // If not form submits just load the view file by default
        else{
			$this->load->view('edit_post', $data);  
        }
	}
}
/* End of file posts.php */
/* Location: ./application/controllers/posts.php */