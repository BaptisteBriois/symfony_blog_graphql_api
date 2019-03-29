<?php

namespace App\Mutation;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;

use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;

final class CategoryDeleteMutation implements MutationInterface, AliasedInterface
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
        $category = $this->em->getRepository(Category::class)->find($id);
        if (!$category instanceof Category) {
            throw new \Exception('Unknown category with id ' . $id);
        }

        $this->em->remove($category);
        $this->em->flush();

        return ['content' => 'deleted'];
    }

    /**
     * {@inheritdoc}
     */
    public static function getAliases(): array
    {
        return [
            'resolve' => 'DeleteCategory',
        ];
    }
}