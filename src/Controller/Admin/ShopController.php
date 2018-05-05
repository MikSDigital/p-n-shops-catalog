<?php

namespace App\Controller\Admin;

use App\Entity\Shop;
use App\Form\ShopType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/admin/shops", name="shops")
 * @Security("is_granted('ROLE_USER')")
 */

class ShopController extends Controller
{
    /**
     * @Route("/", name="shop_index", methods="GET")
     */
    public function index(): Response
    {
        $shops = $this->getDoctrine()
            ->getRepository(Shop::class)
            ->findAll();

        return $this->render('shop/index.html.twig', ['shops' => $shops]);
    }

    /**
     * @Route("/new", name="shop_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $shop = new Shop();
        $form = $this->createForm(ShopType::class, $shop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($shop);
            $em->flush();

            return $this->redirectToRoute('admin_area_dashboard_index');
        }

        return $this->render('admin/pages/add_new_shop.html.twig', [
            'shop' => $shop,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="shop_show", methods="GET")
     */
    public function show(Shop $shop): Response
    {
        return $this->render('shop/show.html.twig', ['shop' => $shop]);
    }

    /**
     * @Route("/{id}/edit", name="shop_edit", methods="GET|POST")
     */
    public function edit(Request $request, Shop $shop): Response
    {
        $form = $this->createForm(ShopType::class, $shop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('shop_edit', ['id' => $shop->getId()]);
        }

        return $this->render('shop/edit.html.twig', [
            'shop' => $shop,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="shop_delete", methods="DELETE")
     */
    public function delete(Request $request, Shop $shop): Response
    {
        if ($this->isCsrfTokenValid('delete'.$shop->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($shop);
            $em->flush();
        }

        return $this->redirectToRoute('admin_area_dashboard_index');
    }
}
