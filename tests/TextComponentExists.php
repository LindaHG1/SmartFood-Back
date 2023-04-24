<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class H1Test extends TestCase
{
    public function testH1ElementExists()
    {
        $client = new Client([
            'base_uri' => 'http://127.0.0.1:8000/clients/', // URL de tu aplicación
            'http_errors' => false, // Para evitar excepciones en errores HTTP
        ]);

        $response = $client->request('GET', ''); // Ruta a la página que deseas probar
        $statusCode = $response->getStatusCode(); // Código de estado de la respuesta
        $content = $response->getBody()->getContents(); // Contenido de la respuesta

        // Verificar que el código de estado sea 200
        $this->assertEquals(200, $statusCode);

        // Verificar que el elemento H1 existe en la página
        $this->assertStringContainsString('<body>', $content);
    }
}


