<?php /* Smarty version Smarty-3.0.7, created on 2014-07-07 09:16:49
         compiled from "/home/david/Source/BlueMonster/config/../views/templates/source.tpl" */ ?>
<?php /*%%SmartyHeaderCode:104726244353ba9dc13343b1-50398375%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8121cc64f4a891f5ad5a5371ede4be97abfe1080' => 
    array (
      0 => '/home/david/Source/BlueMonster/config/../views/templates/source.tpl',
      1 => 1404738996,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '104726244353ba9dc13343b1-50398375',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/home/david/Source/BlueMonster/lib/smarty/plugins/modifier.escape.php';
?><!DOCTYPE html>

<html>
  <head>
    <title><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('source')->value->name);?>
</title>
    <link rel="stylesheet" href="/style/default.css" />
  </head>
  <body>
    <nav class="breadcrumbs">
      <li><a href="/">Home</a></li>
      <li><a href="/data">Data sources</a></li>
    </nav>

    <main>
      <h1><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('source')->value->name);?>
</h1>

      <form method="GET" action="/search">
        <input type="hidden" name="source" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('source')->value->ident);?>
" />
        <label>
          <span>Search within <?php echo smarty_modifier_escape($_smarty_tpl->getVariable('source')->value->name);?>
</span>
          <input name="q" placeholder="Search text" />
        </label>
        <input type="submit" />
      </form>

      <section id="datasets">
        <h2>Datasets from <?php echo smarty_modifier_escape($_smarty_tpl->getVariable('source')->value->name);?>
</h2>

        <ul>
          <?php  $_smarty_tpl->tpl_vars['dataset'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('datasets')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['dataset']->key => $_smarty_tpl->tpl_vars['dataset']->value){
?>
          <li><a href="/data/<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('source')->value->ident,'url');?>
/<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('dataset')->value->ident,'url');?>
"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('dataset')->value->name);?>
</a></li>
          <?php }} ?>      
        </ul>

      </section>
    </main>
  </body>
</html>