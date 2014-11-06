<?php

namespace jaf\web;

abstract class WebRouter {
    abstract public function getMap();
    abstract public function get404Controller(\jaf\web\WebRequest $request);
    
    public function getController(\jaf\web\WebRequest $request) {
        $get = $request->get;
        $path = $get->getString('path', '');
        $pathPieces = preg_split('/\//', $path, -1, PREG_SPLIT_NO_EMPTY);
        $map = $this->getMap();

        foreach ($pathPieces as $piece) {
            $piece = trim($piece);

            // TODO: temp hack for a bad rewrite rule
            if ($piece == 'index.php') {
                continue;
            }

            // if map is a string, we have too long of a path
            if (gettype($map) == 'string') {
                \jaf\log\Logger::warn('Invalid path (too long): '.$path);
                return $this->get404Controller($request);
            }

            // require exact paths for now (or wildcards)
            // TODO: regex
            if (!isset($map[$piece])) {
                if (!isset($map['*'])) {
                    \jaf\log\Logger::warn('Invalid path (missing): '.$path);
                    return $this->get404Controller($request);
                }
                $map = $map['*'];
            } else {
                $map = $map[$piece];
            }
        }

        // if map is still an array, check if there's an empty string,
        // which is the default for that direcetory
        if (gettype($map) == 'array') {
            if (!isset($map[''])) {
                \jaf\log\Logger::warn('Invalid path (incomplete): '.$path);
                return $this->get404Controller($request);
            }
            $map = $map[''];
        }

        // must be a controller now
        if (gettype($map) != 'string') {
            \jaf\log\Logger::warn('Invalid path (not a controller): '.$path);
            return $this->get404Controller($request);
        }

        if (!class_exists($map)) {
            \jaf\log\Logger::warn('Invalid path (controller missing): '.$map);
            return $this->get404Controller($request);
        }

        return new $map($request);
    }
}

