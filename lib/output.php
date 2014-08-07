<?php
/**
 * Utility functions
 */

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
function dump_json($cols, $rows) {
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
    )));
  }
  print("\n  ],");
  print("\n  \"rows\": [");
  $is_first = true;
  foreach ($rows as $row) {
    dump_json_row($cols, $row, $is_first);
    $is_first = false;
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
  print("\n    " . json_encode($row));
  
}

/**
 * Dump a dataset as XML.
 */
function dump_xml($cols, $rows) {
  header("Content-type: application/xml;charset=utf8");
  print("<?xml version=\"1.0\"?>\n\n");
  printf(
    "<hxl-data xmlns=\"http://hxlstandard.org/ns#\" source=\"%s\" dataset=\"%s\" timestamp=\"%s\">\n",
    htmlspecialchars($cols[0]->source),
    htmlspecialchars($cols[0]->dataset),
    htmlspecialchars($cols[0]->stamp)
  );
  print("  <cols>\n");
  $col_counter = 0;
  foreach($cols as $col) {
    printf(
      "    <col n=\"%d\" hxl=\"#%s\" original-header=\"%s\">%s</col>\n",
      $col_counter++,
      htmlspecialchars($col->tag),
      htmlspecialchars($col->header),
      htmlspecialchars($col->tag_name)
    );
  }
  print("  </cols>\n");
  print("  <rows>\n");

  foreach ($rows as $n => $row) {
    $col_counter = 0;
    printf("    <row n=\"%d\">\n", $n);
    foreach ($row as $value) {
      if ($value->value) {
        printf("      <%s col=\"%d\">%s</%s>\n", $value->tag, $col_counter, htmlspecialchars($value->value), $value->tag);
      }
      $col_counter++;
    }
    printf("    </row>\n");
  }

  print("  </rows>\n</hxl-data>\n");
}


/**
 * Dump a dataset as N3 triples.
 */
function dump_n3($cols, $rows) {
  header('Content-type: text/n3;charset=utf8');
  print("@PREFIX hxl: <http://hxlstandard.org/ns#>");
  foreach ($rows as $n => $row) {
    printf(".\n\n<http://demo.hxlstandard.org%s#row%d>", import_link($cols[0]), $n);
    $is_first = true;
    foreach ($row as $value) {
      if ($value->value) {
        if ($is_first) {
          $is_first = false;
        } else {
          print(';');
        }
        printf("\n  hxl:%s %s", $value->tag, json_encode($value->value));
      }
    }
  }
  print(".\n");
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
  return sprintf('/source/%s', urlencode($item->source));
}

/**
 * Make a link to a dataset
 */
function dataset_link($item) {
  return sprintf('/data/%s', urlencode($item->dataset));
}

/**
 * Make a link to an import
 */
function import_link($item) {
  return sprintf(
    '/data/%s/%s',
    urlencode($item->dataset),
    urlencode($item->stamp)
  );
}

