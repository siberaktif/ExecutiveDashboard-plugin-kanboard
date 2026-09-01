<?php

namespace Kanboard\Plugin\ExecutiveDashboard\Helper;

use Kanboard\Core\Base;

class DashboardFormatHelper extends Base
{
    /**
     * Format currency amount
     * @param float $amount
     * @param string $currency
     * @return string
     */
    public function currency($amount, $currency = 'TL')
    {
        return number_format($amount, 2, ',', '.') . ' ' . $currency;
    }

    /**
     * Return HTML color code based on Agile complexity score (C0-C50)
     * @param int $score
     * @return string
     */
    public function getComplexityColor($score)
    {
        if ($score <= 10) {
            // Low complexity - Green
            return '#5cb85c'; 
        } elseif ($score <= 30) {
            // Medium complexity - Yellow
            return '#f0ad4e';
        } else {
            // High complexity - Red
            return '#d9534f';
        }
    }
}
