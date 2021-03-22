<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     * @Security("is_anonymous()")
     */
    public function loginAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->getFormFactory()
            ->createNamedBuilder(null, FormType::class, null, [
                'csrf_protection' => false
            ])
            ->setAction($this->generateUrl('login_check'))
            ->add('_username', HiddenType::class, ['attr' => ['value' => 'admin']])
            ->add('_password', PasswordType::class, [
                'label' => 'Senha|HINT|' . $this->getParameter('admin_password'),
            ])
            ->getForm();
        if ($return = $request->query->get('return', null))
            $form->add('_target_path', HiddenType::class, ['attr' => ['value' => $request->getSchemeAndHttpHost() . $return]]);
        if ($this->get('security.authentication_utils')->getLastAuthenticationError())
            $form->get('_password')->addError(new FormError('Inválida'));
        return $this->render('security/login.html.twig', [
            'title' => 'Login',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction()
    {
        $this->erro();
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
        $this->erro();
    }

    private function erro()
    {
        throw new \Exception('Esse método não deveria ser executado');
    }
}
