# !/bin/bash

REPO="anhzf/kpbi-membership"
ARTIFACT=$1

# Set GH_TOKEN via env variables
# Abort script when no GH_TOKEN
if [ -z $GH_TOKEN ]; then
  echo "GH_TOKEN is not set. Aborting."
  exit 1
fi

if [ -z $ARTIFACT ]; then
  echo "ARTIFACT is not set. Aborting."
  exit 1
fi

curl -L \
  -H "Accept: application/vnd.github+json" \
  -H "Authorization: Bearer $GH_TOKEN" \
  -H "X-GitHub-Api-Version: 2022-11-28" \
  https://api.github.com/repos/$REPO/actions/artifacts/$ARTIFACT/zip \
  -o dist.zip

rm -rf www

unzip dist.zip -d www
