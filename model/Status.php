<?php

class Status
{
  public function getStatuses()
  {
    $sth = Di::get()->db()->prepare("SELECT * FROM statuses");
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
}
?>