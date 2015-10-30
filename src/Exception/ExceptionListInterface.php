<?php
namespace PMarien\RestApiResponse\Exception;

/**
 * @author Philipp Marien <philipp.marien@gmail.com>
 */

interface ExceptionListInterface
{
    /**
     * @return \Exception[]
     */
    public function getExceptions();
}
