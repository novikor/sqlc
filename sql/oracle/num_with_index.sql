call dropSequenceIfExists('seq_num_with_index');
CREATE SEQUENCE seq_num_with_index START WITH 1;

call dropTableIfExists('num_with_index');
CREATE TABLE num_with_index (
  id      INTEGER,
  num     INTEGER,
  CONSTRAINT seq_num_with_index PRIMARY KEY (id)
);
CREATE INDEX num_index ON num_with_index (num);

CREATE OR REPLACE TRIGGER inc_num_with_index
BEFORE INSERT ON num_with_index
FOR EACH ROW
  BEGIN
    SELECT seq_num_with_index.nextval
    INTO :new.id
    FROM dual;
  END;