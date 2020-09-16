Create database project


use project


CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL UNIQUE AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL UNIQUE,
  `password` varchar(100) NOT NULL,
  `avatar` varchar(50) DEFAULT NULL,
  `kinds` int(1) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `user` (
  `user_id` int(11) NOT NULL UNIQUE AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL UNIQUE,
  `password` varchar(100) NOT NULL,
  `phone_number` varchar(10) DEFAULT NULL,
  `avatar` varchar(50) DEFAULT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `post` (
  `post_id` int(11) NOT NULL UNIQUE AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `detail_description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`post_id`),
  FOREIGN KEY (`admin_id`) REFERENCES `admin`(`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `like` (
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`),
  FOREIGN KEY (`post_id`) REFERENCES `post`(`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `comment` (
  `comment_id` int(11) NOT NULL UNIQUE AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created` datetime NOT NULL,
  FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`),
  FOREIGN KEY (`post_id`) REFERENCES `post`(`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `category` (
  `category_id` int(11) NOT NULL UNIQUE AUTO_INCREMENT,
  `name` varchar(100) NOT NULL UNIQUE,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `category_post` (
  `post_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  FOREIGN KEY (`post_id`) REFERENCES `post`(`post_id`),
  FOREIGN KEY (`category_id`) REFERENCES `category`(`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;