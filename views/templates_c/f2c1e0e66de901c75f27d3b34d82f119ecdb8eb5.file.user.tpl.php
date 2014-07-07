<?php /* Smarty version Smarty-3.0.7, created on 2014-07-07 09:58:49
         compiled from "/home/david/Source/BlueMonster/config/../views/templates/user.tpl" */ ?>
<?php /*%%SmartyHeaderCode:84024000653baa799bfbcb7-45327485%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f2c1e0e66de901c75f27d3b34d82f119ecdb8eb5' => 
    array (
      0 => '/home/david/Source/BlueMonster/config/../views/templates/user.tpl',
      1 => 1404741525,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '84024000653baa799bfbcb7-45327485',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/home/david/Source/BlueMonster/lib/smarty/plugins/modifier.escape.php';
?><!DOCTYPE html>

<html>
  <head>
    <title><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('user')->value->name);?>
 (<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('user')->value->ident);?>
)</title>
    <link rel="stylesheet" href="/style/default.css" />
  </head>
  <body>
    <nav class="breadcrumbs">
      <li><a href="/">Home</a></li>
      <li><a href="/data">Data sources</a></li>
    </nav>

    <main>
      <h1><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('user')->value->name);?>
 (<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('user')->value->ident);?>
)</h1>

      <form method="GET" action="/search">
        <input type="hidden" name="user" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('user')->value->ident);?>
" />
        <label>
          <span>Search uploads by <?php echo smarty_modifier_escape($_smarty_tpl->getVariable('user')->value->name);?>
</span>
          <input name="q" placeholder="Search text" />
        </label>
        <input type="submit" />
      </form>

      <section id="imports">
        <h2>Uploads by <?php echo smarty_modifier_escape($_smarty_tpl->getVariable('user')->value->name);?>
</h2>

        <table>
          <thead>
            <tr>
              <th>Version</th>
              <th>Dataset</th>
              <th>Data source</th>
            </tr>
          </thead>
          <tbody>
            <?php  $_smarty_tpl->tpl_vars['import'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('imports')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['import']->key => $_smarty_tpl->tpl_vars['import']->value){
?>
            <tr>
              <td><a href="/data/<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('import')->value->source_ident,'url');?>
/<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('import')->value->dataset_ident,'url');?>
/<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('import')->value->stamp,'url');?>
"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('import')->value->stamp);?>
</a></td>
              <td><a href="/data/<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('import')->value->source_ident,'url');?>
/<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('import')->value->dataset_ident,'url');?>
"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('import')->value->dataset_name);?>
</a></td>
              <td><a href="/data/<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('import')->value->source_ident,'url');?>
"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('import')->value->source_name);?>
</a></td>
            </tr>
            <?php }} ?>
          </tbody>
        </table>

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