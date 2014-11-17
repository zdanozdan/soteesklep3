#!/bin/bash

#
# Skrypt zmieniaj±cy za³±czanie pliku nag³ówkowego w ca³ym sklepie.
# Zmiana polega na wstawieniu odwo³ania wzglêdnego (wzglêdem aktualnej ¶cie¿ki).
# Zamiast 
# require_once ("$DOCUMENT_ROOT/../include/head.inc");
# wstawiane jest np.:
# require_once ("../../../../include/head.inc");
# w zale¿no¶ci od lokalizacji skryptu (ilo¶ci zagnie¿d¿eñ typu /go/_poziom1/_poziom2
#

PHP_BIN=/usr/local/bin/php
touch /tmp/phpdocument_root_soteeskle.tmp

cd ..
for file in `find ./| grep ".php$"| grep -v "sessions"| grep -v '^.\/lib'| grep -v ".html.php"| grep -v ".inc.php"`
do
if [ -f $file ] ; then
    if [ ! -L $file ] ; then
        echo $file
        $PHP_BIN ./bin/change_document_root.php $file > phpdocument_root_soteeskle.tmp
        mv phpdocument_root_soteeskle.tmp $file
    fi
fi
done