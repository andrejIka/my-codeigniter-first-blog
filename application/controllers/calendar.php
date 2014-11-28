<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
 class Calendar extends CI_Controller {
 
 	public function __construct()
 	{
 		parent::__construct();

		$this->load->database();
		$this->load->helper(array('url','form', 'file')); 
		$this->load->library(array('form_validation','pagination','session', 'image_lib', 'ion_auth')); 
		$this->load->model('tasks_model');
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
 		$next_prev_url = site_url('calendar');
		$prefs = array (
               'show_next_prev'  => TRUE,
               'next_prev_url'   => $next_prev_url,
                'template' => '
				   {table_open}<table class="table table-bordered table-striped table-hovered">{/table_open}

				   {heading_row_start}<tr>{/heading_row_start}

				   {heading_previous_cell}<th><a class="btn btn-info" href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
				   {heading_title_cell}<th colspan="{colspan}">{heading}</th>{/heading_title_cell}
				   {heading_next_cell}<th class="text-right"><a class="btn btn-info" href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}

				   {heading_row_end}</tr>{/heading_row_end}

				   {week_row_start}<tr>{/week_row_start}
				   {week_day_cell}<td width="14%">{week_day}</td>{/week_day_cell}
				   {week_row_end}</tr>{/week_row_end}

				   {cal_row_start}<tr>{/cal_row_start}
				   {cal_cell_start}<td>{/cal_cell_start}

				   {cal_cell_content}{day}{content}{/cal_cell_content}
				   {cal_cell_content_today}<b>{day}</b>{content}{/cal_cell_content_today}

				   {cal_cell_no_content}{day}{/cal_cell_no_content}
				   {cal_cell_no_content_today}<div class="highlight">{day}</div>{/cal_cell_no_content_today}

				   {cal_cell_blank}&nbsp;{/cal_cell_blank}

				   {cal_cell_end}</td>{/cal_cell_end}
				   {cal_row_end}</tr>{/cal_row_end}

				   {table_close}</table>{/table_close}
				',
				// 'start_day' => 'sunday',
				'month_type' => 'long', 
				'day_type' => 'long' 
             );

		$this->load->library('calendar', $prefs);

		$year_start = $this->uri->segment(2)!='' ? $this->uri->segment(2) : '2014'; 
		$month_start = $this->uri->segment(3)!='' ? $this->uri->segment(3) : '11'; 

		$events_data = $this->tasks_model->get_tasks_for_month();
 
		$event = array();

		foreach ($events_data as $key) {

			// print_r( $key->title );
			$events_data = date_parse($key->due);
			if($key->completed==1){
				$event_state ='<span class="label label-success">Completed</span>'; 
			}
			else{
				$event_state ='<span class="label label-default">Didn\'t done</span>';  
			}


 			$day = $events_data['day'];
			if($month_start==$events_data['month']){
				$id_info = $events_data['year'].'-'.$events_data['month'].'-'.$events_data['day'];
				$event[$day] = '<p class="alert alert-success"> <b> '.$key->title.' </b> <br> <em> '.$key->body.' </em> <a href="'.site_url("calendar/edit/".$id_info).'"  class="edit-button"><span class="glyphicon glyphicon-edit"></span> </a><a href="'.site_url("calendar/remove/".$id_info).'" data-date="'.$id_info.'"  class="close-button"><span class="glyphicon glyphicon-remove"></span> </a> <br> '.$event_state.' </p>'; 

			}
		}



 		$data['calendar'] = $this->calendar->generate($year_start, $month_start, $event);


		if( $this->input->post('submit') )
        {

        	$this->form_validation->set_rules('date', 'Date', 'trim|required|xss_clean');
        	$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
        	$this->form_validation->set_rules('body', 'Body', 'trim|required|xss_clean');
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
			$validated = $this->form_validation->run();

			if($validated === FALSE){ 
				$this->load->view('calendar', $data, FALSE); 
			} 
			else{   
				$this->tasks_model->add_event();
				// $this->session->set_flashdata('message', "<div class='alert alert-info'> Your event info has been added with success!<button type='button' class='close' data-dismiss='alert'> <span aria-hidden='true'>&times;</span> </button></div>"); 
				// redirect('calendar/');
			}

		}
		else{
	 		$this->load->view('calendar', $data, FALSE); 
		}				 


 	}

 	public function remove(){

		if (!$this->input->is_ajax_request()) {
	 	
	 		$remove_id = $this->uri->segment(3);
	 		$this->tasks_model->remove_task_info($remove_id);
			$this->session->set_flashdata('message', "<div class='alert alert-success'> Your event info has deleted with success!<button type='button' class='close' data-dismiss='alert'> <span aria-hidden='true'>&times;</span> </button></div>"); 
	 		redirect("calendar/");
	
		}
		else if ($this->input->is_ajax_request()) {

			$remove_id = $this->input->post('id');
			if($this->tasks_model->remove_task_info($remove_id)){
				echo "true";
			}
		
		}

 	}

 	public function edit(){
 		$edit_id = $this->uri->segment(3);
 		$data = array();

 		$data['id']="";

		if( $this->input->post('submit') )
        {

        	$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
        	$this->form_validation->set_rules('body', 'Body', 'trim|required|xss_clean');
        	$this->form_validation->set_rules('due', 'Due', 'trim|required|xss_clean');
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
			$validated = $this->form_validation->run();

			$data['title'] = $this->input->post('title');
			$data['body'] = $this->input->post('body');
			$data['due'] = $this->input->post('due');
			$data['id'] = $this->input->post('id'); 

			if($validated === FALSE){ 
		 		$this->load->view('calendar_edit', $data, FALSE); 
			} 
			else{   
				// echo $id = $this->input->post('id');
				// echo "<pre>";
				// print_r($data);
				// echo "</pre>";
				$this->tasks_model->update_current_event_info();
		 		// $this->load->view('calendar_edit', $data, FALSE); 
				$this->session->set_flashdata('message', "<div class='alert alert-info'> Your event info has been updated with success!<button type='button' class='close' data-dismiss='alert'> <span aria-hidden='true'>&times;</span> </button></div>"); 
				redirect('calendar/');
			}
		}
		else{
			$current_event_info = $this->tasks_model->get_event_info($edit_id);
			$data['title'] = $current_event_info[0]->title;
			$data['body'] = $current_event_info[0]->body;
			$data['due'] = $current_event_info[0]->due;
			$data['id'] = $current_event_info[0]->id;

	 		$this->load->view('calendar_edit', $data, FALSE); 
		}				 
	 		// $this->load->view('calendar', $data, FALSE); 

		// dbug($_REQUEST); 


 	}



 }
 
 
 
 /* End of file calendar.php */
 /* Location: ./application/controllers/calendar.php */ ?>