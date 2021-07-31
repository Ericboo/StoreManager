<?php

namespace ConexaoPHPPostgres;

//Classe que realiza a conexao com o banco de dados
class Connection {

    private static $conn;

    public function connect() {
        // Conecta ao postgres
        $conStr = "host=localhost port=5432 dbname=StoreManager user=postgres password=123321";

        $conexao = pg_connect($conStr);
        return $conexao;
    }

    /**
     * retorna uma instancia da coneccao do banco de dados
     * @return type
     */
    public static function get() {
        if (null === static::$conn) {
            static::$conn = new static();
        }

        return static::$conn;
    }
}
?>