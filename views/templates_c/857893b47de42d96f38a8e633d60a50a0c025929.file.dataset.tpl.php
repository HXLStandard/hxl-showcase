<?php /* Smarty version Smarty-3.0.7, created on 2014-07-05 12:48:51
         compiled from "/home/david/Source/BlueMonster/config/../views/templates/dataset.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13726494953b82c736c8744-90213126%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '857893b47de42d96f38a8e633d60a50a0c025929' => 
    array (
      0 => '/home/david/Source/BlueMonster/config/../views/templates/dataset.tpl',
      1 => 1404578910,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13726494953b82c736c8744-90213126',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/home/david/Source/BlueMonster/lib/smarty/plugins/modifier.escape.php';
?><!DOCTYPE html>

<html>
  <head>
    <title><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('dataset')->value->name);?>
</title>
    <link rel="stylesheet" href="/style/default.css" />
  </head>
  <body>
    <nav class="breadcrumbs">
      <li><a href="/">Home</a></li>
      <li><a href="/data">Data sources</a></li>
      <li><a href="/data/<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('dataset')->value->source_ident,'url');?>
"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('dataset')->value->source_name);?>
</a></li>
    </nav>

    <main>
      <h1><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('dataset')->value->name);?>
</h1>

      <section id="imports">
        <h2>Imports</h2>

        <ul>
          <?php  $_smarty_tpl->tpl_vars['import'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('imports')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['import']->key => $_smarty_tpl->tpl_vars['import']->value){
?>
          <li><a href="/data/<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('dataset')->value->source_ident,'url');?>
/<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('dataset')->value->ident,'url');?>
/<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('import')->value->stamp,'url');?>
"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('import')->value->stamp);?>
</a></li>
          <?php }} ?>      
        </ul>

      </section>
    </main>
  </body>
</html>