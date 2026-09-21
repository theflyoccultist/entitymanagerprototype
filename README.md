# Entity Manager Prototype: 
## Character List - Lightweight Database API

## Overview

- I wanted to make a project where I make use of the JSONB data type in Postgres.
- I also wanted to continue using PHP and its scripting capabilities, especially networking ones with API design and web servers.
- The reason I chose to use Postgres was that I wanted to experiment with document querying, without committing to a NoSQL architecture.

## Database Setup

This project uses PostgreSQL, here's what you need to do to set it up:

- Connect as Postgres superuser
- Create a new database called "gamedb", schema and an owner user.
- Set privileges / restrictions for that user.
- Create a table, use the one in the file `entities.sql`.
- Fill username and password fields in `.env.example`, and rename it to `.env`

### JSON Data Structure

- This is the JSON information that will be handled by the API server.

```json
{
    "name": "Murasaki",
    "class": "mage",
    "stats": {
        "strength": 8,
        "intelligence": 17,
        "agility": 12
    },
    "equipment": [
        "staff",
        "cloak"
    ]
}
```

- It will be stored as JSONB in the Postgres database.

## Running the Project

- Make sure to have PHP and Composer installed.
- For development, use the PHP built-in server:

```bash
cd public/
php -S localhost:8888
```

- For public networks, you should look into Apache.
