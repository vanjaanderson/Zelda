--
-- Database: Zelda
--
-- 
-- Drop tables and views. Needs to be  
-- done in correct order due to foreign 
-- key constraints. 
-- 
DROP TABLE IF EXISTS User2Groups; 
DROP TABLE IF EXISTS Groups; 
DROP TABLE IF EXISTS User; 
DROP TABLE IF EXISTS Guestbook;
DROP TABLE IF EXISTS Content;

-- --------------------------------------------------------

--
-- Table structure for table Groups
--

CREATE TABLE Groups (
  id INT NOT NULL AUTO_INCREMENT,
  acronym VARCHAR(24) UNIQUE NOT NULL,
  name VARCHAR(80) NOT NULL,
  created DATETIME NOT NULL,
  updated DATETIME DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table Groups
--

INSERT INTO Groups (id, acronym, name, created, updated) VALUES
(1, 'admin', 'Administratorgruppen', NOW(), NULL),
(2, 'user', 'Användargruppen', NOW(), NULL);

-- --------------------------------------------------------

--
-- Table structure for table Guestbook
--

CREATE TABLE Guestbook (
  id INT NOT NULL AUTO_INCREMENT,
  entry TEXT,
  created DATETIME NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table User
--

CREATE TABLE User (
  id INT NOT NULL AUTO_INCREMENT,
  acronym VARCHAR(24) UNIQUE NOT NULL,
  name VARCHAR(80) NOT NULL,
  email VARCHAR(80) NOT NULL,
  algorithm CHAR(40) NOT NULL,
  salt CHAR(40) NOT NULL,
  password VARCHAR(40) NOT NULL,
  created DATETIME NOT NULL,
  updated DATETIME DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table User
--

INSERT INTO User (id, acronym, name, email, algorithm, salt, password, created, updated) VALUES
(1, 'Anonym', 'Anonym användare, inte autentiserad', 'email@email.se', 'plain', '', 'Anonym', NOW(), NULL),
(2, 'root', 'Administrator', 'root@dbwebb.se', 'sha1salt', '2da218b93b5da10f2428b0acdfad55c3f80b6058', '45e1c6a65533d2e61915afb88119657fef8cb813', NOW(), NULL);

-- --------------------------------------------------------

--
-- Table structure for table Content
--

CREATE TABLE Content (
  id INT NOT NULL AUTO_INCREMENT,
  key VARCHAR(24) UNIQUE NOT NULL,
  type CHAR(40) NOT NULL,
  filter VARCHAR(40) NOT NULL,
  title VARCHAR(40) NOT NULL,
  data TEXT NOT NULL,
  idUser INT NOT NULL,
  created DATETIME NOT NULL,
  updated DATETIME DEFAULT NULL,
  deleted DATETIME DEFAULT NULL,  
  FOREIGN KEY(idUser) REFERENCES User(id) ON DELETE CASCADE ON UPDATE CASCADE,
  PRIMARY KEY (id)   
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table Content
--

INSERT INTO Content VALUES(1,'welcome-to-zelda','page','markdownextra','Välkommen till Zelda','Denna sida är förinställd att visas i menyn.

Ändra innehållet till det du vill, eller skapa en ny sida som du sedan bestämmer ska vara defaultsida (i filen <code>site/themes/mytheme/my_config.php</code>).',1,NOW(),NULL,NULL);
INSERT INTO Content VALUES(2,'ett-rykande-farskt-inlagg','post','markdownextra','Ett rykande färskt inlägg','Detta är ett demoinlägg för att se hur ett sådant ser ut.

Du skapar nya inlägg, raderar eller redigerar de som finns.

Använder du markdownextra som filter, kan du skriva rubriker, fet text, kursiv text etc, på ett enkelt sätt. Se sidan med [CTextFilter](/Zelda-master/page/view/4/).

Ett stort lycka till!',1,NOW(),NULL,NULL);
INSERT INTO Content VALUES(3,'hello-world-once-more','post','plain','Hej världen, återigen','Ytterligare ett demoinlägg.',1,NOW(),NULL,NULL);
INSERT INTO Content VALUES(4,'Filter test','page','plain','Testsida CTextFilter','Här kan du testa olika filter genom att redigera sidan, se längst ner ovanför foten.

Med filtret Plain, som är default, konverteras ingen kod i texten. Men generellt görs en tom rad vid radbrytning med enter. Detta sköter funktionen nl2p() om.

Med filtret Make Clickable så görs textsträngar med http://xxx eller https://xxx automatiskt klickbara.

Med filtret Smarty Pants (Typographer) konverteras texten till typografiskt riktiga tecken. Bland annat blir citattecken och tankstreck (två bindestreck) snyggare. Tusentalsavgränsare blir icke brytande mellanslag. Exempel: 20 000 000 000 000 000 000 000 000 000 000 000 000 -- 100 000 000 000 000 000 000 000 000 000 000 000 000 kommer ej att radbrytas mellan siffergrupperna och får ett snyggt från -- till tecken (m dash).

[h2]BBCode[/h2]
Med filtret BBCode kan du formattera [b]fet text[/b], [i]kursiv text[/i] eller länk till [url=http://vanjaanderson.com]vanjaanderson.com[/url].
Du kan även infoga bilder, såsom Zelda favicon: [img]http://www.student.bth.se/~vaan12/phpmvc/kmom04/zelda/themes/core/favicon_32x32.png[/img]

<h2>HTML Purifier</h2>
Med filtret HMTL Purifier kan du formattera <b>fet text</b>, <i>kursiv text</i> eller länk till <a href=http://vanjaanderson.com>vanjaanderson.com</a>. 
JavaScript-taggar: <javascript>alert(hej);</javascript> kommer att tas bort.

Markdown (Extra)
------------------
Med filtret Markdown Extra kan man formattera **fet text**, *kursiv text* eller länk till [vanjaanderson.com](http://vanjaanderson.com) på ett enkelt sätt. Vanliga HTML-taggar fungerar också, vilket gör att html-taggarna i HTML Purifier-stycket även fungerar med detta filter.

###Onumrerad lista
* Gordon
* Iggy
* Sixten
* Baloo

###Numrerad lista
1. Gordon
2. Iggy
3. Sixten
4. Baloo

###Blockcitat
> Katter är sköna typer!

###Tabell
| Namn (vänsterställd) | Ras (centrerad) | Färg (högerställd) |
|:---------------------|:---------------:|-------------------:|
| Gordon               | Devon Rex       | Rödspotted         |
| Iggy                 | Devon Rex       | Svart smoke        |
| Sixten               | Huskatt         | Svart/Grå          |
| Baloo                | Huskatt         | Grå                | ',1,NOW(),NULL,NULL);

-- --------------------------------------------------------

--
-- Table structure for table User2Groups
--

CREATE TABLE User2Groups (
  idUser INT NOT NULL,
  idGroups INT NOT NULL,
  created DATETIME NOT NULL,  
  FOREIGN KEY(idUser) REFERENCES User(id) ON DELETE CASCADE ON UPDATE CASCADE, 
  FOREIGN KEY(idGroups) REFERENCES Groups(id) ON UPDATE CASCADE,  
  PRIMARY KEY (idUser,idGroups)   
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Dumping data for table User2Groups
--

INSERT INTO User2Groups (idUser, idGroups, created) VALUES
(2, 1, NOW()),
(2, 2, NOW());


