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
function smarty_modifier_params() { 
  $args = func_get_args();
  $params = array_shift($args);
  while ($args) {
    $name = array_shift($args);
    $value = array_shift($args);
    $params[$name] = $value;
  }
  $j = '?';
  foreach ($params as $n => $v) {
    if ($v !== null) {
      $q .= sprintf('%s%s=%s', $j, urlencode($n), urlencode($v));
      $j = '&';
    }
  }
  return $q;
} 
