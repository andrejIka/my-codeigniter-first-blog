<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
 class Tasks_model extends CI_Model {
 
 
     public function __construct()
     {
         parent::__construct();
         //Load Dependencies
        $this->load->database();
     }

     public function get_tasks_for_month($month = 1){

        return $this->db->get('tasks_list')->result();
     }


     public function add_event(){

        $data = array(
          'title'=>$this->input->post('title'),
          'body'=>$this->input->post('body'),
          'due'=>$this->input->post('date') 
        );
        $this->db->insert('tasks_list',$data);   

     }
 
    public function remove_task_info($remove_id){

        $query = $this->db->delete('tasks_list', array('due'=>$remove_id)); 
        return $query;
        
    }



    public function update_current_event_info(){
        $data = array(
              'title'=>$this->input->post('title'),
              'body'=>$this->input->post('body'),
              // 'completed'=>$due,
              'due'=>$this->input->post('due')
            );
        $this->db->where('id',$this->input->post('id'));
        $this->db->update('tasks_list',$data);  
    } 

    public function update_current_event_state($id, $value){
        // $data = array(
        //       'completed'=>$value
        //     );
        // $this->db->where('id',$id);
        // $this->db->update('tasks_list',$data);  

        return $this->db
               ->where('id', $id)
               ->update("tasks_list", array('completed' => $value));

    } 


     public function get_event_info($edit_id){
        $query = $this->db->get_where('tasks_list', array('due'=>$edit_id));
        return $query->result(); 
     }


 }
 
 
 /* End of file tasks_model.php */
 /* Location: ./application/models/tasks_model.php */ ?>