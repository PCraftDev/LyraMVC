<?php

class _20250228_154214_create_Wesgf_table
{
    public function up($pdo)
    {
        $query = "CREATE TABLE IF NOT EXISTS wesgf (
            id INT AUTO_INCREMENT PRIMARY KEY
        )";
        $pdo->exec($query);
    }
}