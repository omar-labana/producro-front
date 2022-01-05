CREATE TABLE Products (
	id INT AUTO_INCREMENT NOT NULL PRIMARY key,
    sku VARCHAR(100) NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL,
  	type varchar(10) NOT NULL,
    price FLOAT NOT NULL
);

CREATE TABLE DVDS (
    product_id int UNIQUE NOT NULL,
  	size float NOT NULL,
  	FOREIGN KEY (product_id) REFERENCES Products(id) on DELETE CASCADE
);

CREATE TABLE Books (
    product_id int UNIQUE NOT NULL,
  	weight float NOT NULL,
  	FOREIGN KEY (product_id) REFERENCES Products(id) on DELETE CASCADE
);

CREATE TABLE Furniture (
    product_id int UNIQUE NOT NULL,
  	width float NOT NULL,
  	height float NOT NULL,
  	length float NOT NULL,
  	FOREIGN KEY (product_id) REFERENCES Products(id) on DELETE CASCADE
);