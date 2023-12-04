<?php

namespace App\Service;

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Builder\BuilderInterface;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;

class QrCodeService
{
    protected $builder;

    public function __construct(BuilderInterface $builder)
    {
        $this->builder=$builder;
    }

    public function qrcode($recherche, $nom_qr)
    {
        $url="agent/";
        $path= dirname(__DIR__,2).'/public/assets/';
        $result=$this->builder
        ->data($url.$recherche)
        ->encoding(new Encoding('UTF-8'))
        ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
        ->size(400)
        ->margin(10)
        ->backgroundColor(new Color(0, 153, 51))
        ->logoPath($path.'images/logo.png')
        ->logoResizeToHeight(100)
        ->logoResizeToWidth(100)
        ->build()
        ;
        $namePng=$nom_qr.'.png';
        $result->saveToFile($path.'qr-code/'.$namePng);
        return $result->getDataUri();
    }

    public function qrcode_matos($reference, $matos_qr)
    {
        $url="https://192.168.115.96:8000/admin/materiel/";
        $path= dirname(__DIR__,2).'/public/assets/';
        $result=$this->builder
        ->data($url.$reference)
        ->encoding(new Encoding('UTF-8'))
        ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
        ->size(400)
        ->margin(10)
        ->backgroundColor(new Color(69, 224, 229))
        ->logoPath($path.'images/logo.png')
        ->logoResizeToHeight(100)
        ->logoResizeToWidth(100)
        ->build()
        ;
        $namePng=$matos_qr.'.png';
        $result->saveToFile($path.'matos_qr-code/'.$namePng);
        return $result->getDataUri();
    }
}
