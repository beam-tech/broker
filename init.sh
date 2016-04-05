#!/bin/bash
# Инициализация приложения для nginx.
RED='\033[0;31m'    # красный
GREEN='\033[0;32m'  # зеленый
YELLOW='\033[0;33m' # желтый
NC='\033[0m'        # No Color

enabled_default="/etc/nginx/sites-enabled/default"
available_default="/etc/nginx/sites-available/default"
if [ -f "$enabled_default"  ] && [ -f "$available_default" ] ; then
	echo -e "${GREEN} $enabled_default found. ${NC}"
	echo -e "${GREEN} $available_default found. ${NC}"
	rm /etc/nginx/sites-enabled/default
	rm /etc/nginx/sites-available/default
	echo -e "${YELLOW} $enabled_default removed. ${NC}"
	echo -e "${YELLOW} $available_default removed. ${NC}"
fi

my_conf="$PWD/conf/default"
conf_file="/etc/nginx/sites-enabled/default"
if [ -f "$my_conf"  ] ; then
	ln -sf "$my_conf" $conf_file
	echo -e "${GREEN} created symlink $my_conf. -> $conf_file ${NC}"
	/etc/init.d/nginx restart
else
	echo -e "${RED} $my_conf not found. ${NC}"
fi

