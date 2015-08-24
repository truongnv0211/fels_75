<?php

namespace ElearningBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ElearningBundle\Entity\Category;
use ElearningBundle\Form\CategoryType;

/**
 * Category controller.
 *
 * @Route("/admin/category")
 */
class CategoryController extends Controller
{
    /**
     * Lists all Category entities.
     *
     * @Route("/", name="category")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('ElearningBundle:Category')->findAll();

        return ['categories' => $categories];
    }

    /**
     * Creates a new Category entity.
     *
     * @Route("/", name="category_create")
     * @Method("POST")
     * @Template("ElearningBundle:Category:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(new CategoryType(), $category);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('category_show', ['id' => $category->getId()]);
        }

        return ['category' => $category, 'form' => $form->createView()];
    }

    /**
     * Displays a form to create a new Category entity.
     *
     * @Route("/new", name="category_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $category = new Category();
        $form = $this->createForm(new CategoryType(), $category);

        return [
            'category' => $category,
            'form'   => $form->createView(),
        ];
    }

    /**
     * Finds and displays a Category entity.
     *
     * @Route("/{id}", name="category_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $category = $em->getRepository('ElearningBundle:Category')->find($id);

        if (!$category) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        return [
            'category'      => $category,
        ];
    }

    /**
     * Displays a form to edit an existing Category entity.
     *
     * @Route("/{id}/edit", requirements={"id" = "\d+"} , name="category_edit")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function editAction($id, Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $category = $em->getRepository('ElearningBundle:Category')->find($id);
        if (!$category) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }
        $form = $this->createForm(new CategoryType(), $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('category', array('id' => $category->getId()));
        }

        return [
          'category' => $category,
          'form' => $form->createView(),
        ];
    }

    /**
     * Deletes a Category entity.
     *
     * @Route("/{id}/delete", requirements={"id" = "\d+"}, name="category_delete")
     * @Method("GET")
     */
    public function deleteAction(Category $category)
    {
        if (!$category) {
            throw $this->createNotFoundException('No book found');
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();
        $this->addFlash(
          'success', 'Category delete successful !!!'
        );
        return $this->redirectToRoute('category');
    }
}
