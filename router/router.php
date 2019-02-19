<?php

session_start();

$controllersAndActions = [
  'admin' => [
    'logout',
    'login',
    'main',
    'questionsWithoutAnswer',
    'questionsWithoutAnswerQuestionDelete',
    'questionsWithoutAnswerChangeStatus',
    'adminList',
    'adminAdd',
    'adminDelete',
    'adminChangePassword',
    'categoryList',
    'categoryAdd',
    'categoryQuestionsDelete',
    'questionList',
    'questionChangeStatus',
    'questionDelete',
    'questionEdit'
  ],
  'front' => [
    'enter',
    'categories',
    'sendQuestion'
  ]
];

if (!isset($_GET['c']) || !isset($_GET['a'])) {
  $controller = 'front';
  $action = 'enter';
} else {
  $controller = $_GET['c'];
  $action = $_GET['a'];
}

foreach($controllersAndActions as $key =>$actions) {
  if ($key === $controller) {
    foreach($actions as $item) {
      if ($item === $action) {
        createController($key, $item);
      }
    }
  }
}

function createController($controller, $action) 
{
  $controllerText = $controller . 'Controller';
  $controllerFile = 'controller/' . ucfirst($controllerText) . '.php';
  if (is_file($controllerFile)) {
    include $controllerFile;
    if (class_exists($controllerText)) {
      $controller = new $controllerText();
      if (method_exists($controller, $action)) {
        $controller->$action();
      } else {
        echo 404;
      }
    } else {
      echo 404;
    }
  } else {
    echo 404;
  }
}
?>
