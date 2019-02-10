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

  <form action="index.php?c=admin&a=logout" method="POST" style="display: inline">
    <input type="submit" name='logout' value="Выйти из аккаунта">
  </form>

  <h3>Кабинет администратора</h3>

  <h3>Имя администратора: <?php echo $_SESSION['login']?></h3>
  <hr/>

  <?php if (isset($message)) { ?>
  <h3><?php echo $message?></h3>
<?php } ?>

  <a href="index.php?c=admin&a=adminList">Список администраторов</a>
  <hr/>

  <h3>Список тем:</h3>
  <?php if (count($categories) > 0): ?>
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
      <?php foreach ($categories as $item): ?>
        <tr>
        
          <?php foreach ($item as $key => $value): ?>
            <td>
              <span><?php echo $value?></span>
            </td>
          <?php endforeach; ?>
          <td>
            <a href="index.php?c=admin&a=questionList&categoryId=<?php echo $item['id']?>">Посмотреть</a>
          </td>
          <td>
            <form action="index.php?c=admin&a=categoryQuestionsDelete" method="post">
              <input type="hidden" name="categoryId" value="<?php echo $item['id']?>"/>
              <input type="submit" name="delete" value="Удалить"/>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>Тем нет</p>
  <?php endif; ?>

  <h3>Добавить новую тему</h3>
  <form action="index.php?c=admin&a=categoryAdd" method="post">
    <legend>Введите название</legend>
    <input type="text" name="newCategory" required/>
    <br/>
    <input type="submit" name="categoryAdd" value="Добавить"/>
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
          <?php foreach ($question as $key => $value): ?>
            <?php if ($key === 'category_id') { 
              continue;
             } else { ?>
             <td><span><?php echo $value?></span></td>
            <?php } ?>
          <?php endforeach; ?>
          <td>
          <form action="index.php?c=admin&a=listAllChangeStatus" method="post">
            <input type="hidden" name="questionId" value="<?php echo $question['id']?>"/>
            <select name="newStatusId">
            <?php foreach ($statuses as $status) { ?>
              <option value="<?php echo $status['id'] ?>" <?php if($status['status'] === $question['status']) :?>selected<?php endif?>><?php echo $status['status'] ?></option>
            <?php } ?>
            </select>
            <input type="submit" name="changeStatus" value="Изменить"/>
          </form>
          </td>
          <td>
            <a href="index.php?c=admin&a=questionEdit&categoryId=<?php echo $question['category_id']?>&questionId=<?php echo $question['id']?>">Редактировать</a>
          </td>
          <td>
            <form action="index.php?c=admin&a=listAllQuestionDelete" method="post">
              <input type="hidden" name="questionId" value="<?php echo $question['id']?>"/>
              <input type="submit" name="deleteQuestion" value="Удалить"/>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>Вопросов нет</p>
  <?php endif; ?>

</body>
</html>