create table userLogin(
userID int(8) primary key not NULL auto_increment,
username varchar(20) not NULL unique,
password varchar(16) not NULL,
signDate date not NULL)

create table userInfo(
userID int(8) primary key not NULL,
name varchar(20) not NULL,
gender varchar(6) not NULL default "male",
birthDate date default "1993-12-18",
email varchar(100),
icon varchar(100),
signature varchar(147)
)

create table userSettings(
userID int(8) primary key not NULL,
background varchar(100)
)

create table blog(
id int(8) primary key not NULL auto_increment,
title varchar(50) not NULL default "NoTitle",
author int(8),
article TEXT(65535),
addTime datetime,
genre varchar(20)
)

create table feelings(
id int(8) primary key not NULL auto_increment,
author int(8),
article TEXT(177),
picture int(8),
addTime datetime
)

create table music(
id int(8) primary key not NULL auto_increment,
author int(8),
name varchar(30),
src varchar(200),
addTime datetime
)

create table photos(
id int(8) primary key not NULL auto_increment,
author int(8),
name varchar(30),
src varchar(200),
album int(8),
addTime datetime
)

create table photoAlbums(
id int(8) primary key not NULL auto_increment,
author int(8),
name varchar(30),
cover int(8),
addTime datetime
)

create table video(
id int(8) primary key not NULL auto_increment,
author int(8),
name varchar(30),
src varchar(200),
addTime datetime
)

create table recommand(
userID int(8),
ObType varchar(6),
relyID int(8)
)

create table following(
userID int(8),
following int(8)
)

create table closeFriends(
userID int(8),
Friends int(8)
)

create table visitLog(
userID int(8),
visitor int(8),
visitTime datetime
)

create table visitNum(
userID int(8),
num int(8)
)

create table readNum(
ObType varchar(10) not NULL,
relyID int(8) not NULL,
num int(8),
primary key (ObType,relyID)
)

create table comment(
id int(8) primary key not NULL auto_increment,
visitor int(8),
content varchar(100),
addTime datetime,
reply varchar(100),
ObType varchar(10),
relyID int(8),
haveRead varchar(3) default"NO"
)

create table retransmission(
id int(8) primary key not NULL auto_increment,
visitor int(8),
content varchar(100),
addTime datetime,
ObType varchar(10),
relyID int(8)
)

create table collect(
id int(8) primary key not NULL auto_increment,
visitor int(8),
addTime datetime,
ObType varchar(10),
relyID int(8)
)

create table message(
id int(8) primary key not NULL auto_increment,
userID int(8),
visitor int(8),
content varchar(100),
addTime datetime,
reply varchar(100),
haveRead varchar(3) default"NO"
)

create table letter(
id int(8) primary key not NULL auto_increment,
userID int(8),
visitor int(8),
content varchar(400),
addTime datetime,
haveRead varchar(3) default"NO"
)

create table newInfo(
id int(8) primary key not NULL auto_increment,
userID int(8),
infoType varchar(20),
addTime datetime
)

delimiter $$;

create trigger add_blog
after insert on blog
for each row
begin
insert into readNum values ('blog',new.id,0);
end$$

create trigger delete_blog
after delete on blog
for each row
begin
delete from readNum where ObType='blog' and relyID=old.id;
delete from comment where ObType='blog' and relyID=old.id;
delete from collect where ObType='blog' and relyID=old.id;
end$$

create trigger add_feeling
after insert on feelings
for each row
begin
insert into readNum values ('feeling',new.id,0);
end$$

create trigger delete_feeling
after delete on feelings
for each row
begin
delete from readNum where ObType='feeling' and relyID=old.id;
delete from comment where ObType='feeling' and relyID=old.id;
delete from collect where ObType='feeling' and relyID=old.id;
end$$

create trigger add_music
after insert on music
for each row
begin
insert into readNum values ('music',new.id,0);
end$$

create trigger delete_music
after delete on music
for each row
begin
delete from readNum where ObType='music' and relyID=old.id;
delete from comment where ObType='music' and relyID=old.id;
delete from collect where ObType='music' and relyID=old.id;
end$$

create trigger add_photo
after insert on photos
for each row
begin
insert into readNum values ('photo',new.id,0);
end$$

create trigger delete_photo
after delete on photos
for each row
begin
delete from readNum where ObType='photo' and relyID=old.id;
delete from comment where ObType='photo' and relyID=old.id;
delete from collect where ObType='photo' and relyID=old.id;
end$$

create trigger add_video
after insert on video
for each row
begin
insert into readNum values ('video',new.id,0);
end$$

create trigger delete_video
after delete on video
for each row
begin
delete from readNum where ObType='video' and relyID=old.id;
delete from comment where ObType='video' and relyID=old.id;
delete from collect where ObType='video' and relyID=old.id;
end$$



