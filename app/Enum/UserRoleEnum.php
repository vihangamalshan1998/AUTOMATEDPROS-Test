<?php

namespace App\Enum;

enum UserRoleEnum: string {
    case ADMIN   = 'admin';
    case MANAGER = 'manager';
    case USER    = 'user';
}
