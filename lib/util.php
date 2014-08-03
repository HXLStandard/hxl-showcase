<?php
/**
 * Utility functions
 */

define('HXL_JSON_OPTS', JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);

/**
 * Dump a dataset as CSV.
 */
function dump_csv($cols, $rows) {

  $output = fopen('php://output', 'w');

  header('Content-type: text/csv;charset=utf8');

  $tag_row = array();
  $header_row = array();

  // HXL tags and original headers
  foreach ($cols as $col) {
    array_push($header_row, $col->header);
    array_push($tag_row, '#' . $col->tag);
  }
  fputcsv($output, $header_row);
  fputcsv($output, $tag_row);

  foreach ($rows as $row) {
    $fields = array();
    foreach ($row as $value) {
      array_push($fields, $value->value);
    }
    fputcsv($output, $fields);
  }
  return;

  $last_row = -1;
  $row = array();
  foreach ($values as $value) {
    if ($last_row != $value->row && $row) {
      dump_csv_row($cols, $row, $output);
      $row = array();
    }
    array_push($row, $value);
    $last_row = $value->row;
  }
  if ($row) {
    dump_csv_row($cols, $row, $output);
  }

  fclose($output);
}


/**
 * Dump a row of a CSV spreadsheet
 */
function dump_csv_row($cols, $values, $output) {
  $row = array();
  foreach ($cols as $col) {
    $v = null;
    foreach ($values as $i => $value) {
      if ($col->col == $value->col) {
        $v = $value->value;
        unset($values[$i]);
        break;
      }
    }
    array_push($row, $v);
  }
  fputcsv($output, $row);
}

/**
 * Dump a dataset as JSON.
 */
function dump_json($cols, $values) {
  header('Content-type: application/json;charset=utf8');
  print("{");
  print("\n  \"cols\": [");
  $is_first = true;
  foreach ($cols as $col) {
    if ($is_first) {
      $is_first = false;
    } else {
      print(',');
    }
    print("\n    " . json_encode(array(
      'hxl' => '#' . $col->tag,
      'hxl_name' => $col->tag_name,
      'hxl_datatype' => $col->datatype,
      'original_header' => $col->header,
    ), HXL_JSON_OPTS));
  }
  print("\n  ],");
  print("\n  \"rows\": [");
  $last_row = -1;
  $row = array();
  $is_first = true;
  foreach ($values as $value) {
    if ($last_row != $value->row && $row) {
      dump_json_row($cols, $row, $is_first);
      $is_first = false;
      $row = array();
    }
    array_push($row, $value);
    $last_row = $value->row;
  }
  if ($row) {
    dump_json_row($cols, $row, $is_first);
  }
  print("\n  ]");
  print("\n}\n");
}

/**
 * Dump a row of JSON data
 */
function dump_json_row($cols, $values, $is_first) {
  $row = array();
  foreach ($cols as $col) {
    $v = null;
    foreach ($values as $i => $value) {
      if ($col->col == $value->col) {
        $v = $value->value;
        unset($values[$i]);
        break;
      }
    }
    array_push($row, $v);
  }
  if (!$is_first) {
    print(',');
  }
  print("\n    " . json_encode($row, HXL_JSON_OPTS));
  
}

/**
 * Dump a dataset as XML.
 */
function dump_xml($cols, $values) {
  header("Content-type: application/xml;charset=utf8");
  print("<?xml version=\"1.0\"?>\n\n");
  printf(
    "<hxl source=\"%s\" dataset=\"%s\" timestamp=\"%s\">\n",
    htmlspecialchars($cols[0]->source),
    htmlspecialchars($cols[0]->dataset),
    htmlspecialchars($cols[0]->stamp)
  );
  print("  <cols>\n");
  $col_counter = 0;
  foreach($cols as $col) {
    printf(
      "    <col n=\"%d\" hxl=\"#%s\" original-header=\"%s\">%s</col>\n",
      ++$col_counter,
      htmlspecialchars($col->tag),
      htmlspecialchars($col->header),
      htmlspecialchars($col->tag_name)
    );
  }
  print("  </cols>\n");
  print("  <rows>\n");
  $last_row = -1;
  $row_counter = 0;
  $col_counter = 0;
  foreach($values as $value) {
    $col_counter++;
    if ($value->row != $last_row) {
      $col_counter = 1;
      if ($last_row == -1) {
        printf("    <row n=\"%d\">\n", ++$row_counter);
      } else {
        printf("    </row>\n    <row n=\"%d\">\n", ++$row_counter);
      }
    }
    if ($value->value) {
      printf("      <%s col=\"%d\">%s</%s>\n", $cols[$col_counter]->tag, $col_counter, htmlspecialchars($value->value), $cols[$col_counter]->tag);
    }
    $last_row = $value->row;
  }
  if ($last_row != -1) {
    print("    </row>\n  </rows>\n</hxl>\n");
  } else {
    print("  </rows>\n</hxl>\n");
  }
}

function dump_n3($cols, $values) {
  header('Content-type: text/n3;charset=utf8');
  print("@PREFIX hxl: <http://hxlstandard.org/ns#>");

  $last_row = -1;
  foreach($values as $value) {
    if ($value->row != $last_row) {
      printf(".\n\n<http://demo.hxlstandard.org%s#row%d>", import_link($cols[0]), $value->row);
    } else if ($value->value) {
      print(';');
    }
    if ($value->value) {
      printf("\n  hxl:%s %s", $value->tag, json_encode($value->value, HXL_JSON_OPTS));
    }
    $last_row = $value->row;
  }
}


////////////////////////////////////////////////////////////////////////
// Link generators.
////////////////////////////////////////////////////////////////////////

/**
 * Make a link to a user
 */
function user_link($item) {
  return sprintf('/user/%s', urlencode($item->usr));
}

/**
 * Make a link to a HXL tag
 */
function tag_link($item) {
  return sprintf('/tag/%s', urlencode($item->tag));
}

/**
 * Make a link to a source
 */
function source_link($item) {
  return sprintf('/data/%s', urlencode($item->source));
}

/**
 * Make a link to a dataset
 */
function dataset_link($item) {
  return sprintf(
    '/data/%s/%s',
    urlencode($item->source),
    urlencode($item->dataset)
  );
}

/**
 * Make a link to an import
 */
function import_link($item) {
  return sprintf(
    '/data/%s/%s/%s',
    urlencode($item->source),
    urlencode($item->dataset),
    urlencode($item->stamp)
  );
}

