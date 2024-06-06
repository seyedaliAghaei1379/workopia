<?php


namespace Framework;
class Authorization
{
    /**
     * Check if current logged in user own a resource
     *
     * @param $resourceId
     * @return bool
     */
    public static function isOwner($resourceId)
    {
        $sessionUser = Session::get('user');
        if ($sessionUser !== null && isset($sessionUser['id'])){
        $sessionUserId = (int) $sessionUser['id'];
        return $sessionUserId === $resourceId;
        }

        return false;
    }
}