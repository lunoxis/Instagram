<?php
declare (strict_types = 1);

namespace Instagram\Login;

use GuzzleHttp\Cookie\CookieJar;

class Session{


    /**
     * Undocumented variable
     *
     * @var string
     */
    private $Mid;
    /**
     * Undocumented variable
     *
     * @var string
     */
    private $CsrfToken;
    /**
     * Undocumented variable
     *
     * @var string
     */
    private $SessionId;
    /**
     * Undocumented function
     *
     * @return string
     */
    public function SetSession(string $Mid,string $CsrfToken,string $SessionId) : string
    { 
        $this->Mid = $Mid;
        $this->CsrfToken = $CsrfToken;
        $this->SessionId = $SessionId;
        if(file_exists('session.json')){
            $file = json_decode(file_get_contents('session.json'),true);
            array_push($file,['mid'=>$this->Mid,
            'csrftoken'=>$this->CsrfToken,
            'sessionid'=>$this->SessionId]);
            file_put_contents('session.json',json_encode($file));
            return 'New Session Was Append!';
        }else{
            $data = 
        [[
            'mid'=>$this->Mid,
            'csrftoken'=>$this->CsrfToken,
            'sessionid'=>$this->SessionId
        
        ]];
        file_put_contents('session.json',json_encode($data));
        return 'Session file was Generate';
        }
        

    }
    /**
     * Undocumented function
     *
     * @return mixed
     */
    public function GetSession() : mixed
    {
        return json_decode(file_get_contents('session.json'));
    }


}