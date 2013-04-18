drop table ausleiher;
drop table zubehoer;
drop table ausleihobjekt;
drop table ausleihe;
drop table verleiher;

create table ausleiher(
	matrikel integer unique,
	name varchar(50), 
	vorname varchar(50),
	email varchar(50),
	telefon varchar(20),
	postleitzahl numeric(5,0),
	strasse varchar(50),
	hausnummer integer,
	primary key (matrikel)
	);
	
create table verleiher(
	verleiherid serial,
	name varchar(50),
	vorname varchar(50),
	primary key (verleiherid)
	);
	
create table ausleihe(
	ausleihid serial,
	matrikel integer,
	verleiherid serial,
	von date,
	bis date,
	ausleihe boolean,
	objekte integer[],
	primary key(ausleihid),
	foreign key (matrikel) references ausleiher
	on delete cascade
	on update cascade,
	foreign key (verleiherid) references verleiher
	on delete cascade
	on update cascade
	);
	
create table ausleihobjekt(
	objektid serial,
	name varchar(50) unique,
	zubehoer integer[],
	primary key (objektid)
	);
	
create table zubehoer(
	zubehoerid serial,
	objektid serial,
	name varchar(50),
	primary key (zubehoerid),
	foreign key (objektid) references ausleihobjekt
	on delete cascade
	on update cascade
	);
	