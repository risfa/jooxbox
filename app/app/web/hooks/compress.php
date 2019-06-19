<?php
/**
 * Created by PhpStorm.
 * User: arahman
 * Date: 2/9/17
 * Time: 3:01 PM
 */
function compress()
{
    $CI =& get_instance();
    $buffer = $CI->output->get_output();

    $search = array(
        '/\n/',            // replace end of line by a space
        '/\>[^\S ]+/s',        // strip whitespaces after tags, except space
        '/[^\S ]+\</s',        // strip whitespaces before tags, except space
    );

    $replace = array(
        ' ',
        '>',
        '<',
    );

    $buffer = preg_replace($search, $replace, $buffer);

    $CI->output->set_output($buffer);
    $CI->output->_display();
}