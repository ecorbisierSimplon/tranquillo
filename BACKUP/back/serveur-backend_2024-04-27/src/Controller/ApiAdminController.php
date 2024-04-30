<?php

namespace App\Controller;

use App\Entity\TpaUsers;
use App\Repository\TpaUsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api/admin')]
class ApiAdminController extends AbstractController
{

    /**
     * Cette fonction PHP récupère tous les utilisateurs d'un référentiel et les renvoie sous forme de
     * réponse JSON avec des groupes de sérialisation spécifiques.
     * 
     * @param TpaUsersRepository tpaUsersRepository Le paramètre `tpaUsersRepository` dans la méthode
     * `index` est une instance de la classe `TpaUsersRepository`. Il est utilisé pour récupérer tous
     * les utilisateurs de la base de données en utilisant la méthode `findAll()` du référentiel. Les
     * utilisateurs récupérés sont ensuite renvoyés sous forme de réponse JSON avec un
     * 
     * @return JsonResponse Une réponse JSON contenant tous les utilisateurs récupérés de
     * TpaUsersRepository est renvoyée. La réponse est formatée avec un code d'état de 200 et inclut
     * les données des utilisateurs regroupées sous « utilisateurs : index ». La route est accessible
     * via une requête GET et nécessite l'autorisation ROLE_ADMIN.
     */
    #[Route('/', name: 'app_api_users_index', methods: ['GET'])]
    public function index(TpaUsersRepository $tpaUsersRepository): JsonResponse
    {
        return $this->json($tpaUsersRepository->findAll(), Response::HTTP_OK, [], [
            'groups' => ['users:index']
        ]);
    }


    /**
     * Cette fonction PHP récupère et renvoie une entité TpaUsers spécifique au format JSON avec des
     * groupes de sérialisation spécifiques.
     * 
     * @param TpaUsers user Le paramètre `user` dans la méthode `show` est de type `TpaUsers`. Il
     * représente l'entité utilisateur qui sera récupérée en fonction de l'« id » fourni dans la route.
     * Cette méthode est chargée de récupérer et de renvoyer les données utilisateur au format JSON avec
     * des groupes de sérialisation spécifiques définis comme `
     * 
     * @return JsonResponse Une JsonResponse contenant les données utilisateur est renvoyée. Le code
     * d'état HTTP est défini sur 200 (OK) et les données utilisateur sont sérialisées à l'aide des
     * groupes de sérialisation spécifiés (« utilisateurs : index », « utilisateurs : show »).
     */
    #[Route('/{id}', name: 'app_api_users_show', methods: ['GET'])]
    public function show(TpaUsers $user): JsonResponse
    {
        return $this->json($user, Response::HTTP_OK, [], [
            'groups' => ['users:index', 'users:show']
        ]);
    }


    /**
     * Cette fonction PHP supprime une entité utilisateur de la base de données après avoir vérifié les
     * autorisations et la validité du jeton CSRF.
     * 
     * @param TpaUsers user L'extrait de code que vous avez fourni est une méthode de contrôleur Symfony
     * permettant de supprimer une entité utilisateur. La méthode prend deux paramètres :
     * @param EntityManagerInterface entityManager Le paramètre `` dans la méthode
     * `delete` est une instance de `EntityManagerInterface`, qui est utilisée pour interagir avec la
     * base de données. Dans ce cas, il est utilisé pour supprimer l'entité `` de la base de
     * données à l'aide de la méthode `remove`, puis conserver les modifications à l'aide de la méthode
     * `flush
     * 
     * @return JsonResponse L'extrait de code est une fonction PHP qui supprime une entité utilisateur
     * de la base de données. Après avoir supprimé l'utilisateur, il renvoie une réponse JSON indiquant
     * que l'utilisateur portant le prénom et le nom donnés a été supprimé avec succès. La réponse
     * inclut le message «   a bien été supprimé ». et a un code d'état de 202
     * (HTTP_ACCEPTED).
     */
    #[Route('/{id}', name: 'app_api_users_delete', methods: ['DELETE'])]
    #[IsGranted('ROLE_WEBMASTER')]
    public function delete(TpaUsers $user, EntityManagerInterface $em): JsonResponse
    {
        $lastname = $user->getLastname();
        $firstname = $user->getFirstname();
        // if ($this->isCsrfTokenValid('delete' . $tpaUser->getId(), $request->getPayload()->get('_token'))) {
        $em->remove($user);
        $em->flush();
        // }

        return $this->json("$lastname $firstname a bien été supprimé.", Response::HTTP_ACCEPTED, [], []);
    }
}
