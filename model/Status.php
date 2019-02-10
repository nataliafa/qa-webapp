<?php

class Status
{
  // возвращает массив статусов
  public function getStatuses()
  {
    $sth = Di::get()->db()->prepare("SELECT id, status FROM statuses");
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
}
?>