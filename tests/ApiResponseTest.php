<?php
namespace PMarien\RestApiResponse\Tests;

use PMarien\RestApiResponse\ApiResponse;
use PMarien\RestApiResponse\Tests\Mocks\JsonEncodable;

/**
 * @author Philipp Marien <philipp.marien@gmail.com>
 */
class ApiResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testApiResponseWithNull()
    {
        $response = new ApiResponse();
        static::assertCount(0, json_decode($response->getContent(), true)['results']);
    }

    public function testApiResponseWithObject()
    {
        $obj       = new \stdClass();
        $obj->test = 'test';

        $response = new ApiResponse($obj);
        $result   = json_decode($response->getContent(), true);

        static::assertCount(1, $result['results']);
        static::assertArrayHasKey('test', $result['results'][0]);
        static::assertEquals('test', $result['results'][0]['test']);
    }

    public function testApiResponseWithJsonEncodable()
    {
        $response = new ApiResponse(new JsonEncodable());
        $result   = json_decode($response->getContent(), true);

        static::assertCount(1, $result['results']);
        static::assertArrayHasKey(JsonEncodable::TEST_KEY, $result['results'][0]);
        static::assertEquals(JsonEncodable::TEST_VALUE, $result['results'][0][JsonEncodable::TEST_KEY]);
    }

    public function testApiResponseWithArray()
    {
        $response = new ApiResponse(['test' => 'test']);
        $result   = json_decode($response->getContent(), true);

        static::assertCount(1, $result['results']);
        static::assertArrayHasKey('test', $result['results'][0]);
        static::assertEquals('test', $result['results'][0]['test']);
    }

    public function testApiResponseWithMultidimensionalArray()
    {
        $response = new ApiResponse(
            [
                [
                    'test'  => 'test',
                    'test2' => new JsonEncodable(),
                    'array' => ['hallo'],
                ],
                [
                    'test'  => 'test',
                    'test2' => new JsonEncodable(),
                ],
            ]
        );
        $result   = json_decode($response->getContent(), true);
        static::assertCount(2, $result['results']);
        static::assertArrayHasKey('test', $result['results'][0]);
        static::assertEquals('test', $result['results'][0]['test']);
        static::assertArrayHasKey(JsonEncodable::TEST_KEY, $result['results'][1]['test2']);
        static::assertEquals(JsonEncodable::TEST_VALUE, $result['results'][1]['test2'][JsonEncodable::TEST_KEY]);
    }

    public function testApiResponseWithMultidimensionalArrayNotCollection()
    {
        $response = new ApiResponse(
            [
                'test',
                'test',
            ]
        );
        $result   = json_decode($response->getContent(), true);
        static::assertCount(1, $result['results']);
        static::assertEquals('test', $result['results'][0][0]);
    }

    public function testApiResponseWithString()
    {
        try {
            new ApiResponse('Fail');
            static::fail('Exception not thrown!');
        } catch (\Exception $e) {
            static::assertTrue(true);
        }
    }

    public function testApiResponseWithBoolean()
    {
        try {
            new ApiResponse(true);
            static::fail('Exception not thrown!');
        } catch (\Exception $e) {
            static::assertTrue(true);
        }
    }

    public function testApiResponseWithInteger()
    {
        try {
            new ApiResponse(1);
            static::fail('Exception not thrown!');
        } catch (\Exception $e) {
            static::assertTrue(true);
        }
    }

    public function testApiResponseWithFloat()
    {
        try {
            new ApiResponse(1.1);
            static::fail('Exception not thrown!');
        } catch (\Exception $e) {
            static::assertTrue(true);
        }
    }
}
