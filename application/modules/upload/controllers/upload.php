<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends MX_Controller {

	public function __construct()
	{
		parent::__construct();

		// if ( !$this->ion_auth->logged_in() ) 
		// { 
		// 	redirect('auth', 'refresh');
		// }

		//Load Dependencies 
		$this->load->model('upload/images_model');
		
	}

	public function index()
	{

		$data['all_images'] = $this->images_model->get_all_images( );
		// if($data['all_images']) echo "111";

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
				
				$this->ci_alerts->set('info', 'Your file: has been saved with success!');
				redirect('/upload/');
				 
			}
		}
		 $this->load->view('upload', $data);   

	 }

	 public function export_images(){

	 	$this->load->library('zip');
		$path =  $_SERVER['DOCUMENT_ROOT']."/ci/assets/uploads/";
		$this->zip->read_dir($path, FALSE); 
		$this->zip->download('all_images.zip');
 
	 }

	 public function export_images_list(){

		// ChromePhp::table($_REQUEST);

	 	// Load herlpers and libs
		// $this->load->helper('file');
		// $this->load->helper('download');
		$this->load->dbutil();

		// Making quesry from model
		$query = $this->images_model->get_all_exported_images( );

		// Generating CSV content
		$delimiter = ",";
		$newline = "\r\n";
		$result_csv_data = $this->dbutil->csv_from_result($query, $delimiter, $newline);

		// And download it to the user
		force_download('export_images.csv', $result_csv_data);

		// Define file params
		// $path =  $_SERVER['DOCUMENT_ROOT']."/ci/assets/export/"; 
		
		// Saving files on the hosting folder - not necessary
		// $csv_file = $path.'export_images.csv';
		// write_file($csv_file, $result_csv_data);


		// Set correct headers for the right download - not necessary
		// header('Content-Description: File Transfer');
		// header('Content-Type: application/csv');
		// header('Content-Disposition: attachment; filename=export_images.csv');
		// header('Expires: 0');  
		// header('Content-Type: application/force-download');
		// header('Cache-Control: must-revalidate, post-check=0, pre-check=0'); 
		// header('Cache-Control: must-revalidate');
		// header('Pragma: public');
		// header('Content-Length: ' . filesize($csv_file));
		// header('Content-Transfer-Encoding: binary');
		// header('Connection: close');
		// readfile($csv_file);    
		// exit();

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

		$this->ci_alerts->set('success', 'Your files was successfuly  removed !');
		redirect('/upload/');

	 }


	 public function delete_image(){

		if (!$this->input->is_ajax_request()) {
	 	
			$image_info_result = $this->images_model->get_current_image_info($this->uri->segment(3)) ; 
			$path =  $_SERVER['DOCUMENT_ROOT']."/ci/assets/uploads/";
			$file1 = $path.$image_info_result[0]->image_url;
			$file2 = $path.$image_info_result[0]->thumb_url;

			if (file_exists($file1)) {
				unlink($file1); 
			}
			if (file_exists($file2)) {  
				unlink($file2);
			}
			$this->images_model->delete_current_image($this->uri->segment(3));

			$this->ci_alerts->set('success', 'Your file has been removed with success!');
			redirect('/upload/');
	
		}
		else if ($this->input->is_ajax_request()) {

			$image_id = $this->input->post('id'); 
  
			if($this->images_model->delete_current_image($image_id)){
				
				$path =  $_SERVER['DOCUMENT_ROOT']."/ci/assets/uploads/";
				$image_info_result = $this->images_model->get_current_image_info($image_id) ; 
				$file1 = $path.$image_info_result[0]->image_url;
				$file2 = $path.$image_info_result[0]->thumb_url;

				if (file_exists($file1)) {
					unlink($path.$image_info_result[0]->image_url); 
				}
				if (file_exists($file2)) {  
					unlink($path.$image_info_result[0]->thumb_url);
				}
				// echo "success";
				// echo "true"; 

			} 
		
		}

	 	
		
	 }

	 public function show_images(){

	 	$this->load->library('parser');
		$data['all_images'] = $this->images_model->get_all_images( );
		$data['image_path'] = site_url("/assets/uploads/");
		$data['delete_path'] = site_url("/upload/delete_image/");
		// dbug($data);

	 	// $this->load->view('upload/show_images', $data, FALSE);
		$this->parser->parse('upload/show_images', $data);

	 }
	 

}


/* End of file upload.php */
/* Location: ./application/controllers/upload.php */