<?php

namespace App\Resolver;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

final class CommentsResolver implements ResolverInterface, AliasedInterface
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
     * @return Comment[]
     */
    public function resolve()
    {
        return $this->commentRepository->findAll();
    }

    /**
     * {@inheritdoc}
     */
    public static function getAliases(): array
    {
        return [
            'resolve' => 'Comments'
        ];
    }
}