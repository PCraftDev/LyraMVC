<?php

namespace Lyramvc\Lyramvc\Core;

class Server
{
    public static function run($host = 'localhost', $port = 8000)
    {
        echo "🚀 Menjalankan LyraMVC di http://$host:$port\n";

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            // Windows: Menyembunyikan output server
            $command = "php -S $host:$port -t public 2>nul";
        } else {
            // Linux/macOS: Menyembunyikan output server
            $command = "php -S $host:$port -t public 2>/dev/null";
        }

        // Jalankan server di foreground, bisa dihentikan dengan Ctrl + C
        passthru($command);
    }
}
