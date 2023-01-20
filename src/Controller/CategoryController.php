<?php

namespace App\Controller;

use App\Entity\Program;
use App\Entity\Category;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



/**
 * @Route("/category", name="category_")
 */

class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */

    public function index(ManagerRegistry $managerRegistry): Response
    {
        $categoryRepository = $managerRegistry->getRepository(Category::class);
        $categories = $categoryRepository->findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * The controller for the category add form
     *
     * @Route("/new", name="new")
     */

    public function new(Request $request) : Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();
            return $this->redirectToRoute('category_index');
        }

        return $this->renderForm('category/new.html.twig', [
            "form" => $form,
        ]);

    }

    /**
     * @Route("/{categoryName}", name="show")
     */
    public function show(string $categoryName, ManagerRegistry $managerRegistry): Response
    {
        $categoryRepository = $managerRegistry->getRepository(Category::class);
        $category = $categoryRepository->findOneBy(['name'=>$categoryName]);

        if (!$category) {
            throw $this->createNotFoundException(
                'No category with id : ' .$categoryName. 'found in category\'s table.'
            );
        }
        $programRepository = $managerRegistry->getRepository(Program::class);
        $programs = $programRepository->findBy(
            ['category' => $category],
            ['id' => 'DESC'],
            3
        );

        return $this->render('category/show.html.twig', [
            'category' => $category,
            'programs' => $programs,
        ]);
    }

}
