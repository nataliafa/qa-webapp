CREATE TABLE `admins`
(
  `id`       int(11) NOT NULL AUTO_INCREMENT,
  `login`    varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `categories`
(
  `id`    int(11) NOT NULL AUTO_INCREMENT,
  `title` tinytext NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `statuses`
(
  `id`     int(11) NOT NULL AUTO_INCREMENT,
  `status` tinytext NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `questions`
(
  `id`          smallint(6) NOT NULL AUTO_INCREMENT,
  `title`       text,
  `category_id` smallint(6) NOT NULL,
  `author_id`   smallint(6) DEFAULT NULL,
  `content`     text      NOT NULL,
  `answer`      varchar(1000)      DEFAULT NULL,
  `status_id`   smallint(6) DEFAULT 1,
  `date_added`  timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);

CREATE TABLE `authors`
(
  `id`    int(11) NOT NULL AUTO_INCREMENT,
  `name`  varchar(50)  NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
);