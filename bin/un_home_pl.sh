#!/bin/sh

#
# Skrypt cofa zmiany dokonane przez skrypt home_pl.sh
# Usuwa zgedne symlinki i przenosi katalogi sporotem na miesce
# Tam gdzie to mozliwe wykorzystywane sa ogolniki 
# (np wszystkie pliki z katalogu admin/libs sa na nowo linkowane w odpowiednie miejsce)
# wiec skrypt powinien funkcjonowac mimo dodawania/zmian w obrebie tych katalogow
# przed jego wykonaniem konieczny jest jednak backup - inne zmiany dokonywane w sklepie moga zostac utracone!
# UWAGA! sklep musi byc wersja przerobiona na home.pl - w przeciwnym wypadku skutki beda fatalne (usuniecie znacznej czesci katalogow systemowych)
#
# @author lukasz@sote.pl
# @version $Id: un_home_pl.sh,v 1.2 2006/05/22 09:05:39 lukasz Exp $
# @package home.pl
# @subpackage install
#

echo "Uwaga!!!"
echo "Upewnij sie ze sklep ktory przerabiasz to wersja home.pl!"
echo "Jezeli sklep jest w normalnej wersji - usuniete zostana katalogi systemowe"
read
cd ..
rm -rf htdocs
mv ./admin/htdocs ./
echo "admin/htdocs -> htdocs"

files=`ls | grep -v "admin" | grep -v "htdocs"`
for file in `echo $files`
do
    rm -rf $file
    mv ./htdocs/base/$file ./
    echo "htdocs/base/$file -> ./$file"
done

# usuwamy padle linki w admin
rm -rf admin/sessions admin/sessions_secure admin/sql admin/sum.md5 htdocs/sessions htdocs/include htdocs/base admin/VERSION admin/tmp2 admin/tmp/tmp admin/.htaccess admin/php.ini htdocs/php.ini

echo "usuwam admin/sessions admin/sessions_secure admin/sql admin/sum.md5 htdocs/sessions htdocs/include htdocs/base admin/VERSION admin/tmp2 admin/tmp/tmp admin/.htaccess admin/php.ini htdocs/php.ini"

# podmieniamy katalog photo
rm -rf admin/photo
ln -s ../htdocs/photo admin/photo
echo "admin/photo -> ../htdocs/photo"

# podmieniamy linki w admin/lib
files=`ls admin/lib`
for file in `echo $files`
do
    rm -rf admin/lib/$file
    ln -s ../../lib/$file admin/lib/$file
    echo "admin/lib/$file -> ../../lib/$file"
done

# podmieniamy linki w htdocs/lib
files=`ls htdocs/lib`
for file in `echo $files`
do
    rm -rf htdocs/lib/$file
    ln -s ../../lib/$file htdocs/lib/$file
    echo "htdocs/lib/$file -> ../../lib/$file"
done

cp admin/.htaccess.dist.setup ./admin/.htaccess
echo "kopia: admin/.htaccess.dist.setup ./admin/.htaccess"
cp admin/.htaccess.dist.setup ./htdocs/.htaccess
echo "Kopia: admin/.htaccess.dist.setup ./htdocs/.htaccess"
rm -rf htdocs/themes/.htaccess
touch htdocs/themes/.htaccess
echo "<FilesMatch \"\.html|~\">" >> htdocs/themes/.htaccess
echo "    Order allow,deny" >> htdocs/themes/.htaccess
echo "    Deny from all" >> htdocs/themes/.htaccess
echo "</FilesMatch>"  >> htdocs/themes/.htaccess
echo "Utworzono nowy plik htdocs/themes/.htaccess"

echo "Sklep przetworzony na standardowa wersje."
