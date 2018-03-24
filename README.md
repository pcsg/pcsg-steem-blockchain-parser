# PCSG Steemit Blockchain PHP Parser

## Description

The Steemit PHP Parser will parse the Steemit Blockchain JSON-RPC Endpoints and insert the data into a structure MySql Database.
The Parser can be ran in multiple processes to increase the parsing speed.  
It is possible to parse either one single block, a range of blocks or run a continuous lopp to parse all available blocks.  

## Features
* [ ] Parse a single block
* [ ] Parse a range of Blocks
* [ ] Verify all the Database (Check all blocks and insert missing data)
* [ ] Parse latest blocks
* [ ] Highly configurable
* [ ] Easily readable output

## Installation

**Step 1** Clone the repository
```
git clone git@dev.quiqqer.com:pcsg/steemit-blockchain-parser.git
```

**Step 2** Edit the config file
```
mv etc/config.ini.php.dist etc/config.ini.php
nano etc/config.ini.php
```

**Step 3** Run composer
```
composer install
```

**Step 4** Run the parser
```
php run.php
```

## Additional steps

**Keep the parser running**

### Supervisor

```
apt-get install supervisor
```

```
nano /etc/supervisor/conf.d/sbpp.conf
mkdir <sbpp-directory>/logs/
```

```
[program:sbpp]
command=/usr/bin/php run.php
process_name = %(program_name)s-80%(process_num)02d
stdout_logfile = <sbpp-directory>/logs/sbpp%(process_num)02d.log
stdout_logfile_maxbytes=100MB
stdout_logfile_backups=10
numprocs=1
directory=<sbpp-directory>
stopwaitsecs=10
user=<user>
```

```
service supervisor restart
```


