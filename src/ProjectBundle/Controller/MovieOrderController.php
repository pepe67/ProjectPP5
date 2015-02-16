<?php

namespace ProjectBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ProjectBundle\Entity\MovieOrder;
use ProjectBundle\Form\MovieOrderType;
use Symfony\Component\HttpFoundation\Response;
/**
 * OrderMovie controller.
 *
 */
class MovieOrderController extends Controller
{

    /**
     * Lists all OrderMovie entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ProjectBundle:MovieOrder')->findAll();

        return $this->render('ProjectBundle:MovieOrder:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Lists user OrderMovie entities.
     *
     */
    public function myOrdersAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ProjectBundle:MovieOrder')->findByUser($this->getUser());

        return $this->render('ProjectBundle:Default:userorders.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new MovieOrder entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new MovieOrder();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            //Kasowanie zawartości koszyka
            $this->get('session')->set('cartIDs', array());
            return $this->redirect($this->generateUrl('project_orders_show', array('id' => $entity->getId())));
        }

        return $this->render('ProjectBundle:MovieOrder:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a OrderMovie entity.
     *
     * @param OrderMovie $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(MovieOrder $entity)
    {
        $form = $this->createForm(new MovieOrderType(), $entity, array(
            'action' => $this->generateUrl('project_orders_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Generuje stronę płatności na podstawie koszyka
     *
     */
    public function newAction(Request $request)
    {
        // Pobieramy ID filmow znajdujących się w koszyku
        $cartIDs = $this->get('session')->get('cartIDs');

        // Jezeli w koszyku nie ma nic, przekieruj do strony głównej
        if (empty($cartIDs)){
           $request->getSession()->getFlashBag()->add(
                'notice',
                'Dodaj filmy do koszyka potem przejdź do płatności!'
            );
            return $this->forward('ProjectBundle:Default:index');
        }

        $em = $this->getDoctrine()->getManager();
        $movies = $em->getRepository('ProjectBundle:Movie')->findById($cartIDs);

        $entity = new MovieOrder();
        // Ustawiamy, zamówienie na akutalnego użytkownika 
        // Manualnie gdyby skrypt był bardzo rozbudowany, można by pozwolić administratorom składać zamównie za kogoś
        $entity->setUser($this->getUser());
        
        $entity->setMovies($movies);

      

        $form   = $this->createCreateForm($entity);

         return $this->render('ProjectBundle:MovieOrder:new.html.twig', array(
            'entity' => $entity,
            'movies' => $movies,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a OrderMovie entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ProjectBundle:MovieOrder')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OrderMovie entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ProjectBundle:MovieOrder:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing OrderMovie entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ProjectBundle:MovieOrder')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MovieOrder entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ProjectBundle:MovieOrder:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a OrderMovie entity.
    *
    * @param MovieOrder $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(MovieOrder $entity)
    {
        $form = $this->createForm(new MovieOrderType(), $entity, array(
            'action' => $this->generateUrl('project_orders_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing MovieOrder entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ProjectBundle:MovieOrder')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MovieOrder entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('project_orders_edit', array('id' => $id)));
        }

        return $this->render('ProjectBundle:MovieOrder:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a MovieOrder entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ProjectBundle:MovieOrder')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find MovieOrder entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('project_orders'));
    }

    /**
     * Creates a form to delete a OrderMovie entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('category_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
