<?php
    class User {
        public function create(int $telegram_user_id) {
            global $pdo;
            $stmt = $pdo->prepare("INSERT INTO `users` (`telegram_user_id`" .
            ") VALUES (:tui);");
            $stmt->execute(array(':tui' => $telegram_user_id));
        }

        public function update($column, $value, $variable_name, $assigned_value) {
            global $pdo;
            $stmt = $pdo->prepare("UPDATE `users` 
                       SET `$variable_name` = :asv 
                       WHERE `$column` = :ui");
            $stmt->execute(array(':ui' => $value,
                        ':asv' => $assigned_value));
        }

        public function read($column, $value) {
            global $pdo;
            return $pdo->query("SELECT * FROM `users` WHERE $column=$value")->fetchAll()[0];
        }

        public function flush($user_id) {
            global $pdo;
            $stmt = $pdo->prepare('UPDATE `users` SET `checkpoint` = "", `background` = NULL,' .
            '`text_one` = NULL, `text_two` = NULL, `text_three` = NULL, `text_four` = NULL,' .
            '`text_five` = NULL WHERE `telegram_user_id` = :si;');
            $stmt->execute(array(':si' => $user_id));
        }
    }