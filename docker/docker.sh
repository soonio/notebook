#!/bin/sh

case $1 in
'info')
    logs=$(find /var/lib/docker/containers/ -name *-json.log)
    for log in $logs
    do
        ls -lh $log | awk '{print $5}'
        $log | egrep '([^<>/\\\|:""\*\?]+)\.\w+$'
    done
    ;;
'delete')
    logs=$(find /var/lib/docker/containers/ -name *-json.log)
    for log in $logs
        do
            echo "clean logs : $log"
            cat /dev/null > $log
        done
    ;;
*)
    echo "no valid parameter!!!";
esac


