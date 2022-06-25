<?php
declare (strict_types = 1);

namespace Instagram\Media;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Instagram\Exception\InstagramInvalidException;
use Instagram\Exception\InstagramLoginException;
use Instagram\Url\URLs;
use Instagram\Url\UserAgent;

class AllHighLight{
    /**
     * Undocumented variable
     *
     * @var Client
     */
    public Client $Client;
    /**
     * Undocumented variable
     *
     * @var array
     */
    public array $HighLight = [];
    /**
     * Undocumented variable
     *
     * @var array
     */
    public array $LinkDown = [];
    /**
     * Undocumented function
     *
     * @return mixed
     */
    public function HighLightLink() : mixed
    {
        return $this->LinkDown;
    }
    /**
     * Undocumented function
     *
     * @return mixed
     */
    public function GetHighLight() : mixed
    {
        return $this->HighLight;
    }
    /**
     * Undocumented function
     *
     * @param string $username
     * @return void
     */
    public function GetAllHighLight(string $username)
    {
        if(file_exists('session.json'))
        {
            $data = json_decode(file_get_contents('session.json'));
            $data = $data[array_rand($data)];
            $this->Client = new Client;
            try
            {
                $query = $this->Client->request('GET',\Instagram\Url\URLs::GetAccountJsonInfo($username),[
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
                $id = $body->graphql->user->id;
                $query = $this->Client->request('GET', \Instagram\Url\URLs::GetAllHighLight($id), [
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
                
                foreach($body->tray as $key=>$value)
                {
                    $this->HighLight[] = [
                        'HighLight_id'=> $value->id,
                        'cover_media'=>$value->cover_media->cropped_image_version->url,
                        'title'=>$value->title,
                        'media_count'=>$value->media_count
                    ];
                }
            }catch(ClientException $exception)
            {
                $data = (string) $exception->getResponse()->getBody();
                if(!isset($body->tray)){
                    throw new InstagramInvalidException('Invalid username');
                }
                return $data;
            }
        }else{
            throw new InstagramLoginException('Please First Login');
        }
    }
    /**
     * Undocumented function
     *
     * @param string $HighLightId
     * @return void
     */
    public function GetHighLightmedia(string $HighLightId)
    {
        if(file_exists('session.json'))
        {
            $data = json_decode(file_get_contents('session.json'));
            $data = $data[array_rand($data)];
            $this->Client = new Client;
            try
            {
                $query = $this->Client->request('GET', \Instagram\Url\URLs::GetHighLight(explode(':',$HighLightId)[1]), [
                    'headers'=>[
                        'Connection'=> 'keep-alive',
                        'Keep-Alive' =>'300',
                        'Accept-Charset'=>'ISO-8859-1,utf-8;q=0.7,*;q=0.7',
                        'Accept-Language'=>'en-us,en;q=0.5',
                        'x-asbd-id'=>' 198387',
                        'x-csrftoken'=>'n6A8zZtrVdpD0DIj3YUOx0NsSAkCpC1v',
                        'x-ig-app-id'=>'936619743392459',
                        'x-ig-www-claim'=>'hmac.AR2U02gV9w0D7GcfYoNdxpw0Gqz-cIDOsEBYRrrBJOP9PSIn',
                        'Cookie'=>'mid='.$data->mid.';csrftoken='.$data->csrftoken.';sessionid='.$data->sessionid,
                        'user-agent'=>UserAgent::AGENT_URL
                    ]
                ]);
                $body = json_decode($query->getBody()->getContents());

                foreach($body->reels->{$HighLightId}->items as $key => $value)
                {
                    if(isset($value->video_versions))
                    {
                        $this->LinkDown[] = [
                            'VideoLink'=>$value->video_versions[0],
                            'video_duration'=>$value->video_duration,

                        ];

                    }else
                    {
                        $this->LinkDown[] = [
                            'ImageLink'=>$value->image_versions2->candidates[0]
                        ];
                    }
                }
            }catch(ClientException $exception)
            {
                $data = (string) $exception->getResponse()->getBody();
                if(!isset($body->reels))
                {
                    throw new InstagramInvalidException('Invalid HighLightId');
                }
                return $data;
            }
        }else
        {
            throw new InstagramLoginException('Please First Login');
        }
    }
}