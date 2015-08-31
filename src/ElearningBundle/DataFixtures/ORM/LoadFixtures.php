<?php

namespace AppBundle\DataFixtures\ORM;

use ElearningBundle\Entity\Answer;
use ElearningBundle\Entity\Category;
use ElearningBundle\Entity\Lesson;
use ElearningBundle\Entity\Relationship;
use ElearningBundle\Entity\Result;
use ElearningBundle\Entity\User;
use ElearningBundle\Entity\Word;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadFixtures implements FixtureInterface, ContainerAwareInterface
{

    private $container;

    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
        $this->loadData($manager);
        $this->loadRelationship($manager);
    }

    private function loadUsers(ObjectManager $manager)
    {
        $passwordEncoder = $this->container->get('security.password_encoder');

        $admin = new User();
        $admin->setName('Administrator');
        $admin->setEmail('admin@fel.com');
        $admin->setRoles('ROLE_ADMIN');
        $encodePassword = $passwordEncoder->encodePassword($admin, 'adminadmin');
        $admin->setPassword($encodePassword);
        $manager->persist($admin);

        foreach (range(1, 20) as $i) {
            $user = new User();
            $user->setName("User" . $i);
            $user->setEmail("user" . $i . "@fel.com");
            $encodePassword = $passwordEncoder->encodePassword($user, 'useruser');
            $user->setPassword($encodePassword);
            $manager->persist($user);
        }
        $manager->flush();
    }

    private function loadData(ObjectManager $manager)
    {
        foreach (range(1, 5) as $i) {
            $category = new Category();
            $category->setContent('Lorem ipsum dolor sit amet consectetur adipisicing elit, sed do eiusmod tempor
                                  incididunt ut labore et dolore magna aliqua: Duis aute irure dolor in
                                  reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                                  Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
                                  deserunt mollit anim id est laborum.');
            $category->setName('Category' . $i);

            foreach (range(1, 100) as $i) {
                $word = new Word();
                $word->setCategory($category);
                $word->setContent($this->getRandom());
                $category->addWord($word);

                foreach (range(1, 4) as $i) {
                    $answer = new Answer();
                    $answer->setContent($this->getRandom());
                    $answer->setWord($word);
                    $answer->setCorrect($i == 4);
                    $word->addAnswer($answer);

                    $manager->persist($answer);
                }

                $manager->persist($word);
            }

            $manager->persist($category);
        }

        $manager->flush();
    }

    private function loadRelationship(ObjectManager $manager)
    {
        foreach (range(1, 100) as $i) {
            $followee = $manager->getRepository('ElearningBundle:User')->findOneById(rand(1, 21));
            $follower = $manager->getRepository('ElearningBundle:User')->findOneById(rand(1, 21));
            if ($followee != $follower) {
                $relationship = new Relationship();
                $relationship->setFollowee($followee);
                $relationship->setFollower($follower);
                $manager->persist($relationship);
            }
        }
        $manager->flush();
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    private function getRandom()
    {
        $phrases = $this->getPhrases();

        $numPhrases = rand(1, 30);
        shuffle($phrases);

        return implode(' ', array_slice($phrases, 0, ($numPhrases-1)/5));
    }

    private function getPhrases()
    {
        return ['Lorem ipsum',
                'Pellentesque',
                'Mauris dapibus',
                'Eros diam',
                'In hac habitasse',
                'Morbi tempus',
                'Ut suscipit',
                'Ut eleifend',
                'Aliquam sodales',
                'Urna nisl',
                'Nulla porta',
                'Curabitur aliquam',
                'Sed varius',
                'Nunc viverra',
                'Pellentesque',
                'Otanjou-bi',
                'Saeng il chuk',
                'Sun Yat',
                'Anniversaire!',
                'razhdjenia',
                'Wszystkiego',
                'Feliz Aniversario!',
                'Feliz Cumplea–os!',
                'Buon Compleanno!',
                'Alles Gute',
                'Dogum gunun',
                'Hartelijk',
                'Selamat Hari',
                'Selamat Ulang',
                'Suk San Wan',
                'Som owie nek'];
    }

}
