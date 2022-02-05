<?php

namespace App\Service\Currency;


use Symfony\Component\DependencyInjection\ContainerInterface;

class CurrencyService implements CurrencyServiceInterface
{
    public function __construct(
        private ContainerInterface $container
    )
    {
    }

    public function convertor(float $price, string $code): float
    {
        $api = $this->container->getParameter('currencies');
        $xmlString = file_get_contents($api);
        $xml = @simplexml_load_string($xmlString);
        $currencies = [];
        foreach ($xml->Cube->Cube as $item) {
            foreach ($item as $key => $val) {
                $currency = $val['currency'];
                $currencies["$currency"] = floatval($val["rate"]);
            }

        }
        if (array_key_exists($code, $currencies)) {
            return $currencies[$code] * $price;
        }
        return  $price;
    }
}