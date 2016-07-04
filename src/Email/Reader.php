<?php

namespace Email;

/**
 * Class EmailReader
 *
 * Базовые класс для писем почтового ящика, по возможности используются методы этого класса (как набор базовых методов по работе с письмами)
 * Расширяется через дочерние классы, у которых (изначально), только разыне коннекты.
 * Эти дочерние классы могут расширяться через @overload method
 */
class Reader extends \Singleton implements ReaderInterface
{
    //protected $user = '';
    //protected $pass = '';
    //protected $server = array('inbox' => '');
    /** @var  Auth */
    protected $auth;
    public $inbox;
    public $content = array();
    /** @var  ReaderBase */
    public $reader;

    public function setAuth($auth)
    {
        $this->auth = $auth;
        return $this;
    }

    /**
     * @return ReaderBase
     */
    public function getReader()
    {
        // use singleton for: cache php-email resurse
        $that = self::getInstance();
        if (!$this->reader) {
            $that->reader = new ReaderBase($that->auth->server, $that->auth->user, $that->auth->pass);
        }
        return $that->reader;
    }

    /**
     * @return $this
     */
    public function loadAndParseInbox()
    {
        $this->inbox = $this->getReader()->loadUnseen()->inbox;
        $this->parseInbox($this->inbox);
        return $this;
    }

    /**
     * @return $this
     */
    public function loadAndParseInboxAll()
    {
        $this->inbox = $this->getReader()->loadInboxAll()->inbox;
        $this->parseInbox($this->inbox);
        return $this;
    }

    /**
     * Parse $this->inbox to $this->phones
     *
     * @param $inbox
     * @param null $_subject
     * @return $this
     * @internal param null $subject collect inbox email only with subject: $_subject
     */
    public function parseInbox($inbox, $_subject = null)
    {
        if (!empty($inbox)) {
            foreach ($inbox as $item) {
                if (isset($item['header'])) {
                    $date = isset($item['header']->date) ? date('Y-m-d', strtotime($item['header']->date)) : null;
                    $bodyText = isset($item['bodyText']) ? explode("\n", $item['bodyText']) : null;
                    // collect all inbox email
                    if (is_null($_subject)) {
                        $this->content[$date] = $bodyText;
                    } else {
                        // collect inbox email only with subject: $_subject
                        $subject = isset($item['header']->subject) ? $item['header']->subject : null;
                        if ($subject && $bodyText) {
                            if (stripos($subject, $subject) !== false) {
                                $this->content[$date] = $bodyText;
                            }
                        }

                    }
                }
            }
        }
        return $this;
    }
}
