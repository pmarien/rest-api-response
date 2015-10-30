<?php
namespace PMarien\RestApiResponse;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */

interface JsonEncodableInterface
{
    /**
     * Return an array of properties which can be encoded as json
     * @return array
     */
    public function encode();
}
