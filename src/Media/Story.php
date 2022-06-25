<?php

declare (strict_types = 1);

namespace Instagram\Media;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Instagram\Exception\InstagramInvalidException;
use Instagram\Exception\InstagramLoginException;
use Instagram\Url\URLs;
use Instagram\Url\UserAgent;

class Story{
    /**
     * Undocumented variable
     *
     * @var [type]
     */
    public $Link;
    /**
     * Undocumented variable
     *
     * @var Client
     */
    public Client $client;
    /**
     * Undocumented function
     *
     * @return string
     */
    public function GetLink() : string
    {
        return $this->Link;
    }
    /**
     * Undocumented function
     *
     * @param string $story_link
     */
    public function __construct( string $story_link) 
    {
        if (file_exists('session.json')) 
        {
                $data = json_decode(file_get_contents('session.json'));
                $data = $data[array_rand($data)];
                $this->Client = new Client;
            try 
            {
                preg_match('~^https://instagram.com/stories/(.+)/(\d+)\?igshid=.*~',$story_link,$match);
                $query = $this->Client->request('GET',\Instagram\Url\URLs::GetAccountJsonInfo($match[1]),
                [
                    'headers'=>[
                        'Connection'=> 'keep-alive',
                        'Keep-Alive' =>'300',
                        'Accept-Charset'=>'ISO-8859-1,utf-8;q=0.7,*;q=0.7',
                        'Accept-Language'=>'en-us,en;q=0.5',
                        'Cookie'=>'mid='.$data->mid.';csrftoken='.$data->csrftoken.';sessionid='.$data->sessionid,
                        'user-agent'=>UserAgent::AGENT_URL
                    ]
                ]);
                $body = json_decode($query->getBody()->getContents());
                if(isset($body->graphql->user->id))
                {
                $query =  $this->Client->request('GET',\Instagram\Url\URLs::GetStoryUser($body->graphql->user->id),
                [
                    'headers'=>[
                        'Connection'=> 'keep-alive',
                        'Keep-Alive' =>'300',
                        'Accept-Charset'=>'ISO-8859-1,utf-8;q=0.7,*;q=0.7',
                        'Accept-Language'=>'en-us,en;q=0.5',
                        'x-ig-app-id' =>URLs::X_IG_APP_ID,
                        'Cookie'=>'mid='.$data->mid.';csrftoken='.$data->csrftoken.';sessionid='.$data->sessionid,
                        'user-agent'=>UserAgent::AGENT_URL
                    ]
                ]);
                $body = json_decode($query->getBody()->getContents());
                foreach($body->reel->items as $key=>$value)
                {
                    if($value->pk == $match[2])
                    {
                        if(!isset($value->video_versions))
                        {
                            $this->Link= $value->image_versions2->candidates[0]->url;
                        }else
                        {
                            $this->Link =  $value->video_versions[0]->url;
                        }
                    }
                }
                }else
                {
                    throw new InstagramInvalidException('Story Link Invalid!');
                }
            } catch (ClientException $exception) 
            {
                $data = (string) $exception->getResponse()->getBody();
                return $data;
            }
        } else 
        {
            throw new InstagramLoginException('Please First Login');
        }
    }
}