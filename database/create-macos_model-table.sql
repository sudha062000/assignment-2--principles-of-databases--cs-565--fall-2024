CREATE TABLE IF NOT EXISTS models (
  model          VARCHAR(48)  NOT NULL,
  model_id       VARCHAR(16)  NOT NULL,
  model_number   VARCHAR(8)   DEFAULT NULL,
  part_number    VARCHAR(24)  NOT NULL,
  url            VARCHAR(64)  NOT NULL,
  darwin         VARCHAR(8)   NOT NULL
);
