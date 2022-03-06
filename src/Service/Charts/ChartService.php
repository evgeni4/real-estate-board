<?php

namespace App\Service\Charts;

use App\Repository\PropertyRepository;
use App\Service\Property\PropertyServiceInterface;
use App\Service\User\UserServiceInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class ChartService implements ChartServiceInterface
{
    public function __construct(
        private ChartBuilderInterface $chartBuilder,
        private TranslatorInterface   $translator,
        private PropertyRepository    $propertyRepository,
        private UserServiceInterface  $userService
    )
    {
    }

    public function chartBuilder(): Chart
    {
        $date = new \DateTimeImmutable();
        $month = intval($date->format('m'));
        $user = $this->userService->currentUser();
        //  dd($date->modify('+1 months'));
        $chart = $this->chartBuilder->createChart(Chart::TYPE_LINE);
        $months = [];
        $count = [];
        for ($i = 1; $i <= $month; $i++) {
            $dates = [];
            if ($month == $i) {
                $newDate = $date->modify('0 months');
                $months[] = $newDate->format('F');
                $dateStart = $newDate->format('Y-m-') . '01';
                $dateEnd = $newDate->format('Y-m-') . '31';
                $dates[] = $dateStart;
                $dates[] = $dateEnd;
                $count [] = $this->propertyRepository->getAllByCreateAtProperty($dates, $user);
            } else {
                $a=$month-$i;
                $newDate = $date->modify("-$a months");
                $dateStart = $newDate->format('Y-m-') . '01';
                $dateEnd = $newDate->format('Y-m-') . '31';
                $dates[] = $dateStart;
                $dates[] = $dateEnd;
                $months[] = $newDate->format('F');
                $count [] = $this->propertyRepository->getAllByCreateAtProperty($dates, $user);
            }
        }
        $chart->setData([
            'labels' => $months,
            'datasets' => [
                [
                    'label' => $this->translator->trans('listings.label'),
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgba(69, 95, 227, 1)',
                    'data' => $count,
                ],
            ],
        ]);
        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => min($count),
                    'suggestedMax' => max($count),
                ],
            ],
        ]);
        return $chart;
    }

    public function chartBuilderLine()
    {
        $date = new \DateTimeImmutable();
        $month = intval($date->format('m'));
        $user = $this->userService->currentUser();
        $months = [];
        $count = [];
        for ($i = 1; $i <= $month; $i++) {
            $dates = [];
            if ($month == $i) {
                $newDate = $date->modify('0 months');
                $months[] = $newDate->format('F');
                $dateStart = $newDate->format('Y-m-') . '01';
                $dateEnd = $newDate->format('Y-m-') . '31';
                $dates[] = $dateStart;
                $dates[] = $dateEnd;
                $count [] = $this->propertyRepository->getAllByCreateAtProperty($dates, $user);
            } else {
                $a=$month-$i;
                $newDate = $date->modify("-$a months");
                $dateStart = $newDate->format('Y-m-') . '01';
                $dateEnd = $newDate->format('Y-m-') . '31';
                $dates[] = $dateStart;
                $dates[] = $dateEnd;
                $months[] = $newDate->format('F');
                $count [] = $this->propertyRepository->getAllByCreateAtProperty($dates, $user);
            }
        }
        $chart['months'] = $months;
        $chart['count'] = $count;
        return $chart;
    }
}