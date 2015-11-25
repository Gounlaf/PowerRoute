# PowerRoute
Power route is a PHP routing system that can execute different sets of actions based in several components of the HTTP requests and is fully compatible with PSR-7.

The configuration is formed by three main components and defines a binary tree:
* **Input sources**: The input sources are the component that takes data from the request to be evaluated.
* **Matchers**: This component receives the value from the input source and executes a check on it.
* **Actions**: The component that is executed based in the result of the check executed by matchers.
    
In the configuration the actions can be set for the case in which the matcher returns true and for the case in which it returns true, hence building a binary tree.

The full system can be extended by adding input sources, matchers and actions. Also the names used in the configuration to identify the components can be assigned arbitrarily.

The components are grouped forming the nodes of the binary tree, each node looks as following:

```php
'route1' => [
    'condition' => [ // The condition is formed by the input source and the matcher
        'input-source' => [
        // The key is the identifier, and the value is the argument. It's the same for input sources, matchers and actions.
            'cookie' => 'cookieTest'
        ],
        'matcher' => [
            'notNull' => null
        ]
    ],
    'actions' => [
        'if-matches' => [ // This is an array with all the actions to run when the condition evaluates as true
                'displayFile' => __DIR__ . '/files/potato-{{cookie.cookieTest}}.html' // Placeholders can be used to access request data.
        ],
        'else' => [ // This is an array with all the actions to run when the condition evaluates as false
                'goto' => 'route2'
        ]
    ]
]
```

