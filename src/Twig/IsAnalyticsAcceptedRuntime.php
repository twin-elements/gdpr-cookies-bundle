<?php

namespace TwinElements\GDPRCookiesBundle\Twig;

use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\RuntimeExtensionInterface;
use TwinElements\GDPRCookiesBundle\CookieName;

class IsAnalyticsAcceptedRuntime implements RuntimeExtensionInterface
{
    /**
     * @var bool
     */
    private $analytic = false;

    public function __construct(RequestStack $request)
    {
        $request = $request->getCurrentRequest();
        if ($request->cookies->has(CookieName::MAIN)) {
            $cookies = json_decode($request->cookies->get(CookieName::MAIN));
            $this->analytic = $cookies->analytic;
        } else {
            $this->analytic = true;
        }
    }

    /**
     * @return bool
     */
    public function isAnalyticsAccepted()
    {
        return $this->analytic;
    }
}
