<?php
session_start();

//------ Работа с полученными данными -----------

if(!empty($_POST)) {
  if (isset($_POST['delete'])) {
    //удаляет вопрос
    deteleQuestion($_POST['questionId']);

  } elseif(isset($_POST['changeStatus'])) {
    //меняет статус
    changeStatus($_POST['newStatusId'], $_POST['questionId']);
  }
}

if(!empty($_GET)) {
  if(isset($_GET['categoryId'])) {
    $categoryName = getCategoryName($_GET['categoryId']);
    $questions = getQuestions($_GET['categoryId']);
    $statuses = getStatuses();
  }
}

//----------- Функции --------------

//возвращает массив статусов
function getStatuses()
{
  include ('dbconnect.php');
  $sth = $pdo->prepare("SELECT * FROM statuses");
  $sth->execute();
  $result = $sth->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}

//изменяет статус в таблице questions
function changeStatus($newStatusId, $questionId)
{
  include ('dbconnect.php');
  $sth = $pdo->prepare("UPDATE questions SET status_id = :status_id WHERE id = :id LIMIT 1");
  $sth->execute([
    ":status_id" => $newStatusId,
    ":id" => $questionId
  ]);
}

//возвращает имя категории
function getCategoryName($categoryId) 
{
  include ('dbconnect.php');
  $sth = $pdo->prepare("SELECT title FROM categories WHERE id = :id LIMIT 1");
  $sth->execute([
    ':id' => $categoryId
  ]);
  $result = $sth->fetchAll(PDO::FETCH_ASSOC);
  return $result[0]['title'];
}

//возвращает вопросы по категории
function getQuestions($categoryId)
{
  include ('dbconnect.php');
  $sth = $pdo->prepare("
    SELECT 
      q.id as id, 
      q.title as title, 
      q.date_added as date_added,
      s.status as status
    FROM questions q
    INNER JOIN statuses s
      ON q.status_id = s.id
    WHERE q.category_id = :category_id");
  $sth->execute([
    ':category_id' => $categoryId
  ]);
  $result = $sth->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}

// удаляет вопрос из таблицы questions
function deteleQuestion($questionId)
{
  include ('dbconnect.php');
  $sth = $pdo->prepare("DELETE questions FROM questions WHERE questions.id = :id");
  $sth->execute([
    ':id' => $questionId
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

<form action="logout.php" method="POST" style="display: inline">
  <input type="submit" value="Выйти из аккаунта">
</form>

<a href="adminInterface.php">Кабинет администратора</a>
<h3>Имя администратора: <?php echo $_SESSION['login']?></h3>
<hr />

<?php if(!empty($_GET)) {?>
  <h3>Категория: <?php echo $categoryName?></h3>
<?php } 
?>

<h3>Список вопросов:</h3>
<?php if (count($questions) > 0): ?>
<table>
  <thead>
    <tr>
      <th>ID вопроса</th>
      <th>Заголовок вопроса</th>
      <th>Дата добавления</th>
      <th>Статус</th>
      <th>Изменить статус</th>
      <th>Редактирование</th>
      <th>Удаление</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($questions as $question): ?>
      <tr>
        <form action="category.php?categoryId=<?php echo $_GET['categoryId']?>" method="post">

          <?php foreach ($question as $key => $value): ?>
            <td><span><?php echo $value?></span></td>
          <?php endforeach; ?>
            <td>
              <select name="newStatusId">
              <?php foreach($statuses as $status) { ?>
                <option value="<?php echo $status['id'] ?>" <?php if($status['status'] === $question['status']) :?>selected<?php endif?>><?php echo $status['status'] ?></option>
              <?php } ?>
              </select>
              <input type="submit" name="changeStatus" value="Изменить"/>
            </td>
            <td>
              <a href="question.php?categoryId=<?php echo $_GET['categoryId']?>&questionId=<?php echo $question['id']?>">Редактировать</a>
            </td>
            <td>
              <input type="hidden" name="categoryId" value="<?php echo $_GET['categoryId']?>"/>
              <input type="hidden" name="questionId" value="<?php echo $question['id']?>"/>
              <input type="submit" name="delete" value="Удалить"/>
            </td>

        </form>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
<?php else: ?>
  <p>Вопросов нет</p>
<?php endif; ?>
    
</body>
</html>