<?php

class Status
{
  /**
   * Returns an array of statuses
   * @return array
   */
  public function getStatuses(): array
  {
    $sth = Di::get()->db()->prepare("SELECT id, status FROM statuses");
    $sth->execute();
    return $sth->fetchAll(PDO::FETCH_ASSOC);
  }
}