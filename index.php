<?php

class Di
{
  private static $di = null;
  private $db;

  public static function get()
  {
    if (!self::$di) {
      self::$di = new Di();
    }
    return self::$di;
  }

  function __construct()
  {
    $this->db = new PDO('sqlite::memory:');
    $this->createTables();
    $this->insertData();
    $this->insertDemoData();
  }

  public function db()
  {
    return $this->db;
  }

  public function render($template, $params = [])
  {
    $fileTemplate = 'template/' . $template;
    if (is_file($fileTemplate)) {
      ob_start();
      if (count($params) > 0) {
        extract($params);
      }
      include $fileTemplate;
      echo ob_get_clean();
    }
  }

  private function createTables()
  {
    $this->db()->exec("
    CREATE TABLE IF NOT EXISTS admins
    (
      id       int(11) NOT NULL,
      login    varchar(150) NOT NULL,
      password varchar(150) NOT NULL,
      PRIMARY KEY (id)
    )");
    $this->db()->exec("
    CREATE TABLE IF NOT EXISTS categories
    (
      id    int(11) NOT NULL,
      title tinytext NOT NULL,
      PRIMARY KEY (id)
    )");
    $this->db()->exec("
    CREATE TABLE IF NOT EXISTS statuses
    (
      id     int(11) NOT NULL,
      status tinytext NOT NULL,
      PRIMARY KEY (id)
    )");
    $this->db()->exec("
    CREATE TABLE IF NOT EXISTS questions
    (
      id          smallint(6) NOT NULL,
      title       text,
      category_id smallint(6) NOT NULL,
      author_id   smallint(6) DEFAULT NULL,
      content     text      NOT NULL,
      answer      varchar(1000)      DEFAULT NULL,
      status_id   smallint(6) DEFAULT 1,
      date_added  timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (id)
    )");
    $this->db()->exec("
    CREATE TABLE IF NOT EXISTS authors
    (
      id    int(11) NOT NULL,
      name  varchar(50)  NOT NULL,
      email varchar(255) NOT NULL,
      PRIMARY KEY (id)
    )");
  }

  private function insertData()
  {
    $this->db()->exec("INSERT INTO admins (id, login, password) VALUES (1, 'admin', 'admin')");

    $this->db()->exec("INSERT INTO statuses (id, status) VALUES (1, 'Unanswered')");
    $this->db()->exec("INSERT INTO statuses (id, status) VALUES (2, 'Answered')");
    $this->db()->exec("INSERT INTO statuses (id, status) VALUES (3, 'Hidden')");
  }

  private function insertDemoData()
  {
    $this->db()->exec("INSERT INTO categories (id, title) VALUES (1, 'PHP')");
    $this->db()->exec("INSERT INTO categories (id, title) VALUES (2, 'JavaScript')");
    $this->db()->exec("INSERT INTO categories (id, title) VALUES (3, 'React')");
    $this->db()->exec("INSERT INTO categories (id, title) VALUES (4, 'HTML5')");

    $this->db()->exec("INSERT INTO authors (id, name, email) VALUES (1, 'Marianne Fields', 'marianne.fields@example.com')");
    $this->db()->exec("INSERT INTO authors (id, name, email) VALUES (2, 'Gilbert Sanders', 'gilbert.sanders@example.com')");
    $this->db()->exec("INSERT INTO authors (id, name, email) VALUES (3, 'Vince Holmwood', 'vince.holmwood@example.com')");
    $this->db()->exec("INSERT INTO authors (id, name, email) VALUES (4, 'Séraphine Dyson', 'séraphine.dyson@example.com')");
    $this->db()->exec("INSERT INTO authors (id, name, email) VALUES (5, 'Perce Saylor', 'perce.saylor@example.com')");
    $this->db()->exec("INSERT INTO authors (id, name, email) VALUES (6, 'Campbell Blackburn', 'campbell.blackburn@example.com')");
    $this->db()->exec("INSERT INTO authors (id, name, email) VALUES (7, 'Valeria Haywood', 'valeria.haywood@example.com')");
    $this->db()->exec("INSERT INTO authors (id, name, email) VALUES (8, 'Johnny Ash', 'johnny.ash@example.com')");
    $this->db()->exec("INSERT INTO authors (id, name, email) VALUES (9, 'Fanny Holland', 'fanny.holland@example.com')");
    $this->db()->exec("INSERT INTO authors (id, name, email) VALUES (10, 'Tatjana Williams', 'tatjana.williams@example.com')");
    $this->db()->exec("INSERT INTO authors (id, name, email) VALUES (11, 'Hiroko Schuster', 'hiroko.schuster@example.com')");
    $this->db()->exec("INSERT INTO authors (id, name, email) VALUES (12, 'Idella Leclair', 'idella.leclair@example.com')");
    $this->db()->exec("INSERT INTO authors (id, name, email) VALUES (13, 'Aglaya Goebel', 'aglaya.goebel@example.com')");
    $this->db()->exec("INSERT INTO authors (id, name, email) VALUES (14, 'Marion Strong', 'marion.strong@example.com')");
    $this->db()->exec("INSERT INTO authors (id, name, email) VALUES (15, 'Wendell Monette', 'wendell.monette@example.com')");
    $this->db()->exec("INSERT INTO authors (id, name, email) VALUES (16, 'Danica Steffen', 'danica.steffen@example.com')");
    $this->db()->exec("INSERT INTO authors (id, name, email) VALUES (17, 'Maxi Fuhrmann', 'maxi.fuhrmann@example.com')");

    $this->db()->exec("INSERT INTO questions (id, title, category_id, author_id, content, answer, status_id, date_added) VALUES (2, 'Global variables', 1, 2, 'What is a global variable?', 'Global variables are built-in variables that are always available in all scopes', 2, '2019-04-26 15:10:28')");
    $this->db()->exec("INSERT INTO questions (id, title, category_id, author_id, content, answer, status_id, date_added) VALUES (3, 'Sessions', 1, 3, 'What are the sessions used for?', 'Sessions are a simple way of storing information for individual users with a unique session ID. This can be used to store state between page requests. Session IDs are usually sent to the browser via a session cookie and are used to retrieve available session data. If there is no session id or session cookie, it tells PHP to create a new session and generate a new session id.', 2, '2019-04-26 15:15:20')");
    $this->db()->exec("INSERT INTO questions (id, title, category_id, author_id, content, answer, status_id, date_added) VALUES (7, 'Redux', 3, 7, 'What problem does Redux solve?', 'Manage the status (data) of your entire application.', 2, '2020-02-12 12:06:04')");
    $this->db()->exec("INSERT INTO questions (id, title, category_id, author_id, content, answer, status_id, date_added) VALUES (8, 'Data types', 2, 8, 'How many data types are there in JS?', '6 data types: number, string, boolean, null, undefined, object.', 2, '2020-02-12 12:10:07')");
    $this->db()->exec("INSERT INTO questions (id, title, category_id, author_id, content, answer, status_id, date_added) VALUES (9, 'Prototype inheritance', 2, 9, 'How does prototype inheritance work?', 'All objects in JavaScript have a prototype property which is a reference to another object. When an object property is accessed, and if the property is not found in that object, the JavaScript engine looks at the prototype object, then the prototype prototype, and so on. Until it finds a particular property on one of the prototypes, or until it reaches the end of the prototype chain', 2, '2020-02-12 12:17:26')");
    $this->db()->exec("INSERT INTO questions (id, title, category_id, author_id, content, answer, status_id, date_added) VALUES (10, 'Delegating events', 2, 5, 'What is event delegation?', 'Event delegation is a technique of adding event handlers to the parent element rather than the child element. The handler will be triggered whenever an event is triggered on the child elements thanks to an event popup in the DOM.', 2, '2020-02-12 12:20:26')");
    $this->db()->exec("INSERT INTO questions (id, title, category_id, author_id, content, answer, status_id, date_added) VALUES (11, 'setState', 3, 11, 'What does setState do?', 'The React setState call rebuilds the application and updates the DOM. React builds a copy of the DOM tree internally and when improving the application, it simply compares the previous version of the DOM to the new one, finds the changes, and effectively implements them into the interface.', 2, '2020-02-12 12:21:57')");
    $this->db()->exec("INSERT INTO questions (id, title, category_id, author_id, content, answer, status_id, date_added) VALUES (12, 'HTML5', 4, 5, 'What is HTML5?', 'HTML 5 is a new HTML standard whose main purpose is to provide any content without the use of additional plugins such as Flash, Silverlight, etc. It contains everything you need to display animations, videos, rich graphical interfaces and more.', 2, '2020-02-12 12:25:39')");
    $this->db()->exec("INSERT INTO questions (id, title, category_id, author_id, content, answer, status_id, date_added) VALUES (13, 'Component', 3, 13, 'When is a Class Component better than a Functional Component?', null, 1, '2020-02-12 12:28:49')");
    $this->db()->exec("INSERT INTO questions (id, title, category_id, author_id, content, answer, status_id, date_added) VALUES (14, 'Late static binding', 1, 14, 'What is late static binding and what is it used for?', null, 1, '2020-02-24 12:03:14')");
  }
}

include 'router/router.php';

?>