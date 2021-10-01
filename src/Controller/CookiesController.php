<?php

namespace TwinElements\GDPRCookiesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Exception;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use TwinElements\GDPRCookiesBundle\CookieName;
use TwinElements\GDPRCookiesBundle\Entity\CookiesForm;
use TwinElements\GDPRCookiesBundle\Form\CookiesFormType;

class CookiesController extends AbstractController
{
    public function renderBaseFormAction(Request $request, array $twin_elements_gdpr_config)
    {
        if($request->cookies->has('accepted_cookies')){
            return new Response();
        }

        return $this->render('@TwinElementsGDPRCookies/cookies.html.twig', [
            'route' => $this->generateUrl($twin_elements_gdpr_config['cookies_policy_route'])
        ]);
    }

    /**
     * @Route("cookies-validate", name="cookies_validate", methods={"POST"}, options={"expose" = true, "i18n" = false})
     */
    public function cookies(Request $request)
    {
        try {
            if (!$request->isXmlHttpRequest()) {
                throw new Exception('Only XmlHttpRequest');
            }
            $cookies = new CookiesForm();
            $form = $this->createCookiesForm($cookies);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {

                $value = $this->getSerializer()->serialize($cookies, 'json');

                $response = new JsonResponse(['ok' => true]);
                $this->setCookies($response, $value);

                return $response;
            }

            $html = $this->renderView('@TwinElementsGDPRCookies/form.html.twig', [
                'form' => $form->createView()
            ]);

            return new JsonResponse(['ok' => false, 'form' => $html]);
        } catch (Exception $exception) {
            return new JsonResponse(['ok' => false, 'form' => null, 'error' => $exception->getMessage()]);
        }
    }

    /**
     * @Route("build-cookies-form", name="build_cookies_form", methods={"POST"}, options={"expose" = true, "i18n" = false})
     */
    public function getForm(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new Exception('Only XmlHttpRequest');
        }
        $cookies = new CookiesForm();

        if ($request->cookies->has(CookieName::MAIN)) {
            $this->getSerializer()->deserialize($request->cookies->get(CookieName::MAIN), CookiesForm::class, 'json', [
                AbstractNormalizer::OBJECT_TO_POPULATE => $cookies
            ]);
        }

        $form = $this->createCookiesForm($cookies);

        $html = $this->renderView('@TwinElementsGDPRCookies/form.html.twig', [
            'form' => $form->createView()
        ]);

        return new JsonResponse(['form' => $html]);
    }

    private function createCookiesForm(CookiesForm $cookies)
    {
        $form = $this->createForm(CookiesFormType::class, $cookies, [
            'method' => 'POST',
            'attr' => [
                'id' => 'cookies_settings_form'
            ]
        ]);

        return $form;
    }

    /**
     * @Route("/cookies-accept", options={"expose"=true, "i18n" = false}, name="accept_cookies_action")
     */
    public function acceptAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new Exception('Only XmlHttpRequest');
        }

        $cookies = new CookiesForm();
        $cookies->setBase(true);
        $cookies->setAnalytic(true);
        $cookies->setMarketing(true);

        $value = $this->getSerializer()->serialize($cookies, 'json');

        $response = new Response('ok');
        $this->setCookies($response, $value);

        return $response;
    }

    /**
     * @return Serializer
     */
    private function getSerializer()
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        return new Serializer($normalizers, $encoders);
    }

    private function setCookies(Response $response, $value)
    {
        $response->headers->setCookie(new Cookie(CookieName::MAIN, $value, time() + (86400 * 30)));
    }
}
