<?php

declare (strict_types = 1);

namespace Instagram\Media;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Instagram\Exception\InstagramInvalidException;
use Instagram\Exception\InstagramLoginException;
use Instagram\Url\UserAgent;

class Info{
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
    private array $Info = [];
    /**
     * Undocumented function
     *
     * @return void
     */
    public function GetInfo()
    {
        return $this->Info;
    }
    /**
     * Undocumented function
     *
     * @param string $username
     */
    public function __construct(string $username)
    {
        if(file_exists('session.json'))
        {
            $data = json_decode(file_get_contents('session.json'));
            $data = $data[array_rand($data)];
            $this->Client = new Client;
            try{
                $Query = $this->Client->request('GET',\Instagram\Url\URLs::GetAccountJsonInfo($username),
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
                $Body = json_decode($Query->getBody()->getContents());
                $this->Info[] = 
                [
                    'full_name'=>$Body->graphql->user->full_name,
                    'username'=>$Body->graphql->user->username,
                    'biography'=>$Body->graphql->user->biography,
                    'bio_links'=>$Body->graphql->user->bio_links,
                    'external_url'=>$Body->graphql->user->external_url,
                    'external_url_linkshimmed'=>$Body->graphql->user->external_url_linkshimmed,
                    'highlight_reel_count'=>$Body->graphql->user->highlight_reel_count,
                    'id'=>$Body->graphql->user->id,
                    'is_business_account'=>$Body->graphql->user->is_business_account ? 'Yes' : 'No',
                    'is_professional_account'=>$Body->graphql->user->is_professional_account ? 'Yes' : 'No',
                    'profile_pic_url'=>$Body->graphql->user->profile_pic_url,
                    'profile_pic_url_hd'=>$Body->graphql->user->profile_pic_url_hd,
                    'edge_follow'=>$Body->graphql->user->edge_follow->count,
                    'edge_followed_by'=>$Body->graphql->user->edge_followed_by->count,
                    'edge_felix_video_timeline'=>$Body->graphql->user->edge_felix_video_timeline->count,
                    'edge_owner_to_timeline_media'=>$Body->graphql->user->edge_owner_to_timeline_media->count,
                    'is_verified'=>$Body->graphql->user->is_verified ? 'Yes' : 'No',
                    'is_private'=>$Body->graphql->user->is_private ? 'Yes' : 'No',
                    'category_name'=>$Body->graphql->user->category_name ? : 'NOT SET',
                    'category_enum'=>$Body->graphql->user->category_enum ? : 'NOT SET',
                    'business_phone_number'=>$Body->graphql->user->business_phone_number ? : 'NOT SET',
                    'business_email'=>$Body->graphql->user->business_email ? : 'NOT SET',
                    'business_category_name'=>$Body->graphql->user->business_category_name ? : 'NOT SET',
                    'has_channel'=>$Body->graphql->user->has_channel ? 'Yes' : 'No',
                    'has_clips'=>$Body->graphql->user->has_clips ? 'Yes' : 'No',
                    'blocked_by_viewer'=>$Body->graphql->user->blocked_by_viewer ? 'Yes' : 'No',

                ];
                
                
            }catch(ClientException $exception)
            {
                $data = (string) $exception->getResponse()->getBody();
                if(!isset($body->graphql))
                {
                    throw new InstagramInvalidException('Invalid username');
                }
                return $data;
            }
        }else
        {
                throw new InstagramLoginException('Please First Login');
        }
       
    }
    
}
