<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
   public function testNew(){
    $client = static::createClient();

    $productData = [
        'label' => "toy"
    ];
    
    
    $client->request('POST', '/product/new', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($productData));
    $idProduct = json_decode($client->getResponse()->getContent(),true)['id'];
        
    $this->assertEquals(200, $client->getResponse()->getStatusCode());
    $this->assertContains('"id":', $client->getResponse()->getContent());
    $this->assertContains('"label":', $client->getResponse()->getContent());

    $this->assertEquals($idProduct, json_decode($client->getResponse()->getContent(), true)['id']);
    $this->assertEquals($productData['label'], json_decode($client->getResponse()->getContent(), true)['label']);
   
    }

    public function testDelete(){
        $client = static::createClient();
    
        $productData = [
            'label' => "dumbProduct"
        ];
        
        $client->request('POST', '/product/new', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($productData));
        $idProduct = json_decode($client->getResponse()->getContent(),true)['id'];

        $client->request('DELETE', '/product/'.strval($idProduct), [], [], ['CONTENT_TYPE' => 'application/json']);
        
        $this->assertEquals(200, $client->getResponse()->getStatusCode());       
        }
}
