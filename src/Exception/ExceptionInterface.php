<?php
namespace PMarien\RestApiResponse\Exception;

/**
 * @author Philipp Marien <philipp.marien@gmail.com>
 */

interface ExceptionInterface
{
    /**
     * @return array
     */
    public function getMetaData();
}
