# PowerRoute
Power route is a PHP routing system that can execute different sets of actions based in several components of the HTTP requests and is fully compatible with PSR-7.

**Important note:** PowerRoute is a work in progress, there is no versions yet and no BC checks are done during development. 

The configuration is formed by three main components and defines a binary tree:
* Input sources: The input sources are the component that takes something from the request to be evaluated.
* Matchers: This component receives the value from the input source and executes a check on it.
* Actions: The component that is executed based in the result of the check executed by matchers.
    
In the configuration the actions can be set for the case in which the matcher returns true and for the case in which it returns true, hence building a binary tree.

The full system can be extended by adding input sources, matchers and actions. Also the names used in the configuration to identify the components can be assigned arbitrarily.

The components are grouped forming the nodes of the binary tree, each node looks as following:

```php
'route1' => [
    'condition' => [ // The condition is formed by the input source and the matcher
        'input-source' => [
            'cookie' => 'cookieTest'
        ],
        'matcher' => [
            'notNull' => null
        ]
    ],
    'actions' => [
        'if-matches' => [ // This is an array with the actions to run when the condition evaluates as true
            [
                'displayFile' => __DIR__ . '/files/potato-{{cookie.cookieTest}}.html'
            ]
        ],
        'else' => [ // This is an array with the actions to run when the condition evaluates as false
            [
                'goto' => 'route2'
            ]
        ]
    ]
]
```

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

