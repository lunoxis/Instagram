<?php

declare (strict_types = 1);

namespace Instagram\Url;

class URLs
{
    const BASE_URL = 'https://www.instagram.com';
    const LOGIN_URL = 'https://www.instagram.com/accounts/login/ajax/';
    const ACCOUNT_PAGE = 'https://www.instagram.com/{username}/';
    const MEDIA_LINK = 'https://www.instagram.com/p/{code}';
    const ACCOUNT_MEDIAS = 'https://www.instagram.com/graphql/query/?query_hash=e769aa130647d2354c40ea6a439bfc08&variables={variables}';
    const ACCOUNT_TAGGED_MEDIAS = 'https://www.instagram.com/graphql/query/?query_hash=be13233562af2d229b008d2976b998b5&variables={variables}';
    const ACCOUNT_JSON_INFO = 'https://www.instagram.com/{username}/?__a=1&__d=dis';
    const ACCOUNT_ACTIVITY = 'https://www.instagram.com/accounts/activity/?__a=1&__d=dis';
    const MEDIA_JSON_INFO = 'https://www.instagram.com/p/{code}/?__a=1&__d=dis';
    const MEDIA_JSON_BY_LOCATION_ID = 'https://www.instagram.com/explore/locations/{{facebookLocationId}}/?__a=1&max_id={{maxId}}';
    const MEDIA_JSON_BY_TAG = 'https://www.instagram.com/explore/tags/{tag}/?__a=1&max_id={max_id}';
    const GENERAL_SEARCH = 'https://www.instagram.com/web/search/topsearch/?query={query}&count={count}';
    const ACCOUNT_JSON_INFO_BY_ID = 'ig_user({userId}){id,username,external_url,full_name,profile_pic_url,biography,followed_by{count},follows{count},media{count},is_private,is_verified}';
    const COMMENTS_BEFORE_COMMENT_ID_BY_CODE = 'https://www.instagram.com/graphql/query/?query_hash=33ba35852cb50da46f5b5e889df7d159&variables={variables}';
    const LAST_LIKES_BY_CODE = 'ig_shortcode({{code}}){likes{nodes{id,user{id,profile_pic_url,username,follows{count},followed_by{count},biography,full_name,media{count},is_private,external_url,is_verified}},page_info}}';
    const LIKES_BY_SHORTCODE = 'https://www.instagram.com/graphql/query/?query_id=17864450716183058&variables={"shortcode":"{{shortcode}}","first":{{count}},"after":"{{likeId}}"}';
    const FOLLOWING_URL = 'https://www.instagram.com/graphql/query/?query_id=17874545323001329&id={{accountId}}&first={{count}}&after={{after}}';
    const FOLLOWERS_URL = 'https://www.instagram.com/graphql/query/?query_id=17851374694183129&id={{accountId}}&first={{count}}&after={{after}}';
    const FOLLOWING_URL_V1 = 'https://i.instagram.com/api/v1/friendships/{{accountId}}/following/';
    const FOLLOWERS_URL_V1 = 'https://i.instagram.com/api/v1/friendships/{{accountId}}/followers/';
    const FOLLOW_URL = 'https://www.instagram.com/web/friendships/{{accountId}}/follow/';
    const UNFOLLOW_URL = 'https://www.instagram.com/web/friendships/{{accountId}}/unfollow/';
    const REMOVE_FOLLOWER_URL = 'https://www.instagram.com/web/friendships/{{accountId}}/remove_follower/';
    const PENDING_URL = 'https://i.instagram.com/api/v1/friendships/pending/';
    const INBOX_NEWS_URL = 'https://i.instagram.com/api/v1/news/inbox/';
    const INBOX_NEWS_SEEN_URL = 'https://i.instagram.com/api/v1/news/inbox_seen/';
    const USER_TAGS = 'https://i.instagram.com/api/v1/usertags/{{accountId}}/feed/?count={{count}}';
    const USER_FEED = 'https://www.instagram.com/graphql/query/?query_id=17861995474116400&fetch_media_item_count=12&fetch_media_item_cursor=&fetch_comment_count=4&fetch_like=10';
    const USER_FEED2 = 'https://www.instagram.com/?__a=1';
    const USER_FEED_hash = 'https://www.instagram.com/graphql/query/?query_hash=3f01472fb28fb8aca9ad9dbc9d4578ff';
    const INSTAGRAM_QUERY_URL = 'https://www.instagram.com/query/';
    const INSTAGRAM_CDN_URL = 'https://scontent.cdninstagram.com/';
    const ACCOUNT_JSON_PRIVATE_INFO_BY_ID = 'https://i.instagram.com/api/v1/users/{userId}/info/';
    const ACCOUNT_JSON_PRIVATE_INFO_BY_ID_2 = 'https://www.instagram.com/graphql/query/?query_hash=c9100bf9110dd6361671f113dd02e7d6&variables={"user_id":"{userId}","include_chaining":false,"include_reel":true,"include_suggested_users":false,"include_logged_out_extras":false,"include_highlight_reels":false,"include_related_profiles":false}';
    const LIKE_URL = 'https://www.instagram.com/web/likes/{mediaId}/like/';
    const UNLIKE_URL = 'https://www.instagram.com/web/likes/{mediaId}/unlike/';
    const ADD_COMMENT_URL = 'https://www.instagram.com/web/comments/{mediaId}/add/';
    const DELETE_COMMENT_URL = 'https://www.instagram.com/web/comments/{mediaId}/delete/{commentId}/';
    const ACCOUNT_MEDIAS2 = 'https://www.instagram.com/graphql/query/?query_id=17880160963012870&id={{accountId}}&first=10&after=';
    const HIGHLIGHT_URL = 'https://www.instagram.com/graphql/query/?query_hash=c9100bf9110dd6361671f113dd02e7d6&variables={"user_id":"{userId}","include_chaining":false,"include_reel":true,"include_suggested_users":false,"include_logged_out_extras":false,"include_highlight_reels":true,"include_live_status":false}';
    const HIGHLIGHT_STORIES = 'https://www.instagram.com/graphql/query/?query_hash=45246d3fe16ccc6577e0bd297a5db1ab';
    const THREADS_URL = 'https://i.instagram.com/api/v1/direct_v2/inbox/?persistentBadging=true&folder=&limit={limit}&thread_message_limit={messageLimit}&cursor={cursor}';
    const THREADS_PENDING_REQUESTS_URL = 'https://i.instagram.com/api/v1/direct_v2/pending_inbox/?limit={limit}&cursor={cursor}';
    const THREADS_APPROVE_MULTIPLE_URL = 'https://i.instagram.com/api/v1/direct_v2/threads/approve_multiple/';
    const URL_SIMILAR = 'https://www.instagram.com/graphql/query/?query_id=17845312237175864&id=4663052';
    const GRAPH_QL_QUERY_URL = 'https://www.instagram.com/graphql/query/?query_id={{queryId}}';
    const ALLSTORY_URL = 'https://i.instagram.com/api/v1/feed/user/{user_id}/story/';
    const HighLight = 'https://i.instagram.com/api/v1/feed/reels_media/?reel_ids=highlight:{HighLightId}';
    const AllHighLight = 'https://i.instagram.com/api/v1/highlights/{user_id}/highlights_tray/';
    const  X_IG_APP_ID = '936619743392459';
    
    
    /**
     * Undocumented function
     *
     * @param integer $user_id
     * @return void
     */
    public static function GetAllHighLight(string $user_id) : string
    {
        return str_replace('{user_id}',$user_id,SELF::AllHighLight);
    }
    /**
     * Undocumented function
     *
     * @param [type] $HighId
     * @return string
     */
    public static function GetHighLight(string $HighId) : string
    {
        return str_replace('{HighLightId}',$HighId,SELF::HighLight);
    }
    /**
     * Undocumented function
     *
     * @param string $username
     * @return mixed
     */
    public static function GetAccountJsonInfo(string $username) : mixed
    {
        return str_replace('{username}',(string)$username,SELF::ACCOUNT_JSON_INFO);
    }
    /**
     * Undocumented function
     *
     * @param string $code
     * @return mixed
     */
    public static function GetMediaJsonInfo(string $code) : mixed
    {
        return str_replace('{code}',(string)$code,SELF::MEDIA_JSON_INFO);
    }
    /**
     * Undocumented function
     *
     * @param string $user_id
     * @return mixed
     */
    public static function GetStoryUser(string $user_id) : mixed
    {
        return str_replace('{user_id}',(string)$user_id,SELF::ALLSTORY_URL);
    }
}
