<?php
/**
 * Utility functions for the HXL Showcase.
 */

/**
 * Normalise text for searching.
 *
 * Remove all leading and training whitespace, replace internal
 * whitespace with a single space, and convert to lower case.
 *
 * @param The raw string.
 * @return The normalised string.
 */
function normalise_text($s) {
  return strtolower(trim(preg_replace('/\s{2,}/', ' ', $s)));
}

/**
 * Test if #lat_deg and #lon_deg appear in the columns.
 */
function is_geocoded($cols) {
  $has_lat = false;
  $has_lon = false;
  foreach($cols as $col) {
    if ($col->tag == 'lat_deg') {
      $has_lat = true;
    } else if ($col->tag == 'lon_deg') {
      $has_lon = true;
    }
  }
  return ($has_lat && $has_lon);
}