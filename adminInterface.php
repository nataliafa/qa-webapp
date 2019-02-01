<?php
session_start();

//------ Работа с полученными данными -----------
if (!empty($_POST)) {
  if(isset($_POST['delete'])) {
    //удалить вопросы
    deleteQuestions($_POST['categoryId']);
    //удалить категорию
    deleteCategory($_POST['categoryId']);

  } elseif (isset($_POST['add'])) {
    //добавить новую категорию
    addCategory($_POST['newCategory']);

  } elseif(isset($_POST['deleteQuestion'])) {
    //удалить вопрос
    deteleQuestion($_POST['questionId']);

  } elseif(isset($_POST['changeStatus'])) {
    //изменить статус
    changeStatus($_POST['newStatusId'], $_POST['questionId']);
  } 
}

//-----------  Получение данных --------------------

$result = getTopicsData();
$statuses = getStatuses();
$questions = getQuestions();

//----------- Функции --------------------

// возвращает данные по категории и вопросам
function getTopicsData() {
  include ('dbconnect.php');
  $sql = "
  SELECT
    c.id,
    c.title,
  COUNT(q.id) as quantity_q,
  SUM(IF(q.status_id='2', 1,0)) as published_q,
  SUM(IF(q.status_id='1', 1,0)) as waiting_q,
  SUM(IF(q.status_id='3', 1,0)) as hidden_q
  FROM categories c
  LEFT JOIN questions q ON q.category_id=c.id
  GROUP BY c.id
  ";
  $sth = $pdo->prepare($sql);
  $sth->execute();
  $result = $sth->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}

// удаляет вопросы из таблицы questions
function deleteQuestions($categoryId) 
{
  include ('dbconnect.php');
  $sth = $pdo->prepare("DELETE questions  FROM questions WHERE questions.category_id = :category_id");
  $sth->execute([
    ':category_id' => $categoryId
  ]);
}

// удаляет категорию из таблицы categories
function deleteCategory($categoryId) 
{
  include ('dbconnect.php');
  $sth = $pdo->prepare("DELETE categories FROM  categories WHERE categories.id = :category_id ");
  $sth->execute([
    ':category_id' => $categoryId
  ]);
}

// добавляет категорию в таблицу categories
function addCategory($newCategory)
{
  // проверка на существование введеной темы
  include ('dbconnect.php');
  $sth = $pdo->prepare("SELECT title FROM categories WHERE title = :title LIMIT 1");
  $sth->execute([
    ':title' => $newCategory
  ]);
  $result = $sth->fetchAll(PDO::FETCH_ASSOC);
  
  if(count($result) === 0) {
    $sth = $pdo->prepare("INSERT INTO categories SET title = :title");
    $sth->execute([
      ':title' => $newCategory
    ]);
  } else {
    print('Данная тема уже существует, введите другую');
  }
}

// возвращает все вопросы со статусом ожидает ответа
function getQuestions()
{
  include ('dbconnect.php');
  $sth = $pdo->prepare("
    SELECT 
      q.id as id, 
      q.title as title, 
      q.category_id as category_id,
      с.title as category,
      q.date_added as date_added,
      s.status as status
    FROM questions q
    INNER JOIN statuses s
      ON q.status_id = s.id AND q.status_id='1'
    INNER JOIN categories с
      ON q.category_id = с.id 
      ");
  $sth->execute();
  $result = $sth->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}

// возращает массив статусов
function getStatuses()
{
  include ('dbconnect.php');
  $sth = $pdo->prepare("SELECT * FROM statuses");
  $sth->execute();
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

//меняет статус 
function changeStatus($newStatusId, $questionId)
{
  include ('dbconnect.php');
  $sth = $pdo->prepare("UPDATE questions SET status_id = :status_id WHERE id = :id LIMIT 1");
  $sth->execute([
    ":status_id" => $newStatusId,
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
  <title>Кабинет администратора</title>
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

  <h3>Кабинет администратора</h3>

  <h3>Имя администратора: <?php echo $_SESSION['login']?></h3>
  <hr/>

  <a href="admins.php">Список администраторов</a>
  <hr/>

  <h3>Список тем:</h3>
  <?php if (count($result) > 0): ?>
    <table>
      <thead>
      <tr>
        <th>ID темы</th>
        <th>Название темы</th>
        <th>Кол-во вопросов</th>
        <th>Опубликованные</th>
        <th>Без ответа</th>
        <th>Скрытые</th>
        <th>Посмотреть все вопросы</th>
        <th>Удалить тему со всеми вопросами</th>
      </tr>
      </thead>
      <tbody>
      <?php foreach ($result as $item): ?>
        <tr>
        <form action="adminInterface.php" method="post">
          <?php foreach ($item as $key => $value): ?>
            <td>
              <span><?php echo $value?></span>
            </td>
          <?php endforeach; ?>
          <td>
            <a href="category.php?categoryId=<?php echo $item['id']?>">Посмотреть</a>
          </td>
          <td>
            <input type="hidden" name="categoryId" value="<?php echo $item['id']?>"/>
             <input type="submit" name="delete" value="Удалить"/>
          </td>
          </form>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>Тем нет</p>
  <?php endif; ?>

  <h3>Добавить новую тему</h3>
  <form action="adminInterface.php" method="post">
    <legend>Введите название</legend>
    <input type="text" name="newCategory" required/>
    <br/>
    <input type="submit" name="add" value="Добавить"/>
  </form>

  <hr/>
  <h3>Список всех вопросов без ответа:</h3>
  <?php if (count($questions) > 0): ?>
    <table>
      <thead>
      <tr>
        <th>ID вопроса</th>
        <th>Заголовок вопроса</th>
        <th>Категория</th>
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
        <form action="adminInterface.php" method="post">
          <?php foreach ($question as $key => $value): ?>
            <?php if ($key === 'category_id') { 
              continue;
             } else { ?>
             <td><span><?php echo $value?></span></td>
            <?php } ?>
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
            <a href="question.php?categoryId=<?php echo $question['category_id']?>&questionId=<?php echo $question['id']?>">Редактировать</a>
          </td>
          <td>
            <input type="hidden" name="questionId" value="<?php echo $question['id']?>"/>
            <input type="submit" name="deleteQuestion" value="Удалить"/>
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