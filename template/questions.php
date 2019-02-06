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

<form action="index.php?c=admin&a=logout" method="POST" style="display: inline">
  <input type="submit" name='logout' value="Выйти из аккаунта">
</form>

<a href="index.php?c=admin&a=listAll">Кабинет администратора</a>
<h3>Имя администратора: <?php echo $_SESSION['login']?></h3>
<hr />

<?php if (isset($message)) { ?>
  <h3><?php echo $message?></h3>
<?php } ?>

<h3>Категория: <?php echo $categoryName?></h3>


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
    
          <?php foreach ($question as $key => $value): ?>
            <td><span><?php echo $value?></span></td>
          <?php endforeach; ?>
            <td>
            <form action="index.php?c=admin&a=questionChangeStatus" method="post">
              <input type="hidden" name="categoryId" value="<?php echo $categoryId?>"/>
              <input type="hidden" name="questionId" value="<?php echo $question['id']?>"/>
              <select name="newStatusId">
              <?php foreach($statuses as $status) { ?>
                <option value="<?php echo $status['id'] ?>" <?php if($status['status'] === $question['status']) :?>selected<?php endif?>><?php echo $status['status'] ?></option>
              <?php } ?>
              </select>
              <input type="submit" name="changeStatus" value="Изменить"/>
            </form>
            </td>
            <td>
              <a href="index.php?c=admin&a=questionEdit&categoryId=<?php echo $categoryId?>&questionId=<?php echo $question['id']?>">Редактировать</a>
            </td>
            <td>
            <form action="index.php?c=admin&a=questionDelete" method="post">
              <input type="hidden" name="categoryId" value="<?php echo $categoryId?>"/>
              <input type="hidden" name="questionId" value="<?php echo $question['id']?>"/>
              <input type="submit" name="delete" value="Удалить"/>
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