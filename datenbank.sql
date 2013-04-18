create table ausleiher(
	matrikel unique integer,
	name varchar(50); 
	vorname varchar(50);
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
	matrikel unique integer,
	verleiherid serial
	von date,
	bis date,
	objekte integer[],
	primary key(ausleihid),
	foreign key (matrikel) references ausleiher,
	foreign key (verleiherid) references verleiher
	);
	
create table ausleihobjekt(
	objektid serial,
	name unique varchar(50),
	zubehoer integer[],
	primary key (objektid)
	);
	
create table zubehoer(
	zubehoerid serial,
	objektid serial,
	name varchar(50),
	primary key (zubehoerid),
	foreign key (objektid) references ausleihobjekt
	);
	