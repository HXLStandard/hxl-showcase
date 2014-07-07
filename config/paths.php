<?php
////////////////////////////////////////////////////////////////////////
// Path mapping for the application.
////////////////////////////////////////////////////////////////////////

global $APP;

$APP->paths = array(
  '' => 'HomeController',
  'source-list' => 'SourceListController',
  'source' => 'SourceController',
  'dataset' => 'DatasetController',
  'import' => 'ImportController',
  'code-list' => 'CodeListController',
  'code' => 'CodeController',
);

// end
