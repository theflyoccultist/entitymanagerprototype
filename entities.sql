-- CREATE TABLE schema.entities (
--   id SERIAL PRIMARY KEY,
--   name VARCHAR(32),
--   type VARCHAR(32), 
--   components JSONB
-- );

CREATE TABLE schema.characterinfo (
  id SERIAL PRIMARY KEY,
  data jsonb
);
