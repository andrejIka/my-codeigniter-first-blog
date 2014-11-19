<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->helper(array('url','form', 'file')); 
		$this->load->library(array('form_validation','pagination','session','image_lib')); 

		$this->load->model('images_model');
		
	}

	public function index()
	{

		if($this->input->post('empty_folder')=='yes'){
			if( delete_files('./assets/uploads/') ){
				$this->images_model->remove_all_images( ); 
				$this->session->set_flashdata('message', "<div class='alert alert-success'>  Your had cleared images directory with success!</div>");
				// redirect('/upload/');
			} 
		}

				// echo $this->session->flashdata('message');
		$data['all_images'] = $this->images_model->get_all_images( );
		// echo "<pre>";
			// print_r($data['all_images']);
		// echo "</pre>";

		// print_r($data['all_images']);

		if( $this->input->post('submit') ){


			$config['upload_path'] = './assets/uploads/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']  = '10000';
			$config['max_width']  = '10024';
			$config['max_height']  = '7068';
			$data['file_errors'] = '';
			$this->load->library('upload', $config);

	 

			if ( ! $this->upload->do_upload()){
				// $data['all_images'] = $this->images_model->get_all_images( );
				$data['file_errors'] = "<div class='alert alert-danger'>".$this->upload->display_errors()."</div>";
			}
			else{
				// $data['file_errors'] = '';
				$data['upload_data'] =  $this->upload->data() ;
				$image_src = $data['upload_data']['file_name'];
				
				// print_r($data['upload_data']);
				$thumbnail = $data['upload_data']['raw_name'].'_thumb'.$data['upload_data']['file_ext'];
				// start image manipulation
				 // $image_manipulation = $data['upload_data']['file_path'].$image_src;
				

				$config['image_library'] = 'gd2';
				$config['source_image'] = './assets/uploads/'.$image_src; 
				$config['maintain_ratio'] = FALSE;
				$config['create_thumb'] = TRUE;
				$config['width']     = 120;
				$config['height']   = 120;

				$this->image_lib->clear();
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				

				// echo $this->image_lib->display_errors();

	            $this->images_model->add_image($thumbnail,$image_src); 
				// $data['file_errors'] = "<div class='alert alert-success'> Your file: has been saved with success!</div>";
				// print_r($data);
				$this->session->set_flashdata('message', "<div class='alert alert-success'> Your file: has been saved with success!</div>");
				redirect('/upload/');
				 
			}
		}
		 $this->load->view('upload', $data);   

	 }

	 public function delete_image(){
	 	// echo "111";
	 	// $this->load->helper("file");
		// unlink($path);

		$image_info_result = $this->images_model->get_current_image_info($this->uri->segment(3)) ;
		$path = "Z:/home/localhost/www/ci/assets/uploads/";
		unlink($path.$image_info_result[0]->image_url);
		unlink($path.$image_info_result[0]->thumb_url);
		$this->images_model->delete_current_image();
		$this->session->set_flashdata('message', "<div class='alert alert-info'> Your file has been removed with success!</div>");
		redirect('/upload/');
		
	 }
	 

}

/* End of file upload.php */
/* Location: ./application/controllers/upload.php */

/* End of file upload.php */
/* Location: ./application/controllers/upload.php */