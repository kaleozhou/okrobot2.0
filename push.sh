#!/usr/bin/env bash
# ******************************************************
# Author       : kaleo
# Last modified: 2016-12-17 12:42
# Email        : kaleo1990@hotmail.com
# Filename     : push.sh
# Description  : 
# *****************************************************
git add .
if [ $1 x = x ]
then
    git commit -m `date`
else
    git commit -m $1
fi
git push
