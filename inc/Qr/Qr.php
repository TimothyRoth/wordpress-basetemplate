<?php

namespace basetemplate\Qr;

use Exception;

class Qr
{
    /**
     * @param string $url
     * @param null $size
     * @return string
     * @throws Exception
     *
     * @example
     * ThemeWizard::Qr()->generate_code('https://www.google.com', '150x150');
     *
     * */
    public function generate_code(string $url, $size = null): string
    {
        $size = $size ?? '150x150';
        return '<img src="https://api.qrserver.com/v1/create-qr-code/?size=' . $size . '&data=' . urlencode($url) . '">';
    }
}