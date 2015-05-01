#!/bin/bash
if [ -f "/home/mingtai/car_data/car_backup.sql" ]; then 
#   echo "found car_backup.sql"
   mv "/home/mingtai/car_data/car_backup.sql" "/home/mingtai/car_data/car_backup_yesterday.sql"
fi

mysqldump --user=root -p"root" car > /home/mingtai/car_data/car_backup.sql

