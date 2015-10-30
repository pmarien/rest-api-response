<?php
namespace PMarien\RestApiResponse\Exception;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */

interface ExceptionListInterface
{
    /**
     * @return \Exception[]
     */
    public function getExceptions();
}
