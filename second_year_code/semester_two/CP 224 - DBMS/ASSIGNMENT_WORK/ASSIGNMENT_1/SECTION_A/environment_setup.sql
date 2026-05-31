-- SECTION A: Environment Setup
-- Fedora Installation Commands
sudo dnf install community-mysql-server
sudo systemctl enable --now mysqld
mysql --version

-- MySQL Commands
CREATE DATABASE db_Bsc_CS_group01;
SHOW DATABASES;