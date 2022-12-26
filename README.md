# Requirement

- Docker
- Docker-compose
- Make

# Installation
- `make .env.local`
- Edit your ``.env.local``

Then

`make install` or `make reset` :)

# Data
## Import all data
If you want to reset all your database
`make mysql_data` else `make import`

You can also specify type of game with:

- `make import_loto`
- `make import_euromillions`
- `make import_superloto`
- `make import_extraloto`

## Import specific file
Download some data (csv file) in [FDJ](https://www.fdj.fr/jeux-de-tirage/loto/historique) and import with ``bin/console app:import:csv FILE_PATH``
