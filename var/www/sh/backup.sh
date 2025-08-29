#!/bin/sh
FECHA=`date +%s`
rm ./tmp/*
mysqldump walger -uroot -pwalger0000 > ./tmp/walger.sql
tar czvf ./tmp/walger-base.$FECHA.tar.gz ./tmp/walger.sql
rm ./tmp/walger.sql
tar czvf ./tmp/walger-sitio.$FECHA.tar.gz /var/www --exclude /var/www/articulos --exclude /var/www/sh/tmp --exclude /var/www/descargas_casa_repuestos --exclude /var/www/descargas_consumidor_final --exclude /var/www/descargas_distribuidor 
cd ./tmp
ftp -n ftp.federicopfaffendorf.com.ar<<END
user walger.r2cu.be walger
put walger-base.$FECHA.tar.gz
put walger-sitio.$FECHA.tar.gz
quit
END
rm *
cd ..
