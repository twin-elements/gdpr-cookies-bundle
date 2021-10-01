<?php

namespace TwinElements\GDPRCookiesBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AcceptedCookiesExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('isMarketingAccepted', [IsMarketingAcceptedRuntime::class, 'isMarketingAccepted']),
            new TwigFunction('isAnalyticsAccepted', [IsAnalyticsAcceptedRuntime::class, 'isAnalyticsAccepted'])
        ];
    }
}
