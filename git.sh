#!/bin/bash
git add .

git commit -am 'update auth'

git pull origin master

git push origin master
