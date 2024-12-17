<?php
    class User {
        public function create(int $telegram_user_id) {
            global $pdo;
            for ($i=0; $i < 10; $i++) {
                try {
                    $stmt = $pdo->prepare("INSERT INTO `users` (`telegram_user_id`" .
                    ") VALUES (:tui);");
                    $stmt->execute(array(':tui' => $telegram_user_id));
                    break;
                } catch(Exception $e) {
                    echo $e->getMessage();
                    db_up();
                }
            }
        }

        public function update($column, $value, $variable_name, $assigned_value) {
            global $pdo;
            for ($i=0; $i < 10; $i++) {
                try {
                    $stmt = $pdo->prepare("UPDATE `users` 
                            SET `$variable_name` = :asv 
                            WHERE `$column` = :ui");
                    $stmt->execute(array(':ui' => $value,
                                ':asv' => $assigned_value));
                        break;
                } catch(Exception $e) {
                    echo $e->getMessage();
                    db_up();
                }
            }
        }

        public function read($column, $value) {
            global $pdo;
            for ($i=0; $i < 10; $i++) {
                try {
                    return $pdo->query("SELECT * FROM `users` WHERE $column=$value")->fetchAll()[0];
                } catch(Exception $e) {
                    echo $e->getMessage();
                    db_up();
                }
            }
        }

        public function flush($user_id) {
            global $pdo;
            for ($i=0; $i < 10; $i++) {
                try {
                    $stmt = $pdo->prepare('UPDATE `users` SET `checkpoint` = "", `background` = NULL,' .
                    '`text_one` = NULL, `text_two` = NULL, `text_three` = NULL, `text_four` = NULL,' .
                    '`text_five` = NULL WHERE `telegram_user_id` = :si;');
                    $stmt->execute(array(':si' => $user_id));
                    break;
                } catch(Exception $e) {
                    echo $e->getMessage();
                    db_up();
                }
            }
        }
    }