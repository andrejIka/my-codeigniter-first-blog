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

		$data['all_images'] = $this->images_model->get_all_images( );

		if( $this->input->post('submit') ){


			$config['upload_path'] = './assets/uploads/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']  = '10000';
			$config['encrypt_name'] = TRUE; 
			$config['max_width']  = '10024';
			$config['max_height']  = '7068';
			$data['file_errors'] = '';
			$this->load->library('upload', $config);

	 

			if ( ! $this->upload->do_upload()){
				$data['file_errors'] = "<div class='alert alert-danger'>".$this->upload->display_errors()."</div>";
			}
			else{
				$data['upload_data'] =  $this->upload->data() ;
				$image_src = $data['upload_data']['file_name'];
				
				$thumbnail = $data['upload_data']['raw_name'].'_thumb'.$data['upload_data']['file_ext'];
				// start image manipulation
				$config['image_library'] = 'gd2';
				$config['source_image'] = './assets/uploads/'.$image_src; 
				$config['maintain_ratio'] = FALSE;
				$config['create_thumb'] = TRUE;
				$config['width']     = 120;
				$config['height']   = 120;

				$this->image_lib->clear();
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				
	            $this->images_model->add_image($thumbnail,$image_src); 
				
				$this->session->set_flashdata('message', "<div class='alert alert-success'> Your file: has been saved with success!</div>");
				redirect('/upload/');
				 
			}
		}
		 $this->load->view('upload', $data);   

	 }

	 public function export(){

		$file_name = "./assets/uploads/7a1e793bc626fc435dc575432dff37e4.jpg";
		$mime = 'application/force-download';
		header('Pragma: public');    
		header('Expires: 0');        
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: private',false);
		header('Content-Type: '.$mime);
		header('Content-Disposition: attachment; filename="'.basename($file_name).'"');
		header('Content-Transfer-Encoding: binary');
		header('Connection: close');
		readfile($file_name);    
		exit();

	 }

	 public function remove_all_images(){


		$data['all_images'] = $this->images_model->get_all_images( ); 
		$path =  $_SERVER['DOCUMENT_ROOT']."/ci/assets/uploads/";

		foreach ($data['all_images'] as $image): 
			$current_file =  $path.$image->image_url;
			if (file_exists($current_file)) {

				unlink($current_file); 
			}  
			$current_file =  $path.$image->thumb_url;
			if (file_exists($current_file)) {
				unlink($current_file); 

			}  

		endforeach; 
		$this->images_model->remove_all_images( ); 

		$this->session->set_flashdata('message', "<div class='alert alert-success'> Your files was successfuly  removed !</div>");
		redirect('/upload/');

	 }


	 public function delete_image(){
	 	
		$image_info_result = $this->images_model->get_current_image_info($this->uri->segment(3)) ; 
		$path =  $_SERVER['DOCUMENT_ROOT']."/ci/assets/uploads/";
		$file1 = $path.$image_info_result[0]->image_url;
		$file2 = $path.$image_info_result[0]->thumb_url;

		if (file_exists($file1)) {
			unlink($path.$image_info_result[0]->image_url); 
		}
		if (file_exists($file2)) {  
			unlink($path.$image_info_result[0]->thumb_url);
		}
		$this->images_model->delete_current_image();

		$this->session->set_flashdata('message', "<div class='alert alert-info'> Your file has been removed with success!</div>");
		redirect('/upload/');
		
	 }
	 

}


/* End of file upload.php */
/* Location: ./application/controllers/upload.php */