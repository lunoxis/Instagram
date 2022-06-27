<?php

declare (strict_types = 1);

namespace Instagram\Media;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Instagram\Exception\InstagramInvalidException;
use Instagram\Exception\InstagramLoginException;
use Instagram\Url\UserAgent;

class Post{
    /**
     * Undocumented variable
     *
     * @var Client
     */
    public Client $client;
    /**
     * Undocumented variable
     *
     * @var array
     */
    private array $info = [];
    /**
     * Undocumented variable
     *
     * @var array
     */
    private array $Url = [];
    /**
     * Undocumented function
     *
     * @return array
     */
    public function GetPost()
    {
        return $this->info;
    }
    /**
     * Undocumented function
     *
     * @return array
     */
    public function GetLink()
    {
        return $this->Url;
    }
    /**
     * Undocumented function
     *
     * @param string $code
     */
    public function __construct(string $Link) 
    {
        if (file_exists('session.json')) {
            $data = json_decode(file_get_contents('session.json'));
            $data = $data[array_rand($data)];
            $this->Client = new Client;
            try {
                preg_match ('~^(?:https?://)?(?:www\.)?instagram\.com/(p|tv|reel)/([^/]+)~',$Link,$match);
                $query = $this->Client->request('GET', \Instagram\Url\URLs::GetMediaJsonInfo($match[2]), [
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
                    if(isset($body->items[0]->carousel_media))
                    {
                        foreach($body->items[0]->carousel_media as $key => $value)
                        {
                            if(isset($value->video_versions))
                            {
                                $this->Url[] = 
                                [
                                    'video_link'=>$value->video_versions[0]->url,
                                    'video_duration'=>$body->items[0]->video_duration,
                                    'view_count'=>$body->items[0]->view_count
                                ];
                            }else
                            {
                                $this->Url[] = 
                                [
                                    'image_link'=>$value->image_versions2->candidates[0]->url
                                ];
                            }
                        }
                    }elseif(isset($body->items[0]->video_versions))
                    {
                        $this->Url[] = 
                        [
                            'video_link' => $body->items[0]->video_versions[0]->url,
                            'video_duration'=>$body->items[0]->video_duration,
                            'view_count'=>$body->items[0]->view_count
                        ];
                    }else{
                        $this->Url[] = 
                        [
                            'image_link' => $body->items[0]->image_versions2->candidates[0]->url
                        ];
                    }
                    $this->info[] = 
                    [
                    'User_Username'=>$body->items[0]->user->username,
                    'User_Full_name'=>$body->items[0]->user->full_name,
                    'User_Profile_pic_url'=>$body->items[0]->user->profile_pic_url,
                    'Caption_Text'=>$body->items[0]->caption->text,
                    'Caption_status'=>$body->items[0]->caption->status,
                    'caption_is_edited'=>$body->items[0]->caption_is_edited ? 'Yes' : 'No',
                    'like_and_view_counts_disabled'=>$body->items[0]->like_and_view_counts_disabled ? 'Yes' : 'NO',
                    'commerciality_status'=>$body->items[0]->commerciality_status,
                    'comment_likes_enabled'=>$body->items[0]->comment_likes_enabled ? 'Yes' : 'No',
                    'comment_count'=>$body->items[0]->comment_count,
                    'like_count'=>$body->items[0]->like_count
                    ];

               
            } catch (ClientException $exception) {
                $data = (string) $exception->getResponse()->getBody();
                if (!isset($body->items)) {
                    throw new InstagramInvalidException('Invalid Link');
                }
                return $data;
            }
        } else {
            throw new InstagramLoginException('Please First Login');
        }
    }
        
}
