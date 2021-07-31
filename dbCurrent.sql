DROP DATABASE IF EXISTS st__2021_04_full__site03;
CREATE DATABASE st__2021_04_full__site03;
USE st__2021_04_full__site03;




CREATE TABLE `member`(
	id INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	regDate DATETIME NOT NULL,
	updateDate DATETIME NOT NULL,
	delStatus TINYINT(1) UNSIGNED NOT NULL,
	delDate DATETIME,
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

# 자유 > 기타로 워딩 변경
UPDATE board
SET `name` = '기타'
, CODE = 'else'
WHERE id = 2;

SELECT * FROM board;


# 자료구조 카테고리 추가
insert into board
set regDate = now(),
updateDate = now(),
memberId = 1,
`name` = '자료구조',
`code` = 'data structure';



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
	digitalCode TINYINT(1) UNSIGNED NOT NULL
);


CREATE TABLE reply(
	id INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	regDate DATETIME NOT NULL,
	updateDate DATETIME NOT NULL,
	memberId INT(10) UNSIGNED NOT NULL,
	relTypeCode VARCHAR(100) NOT NULL,   # relTypeCode = 'article' 고정
	relId INT(10) UNSIGNED NOT NULL,     # relId = 게시물 id 
	liked INT(10) UNSIGNED NOT NULL,
	`body` TEXT NOT NULL
);

CREATE TABLE replyLiked(
	memberId INT(10) UNSIGNED NOT NULL,
	articleId INT(10) UNSIGNED NOT NULL,
	replyId INT(10) UNSIGNED NOT NULL,
	digitalCode TINYINT(1) UNSIGNED NOT NULL
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


SELECT A.*
, IFNULL(M.nickname, '탈퇴한 회원')
, IFNULL(B.name, '삭제된 게시판')
FROM article A
LEFT JOIN `member` M
ON A.memberId = M.id
LEFT JOIN board B
ON A.boardId = B.id 
ORDER BY A.liked DESC
LIMIT 3

SELECT A.*
, IFNULL(M.nickname, '탈퇴한 회원')
, IFNULL(B.name, '삭제된 게시판')
FROM article A
LEFT JOIN `member` M
ON A.memberId = M.id
LEFT JOIN board B
ON A.boardId = B.id 
ORDER BY A.count DESC
LIMIT 3

select * from board;

SELECT A.*
, M.nickname as `nickname`
from article as `A`
inner join `member` as `M`
on A.memberId = M.id









