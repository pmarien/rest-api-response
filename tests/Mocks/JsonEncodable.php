<?php
namespace PMarien\RestApiResponse\Tests\Mocks;

use PMarien\RestApiResponse\JsonEncodableInterface;

/**
 * @author Philipp Marien <philipp.marien@gmail.com>
 */
class JsonEncodable implements JsonEncodableInterface
{
    const TEST_KEY = 'key';
    const TEST_VALUE = 'value';

    /**
     * @return array
     */
    public function encode()
    {
        return [self::TEST_KEY => self::TEST_VALUE];
    }
}
