<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Список администраторов</title>
  <style>
  .form {
    border: 1px solid grey;
    padding: 10px;
    width: 500px;
  }
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
<hr/>

<h3>Список администраторов:</h3>

<table>
  <thead>
    <tr>
      <th>ID</th>
      <th>Логин</th>
      <th>Пароль</th>
      <th>Удаление</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($admins as $admin): ?>
      <tr>
   
          <?php foreach ($admin as $key => $value): ?>
            <td>
              <?php
              if ($key === 'password') { ?>
                <form action="index.php?c=admin&a=adminChangePassword" method="post">
                  <input type="hidden" name="adminId" value="<?php echo $admin['id']?>"/>
                  <span><?php echo $value?></span>
                  <input type="text" name="newPassword" placeholder="Введите новый пароль" required/>
                  <input type="submit" name="changePassword" value="Изменить"/>
                </form>
              <?php
              } else { ?>
                <span><?php echo $value?></span>
              <?php
              }
              ?>
            </td>
          <?php endforeach; ?>
          <td>
          <form action="index.php?c=admin&a=adminDelete" method="post">
            <input type="hidden" name="adminId" value="<?php echo $admin['id']?>"/>
            <input type="submit" name="adminDelete" value="Удалить"/>
          </form>
          </td>
      
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<h3>Добавить администратора</h3>
<form action="index.php?c=admin&a=adminAdd" method="POST">
  <legend>Введите имя:</legend>
  <input type="text" name="login" required/>
  <br/>
  <legend>Введите пароль:</legend>
  <input type="text" name="password" required/>
  <br/>
  <input type="submit" name="adminAdd" value="добавить"/>
</form>

<?php if (isset($message)) { ?>
  <h3><?php echo $message?></h3>
<?php } ?>
    
</body>
</html>