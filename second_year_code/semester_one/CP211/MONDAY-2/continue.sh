#! /bin/bash

for i in BIS HIS BIS BIS SE HIS CS MTA IDIT HIS CNISE CSDFE
do

    if [[ $i == "HIS" ]]
    then
         echo *skipping HIS
    continue
    fi

    echo $i

done
