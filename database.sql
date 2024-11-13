create database user_db;
create table users (user_id int primary key auto_increment ,name varchar(50), username varchar(50), email varchar(50), password nvarchar(max));
create table user_images (user_id int , image_url nvarchar(max));
