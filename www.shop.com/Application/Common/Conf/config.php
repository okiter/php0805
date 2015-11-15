<?php
return array(
    /* 数据库设置 */
    'DB_TYPE'                => 'mysql', // 数据库类型
    'DB_HOST'                => '127.0.0.1', // 服务器地址
    'DB_NAME'                => 'shop', // 数据库名
    'DB_USER'                => 'root', // 用户名
    'DB_PWD'                 => 'admin', // 密码
    'DB_PORT'                => '3306', // 端口
    'DB_PREFIX'              => '', // 数据库表前缀


    /**
     * 使用redis作为缓存的软件
     */
    'DATA_CACHE_TYPE'        => 'Redis', // 数据缓存类型,支持:File|Db|Apc|Memcache|Shmop|Sqlite|Xcache|Apachenote|Eaccelerator
    'REDIS_HOST'             => '127.0.0.1',
    'REDIS_PORT'             => 6379,
    'DATA_CACHE_PREFIX'      => 'itsource_',
);