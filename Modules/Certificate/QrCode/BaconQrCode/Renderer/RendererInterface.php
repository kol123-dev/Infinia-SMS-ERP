<?php
declare(strict_types = 1);

namespace Modules\Certificate\QrCode\BaconQrCode\Renderer;

use Modules\Certificate\QrCode\BaconQrCode\Encoder\QrCode;

interface RendererInterface
{
    public function render(QrCode $qrCode) : string;
}
