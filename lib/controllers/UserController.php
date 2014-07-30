<?php

class UserController extends AbstractController {

  function doGET(HttpRequest $request, HttpResponse $response) {
    $user = $this->doQuery('select * from usr where usr=?', $request->get('user'))->fetch();
    $imports = $this->doQuery('select * from import_view where usr=? order by stamp desc', $user->usr);

    $response->setParameter('user', $user);
    $response->setParameter('imports', $imports);
    $response->setTemplate('user');
  }

}