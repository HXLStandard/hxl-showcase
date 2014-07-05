<?php
////////////////////////////////////////////////////////////////////////
// Path mapping for the application.
////////////////////////////////////////////////////////////////////////

global $APP;

$APP->paths = array(
  '' => 'HelloController',
  'source-list' => 'SourceListController',
  'source' => 'SourceController',
  'dataset' => 'DatasetController',
  'import' => 'ImportController',
);

// end
