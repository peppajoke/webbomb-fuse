<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 1/28/2018
 * Time: 6:54 PM
 */

namespace webBombSite\views;

use webBomb\factories\controller_factory;
use webBomb\helpers\string_helper;
use webBombSite\views\base\view;

final class layout_view extends view {

  public $mainView;

  public function render() : string {
    return '
            <!doctype html>
            <html lang="en">
              <head>
              ' . $this->generateJsTags() . '
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, user-scalable=no">
                <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
                <title>' . $this->title() . '</title>
              </head>
              <body>
                <div class="container-fluid" style="padding:0">' . $this->body() . $this->customJavascript() . $this->generateCssTags() . '
                </div>
              </body>
            </html>
            ';
  }

  protected function javascriptDependencies(): array {
    return array_merge(
      [
        'https://code.jquery.com/jquery-3.2.1.slim.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js',
        'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js',
        'https://use.fontawesome.com/854c747273.js'
      ],
      $this->mainView->javascriptDependencies()
    );
  }

  protected function cssDependencies(): array {
    return array_merge(
      [
        'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css'
      ],
      $this->mainView->cssDependencies()
    );
  }

  protected function title(): string {
    return $this->mainView->title();
  }

  protected function body(): string {
    return $this->navigationMenu() . '<div class="container">' . $this->mainView->body() . '</div>';
  }

  public function customJavascript(): string {
    return '' . $this->mainView->customJavascript();
  }

  private function navigationMenu() {
    $currentApp = $_GET['app'];
    $allControllerNames = controller_factory::getAllControllers();
    $output = '<div class="navbar navbar-dark bg-dark box-shadow">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
';
    foreach ($allControllerNames as $controllerName) {
      $app = string_helper::controllerToAppName($controllerName);
      $isCurrentApp = $currentApp === $app;
      $isHome = $app === 'home';
      $output .= '
      
      <li class="nav-item">
          <a href="/app.php?app=' . $app . '" class="navbar-brand float-left navbar-brand">
          ' . ($isHome ? $this->logo() : '') .'
            ' . ($isHome ? '' : $app) . '
          </a>
      </li>';
    }
    foreach ($this->externalLinks() as $externalLink) {
      $output .= $externalLink;
    }
    $output .= '
          </ul>
        </div>
      </div>';
    return $output;
  }

  private function logo() {
    return '<i class="fa fa-bomb" aria-hidden="true"></i>';
  }

  protected function externalLinks() : array {
    return [
      '
      <li class="nav-item">
        <a class="navbar-brand font-weight-light float-right" target="_blank" href="https://github.com"><i class="fa fa-github" style="margin-right:10px" aria-hidden="true"></i>github</a>
      </li>'
    ];
  }

  protected function layoutView() {
    return null;
  }
}