<?php
namespace PMarien\RestApiResponse\Exception;

use Symfony\Component\HttpFoundation\Response;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
class CriticalException extends AbstractException implements CriticalExceptionInterface
{
    /**
     * @return int
     */
    public function getHttpStatusCode()
    {
        return Response::HTTP_INTERNAL_SERVER_ERROR;
    }
}
