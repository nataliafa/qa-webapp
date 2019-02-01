<?php
session_start();
$mes='';

//------ Работа с полученными данными -----------
if(!empty($_POST)) {

  if(isset($_POST['publish'])) {
    publish($_GET['questionId']);
    $mes='Вопрос опубликован';
  }

  if(isset($_POST['hide'])) {
    hide($_GET['questionId']);
    $mes='Вопрос скрыт';
  }

  // меняет категорию
  if(isset($_POST['newCategory'])) {
    changeCategory($_POST['newCategory'],$_GET['questionId']);
  } 

  // меняет имя автора
  if(isset($_POST['newAuthorName'])) {
    changeAuthorName($_POST['newAuthorName'], $_POST['authorName']);
  }

  //меняет title 
  if(isset($_POST['newTitle'])) {
    changeTitle($_POST['newTitle'], $_GET['questionId']);
  }

  //меняет контент
  if(isset($_POST['newContent'])) {
    changeContent($_POST['newContent'], $_GET['questionId']);
  }

  //меняет ответ на вопрос
  if(isset($_POST['newAnswer'])) {
    changeAnswer($_POST['newAnswer'], $_GET['questionId']);
  }

}

if(!empty($_GET)) {
  if (isset($_GET['categoryId']) && isset($_GET['questionId'])) {
    //делает запрос данных
    $result = getData($_GET['questionId']);
    $categories = getCategories();
  }
}

//----------- Функции ----------------

//возвращает массив данных вопроса
function getData($questionId) 
{
  try {
    include ('dbconnect.php');
    $sql = "
    SELECT 
      q.id as id,
      q.date_added as date_added,
      c.title as category,
      q.title as title,
      s.status as status,
      a.name as author_name,
      q.title as title,
      q.content as content,
      q.answer as answer
    FROM questions q
    INNER JOIN categories c
      ON q.category_id=c.id
    INNER JOIN authors a
      ON q.author_id=a.id
    INNER JOIN statuses s
      ON q.status_id=s.id
    WHERE q.id = :id
    ";
    $sth = $pdo->prepare($sql);
    $sth->execute([
      ':id' => $questionId
    ]);
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
  } catch(PDOException $e) {
    // echo $e->getMessage();
  }
  return $result[0];
}

// возвращает список категорий
function getCategories() {
  include ('dbconnect.php');
  $sth = $pdo->prepare("SELECT * FROM categories");
  $sth->execute();
  $result = $sth->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}

// меняет категорию
function changeCategory($newCategory, $questionId)
{
  include ('dbconnect.php');
  $sth = $pdo->prepare("UPDATE questions SET category_id = :category_id WHERE id = :id LIMIT 1");
  $sth->execute([
    ":category_id" => $newCategory,
    ":id" => $questionId
    ]);
}

// меняет имя автора
function changeAuthorName($newAuthorName, $authorName) 
{
  try{
    include ('dbconnect.php');
    $sth = $pdo->prepare("UPDATE authors SET `name` = :new_name WHERE `name` = :old_name LIMIT 1");
    $sth->execute([
      ":new_name" => $newAuthorName,
      ":old_name" => $authorName,
    ]);
  }
  catch(PDOException $e) {
    // echo $e->getMessage();
  }
}

// меняет заголовок вопроса
function changeTitle($newTitle, $questionId)
{
  include ('dbconnect.php');
  $sth = $pdo->prepare("UPDATE questions SET title = :title WHERE id = :id LIMIT 1");
  $sth->execute([
    ":title" => $newTitle,
    ":id" => $questionId
  ]);
}

// меняет контент вопроса
function changeContent($newContent, $questionId)
{
  include ('dbconnect.php');
  $sth = $pdo->prepare("UPDATE questions SET content = :content WHERE id = :id LIMIT 1");
  $sth->execute([
    ":content" => $newContent,
    ":id" => $questionId
  ]);
}

// меняет ответ на вопрос
function changeAnswer($newAnswer, $questionId)
{
  include ('dbconnect.php');
  $sth = $pdo->prepare("UPDATE questions SET answer = :answer WHERE id = :id LIMIT 1");
  $sth->execute([
    ":answer" => $newAnswer,
    ":id" => $questionId
  ]);
}

// публикует ответ
function publish($questionId) {
  include ('dbconnect.php');
  $sth = $pdo->prepare("UPDATE questions SET status_id = :status_id WHERE id = :id LIMIT 1");
  $sth->execute([
    ":status_id" => 2,
    ":id" => $questionId
  ]);
}

// скрывет ответ
function hide($questionId) {
  include ('dbconnect.php');
  $sth = $pdo->prepare("UPDATE questions SET status_id = :status_id WHERE id = :id LIMIT 1");
  $sth->execute([
    ":status_id" => 3,
    ":id" => $questionId
  ]);
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
<form action="logout.php" method="POST" style="display: inline">
  <input type="submit" value="Выйти из аккаунта">
</form>

<a href="category.php?categoryId=<?php echo $_GET['categoryId']?>">назад</a>
<a href="adminInterface.php">Кабинет администратора</a>
<h2>Имя администратора: <?php echo $_SESSION['login']?></h2>
<hr/>
<h2><?php echo $mes?></h2>
<p>ID Вопроса: <?php echo $result['id']?></p>
<p>Дата и время добавления: <?php echo $result['date_added']?></p>


<form action="question.php?categoryId=<?php echo $_GET['categoryId']?>&questionId=<?php echo $result['id']?>" method="POST">

  <span>Категория:</span>
  <select name="newCategory">
  <?php foreach($categories as $category) { ?>
    <option value="<?php echo $category['id'] ?>" <?php if($category['title'] === $result['category']) :?>selected<?php endif?>><?php echo $category['title'] ?></option>
  <?php } ?>
  </select>
  <br/>

  <span>Статус: <?php echo $result['status']?></span>
  <br/>
  <!-- <span>Статус:</span>
  <select name="newStatusId">
  <?php foreach($statuses as $status) { ?>
    <option value="<?php echo $status['id'] ?>" <?php if($status['status'] === $result['status']) :?>selected<?php endif?>><?php echo $status['status'] ?></option>
  <?php } ?>
  </select>
  <br/> -->

  <span>Автор: </span>
  <input type="hidden" name="authorName" value="<?php echo $result['author_name']?>"/>
  <input type="text" name="newAuthorName" value="<?php echo $result['author_name']?>"/>
  <br/>

  <span>Заголовок вопроса:</span>
  <input type="text" name="newTitle" value="<?php echo $result['title']?>"/>
  <br/>

  <p>Контент вопроса:</p>
  <textarea name="newContent" cols="50" rows="10"><?php echo $result['content']?></textarea>
  <br/>

  <p>Ответ на вопрос:</p>
  <textarea name="newAnswer" cols="50" rows="10"><?php echo $result['answer']?></textarea>
  <br/>

<br/>
<input type="submit" name="publish" value="Опубликовать"/>
<input type="submit" name="hide" value="Скрыть"/>

</form>


    
</body>
</html>