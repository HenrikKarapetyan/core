# Container

### how to use container

```php
require "../vendor/autoload.php";
use Henrik\Container\Container;use Henrik\Container\ContainerModes;

$container = new Container();

$container->set('x',new stdClass());
$container->changeMode(ContainerModes::MULTIPLE_VALUE_MODE);

var_dump($container->get('x'));
```