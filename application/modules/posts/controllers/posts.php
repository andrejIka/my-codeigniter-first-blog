<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Posts extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		
		
		// if ( !$this->ion_auth->logged_in() ) 
		// { 
		// 	redirect('auth', 'refresh');
		// }

		//Load Dependencies
		$this->load->model('posts/posts_model');
		 
		 // dbug($_REQUEST);
		 // ChromePhp::table($_REQUEST);
		 // ChromePhp::table($_SESSION);
		 // ChromePhp::warn($_ENV);
		 // ChromePhp::log($_FILES);

	}

	// List all your items
	public function index( $offset = 0 )
	{

		// dbug($this);

		// Start pagination
		$config = array();
		$config["base_url"] = base_url() . "posts/";
		$config["total_rows"] = $this->posts_model->record_count();
		$config["per_page"] = 4;
		$config["uri_segment"] = 2;
		/* This Application Must Be Used With BootStrap 3 *  */
		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] ="</ul>";
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a>";
		$config['cur_tag_close'] = "</a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";
		// $config['use_page_numbers'] = TRUE;
		// $config['page_query_string'] = TRUE;
		$config['num_links'] = 4;
		$this->pagination->initialize($config);

		$offset = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0; 

		$data['posts'] = $this->posts_model->get_posts($config["per_page"], $offset);

		$data["links"] = $this->pagination->create_links();

		$this->load->view('posts', $data);
		
	} 

	public function delete_post(){

		// Check post ID
		$post_id = $this->uri->segment(3);
		// Fetch the info about the current image
		$image_to_delete = $this->posts_model->get_current_image_info($post_id) ;
		// If the image exists, then the post data exists too
		// So we are making the actions
		if(is_array($image_to_delete)){
			// Making upload file path
			$file_path =  $this->config->item('upload_images_path');
			// Making image file source 
			$image_file = $file_path.$image_to_delete[0]->image_path;
			// If this image file exists
			if (file_exists($image_file)) {
				// Removing the file
				unlink($image_file); 
			} 
			// And deleting the post
			$this->posts_model->delete_post($post_id); 
			// Making success message
			$this->ci_alerts->set('success', 'Your post has been deleted with success.');
			// And redirect to posts
			redirect('posts/');   		 
		}
		// If no data about the image, so no data about the post too
		else{
			// Redirect to the default page with the warning - do not delete non-existent post
			$this->ci_alerts->set('warning', 'Sorry, this post doesn\'t exist');
			redirect('posts/');    
		}

	}

	public function add_post(){

		// Storing the data from the inputs
		$data['post'][0]['content'] = $this->input->post('content');
		$data['post'][0]['title'] = $this->input->post('title');
		$data['post'][0]['author'] = $this->input->post('author');
		$data['file_errors'] = ''; 
		
		// Making return page
		$return_page = '';
		if ( $this->posts_model->record_count() % 4 === 0 ){
			$return_page = $this->posts_model->record_count();
		}

		// If we submit the form
		if( $this->input->post('submit') )
        {

			// dbug($_REQUEST);
			// dbug($_FILES);
        	
 			// If it's form not valid
			if(!$this->form_validation->run('check_post_data')){ 
				// ?Notify the user with the error
				$data['file_errors'] = "<div class='alert alert-danger'>Please fill in the form in a right order and then attach the file</div>";
				// ChromePhp::table($data);
				$this->load->view('add_post', $data);   
			} 
			// If all is valid
			else{  
				// // Load config array
				$upload_config = $this->config->load("uploads", TRUE);
				// Init by config array
				$this->load->library('upload', $upload_config['posts_add_image']); 
				// dbug($upload_config);
				// dbug($config);

				// If upload is not success
				if ( ! $this->upload->do_upload()){
					// Back to this page with type of error
					$data['file_errors'] = "<div class='alert alert-danger'>".$this->upload->display_errors()."</div>";
					// Load the view
					$this->load->view('add_post', $data);   
				}
				// If upload is  completely succeed
				else{

					$data['upload_data'] =  $this->upload->data() ;
					$uploaded_image = $data['upload_data']['file_name'];
					// dbug($this->upload->data());

					// Adding file to resize
					$upload_config['resize_post_images']['source_image'] = $_SERVER['DOCUMENT_ROOT'].'/ci/assets/uploads/'.$uploaded_image;
 
					// Handing the image
					$this->image_lib->clear();
					// Init the upload library with config array
					$this->image_lib->initialize($upload_config['resize_post_images']);
					$this->image_lib->resize(); 
					// Add post with the uploaded image
					$this->posts_model->add_post($uploaded_image);  
					// $this->ci_alerts->set('info', 'Your post has been added with success!');

					// // Come back to the selected page
					if($return_page>1)
						redirect('posts/'.$return_page);
					else    
						redirect('posts/');
				}
			} 
        }
        else{
			// ChromePhp::table($data);
			$this->load->view('add_post', $data);  
        }
	}

	// Edit item
	public function edit_post(){

		$post_id = $this->uri->segment(3);
		$data['post'] = $this->posts_model->get_current_post($post_id);
		$data['file_errors'] = '';
		
		// If we submit the form
		if( $this->input->post('submit') )
        {
 			// If upload file  exists and not empty
			if(  $_FILES['userfile']['name'] !='' ){		

				// Load  upload file config array
				$upload_config = $this->config->load("uploads", TRUE);
				// Adding filename to the array
				$upload_config['posts_images_configuration']['file_name'] = $data['post'][0]['image_path']; 
				// Init the upload library with config array
				$this->load->library('upload', $upload_config['posts_images_configuration']);
				// If upload is success
				if ($this->upload->do_upload()){

					// Adding file to resize
					$upload_config['resize_post_images']['source_image'] = './assets/uploads/'.$upload_config['posts_images_configuration']['file_name'];  
 
					// Making file upload errors
					$data['file_errors'] = "<div class='alert alert-danger'>".$this->upload->display_errors()."</div>";
					
					// Handing the image
					$this->image_lib->clear();
					// Init the upload library with config array
					$this->image_lib->initialize($upload_config['resize_post_images']);
					$this->image_lib->resize(); 

					// If another form goes well
					if($this->form_validation->run('check_post_data')){  
						// Making message
						$this->ci_alerts->set('info', 'Your post has been saved with success!');
						// Come back to posts
						redirect('/posts/');      
					}
					else{
						// If not valida, coming back to the this current post
						redirect('/posts/edit_post/'.$post_id);     
					}
				} 			

			}

			// If validation not success
			if(!$this->form_validation->run('check_post_data')){
				// Store the values
				$data['post'][0]['content'] = $this->input->post('content');
				$data['post'][0]['title'] = $this->input->post('title');
				$data['post'][0]['author'] = $this->input->post('author');
				// Loading view with the new calues
				$this->load->view('edit_post', $data);   
			}
			// If all is valid
			else{  
				// If all from the form are succeed updating the post
				$this->posts_model->update_post(); 
				// Making message
				$this->ci_alerts->set('info', 'Your post has been saved with success!');
				// Coming back to the posts
				redirect('posts/');   
			} 
        }
        // If not form submits just load the view file by default
        else{
			$this->load->view('edit_post', $data);  
        }
	}

	public function export_posts(){

		$this->load->dbutil();
		// Making array from model
		$query = $this->posts_model->get_all_exported_posts( ); 
		// Generating CSV content
		$delimiter = ",";
		$newline = "\r\n";
		$result_csv_data = $this->dbutil->csv_from_result($query, $delimiter, $newline); 
		// And download it to the user
		force_download('exported_posts.csv', $result_csv_data);

	}


	public function search(){

		$data =array();
		// If we press search button
		if( $this->input->post('submit') )
        {

			$data['result'] = '';
			// Checking if the data entered to the post is valid
			if($this->form_validation->run('search_data_info')){ 
				// Looking this data inside the database
				$data['search_results'] = $this->posts_model->get_searched_posts($this->input->post('search_info')); 
				// If the data is valid
				if($data['search_results'])
					// Making the success notification to pass it to the view 
					$data['result'] = "Here are the search result below";
				else
					// or If no data to display  
					$data['result'] = "Sorry, no posts found on your search!";
				// Loading default view with notifications
				$this->load->view('search', $data, FALSE); 
			}
			else{
				// if the form isn't valid, loading default view without data
				$this->load->view('search');   
			}
		}
		else{
			// If no submit button presset just displaying the default view
			$this->load->view('search');  
		} 

	}
	
	
}
/* End of file posts.php */
/* Location: ./application/controllers/posts.php */