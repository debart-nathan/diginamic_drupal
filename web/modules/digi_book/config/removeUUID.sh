#!/bin/bash
for file in ./install/*; do
  sed -i '/^uuid:/d' "$file"
done
