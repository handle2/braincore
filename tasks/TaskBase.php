<?php

/**
 * Created by PhpStorm.
 * User: Krisz
 * Date: 2016.12.13.
 * Time: 10:27
 */
class TaskBase extends \Phalcon\CLI\Task
{
    /**
     * minden egyes task indítást ki fog írni ,hogy mikor történik
     */
    public function initialize() {
        echo date('Y-m-d H:i:s') . PHP_EOL;
    }
}