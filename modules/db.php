<?php
    function db_up() {
        //Variables are derived from .env in bootstrap.php
        global $DB_HOST, $DB_PORT, $DB_USER, $DB_PASS, $DB_NAME;
        $pdo = new PDO("mysql:host=$DB_HOST;port=$DB_PORT", $DB_USER, $DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_PERSISTENT, True);
        
        $create_db = $pdo->prepare("CREATE DATABASE IF NOT EXISTS $DB_NAME");
        $create_db->execute();
        
        $pdo = new PDO("mysql:host=$DB_HOST;port=$DB_PORT;dbname=$DB_NAME", $DB_USER, $DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_PERSISTENT, True);
    }

    db_up();

    try {

        //If later we created a webapp and user was permitted not having telegram_user_id,
        //then it can be set to null    
        $createUsersTable = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            telegram_user_id BIGINT(12) NOT NULL,
            checkpoint VARCHAR(16) NULL,
            background VARCHAR(255) NULL,
            text_one VARCHAR(256) NULL,
            text_two VARCHAR(256) NULL,
            text_three VARCHAR(256) NULL,
            text_four VARCHAR(256) NULL,
            text_five VARCHAR(256) NULL
        );";
    
        //Execute table creation
        $pdo->exec($createUsersTable);
        
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }