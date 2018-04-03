<?php
include 'database.php';

try {
        $dbh = new PDO($DB_DSN_LIGHT, $DB_USER, $DB_PASSWORD);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "CREATE DATABASE `".$DB_NAME."`";
        $dbh->exec($sql);
        echo "Database created successfully\n";
    } catch (PDOException $e) {
        echo "ERROR CREATING DB: \n".$e->getMessage()."\nAborting process\n";
        exit(-1);
    }

try {
        $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "CREATE TABLE `membre` (
          `Id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `Pseudo` VARCHAR(50) NOT NULL,
          `Mail` VARCHAR(100) NOT NULL,
          `motdepasse` TEXT NOT NULL,
          `date_inscription` DATE NOT NULL,
          `avatar` VARCHAR(255) NOT NULL,
          `confirmation_token` VARCHAR(60) NULL,
          `confirmation_at` DATE NULL
        )";
        $dbh->exec($sql);
        echo "Table membre created successfully\n";
    } catch (PDOException $e) {
        echo "ERROR CREATING TABLE: ".$e->getMessage()."\nAborting process\n";
    }

try {
        $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "CREATE TABLE `fichiers` (
          `Id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `Name_image` VARCHAR(50) NOT NULL,
          `Id_usr` INT NOT NULL,
          `Mail_user` VARCHAR(255) NOT NULL
        )";
        $dbh->exec($sql);
        echo "Table fichiers created successfully\n";
    } catch (PDOException $e) {
        echo "ERROR CREATING TABLE: ".$e->getMessage()."\nAborting process\n";
    }
