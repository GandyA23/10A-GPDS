INSERT INTO editorials(id,name) VALUES(1,"Pearson");
INSERT INTO editorials(id,name) VALUES(2,"Alfaomega");
INSERT INTO editorials(id,name) VALUES(3,"McGraw Hill");

INSERT INTO categories(id,name) VALUES(1,"Computing");

INSERT INTO books(id,isbn,title,description,published_date,
category_id,editorial_id)
VALUES
(1,"0136152503","How to program C++","Programming book","2005-12-21",1,1),
(2,"0136152921","Metodología de la programación","Programming book","2001-04-12",1,2),
(3,"0136136791","Fundamentos de programación","Programming book","2008-04-12",1,3);

INSERT INTO authors(id,name,first_surname,second_surname)
VALUES
(1,"Harvey","Deitel",null),
(2,"Paul","Deitel",null),
(3,"Osvaldo","Cairó","Battistutti"),
(4,"Luis","Joyanes","Aguilar"),
(5,"Ignacio","Zahonero","Martínez");

INSERT INTO author_book(author_id,book_id) VALUES(1,1);
INSERT INTO author_book(author_id,book_id) VALUES(2,1);
INSERT INTO author_book(author_id,book_id) VALUES(3,2);
INSERT INTO author_book(author_id,book_id) VALUES(4,3);
INSERT INTO author_book(author_id,book_id) VALUES(5,3);

/*
JSON

{
  "isbn": "0136152921",
  "title": "Metodología de la programación",
  "description": "Programming book",
  "published_date": "2001-04-12",
  "category_id": 1,
  "editorial_id": 2,
  "authors": [1, 2]
}

{
  "isbn": "0136152503",
  "title": "How to program C++",
  "description": "Programming book",
  "published_date": "2005-12-21",
  "category_id": 1,
  "editorial_id": 2,
  "authors": [3]
}

{
  "isbn": "0136136791",
  "title": "Fundamentos de programación",
  "description": "Programming book",
  "published_date": "2008-04-12",
  "category_id": 1,
  "editorial_id": 3,
  "authors": [4, 5]
}

*/