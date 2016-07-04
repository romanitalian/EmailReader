<?php

namespace Email;
/**
 * Class EmailReaderInterface
 */
interface ReaderInterface
{
    /**
     * @return ReaderBase
     */
    public function getReader();
}
