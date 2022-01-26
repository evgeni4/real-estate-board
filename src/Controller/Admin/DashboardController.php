<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

#[Route('/admin')]
class DashboardController extends AbstractController
{
    public function __construct(
        private ChartBuilderInterface $chartBuilder,
        private TranslatorInterface $translator
    )
    {
    }

    #[Route('/dashboard', name: 'admin_dashboard')]
    public function index(Breadcrumbs $breadcrumbs): Response
    {
//         dd(abs( crc32( uniqid() ) ));
        $breadcrumbs->addRouteItem("Dashboard", 'admin_dashboard');
        $chart = $this->chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            'datasets' => [
                [
                    'label' => $this->translator->trans('sign.up.label'),
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgba(69, 95, 227, 1)',
                    'data' => [0, 10, 5, 2, 20, 30, 45],
                ],
            ],
        ]);
        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 100,
                ],
            ],
        ]);
        return $this->render('admin/pages/dashboard/dashboard.html.twig',
        [
            'chart' => $chart,
        ]);
    }
}