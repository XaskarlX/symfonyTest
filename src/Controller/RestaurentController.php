<?php

namespace App\Controller;

use App\Entity\Restaurent;
use App\Form\RestaurentFormType;
use App\Repository\RestaurentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RestaurentController extends AbstractController
{
    #[Route('/', name: 'app_restaurent')]
    public function index(): Response
    {
        return $this->render('restaurent/index.html.twig', [
            'controller_name' => 'RestaurentController',
        ]);
    }

        #[Route('/resto/list', name: 'app_resto_list')]
    public function clublist(RestaurentRepository $restaurentRepository){
        $resto = $restaurentRepository->findAll();
        return $this->render('restaurent/index.html.twig',[
            'controller_name' => 'RestaurentController',
            'resto' => $resto,
        ]);


    }

    #[Route('/resto/add', name: 'app_resto_add')]
    public function restaurentadd(EntityManagerInterface $ent ,Request $require){
        $restaurent = new Restaurent();
        $form = $this->createForm(RestaurentFormType::class, $restaurent);

        $form->handleRequest($require);

        if ($form->isSubmitted() && $form->isValid()) { 
        $ent->persist($restaurent);
        $ent->flush();
        return $this->redirectToRoute('app_resto_add');  
    }
            return $this->render('restaurent/index.html.twig',[
            'controller_name' => 'RestaurentController',
            'Form' => $form->createView(),
        ]);

    }

     #[Route('/resto/edit/{id}', name: 'app_resto_edit')]
public function restoupdate($id, RestaurentRepository $restaurentRepository, Request $request, EntityManagerInterface $ent)
{
    $resto = $restaurentRepository->find($id);

    $form = $this->createForm(RestaurentFormType::class, $resto);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $ent->flush();
        return $this->redirectToRoute('app_resto_list');
    }

    return $this->render('restaurent/index.html.twig', [
        'controller_name' => 'RestaurentController',
        'FormEdit' => $form->createView(),
        
    ]);
}

     #[Route('/resto/delete/{id}', name: 'app_resto_delete')]
     public function restodelete($id,RestaurentRepository $restaurentRepository ,EntityManagerInterface $ent){
        $resto = $restaurentRepository->findOneBy(['id' => $id]);
        $ent->remove($resto);
        $ent->flush();
        dd($resto);
     }


}
