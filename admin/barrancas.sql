create table IF NOT EXISTS arboles(id int not null AUTO_INCREMENT,nombre varchar(255), longitud varchar(255), latitud varchar(255), foto varchar(255), fecha date, revisado int, notas varchar(1023), primary key(id));
create table IF NOT EXISTS contenido(id int not null AUTO_INCREMENT,tipo varchar(255), contenido varchar(255), primary key(id));
create table IF NOT EXISTS galeria(id int not null AUTO_INCREMENT,nombre varchar(255), foto varchar(255), primary key(id));
create table IF NOT EXISTS userTypes(id int not null AUTO_INCREMENT,name varchar(255), primary key(id));
create table IF NOT EXISTS users(id int not null AUTO_INCREMENT,user varchar(255), pass varchar(255), type int, foreign key(type) references userTypes(id), primary key(id));
INSERT INTO userTypes(name) VALUES ('System Administrator');
INSERT INTO userTypes(name) VALUES ('User');            
INSERT INTO users(user, pass, type ) VALUES ('admin',  'admin', 1);