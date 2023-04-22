<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Subscription;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Subscription controller.
 *
 * @Route("subscription")
 */
class SubscriptionController extends Controller
{
    /**
     * Creates a new subscription entity.
     *
     * @Route("/new", name="subscription_new")
     * @Method({"POST"})
     */
    public function newAction(Request $request)
    {
        $subscription = new Subscription();
        $body = json_decode($request->getContent(),true);
        
        $contact = $this->getDoctrine()->getRepository('AppBundle:Contact')->find($body['idContact']);
        $product = $this->getDoctrine()->getRepository('AppBundle:Product')->find($body['idProduct']);

        if(!isset($contact, $product, $body['beginDate'])){
            return new Response(Response::HTTP_BAD_REQUEST);
        }

        $subscription->setBeginDate(new \DateTime($body['beginDate']));
        
        if($body['endDate']){
            $subscription->setEndDate(new \DateTime($body['endDate']));
        }

        $subscription->setContact($contact);
        $subscription->setProduct($product);

        $em = $this->getDoctrine()->getManager();
        $em->persist($subscription);
        $em->flush();

        return  $subscription ? new JsonResponse($subscription->toString(), Response::HTTP_OK) : new response(400);
    }

    /**
     * Finds and displays a subscription entity.
     *
     * @Route("/{id}", name="subscription_show")
     * @Method("GET")
     */
    public function showAction(Request $request)
    {       
        if(intval($request->get('id') < 0)){
            return new Response(Response::HTTP_BAD_REQUEST);
        }
        $subscriptions = $this->getDoctrine()->getRepository('AppBundle:Subscription')->findBy(['contact' => $request->get('id')]);
        if(!isset($subscriptions)){
            return new Response(Response::HTTP_BAD_REQUEST);
        }

        $res = [];
        foreach ($subscriptions as $sub => $value) {
            $res[] = $value->toString();
        }

        return  $subscriptions ? new JsonResponse($res, Response::HTTP_OK) : new Response(Response::HTTP_BAD_REQUEST, "Subscription not exist for this user");
    }

    /**
     * Displays a form to edit an existing subscription entity.
     *
     * @Route("/{id}/edit", name="subscription_edit")
     * @Method({"PUT"})
     */
    public function editAction(Request $request, Subscription $subscription)
    {
        if(!isset($subscription)){
            return new Response(Response::HTTP_BAD_REQUEST, "Subscription don't exists");
        }

        $body = json_decode($request->getContent(),true);
        
        $contact = $this->getDoctrine()->getRepository('AppBundle:Contact')->find($body['idContact']);
        $product = $this->getDoctrine()->getRepository('AppBundle:Product')->find($body['idProduct']);

        $subscription->setBeginDate(new \DateTime($body['beginDate']));
        if($body['endDate']){
            $subscription->setEndDate(new \DateTime($body['endDate']));
        }
        $subscription->setContact($contact);
        $subscription->setProduct($product);

        $em = $this->getDoctrine()->getManager();
        $em->persist($subscription);
        $em->flush();

        return new JsonResponse($subscription->toString(),Response::HTTP_OK);
    }

    /**
     * Deletes a subscription entity.
     *
     * @Route("/{id}", name="subscription_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Subscription $subscription)
    {
            $em = $this->getDoctrine()->getManager();
            $em->remove($subscription);
            $em->flush();

        return new Response(Response::HTTP_ACCEPTED);
    }
}