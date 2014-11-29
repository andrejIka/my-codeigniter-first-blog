<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Images_model extends CI_Model {

    public function __construct()
        {
            parent::__construct();
            //Do your magic here
            $this->load->database();
        }    


    public function count_all_images() {
        return $this->db->count_all("gallery_images");
    }

    public function get_all_images(){ 
        $query = $this->db->get('gallery_images');
        return $query->result(); 
    }

    public function get_all_exported_images(){ 
        $query = $this->db->get('gallery_images');
        return $query; 
    }

    public function get_current_image_info($image_id){ 

        $this->db->select('image_url , thumb_url');
        $this->db->where('id', $image_id);
        $query = $this->db->get('gallery_images');
        return $query->result();  

    }

    public function remove_all_images(){ 
        $query = $this->db->empty_table('gallery_images');  
    }

    public function delete_current_image($remove_id){  

        $query = $this->db->delete('gallery_images', array('id'=>$remove_id)); 
        return $query; 

    }


    public function add_image($thumb_src, $image_src){

        $data = array(
            'thumb_url'=>$thumb_src,  
            'image_url'=>$image_src  
        );

        $this->db->insert('gallery_images',$data); 
    }

}

/* End of file images.php */
/* Location: ./application/models/images.php */

/* End of file images.php */
/* Location: ./application/models/images.php */