[![Build Status](https://travis-ci.org/mcustiel/PowerRoute.png?branch=master)](https://travis-ci.org/mcustiel/PowerRoute)
[![Coverage Status](https://coveralls.io/repos/mcustiel/PowerRoute/badge.svg?branch=master&service=github)](https://coveralls.io/github/mcustiel/PowerRoute?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mcustiel/PowerRoute/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/mcustiel/PowerRoute/?branch=master)


## Table of contents

* [Installation](#installation)
* [How to use](#how-to-use)
    * [The configuration](#the-configuration)
    * [The code](#the-code)
* [Predefined components](#predefined-components)
    * [Input sources](#input-sources)
    * [Matchers](#matchers)
    * [Actions](#actions)
* [Extending PowerRoute](#extending-powerroute)
    * [Creating your own actions](#creating-your-own-actions)
        * [TransactionData class](#transactiondata-class)
        * [Placeholders](#placeholders)
    * [Creating your own input sources](#creating-your-own-input-sources)
    * [Creating your own matchers](#creating-your-own-matchers)

## Installation

This project is published in packagist, so you just need to add it as a dependency in your composer.json:

```javascript
    "require": {
        // ...
        "mcustiel/power-route": "*"
    }
```

If you want to access directly to this repo, adding this to your composer.json should be enough:

```javascript
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/mcustiel/PowerRoute"
        }
    ],
    "require": {
        "mcustiel/power-route": "dev-master"
    }
}
```

Or just download the release and include it in your path.

## How to use

### The configuration

The configuration must be a php array. It must define two keys:
* root: The name of the root node of the graph.
* nodes: The definition of all the nodes, this is a key => value pairs array where key is the name of the node and value it's definition.

#### Example

A configuration that always redirects to google.com:

```php
[
    'root' => 'default',
    'nodes' => [
        'default' => [
            'condition' => [],
            'actions' => [
                'if-matches' => [
                    [
                        'redirect' => 'http://www.google.com'
                    ]
                ]
            ]
        ]
    ]
]
```

You can use the names you prefer for the input sources, the matchers and the actions and then map them in the factories provided by this library.

### The code

After all the configuration is correctly defined, Executor class must be used to walk the graph based in the request received.
To create an instance of Executor class, the factories for Actions, Input Sources and Matchers must be created first.

```php
use Mcustiel\PowerRoute\Matchers\NotNull;
use Mcustiel\PowerRoute\Matchers\Equals;
use Mcustiel\PowerRoute\InputSources\QueryStringParam;
use Mcustiel\PowerRoute\Actions\Redirect;
use Your\Namespace\MyMatcher;
use Your\Namespace\MyInputSource;
use Your\Namespace\MyAction;

$matcherFactory = new MatcherFactory(
    [ 'notNull' => NotNull::class, 'equals' => Equals::class, 'someSpecialMatcher' => MyMatcher::class ]
);
$inputSourceFactory = new InputSourceFactory(
    [ 'get' => QueryStringParam::class, 'someSpecialInputSource' => MyInputSource::class ]
);
$actionFactory = new ActionFactory(
    [ 'redirect' => Redirect::class, 'someSpecialAction' => MyAction::class ]
);

$config = $yourConfigManager->getYourPowerRouteConfig();
$executor = new Executor($config, $actionFactory, $inputSourceFactory, $matcherFactory);
```

After you have your executor instance, just call start method with the PSR7 request and response:

```php
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response\SapiEmitter;

$request = ServerRequestFactory::fromGlobals();
$response = $executor->start($request, new Response());

(new SapiEmiter())->emit($response);
```

## Predefined components

### Input sources

#### Cookie
Allows to execute actions based in cookies from the http request.

##### Arguments
The name of the cookie.

#### Header
Allows to execute actions based in headers from the http request.

##### Arguments
The name of the header.

#### Method
Returns the http method used to execute request. It receives no parameters.

#### QueryStringParam
Allows to execute actions based in parameters from the request's query string.

##### Arguments
The name of the query string parameter.

#### Url
Allows to execute actions based in the url or parts of it.

##### Arguments
A string specifying the part of the url to evaluate. With the following possible values:
* **full**: Evaluates the full url.
* **host**: Evaluates the host.
* **scheme**: Evaluates the scheme.
* **authority**: Evaluates the authority part.
* **fragment**: Evaluates the fragment.
* **path**: Evaluates the path.
* **port**: Evaluates the port.
* **query**: Evaluates the query.
* **user-info**: Evaluates the user information part.

### Matchers

#### Equals
Returns true if the value from the input source is equal to another value received as argument.

#### InArray
Returns true if the value from the input source is in a list of values received as argument.

#### NotEmpty
Returns true if the value from the input source is not empty.

#### NotNull
Returns true if the value from the input source is not null.

#### RegExp
Returns true if the value from the input source matches a regular expression received as argument.

### Actions

#### DisplayFile

This action displays a file. Its path must be defined as argument.

#### NotFound

This action sets the http status code to 404 in the response.

#### Redirect

This action adds a Location header to the response and set the http status code to 302. Its redirection target must be defined as argument.

#### SaveCookie

This action sets the value of a cookie. It receives as an argument an object with all the needed data for the cookie:
* name
* value
* domain
* path
* secure

#### SetHeader

This action sets the value of a header. As an argument receives an object with the following keys:
* name
* value

## Extending PowerRoute

### Creating your own actions

To create your own actions to be used through PowerRoute you have to create a class in which you should extend AbstractArgumentAware class and must implement ActionInterface. If you want to give your action the ability to support placeholders, you you must use PlacheolderEvaluator trait.

* **AbstractArgumentAware** is a class shared by all components, that gives them access to the argument from the configuration.
* **ActionInterface** defines the method that should be implemented by the action.
* **PlaceholderEvaluator** defines the method getValueOrPlaceholder, that gives your action the ability to parse possible placeholders in a string.

```php
interface ActionInterface
{
    public function execute(\Mcustiel\PowerRoute\Common\TransactionData $transactionData);
}
```

TransactionData is an object that is passed as an argument to all actions, it is used to share the request, the response and other data that you may want to share between them.

Inside an action you should retrieve the object you want to modify from TransactionData (request or response object). Then you modify it and set the new object again in TransactionData. This must be done this way because PSR7 are immutable.

You can even init a framework inside an action. 

#### Examples of an action:

```php
class NotFound implements ActionInterface
{
    public function execute(TransactionData $transactionData)
    {
        return $transactionData->setResponse($transactionData->getResponse()->withStatus(404, 'Not Found'));
    }
}
```

```php
class Redirect extends AbstractArgumentAware implements ActionInterface
{
    use PlaceholderEvaluator;

    public function execute(TransactionData $transactionData)
    {
        return $transactionData->setResponse(
            $transactionData->getResponse()
            ->withHeader(
                'Location',
                $this->getValueOrPlaceholder($this->argument, $transactionData)
            )
            ->withStatus(302)
        );
    }
}
```

#### TransactionData class:

This class is passed as an argument to every action and defines two methods to access the current request and the corresponding response (getRequest and getResponse respectively). Also it gives you the ability to save and fetc custom variables throught **get($name)** and **set($name, $value)** methods.

#### Placeholders:

The arguments an action receives can include a placeholder to access values from the TransactionData object. The arguments have the following format:

```
{{source.name}}
``` 

Where source indicates from where to obtain the value, and name is the identifier associated with the given value.

#### Possible placeholder sources:

* **var**: allows you to access some custom value saved in the TransactionData object.
* **uri**: allows you to access data from the url used to request. If you call it without an identifier, it returns the full url. If not, it allows a serie of identifiers to retrieve parts of the request:    
  * **full**: also returns the full url.
  * **host**: returns the host part of the url.
  * **scheme**: returns the scheme part of the url.
  * **authority**: returns the authority part of the url.
  * **fragment**: return the fragment part of the url.
  * **path**: returns the path of the url used in the current request.
  * **port**: returns the port requested in the url.
  * **query**: returns the query string from the current request.
  * **user-info**: returns the user information specified in the url.
* **method**: returns the method used in the current request.
* **get**: allows you to access a parameter from the query string, it must be specified as the name part of the placeholder. 
* **header**: allows you to access a header, it must be specified as the name part of the placeholder.
* **cookie**: allows you to access a cookie, it must be specified as the name part of the placeholder.
* **post**:  allows you to access a post variable, it must be specified as the name part of the placeholder.
* **bodyParam**: allows you to access a variable from the body, it must be specified as the name part of the placeholder.

** __Note__: See PSR7 documentation for more information about previous sources.

### Creating your own input sources

The input source is the component used to access data from the request, it uses a matcher uses to validate the data and the request.

It also should extend AbstractArgumentAware to have access to the argument from the configuration and it must implement InputSourceInterface. It must return the value so PowerRoute gives it to the matcher.

```php
interface InputSourceInterface
{
    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return mixed
     */
    public function evaluate(ServerRequestInterface $request);
}
```

#### Example of an InputSource:

```php
class Header extends AbstractArgumentAware implements InputSourceInterface
{
    public function evaluate(ServerRequestInterface $request)
    {
        $header = $request->getHeaderLine($this->argument);
        return $header ?: null;
    }
}
```

### Creating your own matchers

The matcher is the component in charge of executing a check against the value obtained from the request by the InputSource. To create your own matcher, you must create a class that should extend AbstractArgumentAware to access the argument and must implement MatcherInterface.

```php
interface MatcherInterface
{
    /**
     * @param mixed $value
     *
     * @return boolean
     */
    public function match($value);
}
```

#### Example of a Matcher:

```php
class Equals extends AbstractArgumentAware implements MatcherInterface
{
    public function match($value)
    {
        return $value == $this->argument;
    }
}
```

## Possible uses

### API versioning

```php
return [
    'root' => 'checkHeaders',
    'nodes' => [
        'checkHeaders' => [
            'condition' => [
                'input-source' => [
                    'header' => 'Accept'
                ],
                'matcher' => [
                    'regExp' => '/application\/vnd.myapp.(\d+)\+json/'
                ]
            ],
            'actions' => [
                'if-matches' => [
                    'myActionChooseApiFromHeader' => '{{header.Accept}}'
                ],
                'else' => [
                    'goto' => 'checkUrl'
                ]
            ]
        ],
        'checkUrl' => [
            'condition' => [
                'input-source' => [
                    'uri' => null
                ],
                'matcher' => [
                    'regExp' => '/myApiPath\/(\d+)\/.*$/'
                ]
            ],
            'actions' => [
                'if-matches' => [
                    'myActionChooseApiFromUrl' => '{{uri.path}}'
                ],
                'else' => [
                    'goto' => 'default'
                ]
            ]
        ],
        'default' => [
            'condition' => [],
            'actions' => [
                'if-matches' => [
                    'runLatestApiVersion' => null
                ]
            ]
        ]
    ]
]
```