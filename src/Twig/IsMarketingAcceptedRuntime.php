<?php

namespace TwinElements\GDPRCookiesBundle\Twig;

use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\RuntimeExtensionInterface;
use TwinElements\GDPRCookiesBundle\CookieName;

class IsMarketingAcceptedRuntime implements RuntimeExtensionInterface
{
    /**
     * @var bool
     */
    private $marketing = false;

    public function __construct(RequestStack $request)
    {
        $request = $request->getCurrentRequest();
        if ($request->cookies->has(CookieName::MAIN)) {
            $cookies = json_decode($request->cookies->get(CookieName::MAIN));
            $this->marketing = $cookies->marketing;
        } else {
            $this->marketing = true;
        }
    }

    /**
     * @return bool
     */
    public function isMarketingAccepted()
    {
        return $this->marketing;
    }
}
