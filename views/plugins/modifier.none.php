<?php 
/** 
 * Smarty plugin 
 * @package Smarty 
 * @subpackage plugins 
 */ 


/** 
 * Smarty none modifier plugin 
 * Purpose:  escapes a string, replacing the empty string with "<none>"
 * Type:     modifier<br> 
 * Name:     none<br> 
 * @author   David Megginson
 * @param string 
 * @return string 
 */ 
function smarty_modifier_none($s) 
{ 
  if ($s) {
    return htmlspecialchars($s);
  } else {
    return "&lt;none&gt;";
  }
} 
