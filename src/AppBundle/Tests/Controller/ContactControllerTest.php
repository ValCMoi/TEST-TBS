<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ContactControllerTest extends WebTestCase
{
    public function testNew(){
        $client = static::createClient();
    
        $contactData = [
            'name' => "Jacky".strval(random_int(1,999)),
            'firstname' => "Smith".strval(random_int(1,999))
        ];
        
        $client->request('POST', '/contact/new', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($contactData));
        $idContact = json_decode($client->getResponse()->getContent(),true)['id'];
            
        $this->assertEquals(Response::HTTP_ACCEPTED, $client->getResponse()->getStatusCode());
        $this->assertContains('"name":', $client->getResponse()->getContent());
        $this->assertContains('"firstname":', $client->getResponse()->getContent());
    
        $this->assertEquals($idContact, json_decode($client->getResponse()->getContent(), true)['id']);
        $this->assertEquals($contactData['name'], json_decode($client->getResponse()->getContent(), true)['name']);
        $this->assertEquals($contactData['firstname'], json_decode($client->getResponse()->getContent(), true)['firstname']);
       
        }
    
        public function testDelete(){
            $client = static::createClient();
        
            $contactData = [
                'name' => "Jacky".strval(random_int(1,999)),
                'firstname' => "Smith".strval(random_int(1,999))
            ];
            
            $client->request('POST', '/contact/new', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($contactData));
            $idContact = json_decode($client->getResponse()->getContent(),true)['id'];
    
            $client->request('DELETE', '/contact/'.strval($idContact), [], [], ['CONTENT_TYPE' => 'application/json']);
            
            $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());       
            }
}
