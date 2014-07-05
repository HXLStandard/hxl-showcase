<?php /* Smarty version Smarty-3.0.7, created on 2014-07-05 12:55:39
         compiled from "/home/david/Source/BlueMonster/config/../views/templates/import.tpl" */ ?>
<?php /*%%SmartyHeaderCode:41450595853b82e0b4a5f08-30761215%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd8a0aefea5ec6f12c319c4927bb18d85cf97caa7' => 
    array (
      0 => '/home/david/Source/BlueMonster/config/../views/templates/import.tpl',
      1 => 1404579338,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '41450595853b82e0b4a5f08-30761215',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/home/david/Source/BlueMonster/lib/smarty/plugins/modifier.escape.php';
?><!DOCTYPE html>

<html>
  <head>
    <title><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('import')->value->dataset_name);?>
 (<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('import')->value->stamp);?>
)</title>
    <link rel="stylesheet" href="/style/default.css" />
  </head>
  <body>
    <nav class="breadcrumbs">
      <li><a href="/">Home</a></li>
      <li><a href="/data">Data sources</a></li>
      <li><a href="/data/<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('import')->value->source_ident,'url');?>
"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('import')->value->source_name);?>
</a></li>
      <li><a href="/data/<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('import')->value->source_ident,'url');?>
/<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('import')->value->dataset_ident,'url');?>
"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('import')->value->dataset_name);?>
</a></li>
    </nav>

    <main>
      <h1><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('import')->value->dataset_name);?>
 (<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('import')->value->stamp);?>
)</h1>

      <p>Imported by <a href="/user/<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('import')->value->usr_ident,'url');?>
"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('import')->value->usr_name);?>
</a> on <?php echo smarty_modifier_escape($_smarty_tpl->getVariable('import')->value->stamp);?>
.</p>

      <section id="data">
        <h2>Data</h2>

        <table>
          <thead>
            <tr class="codes">
              <?php  $_smarty_tpl->tpl_vars['col'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('cols')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['col']->key => $_smarty_tpl->tpl_vars['col']->value){
?>
              <th><a href="/code/<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('col')->value->code_code,'url');?>
"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('col')->value->code_name);?>
</a></th>
              <?php }} ?>
            </tr>
          </thead>

          <tbody>
            <tr>
              <?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('values')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
?>
              <?php if ($_smarty_tpl->getVariable('last_row')->value&&($_smarty_tpl->getVariable('last_row')->value!=$_smarty_tpl->getVariable('value')->value->row)){?>
            </tr>
            <tr>
              <?php }?>
              <?php $_smarty_tpl->tpl_vars['last_row'] = new Smarty_variable($_smarty_tpl->getVariable('value')->value->row, null, null);?>
              <td><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('value')->value->value);?>
</td>
              <?php }} ?>
            </tr>
          </tbody>
          
        </table>

      </section>
    </main>
  </body>
</html>