CALL dropSequenceIfExists('seq_text_fulltextindex');
CREATE SEQUENCE seq_text_fulltextindex START WITH 1;

CALL dropTableIfExists('text_fulltextindex');
CREATE TABLE text_fulltextindex (
  id   INTEGER,
  text CLOB,
  CONSTRAINT seq_text_fulltextindex PRIMARY KEY (id)
);

CREATE INDEX fulltextindex
  ON text_fulltextindex (text) INDEXTYPE IS CTXSYS.CONTEXT;

CREATE OR REPLACE TRIGGER inc_text_fulltextindex
BEFORE INSERT ON text_fulltextindex
FOR EACH ROW
  BEGIN
    SELECT seq_text_fulltextindex.nextval
    INTO :new.id
    FROM dual;
  END;


CALL REINDEXTEXT('fulltextindex');
