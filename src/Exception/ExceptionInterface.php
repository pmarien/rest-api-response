<?php
namespace PMarien\RestApiResponse\Exception;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */

interface ExceptionInterface
{
    /**
     * @return array
     */
    public function getMetaData();
}
