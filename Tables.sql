create table users(
    id int auto_increment,
    login varchar(255),
    password varchar(255),
    constraint users_pk
        primary key (id)
)char set utf8
collate utf8_general_ci;

create table images(
    id int auto_increment,
    id_user int,
    file_path varchar(255),
    tags varchar(255),
    views int,
    data date,
    constraint images_pk
        primary key(id)
)char set utf8
collate utf8_general_ci;
