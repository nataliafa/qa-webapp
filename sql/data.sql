INSERT INTO `admins` (`id`, `login`, `password`)
VALUES (1, 'admin', 'admin');

INSERT INTO `categories` (`id`, `title`)
VALUES (1, 'PHP'),
       (2, 'JavaScript'),
       (3, 'React'),
       (4, 'HTML5');

INSERT INTO `statuses` (`id`, `status`)
VALUES (1, 'Waiting for answer'),
       (2, 'Published'),
       (3, 'Hidden');