<?php

namespace jaf\log;

class Logger {

    const LevelInfo = 10;
    const LevelWarn = 5;
    const LevelError = 2;
    const LevelFatal = 1;

    protected static function stringFromException(\Exception $e) {
        return '['.get_class($e).'] '.$e->getMessage();
    }

    protected static function levelName($level) {
        switch($level) {
            case self::LevelInfo: return 'Info';
            case self::LevelWarn: return 'Warn';
            case self::LevelError: return 'Error';
            case self::LevelFatal: return 'Fatal';
            default: return 'Unknown';
        }
    }

    
    protected static function log($level, $message) {
        if ($message instanceof \Exception) {
            $message = self::stringFromException($message);
        }

        error_log(
            '['.self::levelName($level).'] '
            . $message
        );
    }

    public static function info($msg) {
        self::log(self::LevelInfo, $msg);
    }

    public static function warn($msg) {
        self::log(self::LevelWarn, $msg);
    }
    
    public static function error($msg) {
        self::log(self::LevelError, $msg);
    }
}

