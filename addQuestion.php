<?php

$message='';
$categories = getCategories();


//----------- Работа с полученными данными --------------------
if(!empty($_POST)) {
  //отправить автора в таблицу authors
  addAuthor($_POST['authorName'], $_POST['email']);

  // берем id автора
  $authorId = getAuthorId($_POST['authorName'], $_POST['email']);

  // отправить вопрос в таблицу questions
  addQuestion($_POST['title'], $_POST['categoryId'], $authorId, $_POST['content']);
  header('Location: addQuestion.php?send=true');
}

if(!empty($_GET)) {
  if(isset($_GET['send'])) {
    $message='Ваш вопрос был отправлен';
  }
}


//----------- Функции --------------------
// возвращает категории
function getCategories() {
  include ('dbconnect.php');
  $sth = $pdo->prepare("SELECT * FROM categories");
  $sth->execute();
  $result = $sth->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}


// добавляет автора в таблицу authors
function addAuthor($authorName, $email) 
{
  try {
    include ('dbconnect.php');
    $sth = $pdo->prepare("INSERT INTO authors SET name = :name, email = :email");
    $sth->execute([
      ":name" => $authorName,
      ":email" => $email,
      ]);
  } catch(PDOException $e) {
    // echo $e->getMessage();
  }
}

// возвращает id автора 
function getAuthorId($authorName, $email)
{
  include ('dbconnect.php');
  $sth = $pdo->prepare("SELECT * FROM authors WHERE name = :name AND email = :email LIMIT 1");
  $sth->execute([
    ':name' => $authorName,
    ':email' => $email,
  ]);
  $result = $sth->fetchAll(PDO::FETCH_ASSOC);
  return $result[0]['id'];
}

// добавляет вопрос в таблицу questions
function addQuestion($title, $categoryId, $authorId, $content) 
{
  try {
    include ('dbconnect.php');
    $sth = $pdo->prepare("INSERT INTO questions SET title = :title, category_id = :category_id, author_id = :author_id, content = :content");
    $sth->execute([
      ":title" => $title,
      ":category_id" => $categoryId,
      ":author_id" => $authorId,
      ":content" => $content
      ]);
  } catch(PDOException $e) {
    // echo $e->getMessage();
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Задать вопрос</title>
</head>
<body>
<a href="index.php">Войти как администратор</a>
<a href="topics.php">Вопросы</a>

<h2>Задать вопрос</h2>

<form action="addQuestion.php" method="POST">
  <legend>Имя</legend>
  <input type="text" name="authorName" required/>
  <br/>

  <legend>Адрес электронной почты:</legend>
  <input type="email" name="email" required/>
  <br/>

  <legend>Выберите категорию:</legend>
  <select name="categoryId">
    <?php foreach ($categories as $category) { ?>
      <option value="<?php echo $category['id'] ?>"><?php echo $category['title'] ?></option>
    <?php }
    ?>
  </select>
  <br/>

  <legend>Заголовок:</legend>
  <input type="text" name="title" required/>
  <br/>

  <legend>Напишите вопрос:</legend>
  <textarea name="content"  cols="30" rows="10" required></textarea>
  <br/>

  <input type="submit" value="Отправить"/>
</form>

<p><?php echo $message?></p>
    
</body>
</html>