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
