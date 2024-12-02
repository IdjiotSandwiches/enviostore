<?php

namespace App\Interfaces;

interface SessionKeyInterface
{
    public const SESSION_IDENTITY = 'identity';
    public const SESSION_IS_ADMIN = 'is_admin';
    public const SESSION_IS_LOGGED_IN = 'is_logged_in';
}