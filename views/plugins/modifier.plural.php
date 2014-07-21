<?php 
/** 
 * Smarty plugin 
 * @package Smarty 
 * @subpackage plugins 
 */ 


/** 
 * Smarty plural modifier plugin 
 * Purpose:  display different text for singular and plural
 * Type:     modifier<br> 
 * Name:     plural<br> 
 * @author   David Megginson
 * @param number, string, string
 * @return string 
 */ 
function smarty_modifier_plural($num, $string_s, $string_pl) { 
  if ($num == 1) {
    return $string_s;
  } else {
    return $string_pl;
  }
} 
