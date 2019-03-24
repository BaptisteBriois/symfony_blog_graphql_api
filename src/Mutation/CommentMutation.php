<?php

namespace App\Mutation;

use App\Entity\Article;
use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;

use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;

final class CommentMutation implements MutationInterface, AliasedInterface
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
     * @param string $text
     * @param int $articleId
     *
     * @return array
     *
     * @throws \Exception
     */
    public function resolve(string $text, int $articleId)
    {
        $comment = new Comment();
        $comment->setText($text);

        $article = $this->em->getRepository(Article::class)->find($articleId);
        if (!$article instanceof Article) {
            throw new \Exception('Unknown article with id ' . $articleId);
        }

        $comment->setArticle($article);

        $this->em->persist($comment);
        $this->em->flush();

        return ['content' => 'created'];
    }

    /**
     * {@inheritdoc}
     */
    public static function getAliases(): array
    {
        return [
            'resolve' => 'NewComment',
        ];
    }
}