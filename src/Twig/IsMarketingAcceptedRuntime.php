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
    private bool $marketing = false;

    public function __construct(RequestStack $request)
    {
        $request = $request->getCurrentRequest();
        if ($request->cookies->has(CookieName::MAIN)) {
            $cookies = json_decode($request->cookies->get(CookieName::MAIN));
            $this->marketing = $cookies->marketing;
        }
    }

    /**
     * @return bool
     */
    public function isMarketingAccepted(): bool
    {
        return $this->marketing;
    }
}
