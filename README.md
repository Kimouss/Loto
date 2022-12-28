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
## Import all archive data
If you want to reset all your database
`make mysql_data` else `make import`

You can also specify type of game with:

- `make import_loto`
- `make import_euromillions`
- `make import_superloto`
- `make import_extraloto`

## Import specific file
Download some data (csv file) in [FDJ](https://www.fdj.fr/jeux-de-tirage/loto/historique) and import with ``bin/console app:import:csv FILE_PATH``


## Import all new data
In you container `loto_php`

**Make sure you have a VPN activated before**
### Get all CSV file from FDJ's website
- `bin/console app:extract:result-csv`
### Import CSV extracted
- `bin/console app:import:all-csv`
