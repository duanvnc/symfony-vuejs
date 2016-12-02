<?php

namespace Api\UserBundle\Controller;

use Api\UserBundle\Entity\User;
use Api\UserBundle\Form\UserType;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Patch;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends FOSRestController
{
  /**
   * @ApiDoc(
   *    description="Récupère les informations d'un utilisateur",
   *    resource=true,
   *    output="Api\UserBundle\Entity\User",
   *    statusCodes={
   *         200="Returned when successful",
   *         404={
   *           "Returned when the user is not found"
   *         }
   *    }
   * )
   * @Get("/user/{user}")
   * @View()
   */
  public function getUserAction(Request $request, User $user){
    if(empty($user)){
      return \FOS\RestBundle\View\View::create(['message' => 'Place not found'], Response::HTTP_NOT_FOUND);
    }
    return $user;
  }


  /**
   * @ApiDoc(
   *    description="Ajoute un utilisateur",
   *    input="Api\UserBundle\Form\UserType",
   *    output="Api\UserBundle\Entity\User",
   *    resource=true
   *
   * )
   * @View(statusCode=201, serializerGroups={"user"})
   * @Post("/user")
   */
  public function postUsersAction(Request $request)
  {
    $user = new User();
    $form = $this->createForm(UserType::class, $user, ['validation_groups'=>['Default', 'New']]);

    $form->submit($request->request->all());

    if ($form->isValid()) {
      $encoder = $this->get('security.password_encoder');
      // le mot de passe en claire est encodé avant la sauvegarde
      $encoded = $encoder->encodePassword($user, $user->getPlainPassword());
      $user->setPassword($encoded);

      $em = $this->getDoctrine()->getManager();
      $em->persist($user);
      $em->flush();
      return $user;
    } else {
      return $form;
    }
  }

  /**
   * @ApiDoc(
   *    description="Met à jour un utilisateur",
   *    input="Api\UserBundle\Form\UserType",
   *    output="Api\UserBundle\Entity\User"
   * )
   * @View()
   * @Put("/user/{user}")
   */
  public function updateUserAction(Request $request, User $user)
  {
    return $this->updateUser($request, $user, true);
  }

  /**
   * @ApiDoc(
   *    description="Met à jour partiellement un utilisateur",
   *    input="Api\UserBundle\Form\UserType",
   *    output="Api\UserBundle\Entity\User"
   * )
   * @View()
   * @Patch("/user/{user}")
   */
  public function patchUserAction(Request $request, User $user)
  {
    return $this->updateUser($request,$user, false);
  }


  private function updateUser(Request $request,User $user,  $clearMissing)
  {
    if (empty($user)) {
      return \FOS\RestBundle\View\View::create(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
    }

    $form = $this->createForm(UserType::class, $user);
    $form->submit($request->request->all(), $clearMissing);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($user);
      $em->flush();
      return $user;
    } else {
      return $form;
    }
  }


  /**
   * @ApiDoc(
   *    description="Supprime un utilisateur",
   *
   * )
   * @View(statusCode=Response::HTTP_NO_CONTENT)
   * @Delete("/user/{user}")
   */
  public function removeUserAction(Request $request, User $user)
  {
    $em = $this->getDoctrine()->getManager();
    if ($user) {
      $em->remove($user);
      $em->flush();
    }
  }


}
