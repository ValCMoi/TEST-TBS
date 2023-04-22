<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;


class SubscriptionControllerTest extends WebTestCase
{
    public function testNew()
    {
        $client = static::createClient();

        $contactData = [
            'name' => "Billly",
            'firstname' => "Goat",
        ];

        $productData = [
            'label' => "strawberry"
        ];

     
        $client->request('POST', '/contact/new', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($contactData));
        $idContact = json_decode($client->getResponse()->getContent(),true)['id'];
 
        $idProduct = $client->request('POST', '/product/new', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($productData));
        $idProduct = json_decode($client->getResponse()->getContent(),true)['id'];
        

        $subscriptionData = [
            'idContact' => $idContact,
            'idProduct' => $idProduct,
            'beginDate' => '2022-01-01',
            'endDate' => '2022-12-31',
        ];
        
        $client->request('POST', '/subscription/new', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($subscriptionData));

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('"id":', $client->getResponse()->getContent());
    }

    public function blocBadIdContactNew(){
        $client = static::createClient();

        $productData = [
            'label' => "strawberry"
        ];

     
        $idProduct = $client->request('POST', '/product/new', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($productData));
        $idProduct = json_decode($client->getResponse()->getContent(),true)['id'];
        

        $subscriptionData = [
            'idContact' => null,
            'idProduct' => $idProduct,
            'beginDate' => '2022-01-01',
            'endDate' => '2022-12-31',
        ];
        
        $client->request('POST', '/subscription/new', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($subscriptionData));

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
    }

    public function blocBadIdProductNew(){
        $client = static::createClient();

        $contactData = [
            'name' => "Billly",
            'firstname' => "Goat",
        ];
     
        $client->request('POST', '/contact/new', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($contactData));
        $idContact = json_decode($client->getResponse()->getContent(),true)['id'];
        

        $subscriptionData = [
            'idContact' => $idContact,
            'idProduct' => null,
            'beginDate' => '2022-01-01',
            'endDate' => '2022-12-31',
        ];
        
        $client->request('POST', '/subscription/new', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($subscriptionData));

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
    }

