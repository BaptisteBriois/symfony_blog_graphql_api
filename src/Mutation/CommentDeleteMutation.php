<?php

namespace App\Mutation;

use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;

use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;

final class CommentDeleteMutation implements MutationInterface, AliasedInterface
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
     *
     * @return array
     *
     * @throws \Exception
     */
    public function resolve(int $id)
    {
        $comment = $this->em->getRepository(Comment::class)->find($id);
        if (!$comment instanceof Comment) {
            throw new \Exception('Unknown comment with id ' . $id);
        }

        $this->em->remove($comment);
        $this->em->flush();

        return ['content' => 'deleted'];
    }

    /**
     * {@inheritdoc}
     */
    public static function getAliases(): array
    {
        return [
            'resolve' => 'DeleteComment',
        ];
    }
}