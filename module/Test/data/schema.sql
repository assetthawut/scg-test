CREATE TABLE `message` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `text` varchar(25) NULL DEFAULT NULL,
    `response` varchar(25) NULL DEFAULT NULL,
    `created_at` datetime,
    `updated_at` datetime,
    `deleted_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;