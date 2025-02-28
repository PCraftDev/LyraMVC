<?php

class _20250228_155145_create_Users_table
{
    public function up($pdo)
    {
        $query = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY
        )";
        $pdo->exec($query);
    }
}