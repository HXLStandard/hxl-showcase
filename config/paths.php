<?php
////////////////////////////////////////////////////////////////////////
// Path mapping for the application.
////////////////////////////////////////////////////////////////////////

global $APP;

$APP->paths = array(
  'home' => 'HomeController',
  'search' => 'SearchController',
  'report' => 'ReportController',
  'source-list' => 'SourceListController',
  'source' => 'SourceController',
  'dataset-list' => 'DatasetListController',
  'dataset' => 'DatasetController',
  'dataset-history' => 'DatasetHistoryController',
  'import' => 'ImportController',
  'tag-list' => 'TagListController',
  'tag' => 'TagController',
  'user-list' => 'UserListController',
  'user' => 'UserController',
  'stats' => 'StatsController',
);

// end
