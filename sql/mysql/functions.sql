DROP FUNCTION IF EXISTS getTableSize;

DELIMITER 1488;
CREATE FUNCTION getTableSize(tableName VARCHAR(50))
  RETURNS INTEGER
  BEGIN
    DECLARE kb_size INTEGER;
    SELECT
      ROUND((TABLE_ROWS * AVG_ROW_LENGTH) / 1024) AS `Size`
    INTO kb_size
    FROM
      information_schema.TABLES
    WHERE
      TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = tableName;

    RETURN kb_size;
  END;
1488;

SELECT getTableSize('text_fulltextindex') as SIZE_KB FROM dual;