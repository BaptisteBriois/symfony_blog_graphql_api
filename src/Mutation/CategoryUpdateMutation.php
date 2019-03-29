<?php

namespace App\Mutation;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;

use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;

final class CategoryUpdateMutation implements MutationInterface, AliasedInterface
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
     * @param string $name
     *
     * @return array
     *
     * @throws \Exception
     */
    public function resolve(int $id, string $name)
    {
        $category = $this->em->getRepository(Category::class)->find($id);
        if (!$category instanceof Category) {
            throw new \Exception('Unknown category with id ' . $id);
        }

        $category->setName($name);

        $this->em->persist($category);
        $this->em->flush();

        return ['content' => 'updated'];
    }

    /**
     * {@inheritdoc}
     */
    public static function getAliases(): array
    {
        return [
            'resolve' => 'UpdateCategory',
        ];
    }
}