<?php
namespace PMarien\RestApiResponse\Exception;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */

interface CriticalExceptionInterface extends ExceptionInterface
{
    /**
     * @return int
     */
    public function getHttpStatusCode();
}
