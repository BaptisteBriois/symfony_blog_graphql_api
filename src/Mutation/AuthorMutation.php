<?php

namespace App\Mutation;

use App\Entity\Author;
use Doctrine\ORM\EntityManagerInterface;

use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;

final class AuthorMutation implements MutationInterface, AliasedInterface
{
    private $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param string $username
     *
     * @return array
     *
     * @throws \Exception
     */
    public function resolve(string $username)
    {
        $author = new Author();
        $author->setUsername($username);

        $this->em->persist($author);
        $this->em->flush();

        return ['content' => 'created'];
    }

    /**
     * {@inheritdoc}
     */
    public static function getAliases(): array
    {
        return [
            'resolve' => 'NewAuthor',
        ];
    }
}