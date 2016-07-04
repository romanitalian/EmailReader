<?php

/**
 * Class Example
 */
class Example
{
    /** @var  EmailReader */
    public $reader;
    /** @var  Auth */
    public $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @return array
     */
    public function getUnsen()
    {
        return EmailReader::getInstance()->setAuth($this->auth)->loadAndParseInbox()->content;
    }

    /**
     * @return array
     */
    public function getInboxAll()
    {
        return EmailReader::getInstance()->setAuth($this->auth)->loadAndParseInboxAll()->content;
    }
}
