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
<a href="index.php?c=front&a=sendQuestion">Задать вопрос</a>

<h3>Список категорий:</h3>

<form action="index.php?c=front&a=categories&categoryId=<?php echo $activeCategory?>" method="POST">
  <button type="submit" name="categoryId" value="all">Все категории</button> 
  <?php foreach($categories as $category) {?>
    <button type="submit" name="categoryId" value="<?php echo $category['id']?>"><?php echo $category['title']?></button>
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