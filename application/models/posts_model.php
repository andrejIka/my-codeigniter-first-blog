<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Posts_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        //Do your magic here 
    }


    public function record_count() {
        return $this->db->count_all("blog_posts");
    }

    public function get_posts($limit, $start){
        $this->db->limit($limit, $start);
        $query = $this->db->get('blog_posts');
        return $query->result(); 
    }

    public function get_current_image_info($image_id){ 

        $this->db->select('image_path');
        $this->db->where('id', $image_id);
        $query = $this->db->get('blog_posts');
        return $query->result();  

    }
 


    public function delete_post(){

        $query = $this->db->delete('blog_posts', array('id'=>$this->uri->segment(2)));
    }

    public function get_current_post(){ 
        $query = $this->db->get_where('blog_posts', array('id'=>$this->uri->segment(2)));
        return $query->result_array();
    } 
        
    public function update_post(){
        $data = array(
              'title'=>$this->input->post('title'),
              'author'=>$this->input->post('author'),
              'content'=>$this->input->post('content') 
            );
        $this->db->where('id',$this->input->post('id'));
        $this->db->update('blog_posts',$data);  
    } 
  
    public function add_post($image_url){
 
        $data = array(
              'title'=>$this->input->post('title'),
              'author'=>$this->input->post('author'),
              'content'=>$this->input->post('content'), 
              'image_path'=>$image_url 
            );
        $this->db->insert('blog_posts',$data);  

    } 
  
    

}

/* End of file posts_model.php */
/* Location: ./application/models/posts_model.php */

/* End of file posts_model.php */
/* Location: ./application/models/posts_model.php */