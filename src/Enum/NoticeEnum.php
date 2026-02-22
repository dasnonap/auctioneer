<?php

namespace App\Enum;

enum NoticeEnum: string
{
    case SUCCESS = 'success';
    case ERROR = 'error';
    case DEFAULT = 'notice';
}
