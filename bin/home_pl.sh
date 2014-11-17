#!/bin/bash

# 
# Skrypt generuj±cy odpowiednie modyfikacje: zmiany lokalizacji katalogów + linki itp. dostosowuj±cy sklep do instlacji 
# na serwerach home.pl, lub innych dzia³aj±cych w ¶rodowisku CHROOT z DocumentRoot=/
# Skrypt ten nale¿y wywo³aæ po wygenerowaniu standardowej wersji. Wygeneruje on now± wersje z w/w zmianami
# Jest on przeznaczony dla programistów przygotowuj±cych wersje SOTEeSKLEP, lub w przypadku przeniesienia
# sklepu ze standardowej instalacji na instalacjê typu "home.pl".
# Skrypt nale¿y wywo³ywaæ z poziomu: cd ./bin; ./home_pl.sh
#
# @author  m@sote.pl
# @version $Id: home_pl.sh,v 1.5 2004/11/08 09:43:48 maroslaw Exp $
# @package home.pl
# @subpackage install
#

# przejd¼ do g³ównego katalogu sklepu
cd ..

# przenie¶ katalog htdocs do admin/htdocs i utwórz link zwrotny do poprzedniej lokalizacji
if [ -d htdocs ]; then
    mv htdocs admin
    ln -s admin/htdocs .
fi

# za³ó¿ katalog admin/htdocs/base, który bêdzie zawiera³ pliki i katalogi zlokalizowane w g³ównym katalogu sklepu
# przenie¶ do tego katalogu w/w pliki/katalogi i utwórz linki
mkdir admin/htdocs/base
files=`ls| grep -v "admin"| grep -v "htdocs"`
for file in `echo $files`
do
    mv $file admin/htdocs/base
    ln -s admin/htdocs/base/$file . 
done

# ustaw odpowiednie linki w htdocs/lib
cd admin/htdocs/lib
rm -f Treeview 2>/dev/null
ln -s ../base/lib/Treeview .
ln -s ../base/lib/Metabase .

# ustaw odpowiednie linki w admin/lib
cd ../../lib
rm -f Treeview 2>/dev/null
ln -s ../htdocs/base/lib/Treeview .
rm -f Metabase 2>/dev/null
ln -s ../htdocs/base/lib/Metabase .
rm -f WYSIWYG 2>/dev/null
ln -s ../htdocs/base/lib/WYSIWYG  .
rm -f SimpleBarChart 2>/dev/null
ln -s ../htdocs/base/lib/SimpleBarChart  .

# dodaj link do wersji
cd ..
ln -s htdocs/base/VERSION .

# ustaw link do head.inc w htdocs/include/head.inc
cd htdocs
if [ ! -d include ]; then
    mkdir include    
fi
cd include
ln -s ../base/include/head.inc .

# ustaw link do head.inc w admin/include/head.inc
cd ../../include
ln -s ../htdocs/base/include/head.inc .
cd ..

# dodaj link dot sesji htdocs/sessions
cd htdocs
ln -s base/sessions .

# dodaj linki dot sesji w admin/sessions i sessions_secure
cd ..
ln -s htdocs/base/sessions .
ln -s htdocs/base/sessions_secure .

# dodaj link do admin/sql
ln -s htdocs/base/sql .

# podlinkuj plik sum kontrolnych
ln -s htdocs/base/sum.md5 .

# usun pliki standarowe .htaccess i zainstaluj nowe zgodne z home.pl
cd ..
rm -f htdocs/.htaccess
rm -f htdocs/themes/.htaccess

cp config/providers/home.pl/php.ini admin
cp config/providers/home.pl/php.ini htdocs
cp config/providers/home.pl/admin.htaccess admin/.htaccess

# tu jestesmy w glownym katalogu sklepu soteesklep3

# ustaw odpowiedni link do zdjec
cd admin
rm -f photo
ln -s htdocs/photo .
cd ..

# tu jestesmy w glownym katalogu sklepu soteesklep3
cd admin
ln -s tmp tmp2
cd ..

