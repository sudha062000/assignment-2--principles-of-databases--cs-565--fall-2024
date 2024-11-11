CREATE TABLE IF NOT EXISTS macos_dates (
  announced     DATE          NOT NULL,
  released      DATE          DEFAULT NULL,
  last_release  DATE          DEFAULT NULL,
  darwin        VARCHAR(8)    NOT NULL
);
