<?php

namespace App\Mutation;

use App\Entity\Author;
use Doctrine\ORM\EntityManagerInterface;

use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;

final class AuthorUpdateMutation implements MutationInterface, AliasedInterface
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
     * @param int $id
     * @param string $username
     *
     * @return array
     *
     * @throws \Exception
     */
    public function resolve(int $id, string $username)
    {
        $author = $this->em->getRepository(Author::class)->find($id);
        if (!$author instanceof Author) {
            throw new \Exception('Unknown author with id ' . $id);
        }

        $author->setUsername($username);

        $this->em->persist($author);
        $this->em->flush();

        return ['content' => 'updated'];
    }

    /**
     * {@inheritdoc}
     */
    public static function getAliases(): array
    {
        return [
            'resolve' => 'UpdateAuthor',
        ];
    }
}