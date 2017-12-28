DROP TABLE IF EXISTS text_fulltextindex;
CREATE TABLE text_fulltextindex (
  id   INTEGER PRIMARY KEY AUTO_INCREMENT,
  text LONGTEXT CHARACTER SET UTF8,
  FULLTEXT idx (text)
) ENGINE = InnoDB;