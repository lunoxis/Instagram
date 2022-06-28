<?php

declare (strict_types = 1);

namespace Instagram\Media;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Instagram\Exception\InstagramInvalidException;
use Instagram\Exception\InstagramLoginException;
use Instagram\Url\URLs;
use Instagram\Url\UserAgent;

class HighLight{
    /**
     * Undocumented variable
     *
     * @var [type]
     */
    public $link = [];
    /**
     * Undocumented variable
     *
     * @var Client
     */
    public Client $Client;
    /**
     * Undocumented function
     *
     * @return void
     */
    public function GetLink()
    {
        return $this->link;
    }
    /**
     * Undocumented function
     *
     * @param [type] $HighLightLink
     */
    public function __construct($HighLightLink)
    {
        if(file_exists('session.json'))
        {
            $data = json_decode(file_get_contents('session.json'));
            $data = $data[array_rand($data)];
            $this->Client = new Client;
            try
            {
                preg_match('~^(?:https?://)?(?:www\.)?instagram\.com/s/(?:[^\?]+)\?story_media_id=(\d+)_(\d+)~',$HighLightLink,$m);
                $code = get_headers($HighLightLink, true)['Location'][1];
                preg_match('~^(?:https?://)?(?:www\.)?instagram\.com/stories/highlights/(.+)/~',$code,$match);
                $query = $this->Client->request('GET', \Instagram\Url\URLs::GetHighLight($match[1]), [
                    'headers'=>[
                        'Connection'=> 'keep-alive',
                        'Keep-Alive' =>'300',
                        'Accept-Charset'=>'ISO-8859-1,utf-8;q=0.7,*;q=0.7',
                        'Accept-Language'=>'en-us,en;q=0.5',
                        'x-ig-app-id'=>URLs::X_IG_APP_ID,
                        'Cookie'=>'mid='.$data->mid.';csrftoken='.$data->csrftoken.';sessionid='.$data->sessionid,
                        'user-agent'=>UserAgent::AGENT_URL
                    ]
                ]);
                $body = json_decode($query->getBody()->getContents());
               foreach($body->reels->{"highlight:$match[1]"}->items as $key=>$value)
               {
                if($value->pk == $m[1])
                {
                    if(isset($value->video_versions))
                    {
                        $this->link['video'] = $value->video_versions[0]->url;
                    }else{  
                        $this->link['image'] = $value->image_versions2->candidates[0]->url;
                    }
                    break;
                }
               }

            }catch(ClientException $Exception)
            {
                $data = (string) $Exception->getResponse()->getBody();
                if (!isset($body->items)) {
                    throw new InstagramInvalidException('Invalid Hash');
                }
                return $data;
            }
        }else
        {
            throw new InstagramInvalidException('Please First Login !');
        }
    }
}
