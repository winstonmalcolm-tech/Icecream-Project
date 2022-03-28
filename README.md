# Icecream-Project
This project is for a icecream business where it provide the customers to view available products and make orders. The admin for the website
can prform crud operation on the website which includes: adding new product, update, delete and view products from the database. 

# MariaDb queries (phpmyadmin)
CREATE DATABASE icecreamdb;

CREATE TABLE icereamtbl (
      id int(11) not null AUTO_INCREMENT PRIMARY KEY,
      flavor varchar(50) not null,
      price varchar(20) not null,
      category varchar(50) not null
);
 
CREATE TABLE promotions (
      id int(11) not null AUTO_INCREMENT PRIMARY KEY,
      title longtext not null,
      message longtext not null,
      date tinytext not null,
      filepath longtext not null
)
      
CREATE TABLE users (
      id int(11) not null AUTO_INCREMENT PRIMARY KEY,
      username tinytext not null,
      password longtext not null
)
