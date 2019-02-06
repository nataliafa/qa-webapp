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
<a href="index.php?c=front&a=categories&categoryId=all">Вопросы</a>

<h2>Задать вопрос</h2>

<form action="index.php?c=front&a=sendQuestion" method="POST">
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

  <input type="submit" name="send" value="Отправить"/>
</form>

<?php if (isset($message)) { ?>
  <h3><?php echo $message?></h3>
<?php } ?>
    
</body>
</html>