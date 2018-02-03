<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 1/29/2018
 * Time: 7:59 PM
 */

namespace webBombSite\controllers;

use webBombSite\controllers\base\controller;
use webBombSite\views\base\view;
use webBombSite\views\examples_view;

class examples_controller extends controller {

  public function index() : view {
    return new examples_view();
  }
}