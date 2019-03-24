<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Author;
use App\Entity\Category;
use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Categories
        $categories = [];

        for ($i = 0; $i < 10; $i++) {
            $category = new Category();
            $category->setName("Category " . $i);

            $manager->persist($category);

            $categories[] = $category;
        }

        // Authors
        $authors = [];

        for ($i = 0; $i < 8; $i++) {
            $usernames = ["Jhon", "Brenda", "Mickael", "Jessica", "Carmen", "Jason", "Jack", "Rebecca"];

            $author = new Author();
            $author->setUsername($usernames[$i]);

            $manager->persist($author);

            $authors[] = $author;
        }

        // Articles
        $articles = [];

        for ($i = 0; $i < 25; $i++) {
            $article = new Article();
            $article->setTitle("Article " . $i);
            $article->setText("You are currently reading the article n°" . $i);
            $article->setCategory($categories[rand(0, 9)]);
            $article->setAuthor($authors[rand(0, 7)]);

            $manager->persist($article);

            $articles[] = $article;
        }

        // Articles
        for ($i = 0; $i < 100; $i++) {
            $comment = new Comment();
            $comment->setText("My comment is the comment n°" . $i);
            $comment->setArticle($articles[rand(0, 24)]);

            $manager->persist($comment);
        }

        $manager->flush();
    }
}
