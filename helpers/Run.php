<?php

namespace helpers;
class Run {
    public static function runSnippet($full_path) {
        return shell_exec("php {$full_path}");
    }
}