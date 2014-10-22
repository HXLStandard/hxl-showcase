<?php
////////////////////////////////////////////////////////////////////////
// Path mapping for the application.
////////////////////////////////////////////////////////////////////////

global $APP;

$APP->paths = array(
  'home' => 'HomeController',
  'search' => 'SearchController',
  'report' => 'ReportController',
  'filter' => 'FilterController',
  'source-list' => 'SourceListController',
  'source' => 'SourceController',
  'dataset-list' => 'DatasetListController',
  'dataset' => 'DatasetController',
  'dataset-history' => 'DatasetHistoryController',
  'tag-list' => 'TagListController',
  'tag' => 'TagController',
  'user-list' => 'UserListController',
  'user' => 'UserController',
  'stats' => 'StatsController',
  'map' => 'MapController',
);

// end
