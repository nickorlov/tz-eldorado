<?php

namespace App\Controller;

use App\Entity\Song;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/songs", methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function show(Request $request)
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $repository = $this->getDoctrine()->getRepository(Song::class);
        $songs = $repository->findSongs($request->query->all());

        return new Response($serializer->serialize($songs, 'json'));
    }

    /**
     * @Route("/api/song", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $song = new Song();
        $song->setName($request->get('name'));
        $song->setLength($request->get('length'));

        $em = $this->getDoctrine()->getManager();
        $em->persist($song);
        $em->flush();

        return new Response('OK');
    }
}
