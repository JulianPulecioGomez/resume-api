<?php
// api/src/OpenApi/JwtDecorator.php

declare(strict_types=1);

namespace App\OpenApi;

use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\Core\OpenApi\OpenApi;
use ApiPlatform\Core\OpenApi\Model;

final class JwtDecorator implements OpenApiFactoryInterface
{
    /**
     * @var  OpenApiFactoryInterface
     */
    private $decorated;

    public function __construct(
        OpenApiFactoryInterface $decorated
    )
    {
        $this->decorated = $decorated;
    }

    public function __invoke(array $context = []): OpenApi
    {
        $openApi = ($this->decorated)($context);
        $schemas = $openApi->getComponents()->getSchemas();

        $schemas['Token'] = new \ArrayObject([
            'type' => 'object',
            'properties' => [
                'token' => [
                    'type' => 'string',
                    'readOnly' => true,
                ],
            ],
        ]);
        $schemas['Credentials'] = new \ArrayObject([
            'type' => 'object',
            'properties' => [
                'username' => [
                    'type' => 'string',
                    'example' => 'johndoe@example.com',
                ],
                'password' => [
                    'type' => 'string',
                    'example' => 'apassword',
                ],
            ],
        ]);

        $responses = [
            '200' => [
                'description' => 'Get JWT token',
                'content' => [
                    'application/json' => [
                        'schema' => [
                            '$ref' => '#/components/schemas/Token',
                        ],
                    ],
                ],
            ],
        ];

        $content = new \ArrayObject([
            'application/json' => [
                'schema' => [
                    '$ref' => '#/components/schemas/Credentials',
                ],
            ],
        ]);

        $requestBody =  new Model\RequestBody('Generate new JWT Token',$content);

        $post = new Model\Operation('postCredentialsItem', [] ,$responses,'Get JWT token to login.','Generate new JWT Token',null,[],$requestBody);

        $pathItem = new Model\PathItem('JWT Token', 'Get JWT token to login.', 'Generate new JWT Token', null, null, $post);

        $openApi->getPaths()->addPath('/api/login_check', $pathItem);

        return $openApi;
    }
}