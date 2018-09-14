# Soft Deletable Bundle

## Install

```bash
composer require zogxray/soft-deletable-bundle
```

## Config with defaults

```yaml
soft_delete:
    connections:
        default:
```

## Config with custom filter and/or subscriber

```yaml
soft_delete:
    connections:
        example:
          filter: YourNamespace\App\Doctrine\Filters\SoftDeleteFilter
          subscriber: YourNamespace\App\Doctrine\Filters\SoftDeleteSubscriber
```

## Register
```php
return [
    Zogxray\SoftDeletableBundle\SoftDeletableBundle::class => ['all' => true],
];
```

## Usage

```php
class Order implements SoftDeletableInterface
{
    /**
     * @return \DateTime|null
     */
    public function getDeletedAt() :?\DateTime
    {
        return $this->deletedAt;
    }

    /**
     * @param \DateTime|null $deletedAt
     */
    public function setDeletedAt(?\DateTime $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }
}
```

## Troubleshooting
##### Specify connection names
```php
    dbal:
        default_connection: default
        connections:
            default:
                driver: 'pdo_sqlite'
                server_version: '3.15'
                charset: utf8mb4
                url: '%env(resolve:DATABASE_URL)%'
```

## License

The Soft Deletable Bundle is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

