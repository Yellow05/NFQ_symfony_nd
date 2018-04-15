<?php

namespace App\Controller;

use App\Validator\ValidateDateService;
use App\Weather\LoaderService;
use App\Weather\ValidateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Psr\SimpleCache\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

class WeatherController extends AbstractController
{
    /**
     * @param $day
     * @param LoaderService $weatherLoader
     * @param ValidateService $validateRange
     * @param ValidateDateService $validateDate
     * @return Response
     * @throws InvalidArgumentException
     */
    public function index($day, LoaderService $weatherLoader, ValidateService $validateRange,
                          ValidateDateService $validateDate ): Response
    {

        $error = "";
        if($validateDate->validateIfDateTime($day))
        {
            $range = 60;
            if($validateRange->validateDateRange($day, $range))
            {
                $weather = $weatherLoader->loadWeatherByDay(new \DateTime($day));
            }
            else
            {
                $error = "Data negali būti senesnė už šiandien dienos ir daugiau kaip ".$range." į priekį";
            }
        }
        else
        {
            $error = "Neteisingai įvedėte datą. Turi būti (YYYY-MM-DD)";
        }

        if(isset($weather)){
            return $this->render('weather/index.html.twig', [
                'error' => $error,
                'weatherData' => [
                    'date'      => $weather->getDate()->format('Y-m-d'),
                    'dayTemp'   => $weather->getDayTemp(),
                    'nightTemp' => $weather->getNightTemp(),
                    'sky'       => $weather->getSky(),
                    'provider'  => $weather->getProvider()
                ],
            ]);
        }
        else
        {
            return $this->render('weather/index.html.twig', [
                'error' => $error
            ]);
        }
    }
}
