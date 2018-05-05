<?php

namespace App\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/admin", name="admin_area")
 * @Security("is_granted('ROLE_USER')")
 */

class CmsController extends Controller
{
    /**
     * @Route("/", name="_dashboard_index")
     */
    public function index()
    {
        return $this->render('admin/pages/index.html.twig');
    }

}