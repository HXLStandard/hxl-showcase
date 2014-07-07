<?php /* Smarty version Smarty-3.0.7, created on 2014-07-06 21:44:28
         compiled from "/home/david/Source/BlueMonster/config/../views/templates/source-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:52600302653b9fb7c1d73e8-54214469%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fc344ea3042c265c301ab4923ed0154c55112594' => 
    array (
      0 => '/home/david/Source/BlueMonster/config/../views/templates/source-list.tpl',
      1 => 1404697467,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '52600302653b9fb7c1d73e8-54214469',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/home/david/Source/BlueMonster/lib/smarty/plugins/modifier.escape.php';
?><!DOCTYPE html>

<html>
  <head>
    <title>Data sources</title>
    <link rel="stylesheet" href="/style/default.css" />
  </head>
  <body>
    <nav class="breadcrumbs">
      <li><a href="/">Home</a></li>
    </nav>

    <main>
      <h1>Data sources</h1>

      <table>
        <thead>
          <th>Data source</th>
          <th>Datasets available</th>
        </thead>
        <tbody>
          <?php  $_smarty_tpl->tpl_vars['source'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('sources')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['source']->key => $_smarty_tpl->tpl_vars['source']->value){
?>
          <tr>
            <td><a href="/data/<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('source')->value->ident,'url');?>
"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('source')->value->name);?>
</a></td>
            <td><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('source')->value->dataset_count);?>
</td>
          </tr>
          <?php }} ?>      
        </tbody>
      </table>
    </main>
  </body>
</html>