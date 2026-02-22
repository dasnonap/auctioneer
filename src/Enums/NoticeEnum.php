<?php

namespace App\Enums;

enum NoticeEnum: string
{
    case SUCCESS = 'success';
    case ERROR = 'error';
    case DEFAULT = 'notice';
}
