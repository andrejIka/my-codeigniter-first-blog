#!/bin/sh
git checkout dev
git add .
set /P comment=Enter comment here:
git commit -am "jstack %comment%"
git push origin master
echo Press Enter...
read