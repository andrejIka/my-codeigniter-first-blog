<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Хелперы View
 * @author Alexander Makarov
 * @link http://rmcreative.ru/
 */

/** 
 * Позволяет включить подшаблон с определёнными параметрами
 * 
 * @param string $template
 * @param array $data
 * @return string
 */
function partial($template, $data = array()){
    $CI = &get_instance();
    return $CI->load->view($template, $data, true);
}