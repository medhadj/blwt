<?php

namespace App\Controller\V1;

use App\Repository\UserRepository;
use App\Tool\CsvTool;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Manager\BlauwtrustManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlauwtrustController extends AbstractController
{
    /**
     * @param BlauwtrustManager $blauwtrustManager
     * @param Request $request
     * @param CsvTool $csvTool
     * @return Response
     */
    #[Route('/api/generate-csv-sales-dates', name: 'generate_csv_sales_dates', methods: 'GET')]
    public function generateCsvSalesDatesController(BlauwtrustManager $blauwtrustManager, Request $request, CsvTool $csvTool): Response
    {
        // Retrieve data from the request body
        $requestData = json_decode($request->getContent(), true);
        $csvFileName = !empty($requestData['csvFileName']) ? $requestData['csvFileName'] : 'sales-payroll-dates.csv';
        $verificationCsvName = $csvTool->verificationCsvName($csvFileName);

        if ($verificationCsvName) {
            $csvGenerator = $blauwtrustManager->calculateSalesPayrollDates($csvFileName);
        } else {
            $csvGenerator = "The file name does not contain .csv";
        }

        return $this->json($csvGenerator, 200);

    }
}
