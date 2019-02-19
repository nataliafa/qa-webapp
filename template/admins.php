<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Список администраторов</title>
  <link rel="stylesheet" href="template/css/style.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,600,700" rel="stylesheet">
</head>
<body>

  <section class="menuAdmin">
    <div class="menuAdmin__admin">
      <img src="template/i/admin_logo.png" alt=""/>
      <p class="menuAdmin__admin-name"><?php echo $_SESSION['login']?></p>
    </div>
    <a class="menuAdmin__link" href="index.php?c=admin&a=main">Общее</a>
    <a class="menuAdmin__link menuAdmin__link-active" href="index.php?c=admin&a=adminList">Администраторы</a>
    <a class="menuAdmin__link" href="index.php?c=admin&a=categoryList">Категории</a>
    <a class="menuAdmin__link" href="index.php?c=admin&a=questionsWithoutAnswer">Вопросы без ответа</a>
    <form class="menuAdmin__exit" action="index.php?c=admin&a=logout" method="post" >
      <input class="menuAdmin__exit-button" type="submit" name='logout' value="Выйти">
    </form>
  </section>

  <div class="content">
    
    <?php if (isset($message)) { ?>
      <h3 class="error"><?php echo $message?></h3>
    <?php } ?>

    <section class="content__item">
      <h2 class="content__title">Добавить администратора:</h2>

      <div class="content__container">
        <form class="form-add form-content-space-between" action="index.php?c=admin&a=adminAdd" method="post">
          <legend class="form-legend">Введите имя:</legend>
          <input class="input" type="text" name="login" required/>

          <legend class="form-legend">Введите пароль:</legend>
          <input class="input" type="text" name="password" required/>
   
          <input class="button-add" type="submit" name="adminAdd" value="Добавить"/>
        </form>
      </div>
    </section>
  
    <section class="content__item content__line">
      <h2 class="content__title">Список администраторов:</h2>
      <div class="content__container">
        <table>
          <tr>
            <th>ID</th>
            <th>Логин</th>
            <th>Пароль</th>
            <th>Новый пароль</th>
            <th>Удаление</th>
          </tr>
          <?php foreach ($admins as $admin): ?>
            <tr>
              <?php foreach ($admin as $key => $value): ?>
              <td><span><?php echo $value?></span></td>
              <?php endforeach; ?>
              <td>
                <form action="index.php?c=admin&a=adminChangePassword" method="post">
                    <input type="hidden" name="adminId" value="<?php echo $admin['id']?>"/>
                    <input class="input" type="text" name="newPassword" placeholder="Введите новый пароль" required/>
                    <input class="button-delete-change" type="submit" name="changePassword" value="Изменить"/>
                  </form>
              </td>
              <td>
                <form action="index.php?c=admin&a=adminDelete" method="post">
                  <input type="hidden" name="adminId" value="<?php echo $admin['id']?>"/>
                  <input class="button-delete-change" type="submit" name="adminDelete" value="Удалить"/>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </table>
      </div>
    </section>

  </div>  
</body>
</html>