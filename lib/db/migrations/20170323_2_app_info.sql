ALTER TABLE credentials ADD COLUMN identifier VARCHAR(255);

CREATE TABLE app_config (
  `key` VARCHAR(255) PRIMARY KEY,
  value TEXT
);