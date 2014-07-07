<?php /* Smarty version Smarty-3.0.7, created on 2014-07-06 20:21:44
         compiled from "/home/david/Source/BlueMonster/config/../views/templates/code-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:52906416453b9e818bbf981-39359972%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'aeac65cd84f20488b5850688fa22d725e6ba3718' => 
    array (
      0 => '/home/david/Source/BlueMonster/config/../views/templates/code-list.tpl',
      1 => 1404692503,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '52906416453b9e818bbf981-39359972',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/home/david/Source/BlueMonster/lib/smarty/plugins/modifier.escape.php';
?><!DOCTYPE html>

<html>
  <head>
    <title>HXL codes</title>
    <link rel="stylesheet" href="/style/default.css" />
  </head>
  <body>
    <nav class="breadcrumbs">
      <li><a href="/">Home</a></li>
    </nav>

    <main>
      <h1>HXL codes</h1>

      <table>
        <thead>
          <tr>
            <th>HXL code</th>
            <th>Description</th>
          </tr>
        </thead>
        <tbody>
          <?php  $_smarty_tpl->tpl_vars['code'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('codes')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['code']->key => $_smarty_tpl->tpl_vars['code']->value){
?>
          <tr>
            <td><a href="/code/<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('code')->value->code,'url');?>
"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('code')->value->code);?>
</a></td>
            <td><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('code')->value->name);?>
</td>
          </tr>
        <?php }} ?>
        </tbody>
      </table>
    </main>
  </body>
</html>