<?php

namespace App\Mutation;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;

use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;

final class ArticleDeleteMutation implements MutationInterface, AliasedInterface
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
        $article = $this->em->getRepository(Article::class)->find($id);
        if (!$article instanceof Article) {
            throw new \Exception('Unknown article with id ' . $id);
        }

        $this->em->remove($article);
        $this->em->flush();

        return ['content' => 'deleted'];
    }

    /**
     * {@inheritdoc}
     */
    public static function getAliases(): array
    {
        return [
            'resolve' => 'DeleteArticle',
        ];
    }
}