#!/bin/sh
git checkout dev
git add .
git commit -am "made changes"
git push origin master
echo Press Enter...
read