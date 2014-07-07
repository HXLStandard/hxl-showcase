<?php /* Smarty version Smarty-3.0.7, created on 2014-07-07 09:14:25
         compiled from "/home/david/Source/BlueMonster/config/../views/templates/search.tpl" */ ?>
<?php /*%%SmartyHeaderCode:82615532953ba9d315a4694-37851487%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e3115fb2d9e7bb0ca0f7617190e1b66fd8a1aae1' => 
    array (
      0 => '/home/david/Source/BlueMonster/config/../views/templates/search.tpl',
      1 => 1404738864,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '82615532953ba9d315a4694-37851487',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/home/david/Source/BlueMonster/lib/smarty/plugins/modifier.escape.php';
?><!DOCTYPE html>

<html>
  <head>
    <title>Search</title>
    <link rel="stylesheet" href="/style/default.css" />
  </head>
  <body>
    <nav class="breadcrumbs">
      <li><a href="/">Home</a></li>
    </nav>

    <main>
      <h1>Search</h1>

      <form method="GET" action="/search">
        <label>
          <span>Search for</span>
          <input name="q" placeholder="Search text" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('q')->value);?>
" />
        </label>
        <label>
          <span>HXL code</span>
          <select name="code">
            <option value="">(all)</option>
            <?php  $_smarty_tpl->tpl_vars['code'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('codes')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['code']->key => $_smarty_tpl->tpl_vars['code']->value){
?>
            <option value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('code')->value->code);?>
"<?php if ($_smarty_tpl->getVariable('code')->value->code==$_smarty_tpl->getVariable('code_code')->value){?> selected="selected"<?php }?>><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('code')->value->code);?>
 &mdash; <?php echo smarty_modifier_escape($_smarty_tpl->getVariable('code')->value->name);?>
</option>
            <?php }} ?>
          </select>
        </label>
        <label>
          <span>Data source</span>
          <select name="source">
            <option value="">(all)</option>
            <?php  $_smarty_tpl->tpl_vars['source'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('sources')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['source']->key => $_smarty_tpl->tpl_vars['source']->value){
?>
            <option value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('source')->value->ident);?>
"<?php if ($_smarty_tpl->getVariable('source')->value->ident==$_smarty_tpl->getVariable('source_ident')->value){?> selected="selected"<?php }?>><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('source')->value->ident);?>
 &mdash; <?php echo smarty_modifier_escape($_smarty_tpl->getVariable('source')->value->name);?>
</option>
            <?php }} ?>
          </select>
        </label>
        <input type="submit" />
      </form>

      <?php if ($_smarty_tpl->getVariable('q')->value){?>
      <section id="results">
        <h2>Search results</h2>

        <?php if ($_smarty_tpl->getVariable('result_count')->value>0){?>
        <p><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('result_count')->value);?>
 matching values:</p>

        <table>
          <thead>
            <tr>
              <th>Field</th>
              <th>Value</th>
              <th>Dataset</th>
              <th>Date updated</th>
              <th>Data source</th>
              <th>Uploader</th>
            </tr>
          </thead>
          <tbody>
            <?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('values')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
?>
            <tr>
              <td><a href="/code/<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('value')->value->code_code,'url');?>
"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('value')->value->code_name);?>
</a></td>
              <td><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('value')->value->value);?>
</td>
              <td><a href="/data/<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('value')->value->source_ident,'url');?>
/<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('value')->value->dataset_ident,'url');?>
"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('value')->value->dataset_name);?>
</a></td>
              <td><a href="/data/<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('value')->value->source_ident,'url');?>
/<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('value')->value->dataset_ident,'url');?>
/<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('value')->value->stamp,'url');?>
"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('value')->value->stamp);?>
</a></td>
              <td><a href="/data/<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('value')->value->source_ident,'url');?>
"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('value')->value->source_name);?>
</a></td>
              <td><a href="/user/<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('value')->value->usr_ident,'url');?>
"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('value')->value->usr_name);?>
</a></td>
            </tr>
            <?php }} ?>
          </tbody>
        </table>
        <?php }else{ ?>
        <p>No matching data.</p>
        <?php }?>
      </section>
      <?php }else{ ?>
      <p>(Enter some search text to continue.)</p>
      <?php }?>
    </main>
  </body>
</html>