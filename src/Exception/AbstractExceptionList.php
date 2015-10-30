<?php
namespace PMarien\RestApiResponse\Exception;

/**
 * @author Philipp Marien <philipp.marien@gmail.com>
 */
abstract class AbstractExceptionList extends AbstractException implements ExceptionInterface, ExceptionListInterface
{
    /**
     * @var \Exception[]
     */
    private $exceptions = [];

    /**
     * @param \Exception $exception
     *
     * @return $this
     */
    public function addException(\Exception $exception)
    {
        $this->exceptions[] = $exception;

        return $this;
    }

    /**
     * @return \Exception[]
     */
    public function getExceptions()
    {
        return $this->exceptions;
    }
}
