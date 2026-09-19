# Overview

- I wanted to make a project where I make use of the JSONB data type in Postgres.
- I also wanted to continue using PHP and its scripting capabilities.

## Database Setup

This project uses PostgreSQL, here's what you need to do to set it up:

- Connect as Postgres superuser
- Create a new database called "gamedb", schema and an owner user.
- Set privileges / restrictions for that user.
- Create a table, such as the one in the file `entities.sql`.
- Fill username and password fields in `.env.example`, and rename it to `.env`

### Now that I have the basic CRUD operations workings, it is time to move to JSONB querying.

- Something like this:

```json
{
  "profile": {
    "age": 11,
    "location": {
      "country": "South Korea",
      "city": "Busan"
    }
  },
  "preferences": {
    "favorite food": "Kimbap",
    "least favorite food": "None"
  }
}

```
