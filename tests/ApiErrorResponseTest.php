<?php
namespace PMarien\RestApiResponse\Tests;

use PMarien\RestApiResponse\ApiErrorResponse;
use PMarien\RestApiResponse\Exception\CriticalException;
use PMarien\RestApiResponse\Exception\CriticalExceptionList;
use PMarien\RestApiResponse\Exception\UncriticalException;
use PMarien\RestApiResponse\Exception\UncriticalExceptionList;

/**
 * @author Philipp Marien <philipp.marien@gmail.com>
 */
class ApiErrorResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testApiErrorResponseWithException()
    {
        $response = new ApiErrorResponse(new \Exception('Test'));
        $result   = json_decode($response->getContent(), true);

        static::assertEquals(500, $response->getStatusCode());
        static::assertEquals('error', $result['status']);
        static::assertEquals(1, $result['count']);
        static::assertCount(1, $result['results']);
        static::assertEquals('Test', $result['results'][0]['message']);
    }

    public function testApiErrorResponseWithPreviousException()
    {
        $response = new ApiErrorResponse(new \Exception('Test', 3, new \Exception('Test 2')));
        $result   = json_decode($response->getContent(), true);

        static::assertEquals(500, $response->getStatusCode());
        static::assertEquals('error', $result['status']);
        static::assertEquals(1, $result['count']);
        static::assertCount(1, $result['results']);
        static::assertEquals('Test', $result['results'][0]['message']);
        static::assertEquals(3, $result['results'][0]['code']);
        static::assertEquals('Test 2', $result['results'][0]['previous']['message']);
    }

    public function testApiErrorResponseWithCriticalException()
    {
        $e = new CriticalException('Test');
        $e->addMetaData('test', 'Test');
        $response = new ApiErrorResponse($e);
        $result   = json_decode($response->getContent(), true);

        static::assertEquals(500, $response->getStatusCode());
        static::assertEquals('error', $result['status']);
        static::assertEquals(1, $result['count']);
        static::assertCount(1, $result['results']);
        static::assertEquals('Test', $result['results'][0]['message']);
        static::assertEquals('Test', $result['results'][0]['data']['test']);
    }

    public function testApiErrorResponseWithUncriticalException()
    {
        $response = new ApiErrorResponse(new UncriticalException('Test'));
        $result   = json_decode($response->getContent(), true);

        static::assertEquals(200, $response->getStatusCode());
        static::assertEquals('error', $result['status']);
        static::assertEquals(1, $result['count']);
        static::assertCount(1, $result['results']);
        static::assertEquals('Test', $result['results'][0]['message']);
    }

    public function testApiErrorResponseWithCriticalExceptionList()
    {
        $e = new CriticalExceptionList();
        $e->addException(new \Exception());
        $response = new ApiErrorResponse($e);
        $result   = json_decode($response->getContent(), true);

        static::assertEquals(500, $response->getStatusCode());
        static::assertEquals('error', $result['status']);
        static::assertEquals(2, $result['count']);
        static::assertCount(2, $result['results']);
    }

    public function testApiErrorResponseWithUncriticalExceptionList()
    {
        $e = new UncriticalExceptionList();
        $e->addException(new \Exception());
        $response = new ApiErrorResponse($e);
        $result   = json_decode($response->getContent(), true);

        static::assertEquals(200, $response->getStatusCode());
        static::assertEquals('error', $result['status']);
        static::assertEquals(2, $result['count']);
        static::assertCount(2, $result['results']);
    }

    public function testApiErrorResponseWithNull()
    {
        try {
            new ApiErrorResponse(null);
            static::fail('Exception ot thrown!');
        } catch (\Exception $e) {
            static::assertTrue(true);
        }
    }
}
