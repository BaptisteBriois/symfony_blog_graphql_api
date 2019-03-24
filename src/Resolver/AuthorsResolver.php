<?php

namespace App\Resolver;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

final class AuthorsResolver implements ResolverInterface, AliasedInterface
{
    /**
     * @var AuthorRepository
     */
    private $authorRepository;

    /**
     * @param AuthorRepository $authorRepository
     */
    public function __construct(AuthorRepository $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    /**
     * @return Author[]
     */
    public function resolve()
    {
        return $this->authorRepository->findAll();
    }

    /**
     * {@inheritdoc}
     */
    public static function getAliases(): array
    {
        return [
            'resolve' => 'Authors'
        ];
    }
}