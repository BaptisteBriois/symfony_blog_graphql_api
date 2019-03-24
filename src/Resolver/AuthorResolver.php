<?php

namespace App\Resolver;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

final class AuthorResolver implements ResolverInterface, AliasedInterface
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
     * @param int $id
     *
     * @return Author
     */
    public function resolve(int $id)
    {
        return $this->authorRepository->find($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function getAliases(): array
    {
        return [
            'resolve' => 'Author'
        ];
    }
}