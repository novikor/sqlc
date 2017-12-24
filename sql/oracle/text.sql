call dropSequenceIfExists('seq_text');
CREATE SEQUENCE seq_text START WITH 1;

call dropTableIfExists('text');
CREATE TABLE text (
  id      INTEGER,
  text    CLOB,
  CONSTRAINT seq_text PRIMARY KEY (id)
);


CREATE OR REPLACE TRIGGER inc_text
BEFORE INSERT ON text
FOR EACH ROW
  BEGIN
    SELECT seq_text.nextval
    INTO :new.id
    FROM dual;
  END;