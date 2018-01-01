CREATE OR REPLACE PROCEDURE dropSequenceIfExists(sequenceName IN VARCHAR)
IS
  BEGIN
    EXECUTE IMMEDIATE CONCAT('DROP SEQUENCE ', sequenceName);
    EXCEPTION
    WHEN OTHERS THEN
    IF sqlcode != -02289
    THEN RAISE; END IF;
  END;

CREATE OR REPLACE PROCEDURE dropTableIfExists(tableName IN VARCHAR)
IS
  BEGIN
    EXECUTE IMMEDIATE CONCAT('DROP TABLE ', tableName);
    EXCEPTION
    WHEN OTHERS THEN
    IF sqlcode != -0942
    THEN RAISE; END IF;
  END;

CREATE OR REPLACE PROCEDURE reindexText(indexName IN VARCHAR)
IS
  BEGIN
    ctx_ddl.sync_index(indexName);
  END;

CREATE OR REPLACE PROCEDURE REFRESHSTATISTICS AS
  strSchema VARCHAR2(20);

  BEGIN
    dbms_stats.gather_schema_stats(USER, CASCADE => TRUE);
  END;

-- CALL REFRESHSTATISTICS();

CREATE OR REPLACE PROCEDURE clearTable(tableName IN VARCHAR)
AS
  tableNameUpperCase VARCHAR(30) := UPPER(tableName);
  BEGIN
    EXECUTE IMMEDIATE CONCAT('TRUNCATE TABLE ', tableNameUpperCase);
    DROPSEQUENCEIFEXISTS(CONCAT('SEQ_', tableNameUpperCase));
    EXECUTE IMMEDIATE CONCAT(
        'CREATE SEQUENCE ',
        CONCAT(
            CONCAT('SEQ_', tableNameUpperCase),
            ' START WITH 1'
        )
    );
  END;

-- CALL clearTable('text');
