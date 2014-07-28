<?php
/**
 * Display a row in a custom report, sorted as requested by the user.
 */
function smarty_function_report_row($params, $template) {

  $cols = $params['cols'];
  $cells = $params['cells'];

  $values_out = array();

  foreach ($cols as $col) {
    foreach ($cells as $i => $cell) {
      if ($cell->tag_tag == $col->tag) {
        array_push($values_out, $cell);
        unset($cells[$i]);
        break;
      }
    }
  }

  print("<tr>\n");
  foreach ($values_out as $value) {
    printf("<td>%s</td>\n", htmlspecialchars($value->value));
  }
  print("</tr>\n");
}