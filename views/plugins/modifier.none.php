<?php 
/** 
 * Smarty plugin 
 * @package Smarty 
 * @subpackage plugins 
 */ 


/** 
 * Smarty none modifier plugin 
 * Purpose:  escapes a string, replacing the empty string with "<none>" (italicised)
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
    return "<i>&lt;none&gt;</i>";
  }
} 
