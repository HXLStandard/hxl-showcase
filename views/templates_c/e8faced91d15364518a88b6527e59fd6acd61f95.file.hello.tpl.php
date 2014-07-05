<?php /* Smarty version Smarty-3.0.7, created on 2014-07-05 11:48:26
         compiled from "/home/david/Source/BlueMonster/config/../views/templates/hello.tpl" */ ?>
<?php /*%%SmartyHeaderCode:112198797853b81e4ae58053-26602149%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e8faced91d15364518a88b6527e59fd6acd61f95' => 
    array (
      0 => '/home/david/Source/BlueMonster/config/../views/templates/hello.tpl',
      1 => 1404574343,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '112198797853b81e4ae58053-26602149',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/home/david/Source/BlueMonster/lib/smarty/plugins/modifier.escape.php';
?><!DOCTYPE html>

<html>
  <head>
    <title>Template application</title>
  </head>
  <body>
    <h1><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('message')->value);?>
</h1>
  </body>
</html>
