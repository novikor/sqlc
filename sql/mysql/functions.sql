DROP FUNCTION IF EXISTS getTableSize;

DELIMITER 1488;
CREATE FUNCTION getTableSize(tableName VARCHAR(50))
  RETURNS INTEGER
  BEGIN
    DECLARE kb_size INTEGER;
    SELECT ((data_length + index_length) / 1024) as size
    INTO kb_size
    FROM information_schema.TABLES
    WHERE table_schema = DATABASE()
          AND table_name = tableName;
    RETURN kb_size;
  END;
1488;

SELECT getTableSize('text_fulltextindex') AS SIZE_KB
FROM dual;