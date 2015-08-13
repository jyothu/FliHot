CREATE TABLE `cities` (
`id` bigint(12) NOT NULL AUTO_INCREMENT,
`name` varchar(255) NOT NULL,
PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `hotels` (
`id` bigint(12) NOT NULL,
`city_id` bigint(12) NOT NULL,
`name` varchar(255) NOT NULL,
PRIMARY KEY (id),
FOREIGN KEY (city_id)
  REFERENCES cities(id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `airports` (
`id` bigint(12) NOT NULL AUTO_INCREMENT,
`country` varchar(255) NOT NULL,
`name` varchar(255) NOT NULL,
`code` varchar(255) NOT NULL,
PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;