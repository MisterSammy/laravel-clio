<?php

declare(strict_types=1);

return PhpCsFixer\Config::create()
    ->setRules([
        '@Symfony' => true,
        '@Symfony:risky' => true,
        '@PSR2' => true,
        '@PHP71Migration' => true,
        '@PHP71Migration:risky' => true,
        '@PHP73Migration' => true,
        'array_syntax' => ['syntax' => 'short'],
        'protected_to_private' => false,
        'compact_nullable_typehint' => true,
        'concat_space' => ['spacing' => 'one'],
        'phpdoc_separation' => false,
    ])
    ->setRiskyAllowed(true)
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in([
                __DIR__ . '/src',
                __DIR__ . '/config',
            ])
            ->notPath('#c3.php#')
            ->append([__FILE__])
    );
