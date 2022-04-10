# Magento 2 AdminUrl

It's a magento 2 module to create a direct URL to adminhtml page without being redirected to dashboard.

## How to install?

#### Via Composer

If you try to install via composer, just require your project to the module by running this command :

```
composer require fiko/magento2-adminurl
```

#### Manually

1. Download this repo
2. Create a Directory `app/code/Fiko/AdminUrl`
3. Copy downloaded repo to this directory

Once you download it (both composer or manually), just run this commands to apply this module to your project :

```
php bin/magento setup:upgrade --keep-generated
php bin/magento setup:di:compile
```

## How to use?

Simply just use the model

```
class Example
{
    public function __construct(
        .......
        \Fiko\AdminUrl\Model\Url $adminUrl
        .......
    ) {
        .......
        $this->adminUrl = $adminUrl;
        .......
    }

    public function execute()
    {
        $catalogUrl = $this->adminUrl->getUrl('catalog/index/index');
    }
}
```

## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License

[MIT](COPYING.txt) &copy; 2022
