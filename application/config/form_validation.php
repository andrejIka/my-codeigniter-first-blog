<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| SMILEYS
| -------------------------------------------------------------------
| This file contains an array of smileys for use with the emoticon helper.
| Individual images can be used to replace multiple simileys.  For example:
| :-) and :) use the same image replacement.
|
| Please see user guide for more info:
| http://codeigniter.com/user_guide/helpers/smiley_helper.html
|
*/

$config = array
(   
    //this array key matches what you passed into run()
    'check_post_data' => array
    (

        array(
            'field' => 'title',
            'label' => 'Title',
            'rules' => 'trim|required|xss_clean'
        ),
        array(
            'field' => 'author',
            'label' => 'Author',
            'rules' => 'trim|required|xss_clean'
        ),
        array(
            'field' => 'content',
            'label' => 'Content',
            'rules' => 'trim|required|xss_clean'
        )

    ),
    'search_data_info' => array
    (

        array(
            'field' => 'search_info',
            'label' => 'Search info',
            'rules' => 'trim|required|xss_clean|min_length[3]'
        ) 
    )
    //you would add more run() routines here, for separate form submissions.
);