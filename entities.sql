CREATE TABLE schema.entities (
  id SERIAL PRIMARY KEY,
  name VARCHAR(32),
  type VARCHAR(32), 
  components JSONB
);

