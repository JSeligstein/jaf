<?php

namespace jaf\test;

use \jaf\mysql\MySQLConnection;

class DatabaseTestHelper {
    
    public static function assertTableExists(\PHPUnit_Framework_TestCase $test,
                                             MySQLConnection $conn,
                                             $table) {
        $query = $conn->buildQuery('SHOW TABLES LIKE %s', $table);
        $result = $conn->runQuery($query);
        $test->assertEquals(1, $conn->numRows($result), 'Table \''.$table.'\' does not exist.');
    }
}

