<?php

/**
 * Created by PhpStorm.
 * User: Krisz
 * Date: 2017.01.16.
 * Time: 8:47
 */
class CacheTask extends TaskBase
{
    
    public function mainAction(){
        echo "cache drop".PHP_EOL;
    }

    /**
     * Redis cache eldobása
     */
    public function dropAction(){
        /** @var \Predis\Client $cache */
        $cache = $this->redis;
        $keys = $cache->keys('*');
        foreach ($keys as $key){
            echo $key." <- torolve ".PHP_EOL;
            $cache->del($key);
        }
        
        echo "end".PHP_EOL;

    }
}