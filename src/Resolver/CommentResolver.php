<?php

namespace App\Resolver;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

final class CommentResolver implements ResolverInterface, AliasedInterface
{
    /**
     * @var CommentRepository
     */
    private $commentRepository;

    /**
     * @param CommentRepository $commentRepository
     */
    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * @param int $id
     *
     * @return Comment
     */
    public function resolve(int $id)
    {
        return $this->commentRepository->find($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function getAliases(): array
    {
        return [
            'resolve' => 'Comment'
        ];
    }
}