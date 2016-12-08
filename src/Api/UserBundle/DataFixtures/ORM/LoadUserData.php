<?php

namespace Api\UserBundle\DataFixtures\ORM;

use Api\UserBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{

  /**
   * @var ContainerInterface
   */
  private $container;

  /**
   * Sets the container.
   *
   * @param ContainerInterface|null $container A ContainerInterface instance or null
   */
  public function setContainer(ContainerInterface $container = null)
  {
      $this->container = $container;
  }

  /**
   * Load data fixtures with the passed EntityManager
   *
   * @param ObjectManager $manager
   */
  public function load(ObjectManager $manager)
  {
      $user = new User();
      $user->setEmail("johndoe@mail.com");
      $user->setFirstname("John");
      $user->setLastname("Doe");
      $encoder = $this->container->get('security.password_encoder');
      $password = $encoder->encodePassword($user, 'johndoe');
      $user->setPassword($password);

      $manager->persist($user);
      $manager->flush();
  }

  /**
   * Get the order of this fixture
   *
   * @return integer
   */
  public function getOrder()
  {
      return 1;
  }
}
