<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Entidade;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/entidade")
 */
class EntidadeController extends Controller
{
    /**
     * @Route("/new", name="entidade_new")
     */
    public function newAction(Request $request)
    {
        return $this->save(new Entidade, $request, ['title' => 'Adicionar Entidade']);
    }

    /**
     * @Route("/edit/{id}", name="entidade_edit")
     */
    public function editAction(Request $request, Entidade $entidade)
    {
        return $this->save($entidade, $request, [
            'title' => 'Editar Entidade',
            'delete_form' => $this->createFormBuilder(null, ['attr' => [
                'id' => 'delete-form',
                'modal-confirmation' => 'Deletar?'
            ]])
                ->setAction($this->generateUrl('entidade_delete', ['id' => $entidade->getId()]))
                ->setMethod('DELETE')
                ->getForm()
                ->createView()
        ]);
    }

    protected function save(Entidade $entidade, Request $request, $params = [])
    {
        $form = $this->createFormBuilder($entidade, ['attr' => [
            'autocomplete' => 'off',
            'modal-confirmation' => 'Salvar?'
        ]])
            ->add('string', TextType::class, [
                'label' => 'String|HINT|Teste a validação tentando cadastrar uma string já cadastrada',
            ])
            ->add('data', DateType::class, [
                'label' => 'Data',
            ])
            ->add('valor', MoneyType::class, [
                'label' => 'Valor|HINT|Teste a validação tentando cadastrar um valor acima de R$ 99.999.999,99',
                'required' => false,
                'currency' => false,
                'invalid_message' => 'Valor inválido',
                'attr' => ['class' => 'text-left']
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entidade);
            $entityManager->flush();
            $this->addFlash('success', 'Entidade Salva');
            return $this->redirectToRoute('entidade_edit', ['id' => $entidade->getId()]);
        }

        $params['form'] = $form->createView();
        $params['entidade'] = $entidade;
        return $this->render('entidade/save.html.twig', $params);
    }

    /**
     * @Route("/delete/{id}", name="entidade_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Entidade $entidade)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->remove($entidade);
        $entityManager->flush();

        $this->addFlash('warning', 'Entidade Deletada');
        return $this->redirectToRoute('entidade_list');
    }
}
