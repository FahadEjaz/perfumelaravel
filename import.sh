#!/bin/bash
# basepath="$(pwd)"
# echo "$basepath"
cd excel/new
# if [ "$(ls ../old)" ];then
#     rm ../old/pricelist.xlsx  
# fi
# echo "#############{"`date +'%Y-%m-%d %H:%M:%S'`"}###########" >> "$basepath/storage/logs/wget.log"
# mv pricelist.xlsx ../old/pricelist.xlsx &>> "$basepath/storage/logs/wget.log"
# wget https://worldwideperfumesllc.com/downloads/pricelist.xlsx &>> "$basepath/storage/logs/wget.log"
# cp pricelist.xlsx $basepath/storage/app/ &>> "$basepath/storage/logs/wget.log"
diff pricelist.xlsx ../old/pricelist.xlsx
