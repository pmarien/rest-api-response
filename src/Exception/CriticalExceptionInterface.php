<?php
namespace PMarien\RestApiResponse\Exception;

/**
 * @author Philipp Marien <philipp.marien@gmail.com>
 */

interface CriticalExceptionInterface extends ExceptionInterface
{
    /**
     * @return int
     */
    public function getHttpStatusCode();
}
