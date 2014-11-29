<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

$config["posts_add_image"] = 
	array(
		"upload_path" => "./assets/uploads/",
		"allowed_types" => "gif|jpg|png",
		"max_size" => "100010",
		"max_width" => "101024",
		"max_height" => "70618", 
		"encrypt_name" => TRUE,
		"overwrite" => FALSE 
	);

$config["resize_post_images"] = 
	array(
		"image_library" => "gd2",
		"maintain_ratio" => true,
		"width" => 120,
		"height" => 120  
	);


