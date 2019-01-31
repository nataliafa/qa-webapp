<?php

$categories = getCategories();

//------ Работа с полученными данными -----------
if (!empty($_POST)) {

  if(isset($_POST['category'])) {
    $category = $_POST['category'];

    if($category === 'Все категории') {
      $result = getAllData();
    } else {
      $result = getData($category);
    }
  }
} else {
  $result = getAllData();
}

//----------- Функции ----------------

// возращает массив всех опубликованных вопросов
function getAllData() 
{
  try {
    include ('dbconnect.php');
    $sql = "
    SELECT 
      c.title as category,
      a.name as author,
      q.title as title,
      q.content as question,
      q.answer as answer,
      q.date_added as date_added
    FROM questions q
    INNER JOIN categories c
      ON q.category_id=c.id
    INNER JOIN authors a
      ON q.author_id=a.id
    WHERE q.status_id = 2
    ";
    $sth = $pdo->prepare($sql);
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
  } catch(PDOException $e) {
    // echo $e->getMessage();
  }
  return $result;
}

// возращает массив опубликованных вопросов по категории
function getData($categoryId) {
  try {
    include ('dbconnect.php');
    $sql = "
    SELECT 
      c.title as category,
      a.name as author,
      q.title as title,
      q.content as question,
      q.answer as answer,
      q.date_added as date_added
    FROM questions q
    INNER JOIN categories c
      ON q.category_id=c.id
    INNER JOIN authors a
      ON q.author_id=a.id
    WHERE q.status_id = 2 AND q.category_id = :category_id
    ";
    $sth = $pdo->prepare($sql);
    $sth->execute([
      ":category_id" => $categoryId
    ]);
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
  } catch(PDOException $e) {
    // echo $e->getMessage();
  }
  return $result;
}

// возращает массив категорий
function getCategories() {
  include ('dbconnect.php');
  $sth = $pdo->prepare("SELECT * FROM categories");
  $sth->execute();
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
  <title>Вопросы и ответы</title>
  <style>
  table, tr, th, td {
    border: 1px solid grey;
		border-collapse: collapse;
		padding: 10px;
		text-align: center;
  }
  </style>
</head>
<body>
<a href="index.php">Войти как администратор</a>
<a href="addQuestion.php">Задать вопрос</a>

<h3>Список категорий:</h3>

<form action="topics.php" method="POST">
  <button type="submit" name="category" value="Все категории">Все категории</button> 
  <?php foreach($categories as $category) {?>
    <button type="submit" name="category" value="<?php echo $category['id']?>"><?php echo $category['title']?></button>
  <?php } ?>
</form>
<br/>

<?php if (count($result) > 0): ?>
    <table>
      <thead>
      <tr>
        <th>Категория</th>
        <th>Автор</th>
        <th>Заголовок</th>
        <th>Вопрос</th>
        <th>Ответ</th>
        <th>Дата добавления</th>
      </tr>
      </thead>
      <tbody>
      <?php foreach ($result as $item): ?>
        <tr>
          <?php foreach ($item as $key => $value): ?>
            <td>
            <span><?php echo $value?></span>
            </td>
          <?php endforeach; ?>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>Вопросов нет</p>
  <?php endif; ?>

    
</body>
</html>