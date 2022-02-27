# Hyperf 🤝 Doctrine

This project provides an integration for the Doctrine ORM and the Hyperf framework.

[![CI](https://github.com/leocavalcante/hyperf-doctrine/actions/workflows/ci.yml/badge.svg)](https://github.com/leocavalcante/hyperf-doctrine/actions/workflows/ci.yml)

## Install
```
composer require leocavalcante/hyperf-doctrine
```

## Setup
You should publish `hyperf/db` as this package uses it as the underlaying driver engine:
```shell
php bin/hyperf.php vendor:publish hyperf/db
```

**⭐ This means that you have Doctrine ORM baked into Hyperf pools and connections lifecycle management free of charge** - *How awesome?*

Configure the database in `config/autoload/db.php`:
```php
return [
    'default' => [
        'driver' => 'pdo',
        'host' => env('DB_HOST', 'localhost'),
        'port' => env('DB_PORT', 3306),
        'database' => env('DB_DATABASE', 'hyperf'),
        'username' => env('DB_USERNAME', 'root'),
        'password' => env('DB_PASSWORD', ''),
        'charset' => env('DB_CHARSET', 'utf8mb4'),
        'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
        'fetch_mode' => PDO::FETCH_ASSOC,
        'pool' => [
            'min_connections' => 1,
            'max_connections' => 10,
            'connect_timeout' => 10.0,
            'wait_timeout' => 3.0,
            'heartbeat' => -1,
            'max_idle_time' => (float) env('DB_MAX_IDLE_TIME', 60),
        ],
        'options' => [
            PDO::ATTR_CASE => PDO::CASE_NATURAL,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_ORACLE_NULLS => PDO::NULL_NATURAL,
            PDO::ATTR_STRINGIFY_FETCHES => false,
            PDO::ATTR_EMULATE_PREPARES => false,
        ],
    ],
];
```

Then publish Hyperf Doctrine configurations:
```shell
php bin/hyperf.php vendor:publish leocavalcante/hyperf-doctrine
```

You can edit Doctrine's Entity Manager settings in `config/autoload/doctrine.php`:
```php
return [
    'connection' => [
        'driverClass' => Hyperf\Doctrine\Driver::class,
        'pool' => 'default',
    ],
    'config' => Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration([__DIR__ . '/app']),
];
```

It will also publish a `cli-config.php` to `config/` so you can already run `vendor/bin/doctrine`, for example:
```shell
vendor/bin/doctrine orm:schema-tool:create
```

## Usage
At this time, you are ready to use Doctrine ORM with Hyperf.

For example, create an Entity as you would do regulary:
```php
/**
 * @ORM\Entity()
 * @ORM\Table(name="users")
 */
final class User
{
    public function __construct(
        /**
         * @ORM\Id()
         * @ORM\Column(type="integer")
         * @ORM\GeneratedValue(strategy="AUTO")
         */
        public int $id,
        /*
         * @ORM\Column(type="string")
         */
        public string $name,
        /**
         * @ORM\Column(type="string")
         */
        public string $email,
    ) {
    }
}
```

Then let dependency injection magic do the work to inject an `EntityManager` into your application:
```php
/**
 * @Controller(prefix="users")
 */
final class UsersController
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {
    }

    /**
     * @GetMapping(path="")
     */
    public function index(RequestInterface $request, ResponseInterface $response)
    {
        return $this->em->getRepository(User::class)->findAll();
    }
}
```

**And that is it!**

Feel free to contribute submiting issues and PRs.

---

MIT &copy; 2022 Leo Cavalcante
