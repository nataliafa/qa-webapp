<?php
// запустить при первом запуске и удалить

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

// таблица authors
foreach ($tables as $item) {
  if ($item['Tables_in_nfomina'] !== 'authors') {
    createAuthorsTable();
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
      `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
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

// создает таблицу authors
function createAuthorsTable() 
{
  try {
    include ('dbconnect.php');
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); //Error Handling
    $sql = "CREATE TABLE `authors` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `name` varchar(50) NOT NULL,
      `email` varchar(255) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8" ;
    $pdo->exec($sql);
    print("<h3 style='color:green;'>Таблица `authors` создана.</h3>");
  } catch(PDOException $e) {
    // echo $e->getMessage();
  }
}

?>