<?php

namespace App\Mutation;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;

use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;

final class CategoryMutation implements MutationInterface, AliasedInterface
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
     * @param string $name
     *
     * @return array
     *
     * @throws \Exception
     */
    public function resolve(string $name)
    {
        $category = new Category();
        $category->setName($name);

        $this->em->persist($category);
        $this->em->flush();

        return ['content' => 'created'];
    }

    /**
     * {@inheritdoc}
     */
    public static function getAliases(): array
    {
        return [
            'resolve' => 'NewCategory',
        ];
    }
}