#!/bin/bash
git add .

git commit -am 'update controller auth'

git pull origin master

git push origin master
