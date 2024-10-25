<?php

namespace App\Controller;

use App\Entity\Serveur;
use App\Repository\ServeurRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ServeurFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ServeurController extends AbstractController
{
    #[Route('/serveur', name: 'app_serveur')]
    public function index(): Response
    {
        return $this->render('serveur/index.html.twig', [
            'controller_name' => 'ServeurController',
        ]);
    }

    #[Route('/serveur/list', name: 'app_serveur_list')]
    public function serveurlist(ServeurRepository $serveurRepository){
        $serveur = $serveurRepository->findall();
        return $this->render('serveur/index.html.twig',[
            'controller_name' => 'ServeurController',
            'serv' => $serveur,
        ]);


    }

        #[Route('/serveur/list/{restoid}', name: 'app_resto_serveur_list')]
    public function restoserveurlist($restoid,ServeurRepository $serveurRepository){
        $serveur = $serveurRepository->findby(['resto_id' => $restoid ]);
        return $this->render('serveur/index.html.twig',[
            'controller_name' => 'ServeurController',
            'restoserv' => $serveur,
        ]);


    }

    #[Route('/serveur/add', name: 'app_serveur_add')]
    public function restaurentadd(EntityManagerInterface $ent ,Request $require){
        $serveur = new Serveur();
        $form = $this->createForm(ServeurFormType::class, $serveur);

        $form->handleRequest($require);

        if ($form->isSubmitted() && $form->isValid()) { 
        $ent->persist($serveur);
        $ent->flush();
        return $this->redirectToRoute('app_serveur_add');  
    }
            return $this->render('serveur/index.html.twig',[
            'controller_name' => 'ServeurController',
            'Form' => $form->createView(),
        ]);

    }


    #[Route('/serveur/edit/{id}', name: 'app_serveur_edit')]
public function restoupdate($id, ServeurRepository $serveurRepository, Request $request, EntityManagerInterface $ent)
{
    $serv = $serveurRepository->find($id);

    $form = $this->createForm(ServeurFormType::class, $serv);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $ent->flush();
        return $this->redirectToRoute('app_serveur_list');
    }

    return $this->render('serveur/index.html.twig', [
        'controller_name' => 'ServeurController',
        'FormEdit' => $form->createView(),
        
    ]);
}

    
     #[Route('/serveur/delete/{id}', name: 'app_serveur_delete')]
     public function restodelete($id,ServeurRepository $serveurRepository ,EntityManagerInterface $ent){
        $resto = $serveurRepository->findOneBy(['id' => $id]);
        $ent->remove($resto);
        $ent->flush();
        dd($resto);
     }




}
