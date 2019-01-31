<?php
session_start();

$admins = getAdmins();
$message = "";

//------ Работа с полученными данными -----------

if(!empty($_POST)) {

 if (isset($_POST['add'])) {
   // добавить администратора
   // проверить нет ли уже такого логина в таблице
   $result = checkAdmin($_POST['login'], $_POST['password']);
   if (empty($result)) {
    // нет - добавляем нового администратора в таблицу
    addAdmin($_POST['login'], $_POST['password']);
   } else {
    $message = 'Данный логин занят';
   }

 } elseif (isset($_POST['delete'])) {
    // удалить администратора
    deleteAdmin($_POST['id']);

 } elseif(isset($_POST['changePassword'])) {
    // изменить пароль
    if ($_POST['newPassword'] === '') {
      // если пароль не ввели
      $message = 'Введите новый пароль';
    } else {
      changePassword($_POST['newPassword'], $_POST['id']);
    }
 }
}

//----------- Функции --------------

//возращает массив администраторов из таблицы admins
function getAdmins() {
  try {
    include ('dbconnect.php');
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); //Error Handling

    $sth = $pdo->prepare("SELECT * FROM `admins`");
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
  } catch(PDOException $e) {
    // echo $e->getMessage();
  }
  return $result;
}

// добавляет администратора в таблицу admins
function addAdmin($login, $password) 
{
  try {
    include ('dbconnect.php');
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); //Error Handling
    $sth = $pdo->prepare("INSERT INTO `admins` SET login = :login, password= :password");
    $sth->execute([
      ':login' => $login,
      ':password' => $password,
    ]);
    $sth->fetchAll(PDO::FETCH_ASSOC);
  } catch(PDOException $e) {
    // echo $e->getMessage();
  }
  header('Location: admins.php');
}

//провеяет существует введенный администратор в таблице admins
function checkAdmin($login, $password) {
  include ('dbconnect.php');
  $sth = $pdo->prepare("SELECT * FROM admins WHERE login = :login LIMIT 1");
  $sth->execute([
    ':login' => $login,
  ]);
  $result = $sth->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}

// удаляет администратора из таблицы admins
function deleteAdmin($id) 
{
  include ('dbconnect.php');
  $sth = $pdo->prepare("DELETE FROM `admins` WHERE id = :id LIMIT 1");
  $sth->execute([ ":id" => $id]);
  $sth->fetchAll(PDO::FETCH_ASSOC);
  header('Location: admins.php');
}

// меняет пароль администратора в таблице admins
function changePassword($newPassword, $id) 
{
 include ('dbconnect.php');
 $sth = $pdo->prepare("UPDATE `admins` SET password= :password WHERE id = :id LIMIT 1");
 $sth->execute([ 
   ":password" => $newPassword,
   ":id" => $id
 ]);
 $sth->fetchAll(PDO::FETCH_ASSOC);
 header('Location: admins.php');
}
?>

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

<form action="logout.php" method="POST" style="display: inline">
  <input type="submit" value="Выйти из аккаунта">
</form>

<a href="adminInterface.php">Кабинет администратора</a>
<h3>Имя администратора: <?php echo $_SESSION['login']?></h3>
<hr/>
<h3><?php echo $message?></h3>

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
        <form action="admins.php" method="post">

          <?php foreach ($admin as $key => $value): ?>
            <td>
              <?php
              if ($key === 'id') { ?>
                <input type="hidden" name="id" value="<?php echo $value?>"/>
                <span><?php echo $value?></span>
              <?php
              } elseif ($key === 'password') { ?>
                <span><?php echo $value?></span>
                <input type="text" name="newPassword" placeholder="Введите новый пароль"/>
                <input type="submit" name="changePassword" value="Изменить"/>
                <?php
              } else { ?>
                <span><?php echo $value?></span>
              <?php
              }
              ?>
            </td>
          <?php endforeach; ?>
          <td>
             <input type="submit" name="delete" value="Удалить"/>
          </td>
        </form>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<h3>Добавить администратора</h3>
<form action="admins.php" method="POST">
  <legend>Введите имя:</legend>
  <input type="text" name="login" required/>
  <br/>
  <legend>Введите пароль:</legend>
  <input type="text" name="password" required/>
  <br/>
  <input type="submit" name="add" value="добавить"/>
</form>
    
</body>
</html>