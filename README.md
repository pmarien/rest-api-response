Rest API Response Library
=========================
[![Build Status](https://travis-ci.org/pmarien/rest-api-response.svg)](https://travis-ci.org/pmarien/rest-api-response)
[![Coverage Status](https://coveralls.io/repos/pmarien/rest-api-response/badge.svg?branch=develop&service=github)](https://coveralls.io/github/pmarien/rest-api-response?branch=develop)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/358209df-2792-425b-ae62-eacc6742db3c/mini.png)](https://insight.sensiolabs.com/projects/358209df-2792-425b-ae62-eacc6742db3c)

This Library provides a Response abstraction for RESTful JSON-API's on top of the Symfony HTTP-Foundation-Component.

The Library defines custom Exceptions and Exception-Interfaces for Error Handling. 

There is a Response-Class for handling of successfull responses and an Error-Response-Class for Exception-Responses.

## Install with Composer

    composer require pmarien/rest-api-response

### Version
If you use the symfony/http-foundation in any version lower than 3.0 please use version 1.* of these library.

If you use the symfony/http-foundation in any version higher than 3.0 please use version 2.* of these library.


## Usage
### JSON Output

**Status**:

*indicates, weather the request was successful or not*
 
**Count**:

*Number of results which are delivered within the results array*

**Results**:

*Array of one or more data objects (your data)*

#### Success

    {
        "status": "success",
        "count": 1,
        "results": [
            {
                "custom": "data"
            }
        ]
    }

#### Error

    {
        "status": "error",
        "count": 1,
        "results": [
            {
                "code": 0,
                "message": "Error Message",
                "previous": null,
                "data": [
                    "optional custom debug data, can be an object or an array"
                ]
            }
        ]
    }

### Get a Response Object
```$response = new ApiResponse(['message'=>'Hello World']);```

```$errorResponse = new ApiResponse(new \Exception('Request failed!'));```

### Object Handling
By default, protected and private properties of objects will be ignored be json\_encode().

To build a response from custom objects, this library provides an Interface (JsonEncodableInterface). Objects which implement these Interface can be handled on custom way.

#### Example
**your Class**

    class CustomObject implements JsonEncodableInterface {
    
        /**
         * @var string
         */
        protected $publicForResponse = 'hello';
        
        /**
         * @var string
         */
        protected $notPublic = 'world';
        
        /**
         * Return an array of properties which can be encoded as json
         * @return array
         */
        public function encode(){
            return [
                'public' => $this->publicForResponse
            ];
        }
    }

**your Controller Action**

    public function testAction(){
        return new ApiResponse(new CustomObject());
    }    

**Json-Response**

    {
        "status": "success",
        "count": 1,
        "results": [
            {
                "public": "hello"
            }
        ]
    }

### Exceptions
There are four special Exceptions and Interfaces defined in this Library:

**ExceptionInterface**:

*Provides a Method called "getMetaData" which should return an array with custom debug data for the error response*

**UncriticalExceptionInterface**:

*If an Exception implements these Interface, the error response will return the error object and status but with a HTTP-Status-Code 200 (Ok)*

**CriticalExceptionInterface**:

*With these Interface you are able to define a custom HTTP-Status-Code instead of the default 500 (Internal Server Error) Status*

**ExceptionListInterface**: 

*With these Interface you are able to define more than one error result object for one response*

**Please note that your custom Exception must extend the basic php exception, even if you implement one ore more of the interfaces.**

There are also predefined exceptions ready to use:

**UncriticalException**:

*Implements the ExceptionInterface and the UncriticalExceptionInterface*

**CriticalException**:

*Implements the ExceptionInterface and the CriticalExceptionInterface*

**UncriticalExceptionExceptionList**:

*Implements the ExceptionInterface, the UncriticalExceptionInterface and the ExceptionListInterface*

**CriticalExceptionExceptionList**:

*Implements the ExceptionInterface, the CriticalExceptionInterface and the ExceptionListInterface*

## Licence
This library is under MIT Licence.
