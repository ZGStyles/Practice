create table uploaded_text(
    id int auto_increment,
    content MEDIUMTEXT,
    date datetime,
    words_count int,
    constraint uploaded_pk
        primary key (id)
)char set utf8
collate utf8_general_ci;

create table word(
    id int auto_increment,
    text_id int,
    word varchar(255),
    count int,
    constraint word_pk
        primary key (id)
)char set utf8
collate utf8_general_ci;