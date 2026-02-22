<?php

namespace App\Twig;

use App\Enum\NoticeEnum;
use Twig\TwigFunction;

class HelperExtensions extends \Twig\Extension\AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('asset_version', [$this, 'assetVersion']),
            new TwigFunction('notice_classes', [$this, 'noticeClasses']),
        ];
    }

    public function assetVersion(string $assetPath): string
    {
        $version = filemtime($assetPath);
        return $assetPath . '?v=' . $version;
    }

    /**
     * Return an associative array of notice types
     */
    public function noticeClasses(): array
    {
        return array_combine(
            array_map(
                fn(NoticeEnum $notice) => $notice->name,
                NoticeEnum::cases()
            ),
            array_map(
                fn(NoticeEnum $notice) => $notice->value,
                NoticeEnum::cases()
            )
        );
    }
}
