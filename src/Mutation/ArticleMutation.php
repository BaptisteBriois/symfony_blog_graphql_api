<?php

namespace App\Mutation;

use App\Entity\Article;
use App\Entity\Author;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;

use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;

final class ArticleMutation implements MutationInterface, AliasedInterface
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
     * @param string $title
     * @param string $text
     * @param int $authorId
     * @param int $categoryId
     *
     * @return array
     *
     * @throws \Exception
     */
    public function resolve(string $title, string $text, int $authorId, int $categoryId)
    {
        $article = new Article();
        $article->setTitle($title);
        $article->setText($text);

        $author = $this->em->getRepository(Author::class)->find($authorId);
        if (!$author instanceof Author) {
            throw new \Exception('Unknown author with id ' . $authorId);
        }

        $article->setAuthor($author);

        $category = $this->em->getRepository(Category::class)->find($categoryId);
        if (!$category instanceof Category) {
            throw new \Exception('Unknown category with id ' . $categoryId);
        }

        $article->setCategory($category);

        $this->em->persist($article);
        $this->em->flush();

        return ['content' => 'created'];
    }

    /**
     * @param int $id
     * @param string $title
     * @param string $text
     * @param int $authorId
     * @param int $categoryId
     *
     * @return array
     *
     * @throws \Exception
     */
    public function update(int $id, string $title, string $text, int $authorId, int $categoryId)
    {
        $article = $this->em->getRepository(Article::class)->find($id);
        if (!$article instanceof Article) {
            throw new \Exception('Unknown article with id ' . $id);
        }

        $article->setTitle($title);
        $article->setText($text);

        $author = $this->em->getRepository(Author::class)->find($authorId);
        if (!$author instanceof Author) {
            throw new \Exception('Unknown author with id ' . $authorId);
        }

        $article->setAuthor($author);

        $category = $this->em->getRepository(Category::class)->find($categoryId);
        if (!$category instanceof Category) {
            throw new \Exception('Unknown category with id ' . $categoryId);
        }

        $article->setCategory($category);

        $this->em->persist($article);
        $this->em->flush();

        return ['content' => 'updated'];
    }

    /**
     * @param int $id
     *
     * @return array
     *
     * @throws \Exception
     */
    public function delete(int $id)
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
            'resolve' => 'NewArticle',
            'update' => 'UpdateArticle',
            'delete' => 'DeleteArticle'
        ];
    }
}