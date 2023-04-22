<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use AppBundle\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;


/**
 * Contact controller.
 *
 * @Route("contact")
 */
class ContactController extends Controller
{
    /**
     * Lists all contact entities.
     *
     * @Route("/", name="contact_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $contacts = $em->getRepository('AppBundle:Contact')->findAll();

        return $this->render('contact/index.html.twig', array(
            'contacts' => $contacts,
        ));
    }

    /**
     * Creates a new contact entity.
     *
     * @Route("/new", name="contact_new")
     * @Method({"POST"})
     */
    public function newAction(Request $request)
    {
        $contact = new Contact();  
        $body = json_decode($request->getContent(),true);

        $contact->setName($body['name']);
        $contact->setFirstname($body['firstname']);

        $em = $this->getDoctrine()->getManager();
        $em->persist($contact);
        $em->flush();

        return new JsonResponse($contact->toString(), Response::HTTP_ACCEPTED);
    }

    /**
     * Deletes a contact entity.
     *
     * @Route("/{id}", name="contact_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Contact $contact)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($contact);
        $em->flush();

        return new Response(Response::HTTP_OK);
    }

}
