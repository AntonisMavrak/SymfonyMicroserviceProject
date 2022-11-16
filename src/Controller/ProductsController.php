<?php

namespace App\Controller;

use App\DTO\LowestPriceEnquiry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ProductsController extends AbstractController
{
//    /**
//     * @param int $id
//     * @return Response
//     * @Route("/products/{id}/lowest-price", name="lowest-price")
//     */
    /**
     * @param int $id
     * @return JsonResponse
     * @Route("/products/{id}/lowest-price", name="lowest-price", methods="POST")
     */
    public function lowestPrice(Request $request, int $id, SerializerInterface $serializer): JsonResponse
    {
        if ($request->headers->has('force_fail')) {
            return new JsonResponse(
                ['error' => 'Promotions Engine failure message'],
                $request->headers->get('force_fail')
            );
        }

        // TODO
        //    1. Deserialize json data into a EnquiryDTO (Data Access Object)
        $lowestPriceEnquiry = $serializer->deserialize($request->getContent(), LowestPriceEnquiry::class, 'json');
        dd($lowestPriceEnquiry);
        // TODO
        //    2. Pass the Enquiry into a promotions filter
        //        - The appropriate promotion will be applied
        // TODO
        //    3. Return the modified Enquiry
        return new JsonResponse([
            'quantity' => 5,
            'request_location' => 'UK',
            'voucher_code' => 'OU812',
            'request_date' => '2022-04-04',
            'product_id' => $id,
            'price' => 100,
            'discounted_price' => 50,
            'promotion_id' => 3,
            'promotion_name' => 'Black Friday Discount'
        ], 200);
    }

    /**
     * @return Response
     * @Route ("/products/{id}/promotions", name="promotions", methods="GET")
     */
    public function promotions(): Response
    {

    }
}