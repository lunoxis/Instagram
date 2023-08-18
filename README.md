# Instagram Media Scraper 
This is a simple library for extracting media from Instagram. 

## Dependencies
- PHP >= 8.0.6

## Login Example
```php
require __DIR__.'/vendor/autoload.php';
$ig = new Instagram\Login\Instagram('Username', 'Pass');
$cooki = $ig->login();
$session = new \Instagram\Login\Session();
print_r($session->SetSession($cooki->getCookieByName('rur')->getValue(),$cooki->getCookieByName('csrftoken')->getValue(),$cooki->getCookieByName('sessionid')->getValue(),$cooki->getCookieByName('ds_user_id')->getValue()));
```

Get Post Media By Link: 

```php
require __DIR__.'/vendor/autoload.php';
$media = new \Instagram\Media\Post('https://www.instagram.com/p/CfJec1mMLie/?igshid=YmMyMTA2M2Y=');
print_r( $media->GetPost());
```

Get Account Info By Username 

```php
require __DIR__.'/vendor/autoload.php';

$info = new \Instagram\Media\Info('click.ir');
Get All Info
print_r($info->GetInfo());
Get Info
echo $info->GetInfo()[0]['username'];
```
Get Story By Story Link

```php
require __DIR__.'/vendor/autoload.php';

$story = new \Instagram\Media\Story('https://instagram.com/stories/pcgadjettv/2868234876450457114?igshid=MDJmNzVkMjY=');
echo $story->GetLink();

```
Get All Story By Username

```php
require __DIR__.'/vendor/autoload.php';

$story = new \Instagram\Media\AllStory('click.ir');
print_r( $story->GetLink());
echo $story->MediaCount();
```

Get HighLight BY HighLight Link
```php
require __DIR__.'/vendor/autoload.php';

$high = new \Instagram\Media\HighLight('https://www.instagram.com/s/aGlnaGxpZ2h0OjE3OTI5NjQ4NzIzOTAyNjMy?story_media_id=2768449635828641458_7247131961&igshid=YmMyMTA2M2Y=');
echo $high->GetLink();

```

Get All HighLight BY Username

```php
require __DIR__.'/vendor/autoload.php';

$all = new \Instagram\Media\AllHighLight();
$all->GetAllHighLight('click.ir');
print_r($all->GetHighLight());

Download HighLight BY HighLight ID 

$all->GetHighLightmedia('highlight:17917690438338215');
print_r($all->HighLightLink());

```


## Installation

### Using composer

```sh
composer.phar require lunoxis/instagram
```
or 
```sh
composer require lunoxis/instagram 
```

### If you don't have composer
You can download it [here](https://getcomposer.org/download/).

