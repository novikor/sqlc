-- CREATE OR REPLACE FUNCTION getTableSize(tableName VARCHAR)
--   RETURN INTEGER
-- IS kb_size INTEGER;
--   BEGIN
--     SELECT round((num_rows * avg_row_len) / (1024)) AS KB
--     INTO kb_size
--     FROM all_tables
--     WHERE owner = USER
--           AND TABLE_NAME LIKE UPPER(tableName);
--     RETURN kb_size;
--   END;

CREATE OR REPLACE FUNCTION getTableSize(tableName VARCHAR)
  RETURN INTEGER
IS kb_size INTEGER;
  BEGIN
    SELECT
      SUM(bytes)/1024 as kb_size
    INTO kb_size
    FROM user_segments
    --    WHERE segment_type='TABLE'
    WHERE segment_name LIKE CONCAT('%', CONCAT(tableName, '%'));
    RETURN kb_size;
  END;

SELECT getTableSize('text_fulltextindex') as SIZE_KB FROM dual;


SELECT *
FROM user_tables