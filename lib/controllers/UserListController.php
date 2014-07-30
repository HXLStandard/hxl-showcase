<?php

class UserListController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {
    $users = $this->doQuery(
      'select U.*, CNT.import_count' .
      ' from usr U' .
      ' join (select usr, count(*) as import_count from import group by usr) CNT using(usr)' .
      ' order by U.usr');

    $response->setParameter('users', $users);
    $response->setTemplate('user-list');
  }

}