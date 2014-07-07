<?php /* Smarty version Smarty-3.0.7, created on 2014-07-07 09:48:40
         compiled from "/home/david/Source/BlueMonster/config/../views/templates/user-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:140477445153baa53866d2f5-06518764%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '491d6705627da0dffa43d8ef1b2e74779b0fe75d' => 
    array (
      0 => '/home/david/Source/BlueMonster/config/../views/templates/user-list.tpl',
      1 => 1404740919,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '140477445153baa53866d2f5-06518764',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/home/david/Source/BlueMonster/lib/smarty/plugins/modifier.escape.php';
?><!DOCTYPE html>

<html>
  <head>
    <title>Users</title>
    <link rel="stylesheet" href="/style/default.css" />
  </head>
  <body>
    <nav class="breadcrumbs">
      <li><a href="/">Home</a></li>
    </nav>

    <main>
      <h1>Users</h1>

      <table>
        <thead>
          <th>User</th>
          <th>Full name</th>
          <th>Uploads</th>
        </thead>
        <tbody>
          <?php  $_smarty_tpl->tpl_vars['user'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('users')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['user']->key => $_smarty_tpl->tpl_vars['user']->value){
?>
          <tr>
            <td><a href="/user/<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('user')->value->ident,'url');?>
"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('user')->value->ident);?>
</a></td>
            <td><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('user')->value->name);?>
</td>
            <td><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('user')->value->import_count);?>
</td>
          </tr>
          <?php }} ?>      
        </tbody>
      </table>
    </main>
  </body>
</html>