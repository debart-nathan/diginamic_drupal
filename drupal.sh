#!/usr/bin/bashY
cd /opt/drupal
apt update
apt install unzip
apt install nano
apt-get install -y git
git config --global init.defaultBranch main
git config --global user.name "debart-nathan"
git config --global user.email "denathan@laposte.net"
git config --global alias.co checkout
git config --global alias.br branch
git config --global alias.ci commit
git config --global alias.st status

composer require drush/drush
composer require drupal/devel
drush en devel
composer require 'drupal/devel_php:^1.5'
drush en devel_php
composer require 'drupal/admin_toolbar:^3.4'
drush en admin_toolbar
drush en admin_toolbar_tools
composer require 'drupal/calendar_view:^2.1'
drush en calendar_view
composer require 'drupal/twig_tweak:^3.2'
drush en twig_tweak
composer require 'drupal/twig_vardumper:^3.1'
drush en twig_vardumper
drush twig:debug on
composer require 'drupal/bootstrap_sass:^5.0'
apt install nodejs
apt install npm -y

cd ./web/themes/contrib/bootstrap_sass/
chmod +x scripts/create_subtheme.sh
bash scripts/create_subtheme.sh


composer require 'drupal/restui:^1.21'
composer en restui