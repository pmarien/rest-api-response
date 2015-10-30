<?php
namespace PMarien\RestApiResponse\Exception;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
abstract class AbstractException extends \Exception
{
    /**
     * @var array
     */
    private $metaData = [];

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return $this
     */
    public function addMetaData($key, $value)
    {
        $this->metaData[$key] = $value;

        return $this;
    }

    /**
     * @return array
     */
    public function getMetaData()
    {
        return $this->metaData;
    }
}