    public function blocBadBeginDateNew(){
        $client = static::createClient();

        $contactData = [
            'name' => "Billly",
            'firstname' => "Goat",
        ];

        $productData = [
            'label' => "strawberry"
        ];

     
        $client->request('POST', '/contact/new', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($contactData));
        $idContact = json_decode($client->getResponse()->getContent(),true)['id'];
 
        $idProduct = $client->request('POST', '/product/new', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($productData));
        $idProduct = json_decode($client->getResponse()->getContent(),true)['id'];
        

        $subscriptionData = [
            'idContact' => $idContact,
            'idProduct' => $idProduct,
            'beginDate' => null,
            'endDate' => '2022-12-31',
        ];
        
        $client->request('POST', '/subscription/new', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($subscriptionData));

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
    }
    public function testShowSubscription()
    {
        $client = static::createClient();

        $contactData = [
            'name' => "Max".strval(random_int(1,999999)),
            'firstname' => "Pioupiou".strval(random_int(1,999999)),
        ];

        $productData = [
            'label' => "helmet"
        ];
     
        $client->request('POST', '/contact/new', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($contactData));
        $idContact = json_decode($client->getResponse()->getContent(),true)['id'];
        
        $idProduct = $client->request('POST', '/product/new', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($productData));
        $idProduct = json_decode($client->getResponse()->getContent(),true)['id'];
        
        $subscriptionData = [
            'idContact' => $idContact,
            'idProduct' => $idProduct,
            'beginDate' => '2022-01-01',
            'endDate' => '2022-12-31',
        ];

        $nbEntity = random_int(10,50);
        $idTable = [];

        for ($i=0; $i < $nbEntity; $i++) { 
            $client->request('POST', '/subscription/new', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($subscriptionData));
            $idTable[] = json_decode($client->getResponse()->getContent(),true)['id'];
        }

        $client->request('GET', '/subscription/'. strval($idContact), [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($subscriptionData));

        $this->assertEquals(200, $client->getResponse()->getStatusCode());        
        $this->assertEquals($nbEntity, sizeof(json_decode($client->getResponse()->getContent())));

        for ($i=0; $i < $nbEntity; $i++) { 
            $this->assertEquals($idTable[$i], json_decode($client->getResponse()->getContent())[$i]->id);
        }
    }
    public function testEditUpdateDateSubscription()
    {

        $client = static::createClient();

        $contactData = [
            'name' => "POCBA",
            'firstname' => "Paolo",
        ];

        $productData = [
            'label' => "arrow"
        ];

        $client->request('POST', '/contact/new', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($contactData));
        $idContact = json_decode($client->getResponse()->getContent(),true)['id'];
        
        
        $client->request('POST', '/product/new', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($productData));
        $idProduct = json_decode($client->getResponse()->getContent(),true)['id'];
        
        $subscriptionData = [
            'idContact' => $idContact,
            'idProduct' => $idProduct,
            'beginDate' => '2022-01-01',
            'endDate' => '2022-12-31',
        ];
        
        $client->request('POST', '/subscription/new', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($subscriptionData));
        $idSubscription = json_decode($client->getResponse()->getContent(), true)['id'];

        $newBeginDate = '2023-01-01';
        $newEndDate = '2028-01-01';
        $newsSubcription = [
            'idContact' => $idContact,
            'idProduct' => $idProduct,
            'beginDate' => $newBeginDate,
            'endDate' => $newEndDate,
        ];

        $client->request('PUT', '/subscription/'.strval($idSubscription).'/edit', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($newsSubcription));

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(date_format(new \DateTime($newBeginDate), "d-M-Y"), date_format(new \DateTime(json_decode($client->getResponse()->getContent(), true)['beginDate']["date"]), "d-M-Y") );
        $this->assertEquals(date_format(new \DateTime($newEndDate), "d-M-Y"), date_format(new \DateTime(json_decode($client->getResponse()->getContent(), true)['endDate']["date"]), "d-M-Y") );


    }
        
    public function testEditUpdateContactSubscription()
    {
        $client = static::createClient();

        $contact0Data = [
            'name' => "POCBA",
            'firstname' => "Paolo",
        ];

        $contact1Data = [
            'name' => "Trumpy",
            'firstname' => "Poulo",
        ];

        $productData = [
            'label' => "arrow"
        ];

        $client->request('POST', '/contact/new', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($contact0Data));
        $idContact0 = json_decode($client->getResponse()->getContent(),true)['id'];

        $client->request('POST', '/contact/new', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($contact1Data));
        $idContact1 = json_decode($client->getResponse()->getContent(),true)['id'];
        
        $client->request('POST', '/product/new', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($productData));
        $idProduct = json_decode($client->getResponse()->getContent(),true)['id'];
        
        $subscriptionData = [
            'idContact' => $idContact0,
            'idProduct' => $idProduct,
            'beginDate' => '2022-01-01',
            'endDate' => '2022-12-31',
        ];
        
        $client->request('POST', '/subscription/new', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($subscriptionData));
        $idSubscription = json_decode($client->getResponse()->getContent(), true)['id'];
        
        $newsSubcription = [
            'idContact' => $idContact1,
            'idProduct' => $idProduct,
            'beginDate' => '2022-01-01',
            'endDate' => '2025-12-31',
        ];

        $client->request('PUT', '/subscription/'. strval($idSubscription) .'/edit', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($newsSubcription));

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals($idContact1, json_decode($client->getResponse()->getContent(), true)['contact']);
    }
    public function testDelete()
    {
        $contactData = [
            'name' => "James",
            'firstname' => "Camerooun",
        ];

        $productData = [
            'label' => "sword"
        ];

        $subscriptionData = [
            'idContact' => 1,
            'idProduct' => 1,
            'beginDate' => '2022-01-01',
            'endDate' => '2022-12-31',
        ];

        $client = static::createClient();

        $client->request('POST', '/contact/new', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($contactData));
        $idContact = json_decode($client->getResponse()->getContent(),true)['id'];
        
        $client->request('POST', '/product/new', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($productData));
        $idProduct = json_decode($client->getResponse()->getContent(),true)['id'];
        
        $subscriptionData = [
            'idContact' => $idContact,
            'idProduct' => $idProduct,
            'beginDate' => '2022-01-01',
            'endDate' => '2022-12-31',
        ];
        
        $client->request('POST', '/subscription/new', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($subscriptionData));
        $idSubscription = json_decode($client->getResponse()->getContent(), true)['id'];


        $client->request('DELETE', '/subscription/'.strval($idSubscription));

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

}