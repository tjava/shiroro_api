<?php

namespace App;

/**
 * Application configuration
 *
 * PHP version 7.0
 */
class Config
{

    /**
     * Database host
     * @var string
     */
    const DB_HOST = 'localhost';

    /**
     * Database name
     * @var string
     */
    const DB_NAME = 'bluewavetk_shiroro_api';

    /**
     * Database user
     * @var string
     */
    const DB_USER = 'bluewavetk_shiroro_api';

    /**
     * Database password
     * @var string
     */
    const DB_PASSWORD = 'Password4shiroro_api';

    /**
     * Show or hide error messages on screen
     * @var boolean
     */
    const SHOW_ERRORS = true;

    /**
     * Secret key for hashing
     * @var boolean
     */
    const SECRET_KEY = 'secret';

    /**
     * Mailgun API key
     *
     * @var string
     */
    const MAILGUN_API_KEY = '0c9959d332a918b75573990a1581b197-3939b93a-323a4364';

    /**
     * Mailgun domain
     *
     * @var string
     */
    const MAILGUN_DOMAIN = 'sandboxc9456940e8134ddfb8871fb1ff76a027.mailgun.org';
}