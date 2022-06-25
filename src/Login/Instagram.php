<?php
declare (strict_types = 1);

namespace Instagram\Login;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Exception\ClientException;
use Instagram\Url\URLs;
use Instagram\Url\UserAgent;
use Instagram\Exception\InstagramLoginException;

class Instagram
{
    public string $username;
    public string $password;

    public Client    $client;
    public CookieJar $cookie;

    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;

        $this->client = new Client;
        $this->cookie = new CookieJar;
    }

    public function login(): mixed
    {
        $baseRequest = $this->client->request('GET', URLs::BASE_URL, [
            'headers' => [
                'user-agent' => UserAgent::AGENT_URL,
            ],
        ]);

        preg_match(
            '/<script type="text\/javascript">window\._sharedData\s?=(.+);<\/script>/',
            (string) $baseRequest->getBody(),
            $matches
        );
        if (!isset($matches[1])) {
            throw new InstagramLoginException('Unable to extract JSON data');
        }

        $data = json_decode($matches[1]);
        try {
            $query = $this->client->request('POST', URLs::LOGIN_URL, [
                'form_params' => [
                    'username'     => $this->username,
                    'enc_password' => '#PWD_INSTAGRAM_BROWSER:0:' . time() . ':' . $this->password,
                ],
                'headers'     => [
                    'cookie'      => 'ig_cb=1; csrftoken=' . $data->config->csrf_token,
                    'referer'     => URLs::BASE_URL,
                    'x-csrftoken' => $data->config->csrf_token,
                    'user-agent'  => UserAgent::AGENT_URL,
                ],
                'cookies'     => $this->cookie,
            ]);
        } catch (ClientException $exception) {
            $data = json_decode((string) $exception->getResponse()->getBody());

            if ($data && $data->message === 'checkpoint_required') {
                // @codeCoverageIgnoreStart
               
                // @codeCoverageIgnoreEnd
            } else {
                throw new InstagramLoginException('Unknown error, please report it with a GitHub issue. ' . $exception->getMessage());
            }
        }

         $response = json_decode($query->getBody());
        if (property_exists($response, 'authenticated') && $response->authenticated) {
             return $this->cookie;
        } else if (property_exists($response, 'error_type') && $response->error_type === 'generic_request_error') {
            throw new InstagramLoginException('Generic error / Your IP may be block from Instagram. You should consider using a proxy.');
        } else {
            throw new InstagramLoginException('Wrong login / password');
        }
    }
}
