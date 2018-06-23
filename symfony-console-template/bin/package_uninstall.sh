#!/bin/sh

if [ ! -e "composer.phar" ] ; then
    curl -s http://getcomposer.org/installer | php
fi

php composer.phar remove --no-update "$@"
php composer.phar update --dry-run |grep -Eo -e '- Uninstalling\s+\S+' |cut -d' ' -f3 |xargs php composer.phar update
