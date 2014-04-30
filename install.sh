#! /bin/bash

if [ -z $1 ]
then
    echo "usage: $0 path_to_install"
    exit
fi

exec_cmd()
{
    echo $1
    $1
}

# todo - finish install script
