#!/bin/sh
echo "Creating MySQL database ..."
mysql -e 'create database silex;'
echo "Done."

echo "Populating database ..."
mysql silex < docs/silex.sql
echo "Done."

# Setup config
echo "Generating config file ..."
touch lib/config.inc.php
echo "<?php"                               > lib/config.inc.php
echo "return ["                            >> lib/config.inc.php
echo "'database.host'     => 'localhost'," >> lib/config.inc.php
echo "'database.user'     => 'root',"      >> lib/config.inc.php
echo "'database.password' => '',"          >> lib/config.inc.php
echo "'database.name'     => 'silex',"  >> lib/config.inc.php
echo "'database.port'     => 3306,"        >> lib/config.inc.php
echo "'database.wrapper'  => 'mysql'"      >> lib/config.inc.php
echo "];"                                  >> lib/config.inc.php
echo "Done."
