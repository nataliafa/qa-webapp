<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Личный кабинет</title>
  <link rel="stylesheet" href="template/css/style.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,600,700" rel="stylesheet">
</head>
<body>

  <section class="menuAdmin">
    <div class="menuAdmin__admin">
      <img src="template/i/admin_logo.png" alt=""/>
      <p class="menuAdmin__admin-name"><?php echo $_SESSION['login']?></p>
    </div>
    <a class="menuAdmin__link menuAdmin__link-active" href="index.php?c=admin&a=main">Общее</a>
    <a class="menuAdmin__link" href="index.php?c=admin&a=adminList">Администраторы</a>
    <a class="menuAdmin__link" href="index.php?c=admin&a=categoryList">Категории</a>
    <a class="menuAdmin__link" href="index.php?c=admin&a=questionsWithoutAnswer">Вопросы без ответа</a>
    <form class="menuAdmin__exit" action="index.php?c=admin&a=logout" method="post" >
      <input class="menuAdmin__exit-button" type="submit" name='logout' value="Выйти">
    </form>
  </section>
  
  <div class="content">

    <section class="content__item">
      <h2 class="content__title">Общие показания:</h2>

      <div class="content__container">
        <div id="piechart" class="content__piechart"></div>
        
        <div class="content__container-item">
          <div class="content__questions-no-answer">
            <span class="content__questions-no-answer-number"><?php echo $questions?></span>
            <span class="content__questions-no-answer-text">вопросов без ответа</span>
          </div>
          <div class="content__admins">
            <span class="content__admins-number"><?php echo $admins?></span>
            <span class="content__admins-text">администраторов</span>
          </div>
        </div>
      </div>
    </section>
  </div>
  <?php $json = json_encode($categories)?>
  <!-- Диаграмма Google  -->
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    const categories = Object.entries(JSON.parse('<?php echo $json; ?>'));
    let categoriesArray = categories.map(function (category) {
      return [category[1].title, Number(category[1].quantity_q)];
    });
    categoriesArray.unshift(['Категории', 'Вопросов в категории']);

    function drawChart() {
      var data = google.visualization.arrayToDataTable(categoriesArray);

      var options = {
        title: 'Количество вопросов в каждой категории'
      };

      var chart = new google.visualization.PieChart(document.getElementById('piechart'));

      chart.draw(data, options);
    }

  </script>
</body>
</html>
