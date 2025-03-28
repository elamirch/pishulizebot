<?php
    class User {
        public function create(int $telegram_user_id) {
            global $pdo;
            $stmt = $pdo->prepare("INSERT INTO `users` (`telegram_user_id`" .
            ") VALUES (:tui);");
            $stmt->execute(array(':tui' => $telegram_user_id));
        }

        public function update($whereColumn, $whereValue, $updateColumn, $updateValue) {
            global $pdo;
            $stmt = $pdo->prepare("UPDATE `users` 
                    SET `$updateColumn` = :asv 
                    WHERE `$whereColumn` = :ui");
            $stmt->execute(array(':ui' => $whereValue,
                        ':asv' => $updateValue));
        }

        public function read($column, $value) {
            global $pdo;
            return $pdo->query("SELECT * FROM `users` WHERE $column=$value")->fetchAll()[0];
        }

        public function flush($user_id) {
            global $pdo;
            $stmt = $pdo->prepare('UPDATE `users` SET `checkpoint` = NULL, `background` = NULL,' .
            '`text_one` = NULL, `text_two` = NULL, `text_three` = NULL, `text_four` = NULL,' .
            '`text_five` = NULL WHERE `telegram_user_id` = :si;');
            $stmt->execute(array(':si' => $user_id));
        }
    }