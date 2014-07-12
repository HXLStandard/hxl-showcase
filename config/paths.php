<?php
////////////////////////////////////////////////////////////////////////
// Path mapping for the application.
////////////////////////////////////////////////////////////////////////

global $APP;

$APP->paths = array(
  '' => 'HomeController',
  'search' => 'SearchController',
  'report' => 'ReportController',
  'source-list' => 'SourceListController',
  'source' => 'SourceController',
  'dataset' => 'DatasetController',
  'import' => 'ImportController',
  'import-analysis' => 'ImportAnalysisController',
  'code-list' => 'CodeListController',
  'code' => 'CodeController',
  'user-list' => 'UserListController',
  'user' => 'UserController',
);

// end
