<?php
class Database {
    private static $connection = null;

    // Helper function to get environment variable with fallback
    private static function get_env($name, $default) {
        return isset($_ENV[$name]) && trim($_ENV[$name]) != "" ? $_ENV[$name] : $default;
    }

    public static function DB_HOST() {
        return self::get_env("DB_HOST", "localhost");
    }

    public static function DB_PORT() {
        return self::get_env("DB_PORT", "3306");
    }

    public static function DB_NAME() {
        return self::get_env("DB_NAME", "hadrofit_db");
    }

    public static function DB_USER() {
        return self::get_env("DB_USER", "root");
    }

    public static function DB_PASSWORD() {
        return self::get_env("DB_PASSWORD", "");
    }

    public static function JWT_SECRET() {
        return self::get_env("JWT_SECRET", "hadrofit_super_secret_key_2024_9x8z7y6w5v4u3t2s1r");
    }

    public static function connect() {
        if (self::$connection === null) {
            try {
                $host = self::DB_HOST();
                $port = self::DB_PORT();
                $dbname = self::DB_NAME();
                $username = self::DB_USER();
                $password = self::DB_PASSWORD();

                // Build DSN with port
                $dsn = "mysql:host={$host};port={$port};dbname={$dbname}";

                self::$connection = new PDO(
                    $dsn,
                    $username,
                    $password,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false
                    ]
                );
            } catch (PDOException $e) {
                die("Connection failed: " . $e->getMessage());
            }
        }
        return self::$connection;
    }
}