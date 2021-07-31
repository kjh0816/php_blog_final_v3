DROP DATABASE php_blog;

 

CREATE DATABASE php_blog;

 

USE php_blog;

 

 

CREATE TABLE `member`(

	id INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,

	delStatus INT(1) UNSIGNED NOT NULL,

	regDate DATETIME NOT NULL,

	updateDate DATETIME NOT NULL,

	loginId CHAR(20) NOT NULL,

	loginPw CHAR(100) NOT NULL,

	`name` CHAR(20) NOT NULL,

	nickname CHAR(20) NOT NULL,

	cellphoneNo CHAR(20) NOT NULL,

	email CHAR(100) NOT NULL

);

 

CREATE TABLE board(

    id INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,

    regDate DATETIME NOT NULL,

    updateDate DATETIME NOT NULL,

    memberId INT(10) UNSIGNED NOT NULL,

    `name` VARCHAR(100) NOT NULL,

    `code` VARCHAR(100) NOT NULL

);

 

 

 

CREATE TABLE article(

	id INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,

	regDate DATETIME NOT NULL,

	updateDate DATETIME NOT NULL,

	memberId INT(10) UNSIGNED NOT NULL,

	boardId INT(10) UNSIGNED NOT NULL,

	liked INT(10) UNSIGNED NOT NULL,

	`count` INT(10) UNSIGNED NOT NULL,

	title VARCHAR(100) NOT NULL,

	`body` TEXT NOT NULL

);

 

CREATE TABLE articleLiked(

	memberId INT(10) UNSIGNED NOT NULL,

	articleId INT(10) UNSIGNED NOT NULL,

	digitalCode INT(1) UNSIGNED NOT NULL

);

 

 

CREATE TABLE reply(

	id INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,

	regDate DATETIME NOT NULL,

	updateDate DATETIME NOT NULL,

	memberId INT(10) UNSIGNED NOT NULL,

	relTypeCode VARCHAR(100) NOT NULL,   # relTypeCode = 'article' 고정

	relId INT(10) UNSIGNED NOT NULL,     # relId = 게시물 id 

	liked INT (10) UNSIGNED NOT NULL,

	`body` TEXT NOT NULL

);

 

CREATE TABLE replyLiked(

	memberId INT(10) UNSIGNED NOT NULL,

	articleId INT(10) UNSIGNED NOT NULL,

	replyId INT(10) UNSIGNED NOT NULL,

	digitalCode INT(1) UNSIGNED NOT NULL

);

 

# 관리자 멤버

INSERT INTO `member`

SET regDate = NOW(),

updateDate = NOW(),

delStatus = 0,

loginId = 'admin',

loginpw = 'adjhmin',

`name` = '관리자',

nickname = '관리자',

cellphoneNo = '010-4921-9810',

email = 'readshot2@gmail.com';

 

 

 

INSERT INTO `member`

SET regDate = NOW(),

updateDate = NOW(),

delStatus = 0,

loginId = 'user1',

loginpw = 'user1',

`name` = 'user1_name',

nickname = 'user1_nickname',

cellphoneNo = '010-1234-1234',

email = 'test1@test.com';

 

INSERT INTO `member`

SET regDate = NOW(),

updateDate = NOW(),

delStatus = 0,

loginId = 'user2',

loginpw = 'user2',

`name` = 'user2_name',

nickname = 'user2_nickname',

cellphoneNo = '010-1234-1234',

email = 'test1@test.com';

 

 

 

 

INSERT INTO board

SET regDate = NOW(),

updateDate = NOW(),

memberId = 1,

`name` = '공지',

`code` = 'notice';

 

INSERT INTO board

SET regDate = NOW(),

updateDate = NOW(),

memberId = 1,

`name` = '자유',

`code` = 'free';

 

 

INSERT INTO article

SET regDate = NOW(),

updateDate = NOW(),

memberId = 1,

boardId = 1,

liked = 0,

`count`= 0,

title = '제목1',

`body`= '내용1';

 

INSERT INTO article

SET regDate = NOW(),

updateDate = NOW(),

memberId = 1,

boardId = 2,

liked = 0,

`count`= 0,

title = '제목2',

`body`= '내용2';

 

INSERT INTO article

SET regDate = NOW(),

updateDate = NOW(),

memberId = 1,

boardId = 2,

liked = 0,

`count`= 0,

title = '제목3',

`body`= '내용3';

 

INSERT INTO article

SET regDate = NOW(),

updateDate = NOW(),

memberId = 1,

boardId = 2,

liked = 0,

`count`= 0,

title = '제목4',

`body`= '내용4';

 

INSERT INTO article

SET regDate = NOW(),

updateDate = NOW(),

memberId = 1,

boardId = 2,

liked = 0,

`count`= 0,

title = '제목5',

`body`= '내용5';

 

 

 

INSERT INTO reply

SET regDate = NOW(),

updateDate = NOW(),

memberId = 1,

relTypeCode = 'article',

relId = 1,

liked = 0,

`body` = '게시물1_댓글1';

 

INSERT INTO reply

SET regDate = NOW(),

updateDate = NOW(),

memberId = 1,

relTypeCode = 'article',

relId = 1,

liked = 0,

`body` = '게시물1_댓글2';

 

INSERT INTO reply

SET regDate = NOW(),

updateDate = NOW(),

memberId = 1,

relTypeCode = 'article',

relId = 1,

liked = 0,

`body` = '게시물1_댓글3';

 

 

INSERT INTO reply

SET regDate = NOW(),

updateDate = NOW(),

memberId = 1,

relTypeCode = 'article',

relId = 2,

liked = 0,

`body` = '게시물2_댓글1';

 

INSERT INTO reply

SET regDate = NOW(),

updateDate = NOW(),

memberId = 1,

relTypeCode = 'article',

relId = 2,

liked = 0,

`body` = '게시물2_댓글2';


SELECT R.body `body`
, R.liked `liked`
, R.id `replyId`
, R.relId `articleId`
, M.nickname `nickname`
, M.id `memberId`
, IFNULL((SELECT digitalCode FROM replyLiked `L`
WHERE L.articleId = 2
AND L.memberId = 2
AND L.replyId = R.id
), 100) AS `digitalCode`
FROM reply `R`
LEFT JOIN replyLiked `L`
ON R.id = L.replyId
LEFT JOIN `member` `M`
ON M.id = R.memberId
LEFT JOIN article `A`
ON A.id = L.articleId
WHERE R.relId = 2
ORDER BY R.liked DESC

