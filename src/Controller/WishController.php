<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use App\Entity\Wish;
use App\Form\WishType;

use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class WishController extends AbstractController
{
  /**
   * @Route("/wish", name="wish_list")
   */
  public function list(WishRepository $wishRepository): Response
  {
    $wishes = $wishRepository->findBy([], ['dateCreated' => 'DESC']);

    return $this->render('wish/list.html.twig', ['wishes' => $wishes]);
  }

  /** 
   * @Route("/wish/detail/{id}", name="wish_detail")
   */
  public function detail(int $id, WishRepository $wishRepository): Response
  {
    $wish = $wishRepository->find($id); // Récupérez le "wish" par son ID

    if (!$wish) {
      throw $this->createNotFoundException('Wish non trouvé'); // Gérez le cas où le "wish" n'est pas trouvé
    }

    return $this->render('wish/detail.html.twig', ['wish' => $wish]); // Passez le "wish" au template
  }

  /**
   * @Route("/wish/add", name="wish_add")
   */
  public function add(Request $request, EntityManagerInterface $entityManager): Response
  {
    $wish = new Wish();
    $wishForm = $this->createForm(WishType::class, $wish);
    $wishForm->handleRequest($request);
    if ($wishForm->isSubmitted() && $wishForm->isValid()) {
      $entityManager->persist($wish);
      $entityManager->flush();
      return $this->redirectToRoute('wish_list');
    }
    return $this->render('wish/add.html.twig', ['wishForm' => $wishForm->createView()]);
  }
}
