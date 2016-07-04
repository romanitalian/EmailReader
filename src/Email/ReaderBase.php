<?php

namespace Email;
/**
 * Class EmailReaderBase
 * Specific reader and adapter - get UNSEEN email from INBOX, parse it and return array (as adapter)
 */
class ReaderBase
{
    public $inbox = array();
    protected $conn;
    protected $msgCnt = 0;

    function __construct($server, $user, $pass)
    {
        $this->connect($server, $user, $pass);
    }

    function connect($server, $user, $pass)
    {
        $this->conn = imap_open($server['inbox'], $user, $pass);
    }

    function loadInboxAll()
    {
        if ($this->conn) {
            $this->msgCnt = imap_num_msg($this->conn);
            for ($i = 1; $i <= $this->msgCnt; $i++) {
                $this->inbox[] = $this->getData($i);
            }
        }
        return $this;
    }

    public function loadUnseen()
    {
        if ($this->conn) {
            $result = imap_search($this->conn, 'UNSEEN');
            if (!empty($result)) {
                foreach ($result as $i) {
                    $this->inbox[] = $this->getData($i);
                }
            }
        }
        return $this;
    }

    protected function getData($i)
    {
        return array(
            'index' => $i,
            'header' => imap_headerinfo($this->conn, $i),
            'body' => imap_body($this->conn, $i),
            'bodyText' => imap_fetchbody($this->conn, $i, 1),
            'bodyText2' => imap_fetchbody($this->conn, $i, 2),
            'structure' => imap_fetchstructure($this->conn, $i)
        );
    }
}
