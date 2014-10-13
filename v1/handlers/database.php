<?php
namespace Database;

class Database extends \R {
	static function setupDatabase($config) {
        $config = require_once($config);

        $conn = $config['connections'][$config['default']];       
        
        switch($conn['driver']) {
            case 'mysql':
                self::setup ($conn['driver'] . ':host=' . $conn['host'] . '; dbname=' . $conn['database'], $conn['username'], $conn['password']);
                break;
            case 'sqlite':
                self::setup ($conn['driver'] . ':' . $conn['database']);
                break;
        }
    }

    static function getInstance() {
        return get_class();
    }
}