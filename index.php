<?php
session_start();

//создание таблиц
include_once ('install.php');

//------ Работа с полученными данными -----------

if(!empty($_POST)) {
  // проверяет в таблице admins администратора
  $result = checkAdmin($_POST['login'], $_POST['password']);
  if (!empty($result)) {
    // есть -  добавить в ссессию
    $_SESSION['login'] = $result[0]['login'];
    //перейти на страницу администрирования
    header('Location: adminInterface.php');
  } else {
    print('Введен не верный логин или пароль');
  }
}

//----------- Функции ----------------

// проверяет в таблице admins администратора
function checkAdmin($login, $password) {
  include ('dbconnect.php');
  $sth = $pdo->prepare("SELECT * FROM admins WHERE login = :login AND password = :password LIMIT 1");
  $sth->execute([
    ':login' => $login,
    ':password' => $password,
  ]);
  $result = $sth->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>

<h2>Форма авторизации</h2>
<form action="index.php" method="POST">
  <legend>Введите имя администратора</legend>
  <input type="text" name="login" required/>
  <br/>
  <legend>Введите пароль</legend>
  <input type="text" name="password" required/>
  <input type="submit">
</form>

<h2>Или войдите как гость</h2>
<a href="topics.php">Перейти</a>
</body>
</html>