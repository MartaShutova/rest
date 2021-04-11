<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Form\HotelFormType;
use App\Repository\HotelRepository;
use App\Repository\ApartmentRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HotelController extends AbstractController
{

    private $hotelRepository;
    private $apartmentRepository;

    public function __construct(HotelRepository $hotelRepository, ApartmentRepository $apartmentRepository)
    {
        $this->hotelRepository = $hotelRepository;
        $this->apartmentRepository = $apartmentRepository;
    }

    /**
     * @Route("/hotels/", name="add_hotel", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $name = $data['name'];
        $place = $data['place'];
        $url = $data['url'];
        $number = $data['number'];

        if (empty($name) || empty($place) || empty($url) || empty($number)) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        $this->hotelRepository->saveHotel($name, $place, $url, $number);

        return new JsonResponse(['status' => 'Hotel created!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/hotels/{id}", name="get_one_hotel", methods={"GET"})
     */
    public function get($id): JsonResponse
    {
        $hotel = $this->hotelRepository->findOneBy(['id' => $id]);
        $data = [
            'id' => $hotel->getId(),
            'name' => $hotel->getName(),
            'place' => $hotel->getPlace(),
            'url' => $hotel->getUrl(),
            'number' => $hotel->getNumber(),
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/hotels", name="get_all_hotels", methods={"GET"})
     */
    public function getAll(): Response
    {
        $hotels = $this->hotelRepository->findAll();
        $data = [];
        foreach ($hotels as $hotel) {
            $data[] = [
                'id' => $hotel->getId(),
                'name' => $hotel->getName(),
                'place' => $hotel->getPlace(),
                'url' => $hotel->getUrl(),
                'number' => $hotel->getNumber(),
            ];
        }
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/hotels/update/{id}", name="update_hotel", methods={"PUT"})
     */
    public function update($id, Request $request): JsonResponse
    {
        $hotel = $this->hotelRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);

        empty($data['name']) ? true : $hotel->setName($data['name']);
        empty($data['place']) ? true : $hotel->setPlace($data['place']);
        empty($data['url']) ? true : $hotel->setUrl($data['url']);
        empty($data['number']) ? true : $hotel->setNumber($data['number']);

        $updatedHotel = $this->hotelRepository->updateHotel($hotel);

        return new JsonResponse($updatedHotel->getDataArray(), Response::HTTP_OK);
    }

    /**
     * @Route("/hotels/{id}", name="delete_hotel", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $hotel = $this->hotelRepository->findOneBy(['id' => $id]);

        $this->hotelRepository->removeHotel($hotel);

        return new JsonResponse(['status' => 'Hotel deleted'], Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/hotels/list", name="list_hotels", methods={"POST"})
     */
    public function list(Request $request): Response
    {
        
        $hotel = new Hotel();
        $form = $this->createForm(HotelFormType::class, $hotel);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $request->request->get('hotel_form');
            $name = !empty($data['name']) ? $data['name'] : null;
            $place = !empty($data['place']) ? $data['place'] : null;
            $number = !empty($data['number']) ? $data['number'] : null;
            $hotels = $this->hotelRepository->findByFilter($name, $place, $number);
        } else {
            $hotels = $this->hotelRepository->findAll();
        }
        
        $data = [];
        foreach ($hotels as $key => $hotel) {
            $hotels[$key]->apartments = $this->apartmentRepository->findByHotelId($hotel->getId());
        }
        return $this->render('hotels.html.twig', [
            'hotels' => $hotels,
            'hotel_form' => $form->createView(),
        ]);
    }
}