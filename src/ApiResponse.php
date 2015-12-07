<?php
namespace PMarien\RestApiResponse;

use PMarien\RestApiResponse\Exception\CriticalException;

/**
 * @author Philipp Marien <philipp.marien@gmail.com>
 */
class ApiResponse extends AbstractApiResponse
{
    /**
     * @return string
     */
    protected function getStatusMessage()
    {
        return 'success';
    }

    /**
     * @param mixed $data
     *
     * @return array
     * @throws CriticalException
     */
    protected function getResults($data)
    {
        switch (gettype($data)) {
            case 'array':
                if ($this->isCollection($data)) {
                    $results = [];
                    foreach ($data as $subArray) {
                        $results[] = $this->handleArray($subArray);
                    }

                    return $results;
                }

                return [$this->handleArray($data)];
            case 'object':
                return [$this->handleObject($data)];
            case 'NULL':
                break;
            default:
                $e = new CriticalException('Data could not be formatted!');
                $e->addMetaData('input', $data);
                throw $e;
        }

        return [];
    }

    /**
     * @param object $object
     *
     * @return array|object
     */
    protected function handleObject($object)
    {
        // If object implements JsonEncodableInterface, handle encode result
        if ($object instanceof JsonEncodableInterface) {
            return $this->handleArray($object->encode());
        }

        return $object;
    }

    /**
     * @param array $array
     *
     * @return array
     */
    protected function handleArray(array $array)
    {
        $results = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $value = $this->handleArray($value);
            } elseif (is_object($value)) {
                $value = $this->handleObject($value);
            }
            $results[$key] = $value;
        }

        return $results;
    }

    /**
     * @param array $array
     *
     * @return bool
     */
    protected function isCollection(array $array)
    {
        $isCollection = true;

        $i = 0;
        foreach ($array as $key => $value) {
            if ($key !== $i || (!is_array($value) && !is_object($value))) {
                $isCollection = false;
                break;
            }
            $i++;
        }

        return $isCollection;
    }
}
