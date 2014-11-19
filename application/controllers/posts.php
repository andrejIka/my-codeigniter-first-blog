<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Posts extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url','form')); 
		$this->load->library(array('form_validation','pagination','session')); 
		$this->load->model('posts_model');
		//Load Dependencies

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


		$this->load->view('posts', $data);
	} 

	public function delete_post(){
		$page_id = $this->uri->segment(2);
		$this->posts_model->delete_post();
		// $back_page = $this->session->userdata('current_page');
		// if($back_page>0){
		// 	redirect('posts/'.$back_page);  
		// }
		// else{
		$this->session->set_flashdata('message', "<div class='alert alert-info'> Your post has been deleted. <button type='button' class='close' data-dismiss='alert'> <span aria-hidden='true'>&times;</span> </button></div>");
			redirect('posts/');   
		// }
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
				$this->load->view('add_post', $data);   
			}
			else{  

				// Upload files
				$config['upload_path'] = './assets/uploads/';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size']	= '100';
				$config['max_width']  = '1024';
				$config['max_height']  = '768';
				$this->load->library('upload', $config);
				
				if ( ! $this->upload->do_upload())
				{
		        	$this->form_validation->set_rules('userfile', 'User file', 'required');
					// print_r( $data['upload_error'] =  ); 
					// $this->load->view('upload_form', $error);
					$data['file_errors'] = "<div class='alert alert-danger'>".$this->upload->display_errors()."</div>";
					// $this->form_validation->set_message('userfile', '$this->upload->display_errors()');
					// print_r($data = array('upload_data' => $this->upload->data())); 
				}
				else
				{
					// print_r($data = array('upload_data' => $this->upload->data())); 
					// $this->load->view('upload_success', $data);
				}
				// $this->load->view('add_post', $data);   
				$this->session->set_flashdata('message', "<div class='alert alert-info'> Your post has been added with success!<button type='button' class='close' data-dismiss='alert'> <span aria-hidden='true'>&times;</span> </button></div>");

				$this->posts_model->add_post(); 
				// $last_page = ceil($this->posts_model->record_count()/$last_page);
				// if($last_page>1){
				// 	redirect('posts/'.$last_page);  
				// }
				// else{
					redirect('posts/');   
				// }
			} 
        }
        else{
			$this->load->view('add_post', $data);  
        }
	}

	// Edit item
	public function edit_post(){


		$data['post'] = $this->posts_model->get_current_post();
		// print_r ($data['post'][0]);
		// print_r( $_REQUEST );
		// echo $this->input->post('id');
		// $back_page = $this->session->userdata('current_page');
				// echo "current page:".$this->session->userdata('current_page');

		if( $this->input->post('submit') )
        {

        	$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
        	$this->form_validation->set_rules('author', 'Author', 'trim|required|xss_clean');
        	$this->form_validation->set_rules('content', 'Content', 'trim|required|xss_clean');

			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
			$validated = $this->form_validation->run();

			if($validated === FALSE){

				$data['post'][0]['content'] = $this->input->post('content');
				$data['post'][0]['title'] = $this->input->post('title');
				$data['post'][0]['author'] = $this->input->post('author');



				$this->load->view('edit_post', $data);   
			}
			else{  
				$this->posts_model->update_post();
				// if($back_page>0){
					// redirect('posts/'.$back_page);  
				// }
				// else{
				$this->session->set_flashdata('message', "<div class='alert alert-success'> Your post has been saved with success!<button type='button' class='close' data-dismiss='alert'> <span aria-hidden='true'>&times;</span> </button></div>");
					redirect('posts/');   
				// }
			} 
        }
        else{
			$this->load->view('edit_post', $data);  
        }
	}
}
/* End of file posts.php */
/* Location: ./application/controllers/posts.php */