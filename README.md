# PowerRoute
Power route is a PHP routing system that can execute different sets of actions based in several components of the HTTP requests and is fully compatible with PSR-7.

The configuration is formed by three main components and defines a binary tree:
* Evaluators: The evaluators are the component that takes something from the request to be evaluated.
* Matchers: This component receives the value from the evaluator and executes a check on it.
* Actions: The component that is executed based in the result of the check executed by matchers.
    
In the configuration the actions can be set for the case in which the matcher returns true and for the case in which it returns true, hence building a binary tree.

The full system can be extended by adding evaluators, matchers and actions. Also the names used in the configuration to identify the components can be assigned arbitrarily.

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
* full: Evaluates the full url.
* host: Evaluates the host.
* scheme: Evaluates the scheme.
* authority: Evaluates the authority part.
* fragment: Evaluates the fragment.
* path: Evaluates the path.
* port: Evaluates the port.
* query: Evaluates the query.
* user-info: Evaluates the user information part.

