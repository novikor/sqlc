DROP PROCEDURE IF EXISTS clearTable;

DELIMITER 1488;
CREATE PROCEDURE clearTable(tableName VARCHAR(30))
  BEGIN
    SET @query = CONCAT('TRUNCATE ', tableName);
    PREPARE statement FROM @query;
    EXECUTE statement;
    DEALLOCATE PREPARE statement;
  END;
1488;

CALL clearTable('text');