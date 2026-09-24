<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EnviaService
{
    private string $apiKey;
    private string $baseUrl;

   public function __construct()
{
    $this->apiKey  = config('services.envia.key', '');
    $this->baseUrl = config('services.envia.env') === 'production'
       ? 'https://queries.envia.com'
        : 'https://queries-test.envia.com';
}

    private function headers(): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
        ];
    }

    /**
     * Crear paquete en Envia.com y devolver su ID
     */
   public function createPackage(array $data): array|null
{
    try {
        $response = Http::withHeaders($this->headers())
            ->post("{$this->baseUrl}/packages", [
                'name'            => $data['nombre'],
                'content'         => $data['nombre'],
                'length'          => $data['largo'],
                'width'           => $data['ancho'],
                'height'          => $data['alto'],
                'weight'          => $data['peso'],
                'package_type_id' => 1,
                'weight_unit'     => 'KG',
                'length_unit'     => 'CM',
                'insurance'       => 0,
            ]);

       if ($response->successful()) {
        $body = $response->json();
        Log::info('Envia body parsed: ', $body ?? []);
        return $body;
    }

        Log::error('Envia createPackage error', $response->json() ?? []);
        
        return null;

    } catch (\Exception $e) {
        Log::error('Envia createPackage exception: ' . $e->getMessage());
        return null;
    }
}

    /**
     * Cotizar envío — devuelve array de opciones de paquetería
     */
    public function getRates(array $origen, array $destino, array $paquete): array
    {
        try {
            $response = Http::withHeaders($this->headers())
                ->post("{$this->baseUrl}/ship/rate", [
                    'origin' => [
                        'name'        => $origen['nombre'],
                        'company'     => $origen['empresa'] ?? 'Raíces Artesanas',
                        'email'       => $origen['email'],
                        'phone'       => $origen['telefono'],
                        'street'      => $origen['calle'],
                        'number'      => $origen['numero'],
                        'district'    => $origen['colonia'],
                        'city'        => $origen['ciudad'],
                        'state'       => $origen['estado'],
                        'country'     => 'MX',
                        'postalCode'  => $origen['cp'],
                    ],
                    'destination' => [
                        'name'        => $destino['nombre'],
                        'company'     => $destino['empresa'] ?? '',
                        'email'       => $destino['email'] ?? '',
                        'phone'       => $destino['telefono'],
                        'street'      => $destino['calle'],
                        'number'      => $destino['numero'],
                        'district'    => $destino['colonia'],
                        'city'        => $destino['ciudad'],
                        'state'       => $destino['estado'],
                        'country'     => 'MX',
                        'postalCode'  => $destino['cp'],
                    ],
                    'packages' => [[
                        'content'  => 'Artesanía',
                        'amount'   => 1,
                        'type'     => 'box',
                        'weight'   => $paquete['peso'],
                        'length'   => $paquete['largo'],
                        'width'    => $paquete['ancho'],
                        'height'   => $paquete['alto'],
                    ]],
                    'shipment' => [
                        'carrier' => 'all',
                        'type'    => 1,
                    ],
                ]);

            if ($response->successful()) {
                return $response->json('data') ?? [];
            }

            Log::error('Envia getRates error', $response->json());
            return [];

        } catch (\Exception $e) {
            Log::error('Envia getRates exception: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Generar guía de envío
     */
    public function createShipment(array $origen, array $destino, array $paquete, string $carrier, string $service): array|null
    {
        try {
            $response = Http::withHeaders($this->headers())
                ->post("{$this->baseUrl}/ship/generate", [
                    'origin'      => $origen,
                    'destination' => $destino,
                    'packages'    => [[
                        'content' => 'Artesanía',
                        'amount'  => 1,
                        'type'    => 'box',
                        'weight'  => $paquete['peso'],
                        'length'  => $paquete['largo'],
                        'width'   => $paquete['ancho'],
                        'height'  => $paquete['alto'],
                    ]],
                    'shipment' => [
                        'carrier' => $carrier,
                        'service' => $service,
                        'type'    => 1,
                    ],
                ]);

            if ($response->successful()) {
                return $response->json('data');
            }

            Log::error('Envia createShipment error', $response->json());
            return null;

        } catch (\Exception $e) {
            Log::error('Envia createShipment exception: ' . $e->getMessage());
            return null;
        }
    }
}