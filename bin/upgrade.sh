#!/bin/bash

#
# Instaluj link symboliczny w starszych wersjach soteesklep2->soteesklep3
#
# @author  m@sote.pl
# @version $Id: upgrade.sh,v 1.1 2004/08/31 08:01:26 maroslaw Exp $
# @package upgrade
# @subpackage 00005

cd ../..
if [ ! -d soteesklep3 ] ; then
    if [ -d soteesklep2 ] ; then 
        ln -s soteesklep2 soteesklep3
    else 
       echo "Directory soteesklep2 not found"
    fi
fi
echo "OK"
