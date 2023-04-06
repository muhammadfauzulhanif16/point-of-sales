CREATE TABLE `categories` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `histories` (
  `id` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `by` varchar(255) NOT NULL,
  `createdAt` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `products` (
 `id` varchar(255) NOT NULL,
 `name` varchar(255) NOT NULL,
 `quantity` int NOT NULL,
 `unitType` varchar(255) NOT NULL,
 `category` varchar(255) NOT NULL,
 `price` int NOT NULL,
 `createdAt` datetime NOT NULL,
 `updatedAt` datetime NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `rules` (
  `id` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `quantity` int NOT NULL,
  `price` int NOT NULL,
  `productId` varchar(255) NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `transactions` (
 `id` varchar(255) NOT NULL,
 `customerName` varchar(255) NOT NULL,
 `productName` varchar(255) NOT NULL,
 `category` varchar(255) NOT NULL,
 `quantity` int NOT NULL,
 `unitPrice` int NOT NULL,
 `totalPrice` int NOT NULL,
 `createdAt` datetime NOT NULL,
 `updatedAt` datetime NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `users` (
  `id` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;