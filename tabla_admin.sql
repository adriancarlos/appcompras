create table admin
(id integer(11),
 username char(50),
 passcode char(50));
 
 ALTER TABLE admin ADD CONSTRAINT pk_admin PRIMARY KEY (id);
 
 INSERT INTO admin (ID, USERNAME, PASSCODE)
 SELECT customerNumber, customerName, contactLastName FROM customers;
 
 UPDATE ADMIN SET username = trim(substr(username,1,8));