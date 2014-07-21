<?php 
/** 
 * Smarty plugin 
 * @package Smarty 
 * @subpackage plugins 
 */ 


/** 
 * Smarty GET-parameter modifier plugin 
 * Purpose:  display different text for singular and plural
 * Type:     modifier<br> 
 * Name:     plural<br> 
 * @author   David Megginson
 * @param number, string, string
 * @return string 
 */ 
function smarty_modifier_params($params, $name, $value) { 
  $params[$name] = $value;
  $j = '?';
  foreach ($params as $n => $v) {
    $q .= sprintf('%s%s=%s', $j, urlencode($n), urlencode($v));
    $j = '&';
  }
  return $q;
} 
