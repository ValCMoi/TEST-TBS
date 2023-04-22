<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;                                                           
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Product controller.
 *
 * @Route("product")
 */
class ProductController extends Controller
{
    /**
     * Creates a new product entity.
     *
     * @Route("/new", name="product_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $product = new Product();
        $body = json_decode($request->getContent(),true);

        if(is_string($body['label']) && isset($body['label']) ){
            $product->setLabel($body['label']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
            return new JsonResponse($product->toString(), JsonResponse::HTTP_OK);
        }
        return new JsonResponse($product->toString(), JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Finds and displays a product entity.
     *
     * @Route("/{id}", name="product_show")
     * @Method("GET")
     */
    public function showAction(Product $product)
    {
        return isset($product) ? new JsonResponse($product->toString()) : new Response(Response::HTTP_BAD_REQUEST);
    }

    /**
     * Deletes a product entity.
     *
     * @Route("/{id}", name="product_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Product $product)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush();

        return new Response(200);
    }

   
}
