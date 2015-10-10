# PowerRoute
Power route is a PHP routing system that can execute different sets of actions based in several components of the HTTP requests and is fully compatible with PSR-7.

The configuration is formed by three main components and defines a binary tree:
* Evaluators: The evaluators are the component that takes something from the request to be evaluated.
* Matchers: This component receives the value from the evaluator and executes a check on it.
* Actions: The component that is executed based in the result of the check executed by matchers.
    
In the configuration the actions can be set for the case in which the matcher returns true and for the case in which it returns true, hence building a binary tree.

The full system can be extended by adding evaluators, matchers and actions. Also the names used in the configuration to identify the components can be assigned arbitrarily.

The components are grouped forming the nodes of the binary tree, each node looks as following:

```php
'route1' => [
    'condition' => [ // The condition is formed by the evaluator and the matcher
        'evaluator' => [
            'cookie' => 'cookieTest'
        ],
        'matcher' => [
            'notNull' => null
        ]
    ],
    'actions' => [
        'match' => [ // This is an array with the actions to run when the condition evaluates as true
            [
                'displayFile' => __DIR__ . '/files/potato-{{cookie.cookieTest}}.html'
            ]
        ],
        'doesNotMatch' => [ // This is an array with the actions to run when the condition evaluates as false
            [
                'goto' => 'route2'
            ]
        ]
    ]
]
```

## Predefined components

### Evaluators

#### CookieEvaluator
Allows to execute actions based in cookies from the http request.

##### Arguments
The name of the cookie.

#### HeaderEvaluator
Allows to execute actions based in headers from the http request.

##### Arguments
The name of the header.

#### QueryStringParamEvaluator
Allows to execute actions based in parameters from the request's query string.

##### Arguments
The name of the query string parameter.

#### UrlEvaluator
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

#### EqualsMatcher
Returns true if the value from the evaluator is equal to another value received as argument.

### InArrayMatcher
Returns true if the value from the evaluator is in a list of values received as argument.

### NotEmptyMatcher
Returns true if the value from the evaluator is not empty.

### NotNull
Returns true if the value from the evaluator is not null.

### RegExpMatcher
Returns true if the value from the evaluator matches a regular expression received as argument.

### Actions

#### DisplayFileAction

This action displays a file. Its path must be defined as argument.

#### NotFoundAction

This action sets the http status code to 404 in the response.

#### RedirectAction

This action adds a Location header to the response and set the http status code to 302. Its redirection target must be defined as argument.

#### SaveCookieAction

This action sets the value of a cookie. It receives as an argument an object with all the needed data for the cookie:
* name
* value
* domain
* path
* secure

#### SetHeaderAction

This action sets the value of a header. As an argument receives an object with the following keys:
* name
* value

## The configuration

The configuration should be a php array. It must define two keys:
* start: The first route to evaluate (the root of the binary tree).
* routes: The definition of all the routes.

