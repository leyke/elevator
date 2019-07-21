create table order
(
	id serial,
	elevator_id integer,
	floor integer,
	datetime timestamp,
	status integer,
	direction integer
);