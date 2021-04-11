<?php

namespace App\Controller;

use App\Repository\ApartmentRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ApartmentController extends AbstractController
{
    private $apartmentRepository;

    public function __construct(ApartmentRepository $apartmentRepository)
    {
        $this->apartmentRepository = $apartmentRepository;
    }

    /**
     * @Route("/apartments/", name="add_apartment", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $hotel_id = $data['hotel_id'];
        $url = $data['url'];
        $price = $data['price'];
        $guests_count = $data['guests_count'];
        $square = $data['square'];
        $additionals = $data['additionals'];
        $number = $data['number'];

        if (empty($hotel_id) || empty($url) || empty($price) || empty($guests_count) || empty($number)) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        $this->apartmentRepository->saveApartment($data);

        return new JsonResponse(['status' => 'Apartment created!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/apartments/{id}", name="get_one_apartment", methods={"GET"})
     */
    public function get($id): JsonResponse
    {
        $apartment = $this->apartmentRepository->findOneBy(['id' => $id]);
        $data = $apartment->getDataArray();

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/apartments", name="get_all_apartments", methods={"GET"})
     */
    public function getAll(): Response
    {
        $apartments = $this->apartmentRepository->findAll();
        $data = [];
        foreach ($apartments as $apartment) {
            $data[] = $apartment->getDataArray();
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/apartments/update/{id}", name="update_apartment", methods={"PUT"})
     */
    public function update($id, Request $request): JsonResponse
    {
        $apartment = $this->apartmentRepository->findOneBy(['id' => $id]);

        if (!$apartment) {
            throw new NotFoundHttpException('Not Found Apartment!');
        }

        $data = json_decode($request->getContent(), true);

        empty($data['hotel_id']) ? true : $apartment->setHotelId($data['hotel_id']);
        empty($data['url']) ? true : $apartment->setUrl($data['url']);
        empty($data['price']) ? true : $apartment->setPrice($data['price']);
        empty($data['guests_count']) ? true : $apartment->setGuestsCount($data['guests_count']);
        empty($data['square']) ? true : $apartment->setSquare($data['square']);
        empty($data['additionals']) ? true : $apartment->setAdditionals($data['additionals']);
        empty($data['number']) ? true : $apartment->setNumber($data['number']);

        $updatedApartment = $this->apartmentRepository->updateApartment($apartment);

        return new JsonResponse($updatedApartment->getDataArray(), Response::HTTP_OK);
    }

    /**
     * @Route("/apartments/delete/{id}", name="delete_apartment", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $apartment = $this->apartmentRepository->findOneBy(['id' => $id]);

        if (!$apartment) {
            throw new NotFoundHttpException('Not Found Apartment!');
        }

        $this->apartmentRepository->removeApartment($apartment);

        return new JsonResponse(['status' => 'Apartment deleted'], Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/apartments/hotel/{id}", name="apartments_by_hotel", methods={"GET"})
     */
    public function listByHotel($id): Response
    {
        $apartments = $this->apartmentRepository->findByHotelId($id);
        if (count($apartments) == 0) {
            return new JsonResponse(['status' => 'There are no apartments in this hotel'], Response::HTTP_NO_CONTENT);
        }
        $data = [];
        foreach ($apartments as $apartment) {
            $data[] = $apartment->getDataArray();
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

}