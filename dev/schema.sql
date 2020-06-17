drop table users cascade;
drop table study cascade;
drop table wins cascade;

create table users (
	username varchar(20) NOT NULL,
	first varchar(20) NOT NULL,
	last varchar(20) NOT NULL,
	given varchar(20),
	gender integer NOT NULL,
	dob date NOT NULL,
	yearofstudy integer NOT NULL,
	password varchar(255) NOT NULL

);

create table study (
	username varchar(20) NOT NULL,
	study char(3) NOT NULL
);

create table wins (
	userid varchar(20) NOT NULL,
	game varchar(20) NOT NULL,
	moves integer NOT NULL,
	time double precision NOT NULL
);

ALTER TABLE ONLY study
    ADD CONSTRAINT study_pkey PRIMARY KEY (username, study);

ALTER TABLE ONLY users
    ADD CONSTRAINT users_pkey PRIMARY KEY (username);

ALTER TABLE ONLY wins
	ADD CONSTRAINT wins_pkey PRIMARY KEY (userid, game, moves, time),
	ADD CONSTRAINT wins_fkey FOREIGN KEY (userid) REFERENCES users (username);