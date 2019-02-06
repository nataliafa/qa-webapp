<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>

<form action="index.php?c=admin&a=logout" method="POST" style="display: inline">
  <input type="submit" name='logout' value="Выйти из аккаунта">
</form>

<a href="index.php?c=admin&a=listAll">Кабинет администратора</a>

<h2>Имя администратора: <?php echo $_SESSION['login']?></h2>
<hr/>

<p>ID Вопроса: <?php echo $question['id']?></p>
<p>Дата и время добавления: <?php echo $question['date_added']?></p>

<form action="index.php?c=admin&a=questionEdit&categoryId=<?php echo $question['category_id']?>&questionId=<?php echo $question['id']?>" method="POST">

  <span>Категория:</span>
  <select name="newCategory">
  <?php foreach($categories as $category) { ?>
    <option value="<?php echo $category['id'] ?>" <?php if($category['title'] === $question['category']) :?>selected<?php endif?>><?php echo $category['title'] ?></option>
  <?php } ?>
  </select>
  <br/>

  <span>Статус: <?php echo $question['status']?></span>
  <br/>
 
  <span>Автор: </span>
  <input type="hidden" name="authorName" value="<?php echo $question['author_name']?>"/>
  <input type="text" name="newAuthorName" value="<?php echo $question['author_name']?>"/>
  <br/>

  <span>Заголовок вопроса:</span>
  <input type="text" name="newTitle" value="<?php echo $question['title']?>"/>
  <br/>

  <p>Контент вопроса:</p>
  <textarea name="newContent" cols="50" rows="10"><?php echo $question['content']?></textarea>
  <br/>

  <p>Ответ на вопрос:</p>
  <textarea name="newAnswer" cols="50" rows="10"><?php echo $question['answer']?></textarea>
  <br/>

<br/>
<input type="submit" name="publish" value="Опубликовать"/>
<input type="submit" name="hide" value="Скрыть"/>

</form>

<?php if (isset($message)) { ?>
  <h3><?php echo $message?></h3>
<?php } ?>


    
</body>
</html>