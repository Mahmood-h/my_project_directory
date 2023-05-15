<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\Provincie;

use App\Form\ProvincieType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProvincieController extends AbstractController
{
    #[Route('/home', name: 'home')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $provincies=$doctrine->getRepository(Provincie::class)->findAll();

        return $this->render('index.html.twig', [
            'provincies' => $provincies,
        ]);
    }

     #[Route('/details/{id}', name: 'details')]
        public function city(ManagerRegistry $doctrine, int $id){
            $provincie=$doctrine->getRepository(Provincie::class)->find($id);

            return $this->render('details.html.twig', [
                'provincie'=>$provincie,
            ]);
        }

#[Route('/insert', name: 'insert')]
public function insert(Request $request, EntityManagerInterface $entityManager): Response{
        $provincie= new Provincie();

        $form=$this->createForm(ProvincieType::class, $provincie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $provincie=$form->getData();
            $entityManager->persist($provincie);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
    return $this->renderForm('insert.html.twig', [
        'form' => $form,
    ]);

}

    #[Route('/update/{id}', name: 'update')]
    public function update(Request $request, EntityManagerInterface $entityManager, int $id): Response{
        $provincie=$entityManager->getRepository(Provincie::class)->find($id);

        $form=$this->createForm(ProvincieType::class, $provincie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $provincie=$form->getData();
            $entityManager->persist($provincie);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->renderForm('insert.html.twig', [
            'form' => $form,
        ]);

    }



}
