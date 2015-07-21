#!/bin/sh

git ls-files -v | grep "^S" | sed "s/^S //"

