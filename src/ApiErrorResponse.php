<?php
namespace PMarien\RestApiResponse;

use PMarien\RestApiResponse\Exception\CriticalExceptionInterface;
use PMarien\RestApiResponse\Exception\ExceptionInterface;
use PMarien\RestApiResponse\Exception\ExceptionListInterface;
use PMarien\RestApiResponse\Exception\UncriticalExceptionInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Philipp Marien <philipp.marien@gmail.com>
 */
class ApiErrorResponse extends AbstractApiResponse
{

    /**
     * @param \Exception $data
     * @param int $status
     * @param array $headers
     */
    public function __construct(\Exception $data, $status = Response::HTTP_INTERNAL_SERVER_ERROR, $headers = array())
    {
        if ($data instanceof CriticalExceptionInterface) {
            $status = $data->getHttpStatusCode();
        } elseif ($data instanceof UncriticalExceptionInterface) {
            $status = Response::HTTP_OK;
        }
        parent::__construct($data, $status, $headers);

    }

    /**
     * @return string
     */
    protected function getStatusMessage()
    {
        return 'error';
    }

    /**
     * @param mixed $data
     *
     * @return array
     */
    protected function getResults($data)
    {
        $results   = [];
        $results[] = $this->buildError($data);

        if ($data instanceof ExceptionListInterface) {
            foreach ($data->getExceptions() as $e) {
                $results[] = $this->buildError($e);
            }
        }

        return $results;
    }

    /**
     * @param \Exception $exception
     *
     * @return array
     */
    protected function buildError(\Exception $exception)
    {
        $result = [
            'code'     => $exception->getCode(),
            'message'  => $exception->getMessage(),
            'previous' => null,
            'data'     => null,
        ];

        if ($exception->getPrevious() !== null) {
            $result['previous'] = $this->buildError($exception->getPrevious());
        }

        if ($exception instanceof ExceptionInterface) {
            $result['data'] = $exception->getMetaData();
        }

        return $result;
    }
}
