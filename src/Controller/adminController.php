<?php
namespace App\Controller;

use App\Entity\Type;
use App\Form\TagType;
use App\Repository\TypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class adminController extends AbstractController
{
    #[Route('/type', name: 'Type' )]
    public function type(Request $request, TypeRepository $typeRepository)
    {
      $type = new Type();
      $types = $typeRepository->findBy([],['name'=>'ASC']);


      $formType = $this->createForm(TagType::class, $type);
       $formType->handleRequest($request);
       if ($formType->isSubmitted() && $formType->isValid())
       {
           $typeRepository->add($type);
       }
      return $this->render('admin/type.html.twig', [
          'formType'=>$formType->createView(),
          'types'=>$types
      ]);

    }

    #[Route('/removeType/{id}', name:'removeType')]
    public function removeType($id,TypeRepository $typeRepository)
    {
        $type = $typeRepository->findOneBy(['id'=>$id]);
        $typeRepository->remove($type);

        return $this->redirectToRoute('Type');
    }
}