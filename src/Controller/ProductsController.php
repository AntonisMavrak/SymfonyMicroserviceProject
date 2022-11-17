<?php

namespace App\Controller;

use App\DTO\LowestPriceEnquiry;
use App\Entity\Promotion;
use App\Filter\PromotionsFilterInterface;
use App\Repository\ProductRepository;
use App\Service\Serializer\DTOSerializer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ProductsController extends AbstractController
{
    public function __construct(ProductRepository $repository, EntityManagerInterface $entityManager)
    {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
    }

    /**
     * @param Request $request
     * @param int $id
     * @param DTOSerializer $serializer
     * @param PromotionsFilterInterface $promotionsFilter
     * @return Response
     * @Route("/products/{id}/lowest-price", name="lowest-price", methods="POST")
     */
    public function lowestPrice(Request $request, int $id, DTOSerializer $serializer, PromotionsFilterInterface $promotionsFilter): Response
    {
        if ($request->headers->has('force_fail')) {
            return new JsonResponse(
                ['error' => 'Promotions Engine failure message'],
                $request->headers->get('force_fail')
            );
        }

        /** @var LowestPriceEnquiry $lowestPriceEnquiry */
        $lowestPriceEnquiry = $serializer->deserialize($request->getContent(), LowestPriceEnquiry::class, 'json');

        $product = $this->repository->find($id);

        $lowestPriceEnquiry->setProduct($product);

        $promotions = $this->entityManager->getRepository(Promotion::class)->findValidForProduct(
            $product,
            date_create_immutable($lowestPriceEnquiry->getRequestDate())
        );

        dd($promotions);

        $modifiedEnquiry = $promotionsFilter->apply($lowestPriceEnquiry);

        $responseContent = $serializer->serialize($modifiedEnquiry, 'json');

        return new Response($responseContent, 200);
    }

    /**
     * @return Response
     * @Route ("/products/{id}/promotions", name="promotions", methods="GET")
     */
    public function promotions(): Response
    {
        return $this->render('base.html.twig');
    }
}