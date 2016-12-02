<?php
/**
 * Created by PhpStorm.
 * User: quentinrillet
 * Date: 02/12/2016
 * Time: 19:43
 */

namespace Api\UserBundle\Controller;


use Api\UserBundle\Entity\AuthToken;
use Api\UserBundle\Entity\Credentials;
use Api\UserBundle\Form\CredentialsType;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthTokenController extends FOSRestController
{
  /**
   * @ApiDoc(
   *    description="Création d'un token pour un utilisateur",
   *    input="Api\UserBundle\Form\CredentialsType",
   *    output="Api\UserBundle\Entity\AuthToken"
   * )
   *
   *
   * @View(statusCode=201, serializerGroups={"auth-token"})
   * @Post("/auth-tokens")
   */
  public function postAuthTokensAction(Request $request)
  {
    $credentials = new Credentials();
    $form = $this->createForm(CredentialsType::class, $credentials);
dump($form);
    $form->submit($request->request->all());

    if (!$form->isValid()) {
      return $form;
    }

    $em = $this->getDoctrine()->getManager();

    $user = $em->getRepository('ApiUserBundle:User')
      ->findOneByEmail($credentials->getLogin());

    if (!$user) { // L'utilisateur n'existe pas
      return $this->invalidCredentials();
    }

    $encoder = $this->get('security.password_encoder');
    $isPasswordValid = $encoder->isPasswordValid($user, $credentials->getPassword());

    if (!$isPasswordValid) { // Le mot de passe n'est pas correct
      return $this->invalidCredentials();
    }

    $authToken = new AuthToken();
    $authToken->setValue(base64_encode(random_bytes(50)));
    $authToken->setCreatedAt(new \DateTime('now'));
    $authToken->setUser($user);

    $em->persist($authToken);
    $em->flush();


    return $authToken;
  }

  private function invalidCredentials()
  {
    return \FOS\RestBundle\View\View::create(['message' => 'Invalid credentials'], Response::HTTP_BAD_REQUEST);
  }

  /**
   * @ApiDoc(
   *    description="Déconnexion d'un utilisateur",
   * )
   * @View(statusCode=Response::HTTP_NO_CONTENT)
   * @Delete("/auth-tokens/{authToken}")
   */
  public function removeAuthTokenAction(Request $request, AuthToken $authToken)
  {
    $em = $this->getDoctrine()->getManager();

    $connectedUser = $this->get('security.token_storage')->getToken()->getUser();

    if ($authToken && $authToken->getUser()->getId() === $connectedUser->getId()) {
      $em->remove($authToken);
      $em->flush();
    } else {
      throw new \Symfony\Component\HttpKernel\Exception\BadRequestHttpException();
    }
  }
}