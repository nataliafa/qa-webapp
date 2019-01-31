<?php
session_start();

//----------- Проверки и создание таблиц--------------------
include ('dbconnect.php');
$sth = $pdo->query("SHOW TABLES in `nfomina`");
$tables = $sth->fetchAll(PDO::FETCH_ASSOC);

// таблица admins
foreach ($tables as $table) {
  if ($table['Tables_in_nfomina'] !== 'admins') {
    // создать таблицу admins
    createAdminsTable();
    // добавить администратора по умолчанию
    addDefaultAdmin();
  } 
}

// таблица questions
foreach ($tables as $table) {
  if ($table['Tables_in_nfomina'] !== 'questions') {
     // создать таблицу questions
     createQuestionsTable();
  } 
}

// таблица categories
foreach ($tables as $table) {
  if ($table['Tables_in_nfomina'] !== 'categories') {
     // создать таблицу categories
     createСategoriesTable();
     // добавить категории по умолчанию
     addDefaultСategories();
  } 
}

// таблица statuses
foreach ($tables as $table) {
  if ($table['Tables_in_nfomina'] !== 'statuses') {
     // создать таблицу statuses
     createStatusesTable();
     // добавить категории по умолчанию
     addDefaultStatuses();
  } 
}

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
//создает таблицу admins
function createAdminsTable()
{
  try {
    include ('dbconnect.php');
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); //Error Handling
    $sql = "CREATE TABLE `admins`(
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `login` varchar(150) NOT NULL,
      `password` varchar(150) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
    $pdo->exec($sql);
    print("<h3 style='color:green;'>Таблица `admins` создана.</h3>");
  } catch(PDOException $e) {
    // echo $e->getMessage();
  }
}

//добавляет в таблицу admins администратора по умолчанию
function addDefaultAdmin() 
{
  try {
    include ('dbconnect.php');
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); //Error Handling
    $sql = "INSERT INTO `admins` (`id`, `login`, `password`) VALUES (1, 'admin', 'admin')";
    $pdo->exec($sql);
    print("<h3 style='color:green;'>Администратор по умолчанию добавлен в таблицу `admins`.</h3>");
  } catch(PDOException $e) {
    // echo $e->getMessage();
  }
}

//создает таблицу questions
function createQuestionsTable() 
{
  try {
    include ('dbconnect.php');
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); //Error Handling
    $sql = "CREATE TABLE `questions`(
      `id` smallint(6) NOT NULL AUTO_INCREMENT,
      `title` text,
      `category_id` smallint(6) NOT NULL,
      `author_id` smallint(6) DEFAULT NULL,
      `content` text NOT NULL,
      `answer` varchar(1000) DEFAULT NULL,
      `status_id` smallint(6) DEFAULT 1,
      `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
    $pdo->exec($sql);
    print("<h3 style='color:green;'>Таблица `questions` создана.</h3>");
  } catch(PDOException $e) {
    // echo $e->getMessage();
  }
}

//создает таблицу categories
function createСategoriesTable()
{
  try {
    include ('dbconnect.php');
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); //Error Handling
    $sql = "CREATE TABLE `categories`(
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `title` tinytext NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
    $pdo->exec($sql);
    print("<h3 style='color:green;'>Таблица `categories` создана.</h3>");
  } catch(PDOException $e) {
    // echo $e->getMessage();
  }
}

//добавляет в таблицу categories категории по умолчанию
function addDefaultСategories()
{
  try {
    include ('dbconnect.php');
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); //Error Handling
    $sql = "INSERT INTO `categories` (`id`, `title`) VALUES 
      (1, 'основы PHP'),
      (2, 'Javascript'),
      (3, 'React')";
    $pdo->exec($sql);
    print("<h3 style='color:green;'>Администратор по умолчанию добавлен в таблицу `admins`.</h3>");
  } catch(PDOException $e) {
    // echo $e->getMessage();
  }
}

//создает таблицу statuses
function createStatusesTable()
{
  try {
    include ('dbconnect.php');
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); //Error Handling
    $sql = "CREATE TABLE `statuses`(
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `status` tinytext NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
    $pdo->exec($sql);
    print("<h3 style='color:green;'>Таблица `statuses` создана.</h3>");
  } catch(PDOException $e) {
    // echo $e->getMessage();
  }

}

//добавляет в таблицу statuses статусы по умолчанию
function addDefaultStatuses()
{
  try {
    include ('dbconnect.php');
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); //Error Handling
    $sql = "INSERT INTO `statuses` (`id`, `status`) VALUES
      (1, 'ожидает ответа'),
      (2, 'опубликован'), 
      (3, 'скрыт')";
    $pdo->exec($sql);
    print("<h3 style='color:green;'>Статусы по умолчанию добавлены в таблицу `statuses`.</h3>");
  } catch(PDOException $e) {
    // echo $e->getMessage();
  }
}

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