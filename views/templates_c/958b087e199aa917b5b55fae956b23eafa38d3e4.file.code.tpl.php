<?php /* Smarty version Smarty-3.0.7, created on 2014-07-06 21:33:57
         compiled from "/home/david/Source/BlueMonster/config/../views/templates/code.tpl" */ ?>
<?php /*%%SmartyHeaderCode:165892844953b9f905cbc2c0-73627699%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '958b087e199aa917b5b55fae956b23eafa38d3e4' => 
    array (
      0 => '/home/david/Source/BlueMonster/config/../views/templates/code.tpl',
      1 => 1404696836,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '165892844953b9f905cbc2c0-73627699',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/home/david/Source/BlueMonster/lib/smarty/plugins/modifier.escape.php';
?><!DOCTYPE html>

<html>
  <head>
    <title>HXL code "<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('code')->value->code);?>
" (<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('code')->value->name);?>
)</title>
    <link rel="stylesheet" href="/style/default.css" />
  </head>
  <body>
    <nav class="breadcrumbs">
      <li><a href="/">Home</a></li>
      <li><a href="/code">HXL codes</a></li>
    </nav>

    <main>
      <h1>HXL code &ldquo;<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('code')->value->code);?>
&rdquo; (<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('code')->value->name);?>
)</h1>

      <form method="GET" action="/search">
        <input type="hidden" name="code" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('code')->value->ident);?>
" />
        <input placeholder="Search within &ldquo;<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('code')->value->code);?>
&rdquo;" />
        <input type="submit" />
      </form>

      <section id="datasets">
        <h2>Datasets</h2>

        <?php if ($_smarty_tpl->getVariable('dataset_count')->value>0){?>
        <p><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('dataset_count')->value);?>
 dataset(s) use the HXL code &ldquo;<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('code')->value->code);?>
&rdquo;:</p>

        <table>
          <thead>
            <tr>
              <th>Dataset</th>
              <th>Source</th>
              <th>Latest copy</th>
              <th>Imported by</th>
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
"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('import')->value->dataset_name);?>
</a></td>
              <td><a href="/data/<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('import')->value->source_ident,'url');?>
"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('import')->value->source_name);?>
</a></td>
              <td><a href="/data/<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('import')->value->source_ident,'url');?>
/<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('import')->value->dataset_ident,'url');?>
/<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('import')->value->stamp,'url');?>
"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('import')->value->stamp);?>
</a></td>
              <td><a href="/user/<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('import')->value->usr_ident,'url');?>
"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('import')->value->usr_name);?>
</a></td>
            </tr>
            <?php }} ?>      
          </tbody>
        </table>
        <?php }else{ ?>
        <p>No datasets use the HXL code &ldquo;<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('code')->value->code);?>
&rdquo; yet.</p>
        <?php }?>

      </section>
    </main>
  </body>
</html>