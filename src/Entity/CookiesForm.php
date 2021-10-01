<?php

namespace TwinElements\GDPRCookiesBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class CookiesForm
{
    /**
     * @var boolean
     * @Assert\IsTrue()
     */
    private $base = true;
    /**
     * @var boolean
     */
    private $analytic = false;
    /**
     * @var boolean
     */
    private $marketing = false;

    /**
     * @return bool
     */
    public function isBase(): bool
    {
        return $this->base;
    }

    /**
     * @param bool $base
     */
    public function setBase(bool $base): void
    {
        $this->base = $base;
    }

    /**
     * @return bool
     */
    public function isAnalytic(): bool
    {
        return $this->analytic;
    }

    /**
     * @param bool $analytic
     */
    public function setAnalytic(bool $analytic): void
    {
        $this->analytic = $analytic;
    }

    /**
     * @return bool
     */
    public function isMarketing(): bool
    {
        return $this->marketing;
    }

    /**
     * @param bool $marketing
     */
    public function setMarketing(bool $marketing): void
    {
        $this->marketing = $marketing;
    }
}
