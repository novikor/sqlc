CREATE OR REPLACE FUNCTION getTableSize(tableName VARCHAR)
  RETURN INTEGER
IS kb_size INTEGER;
  BEGIN
    SELECT SUM(bytes) / 1024 AS kb_size
    INTO kb_size
    FROM user_segments
    WHERE segment_type = 'TABLE'
          AND segment_name = UPPER(tableName);
    RETURN kb_size;
  END;

-- SELECT getTableSize('text_fulltextindex') as SIZE_KB FROM dual;


-- SELECT *
-- FROM user_tables


CREATE OR REPLACE FUNCTION getQueryExecutionTime(sqlQuery VARCHAR)
  RETURN NUMBER
IS
  TYPE EMPCURTYP IS REF CURSOR;
  t           NUMBER;
  plsql_block VARCHAR(255);
  cusror      EMPCURTYP;
  BEGIN
    plsql_block :=
    'SELECT
      ROUND(ELAPSED_TIME / 1000000, 6) AS Time
    FROM v$sqlarea
    WHERE SQL_TEXT = :sqlQuery';

    -- Open cursor & specify bind variable in USING clause:
    OPEN cusror FOR plsql_block USING sqlQuery;

    -- Fetch rows from result set one at a time:
    LOOP
      FETCH cusror INTO t;
      EXIT;
    END LOOP;

    CLOSE cusror;

    RETURN t;
  END;
--
-- SELECT getQueryExecutionTime('SELECT COUNT(*) FROm TEXT WHERE  REGEXP_LIKE (TEXT, ''ipsum'')') from dual;

CREATE OR REPLACE FUNCTION execAndGetTime(sqlQuery VARCHAR)
  RETURN NUMBER
IS
  TYPE EMPCURTYP IS REF CURSOR;
  t_before NUMBER;
  t_after  NUMBER;
  cusror   EMPCURTYP;
PRAGMA AUTONOMOUS_TRANSACTION;
  BEGIN
    t_before := NVL(GETQUERYEXECUTIONTIME(sqlQuery), 0);

    EXECUTE IMMEDIATE sqlQuery;
    COMMIT;

    t_after := GETQUERYEXECUTIONTIME(sqlQuery);

    RETURN t_after - t_before;
  END;

-- SELECT execAndGetTime('SELECT COUNT(*) FROM TEXT WHERE TEXT LIKE ''%sum%'' ') from dual;
