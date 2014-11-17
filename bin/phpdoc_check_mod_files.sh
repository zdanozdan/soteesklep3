#!/bin/bash

#
# Sprawd¼ listê plików PHP czy zawieraj± one odpowiednie wpisy phpdoc i wersji CVS.
# Je¶li nie, to dodaj te wpisy do plików.
# 
# @author  m@sote.pl
# @version $Id: phpdoc_check_mod_files.sh,v 1.1 2005/02/21 12:07:26 maroslaw Exp $
# @package bin
#

PHP_BIN=/usr/local/bin/php
touch /tmp/phpdoc_soteeskle.tmp

cd ..
for file in `find ./|grep ".php$"| grep -v "CVS"| grep -v ".inc"| grep -v "^./lib"| grep -v ".pkg"| grep -v "session"|grep -v "_pl"| grep -v "_de"| grep -v "_en"| grep -v "tmp"`
do
    echo $file
    if [ -f $file ] ; then
        if [ ! -L $file ] ; then
            $PHP_BIN ./bin/phpdoc_check_mod_file.php $file 2> /dev/null 1> /tmp/phpdoc_soteeskle.tmp
            mv /tmp/phpdoc_soteeskle.tmp $file            
        fi
    fi    
done

for file in `find ./|grep ".inc"| grep -v "CVS"| grep -v "lang.inc.php"| grep -v "^./lib"| grep -v ".pkg"| grep -v "session"|grep -v "_pl"| grep -v "_de"| grep -v "_en"| grep -v "tmp"`
do    
   echo $file
    if [ -f $file ] ; then
        if [ ! -L $file ] ; then
            $PHP_BIN ./bin/phpdoc_check_mod_file.php $file 2> /dev/null 1> /tmp/phpdoc_soteeskle.tmp
            mv /tmp/phpdoc_soteeskle.tmp $file            
        fi
    fi  
done
