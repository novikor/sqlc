call dropSequenceIfExists('seq_num_no_index');
CREATE SEQUENCE seq_num_no_index START WITH 1;

call dropTableIfExists('num_no_index');
CREATE TABLE num_no_index (
  id      INTEGER,
  num     INTEGER,
  CONSTRAINT seq_num_no_index PRIMARY KEY (id)
);

CREATE OR REPLACE TRIGGER inc_num_no_index
BEFORE INSERT ON num_no_index
FOR EACH ROW
  BEGIN
    SELECT seq_num_no_index.nextval
    INTO :new.id
    FROM dual;
  END;