<?php

require __DIR__.'/vendor/autoload.php';
//--------------- Login and Create Session-----------------------//
/*$ig = new Instagram\Login\Instagram('USERNAME', 'PASSWORD');
$cooki = $ig->login();
$session = new \Instagram\Login\Session();
print_r($session->SetSession($cooki->getCookieByName('mid')->getValue(),$cooki->getCookieByName('csrftoken')->getValue(),$cooki->getCookieByName('sessionid')->getValue()));*/


//-------------------------- GET Media Post ---------------------//
/*$media = new \Instagram\Media\Post('https://www.instagram.com/p/CfJec1mMLie/?igshid=YmMyMTA2M2Y=');
 print_r( $media->GetPost());*/


 //----------------------- GET Link Story------------------------//
/*$story = new \Instagram\Media\Story('https://instagram.com/stories/pcgadjettv/2868234876450457114?igshid=MDJmNzVkMjY=');
echo $story->GetLink();*/


//------------------------ GET All Story ------------------------//
/*$story = new \Instagram\Media\AllStory('click.ir');
print_r( $story->GetLink());
echo $story->MediaCount();*/


//------------------------- GET Link High Light------------------//
/*$high = new \Instagram\Media\HighLight('https://www.instagram.com/s/aGlnaGxpZ2h0OjE3OTI5NjQ4NzIzOTAyNjMy?story_media_id=2768449635828641458_7247131961&igshid=YmMyMTA2M2Y=');
echo $high->GetLink();*/


//------------------------ GET ALL High Light --------------------//
//$all = new \Instagram\Media\AllHighLight();
/*$all->GetAllHighLight('click.ir');
print_r($all->GetHighLight());*/
/*$all->GetHighLightmedia('highlight:17917690438338215');
print_r($all->HighLightLink());*/

//-------------  GET Account Info ---------------------//
$info = new \Instagram\Media\info('click.ir');
echo $info->GetInfo()[0]['username'];
