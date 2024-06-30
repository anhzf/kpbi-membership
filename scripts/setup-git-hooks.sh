#! /bin/sh

# copy ./git-hooks to .git/hooks
cp -r ./git-hooks/* .git/hooks

# make all files executable
chmod +x .git/hooks/*
