<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>

<?php if (isset($message)) { ?>
  <p><?php echo $message?></p>
<?php } ?>

<h2>Форма авторизации</h2>
<form action="index.php?c=admin&a=login" method="POST">
  <legend>Введите имя администратора</legend>
  <input type="text" name="login" required/>
  <br/>
  <legend>Введите пароль</legend>
  <input type="text" name="password" required/>
  <input type="submit">
</form>

<h2>Или войдите как гость</h2>
<a href="index.php?c=front&a=categories&categoryId=all">Перейти</a>
</body>
</html>