<?php

session_start();

if (!isset($_GET['c']) || !isset($_GET['a'])) {
  $controller = 'front';
  $action = 'enter';
} else {
  $controller = $_GET['c'];
  $action = $_GET['a'];
}

if ($controller === 'admin') {
  include 'controller/AdminController.php';
  $adminController = new AdminController;

  if ($action === 'logout') {
    //выйти
    $adminController->logout();

  } elseif ($action === 'login') {
    // авторизация
    $adminController->login();

  } elseif ($action === 'listAll') {
    // спикок тем и вопросы ожидающие ответа
    $adminController->listAll();
   
  } elseif ($action === 'listAllQuestionDelete') {
    //удалить вопрос
    $adminController->listAllQuestionDelete();

  } elseif ($action === 'listAllChangeStatus'){
    // изменить статус вопроса
    $adminController->listAllChangeStatus();

  } elseif ($action === 'adminList'){
    //список администраторов
    $adminController->adminList();

  } elseif ($action === 'adminAdd') {
    // добавить администратора
    $adminController->adminAdd();

  } elseif($action === 'adminDelete') {
    // удалить аминистратора
    $adminController->adminDelete();

  } elseif($action === 'adminChangePass') {
    // изменить пароль аминистратора
    $adminController->adminChangePass();

  } elseif($action ==='categoryAdd') {
    // добавить категорию
    $adminController->categoryAdd();

  } elseif($action ==='categoryQuestionsDelete') {
    // удалить категорию и вопросы в ней
    $adminController->categoryQuestionsDelete();

  } elseif ($action ==='questionList') {
    // список вопросов
    $adminController->questionList();

  } elseif ($action ==='questionChangeStatus') {
    // изменить статус вопроса
    $adminController->questionChangeStatus();

  } elseif ($action ==='questionDelete') {
    // удалить вопрос
    $adminController->questionDelete();

  } elseif ($action === 'questionEdit') {
    //редактировать вопрос
    $adminController->questionEdit();
  }

} elseif ($controller === 'front') {
  include 'controller/FrontController.php';
  $frontController = new FrontController;

  if($action === 'enter') {
    //вход на страницу
    $frontController->enter();

  } elseif ($action === 'categories') {
    //страница категории
    $frontController->categories();

  } elseif ($action === 'sendQuestion') {
    //страница отправить вопрос
    $frontController->sendQuestion();
  }
}

?>
