<?php
namespace PMarien\RestApiResponse;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
abstract class AbstractApiResponse extends JsonResponse
{
    /**
     * @param mixed $data
     * @param int $status
     * @param array $headers
     */
    public function __construct($data = null, $status = 200, $headers = array())
    {
        parent::__construct($this->buildResponseArray($data), $status, $headers);
    }

    /**
     * @return string
     */
    abstract protected function getStatusMessage();

    /**
     * @param mixed $data
     *
     * @return array
     */
    abstract protected function getResults($data);

    /**
     * @param mixed $data
     *
     * @return array
     */
    protected function buildResponseArray($data)
    {
        $results = $this->getResults($data);

        return [
            'status'  => $this->getStatusMessage(),
            'count'   => count($results),
            'results' => $results,
        ];
    }
}
